<?php
session_start();
require_once 'conexion.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'aprendiz') {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

// Obtener datos del aprendiz
$id_aprendiz = $_SESSION['usuario_id'];
$nombres = $_SESSION['nombres'] ?? '';
$apellidos = $_SESSION['apellidos'] ?? '';
$documento = $_SESSION['documento'] ?? '';

// Generar un token único
$token = bin2hex(random_bytes(16));
$codigo_qr = 'QR-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));

// Fechas
$fecha_generacion = date('Y-m-d H:i:s');
$fecha_expiracion = date('Y-m-d H:i:s', strtotime('+30 minutes'));

try {
    // Guardar en la tabla codigos_qr
    $sql = "INSERT INTO codigos_qr (codigo_unico, id_aprendiz, token, fecha_generacion, fecha_expiracion, estado) 
            VALUES (?, ?, ?, ?, ?, 'activo')";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error preparando consulta: " . $conn->error);
    }
    
    $stmt->bind_param("sisss", 
        $codigo_qr,
        $id_aprendiz,
        $token,
        $fecha_generacion,
        $fecha_expiracion
    );
    
    if ($stmt->execute()) {
        // Construir URL correcta
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $base_path = dirname(dirname($_SERVER['SCRIPT_NAME']));
        $qr_url = "$protocol://$host$base_path/src/procesar_qr_vigilante.php?token=" . $token;
        
        // Para desarrollo local, usar URL relativa
        $qr_url_alternativa = "../src/procesar_qr_vigilante.php?token=" . $token;
        
        echo json_encode([
            'success' => true,
            'mensaje' => 'Código QR generado exitosamente',
            'codigo_qr' => $codigo_qr,
            'token' => $token,
            'aprendiz' => $nombres . ' ' . $apellidos,
            'documento' => $documento,
            'fecha_generado' => $fecha_generacion,
            'fecha_expiracion' => $fecha_expiracion,
            'qr_url' => $qr_url,
            'qr_url_relativa' => $qr_url_alternativa,
            'debug' => [
                'host' => $host,
                'base_path' => $base_path,
                'protocol' => $protocol
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al guardar en la base de datos: ' . $conn->error]);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
}

$conn->close();
?>