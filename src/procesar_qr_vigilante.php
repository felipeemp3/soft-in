<?php
session_start();
header('Content-Type: application/json');
include 'conexion.php'; // Usamos tu archivo de conexión

// El token es lo que se extrae del escaneo (puede venir por GET o POST)
if (!isset($_GET['token'])) {
    echo json_encode(['success' => false, 'error' => 'Token de escaneo no proporcionado']);
    exit;
}

$token = $_GET['token'];
date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d H:i:s');

try {
    // 1. Buscar y obtener datos del QR y del Aprendiz (JOIN con la tabla 'personas')
    $sql = "SELECT c.id_qr, c.id_aprendiz, c.fecha_expiracion, c.estado, 
                   p.nombres, p.apellidos, p.documento, p.programa_formacion, p.no_ficha
            FROM codigos_qr c
            JOIN personas p ON c.id_aprendiz = p.id_persona
            WHERE c.token = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        throw new Exception("El código QR no es válido o ya fue eliminado.");
    }

    $qrData = $resultado->fetch_assoc();

    // 2. Validaciones de lógica
    if ($qrData['estado'] !== 'activo') {
        throw new Exception("El código QR ya fue usado o está inactivo. Estado: " . $qrData['estado']);
    }

    if ($fecha_actual > $qrData['fecha_expiracion']) {
        // Opcional: Actualizar el estado a expirado en la BD
        $conn->query("UPDATE codigos_qr SET estado = 'expirado' WHERE id_qr = " . $qrData['id_qr']);
        throw new Exception("El código QR ha expirado. Generar uno nuevo.");
    }

    // 3. Registrar el Ingreso y Quemar el QR (Transacción para asegurar ambas operaciones)
    $conn->begin_transaction();

    try {
        // A. Actualizar estado del QR a 'usado'
        $updateQR = "UPDATE codigos_qr SET estado = 'usado', veces_usado = veces_usado + 1 WHERE id_qr = ?";
        $stmtUpd = $conn->prepare($updateQR);
        $stmtUpd->bind_param("i", $qrData['id_qr']);
        $stmtUpd->execute();

        // B. Insertar en 'registro_ingreso'
        // Obtener ID del vigilante (Si no hay sesión, puedes usar un ID por defecto, como '1' de tu tabla)
        $id_vigilante = 1; // ID por defecto de tu vigilante (Jesus David en tu DB)
        if (isset($_SESSION['usuario_id']) && $_SESSION['rol'] == 'vigilante') {
            $id_vigilante = $_SESSION['usuario_id'];
        }
        
        $insertIngreso = "INSERT INTO registro_ingreso (id_aprendiz, id_vigilante, fecha_escaneo, estado, tipo_ingreso, observaciones) 
                          VALUES (?, ?, ?, 'escaneado', 'qr', 'Ingreso validado por QR')";
        
        $stmtIngreso = $conn->prepare($insertIngreso);
        $stmtIngreso->bind_param("iis", $qrData['id_aprendiz'], $id_vigilante, $fecha_actual);
        $stmtIngreso->execute();

        // Confirmar transacción
        $conn->commit();

        // 4. Respuesta de éxito con datos del aprendiz
        echo json_encode([
            'success' => true,
            'mensaje' => 'ACCESO AUTORIZADO Y REGISTRADO',
            'aprendiz' => [
                'nombre' => $qrData['nombres'] . ' ' . $qrData['apellidos'],
                'documento' => $qrData['documento'],
                'programa' => $qrData['programa_formacion'],
                'ficha' => $qrData['no_ficha']
            ]
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        throw new Exception("Error al procesar el ingreso: " . $e->getMessage());
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Acceso Denegado. ' . $e->getMessage()]);
}
?>