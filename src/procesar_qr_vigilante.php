<?php
session_start();
include 'conexion.php';

// Verificar que sea vigilante
if (!isset($_SESSION['id_persona']) || $_SESSION['rol'] != 'vigilante') {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

$vigilante_id = $_SESSION['id_persona'];

// Recibir datos
$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'] ?? '';
$tipo = $data['tipo'] ?? 'ingreso';

if (empty($token)) {
    echo json_encode(['success' => false, 'error' => 'Token no proporcionado']);
    exit();
}

try {
    // Buscar el QR por token
    $stmt = $conn->prepare("
        SELECT 
            cq.*,
            p.id_persona as id_aprendiz
        FROM codigos_qr cq
        JOIN personas p ON cq.id_aprendiz = p.id_persona
        WHERE cq.token = ? 
        AND cq.estado = 'activo'
        AND cq.fecha_expiracion > NOW()
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $qr_data = $result->fetch_assoc();
        
        // 1. Marcar QR como usado
        $update_stmt = $conn->prepare("
            UPDATE codigos_qr 
            SET estado = 'usado', 
                veces_usado = veces_usado + 1 
            WHERE id_qr = ?
        ");
        $update_stmt->bind_param("i", $qr_data['id_qr']);
        $update_stmt->execute();
        
        // 2. Registrar en registro_ingreso
        $registro_stmt = $conn->prepare("
            INSERT INTO registro_ingreso 
            (id_aprendiz, id_vigilante, estado, tipo_ingreso)
            VALUES (?, ?, 'completado', ?)
        ");
        $registro_stmt->bind_param("iis", $qr_data['id_aprendiz'], $vigilante_id, $tipo);
        $registro_stmt->execute();
        
        $registro_id = $registro_stmt->insert_id;
        
        // 3. Registrar en historial_ingreso (¡CLAVE PARA EL CONTEO Y DASHBOARD DE BIENESTAR!)
        $hist_ingreso_stmt = $conn->prepare("
            INSERT INTO historial_ingreso 
            (id_personas, fecha_ingreso, observacion)
            VALUES (?, NOW(), ?)
        ");
        $obs_text = ($tipo == 'ingreso' ? 'Ingreso' : 'Salida') . " registrado mediante QR. Código: " . $qr_data['codigo_unico'];
        // Usamos id_aprendiz, que es el id_persona
        $hist_ingreso_stmt->bind_param("is", $qr_data['id_aprendiz'], $obs_text); 
        $hist_ingreso_stmt->execute();
        
        echo json_encode([
            'success' => true,
            'id_ingreso' => $registro_id,
            'tipo_registrado' => $tipo,
            'mensaje' => ($tipo == 'ingreso') ? '✅ Ingreso registrado exitosamente' : '🚪 Salida registrada exitosamente'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'error' => 'Código QR no válido, expirado o ya utilizado'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'error' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

$conn->close();
?>