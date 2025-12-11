<?php
session_start();
header('Content-Type: application/json');
include 'conexion.php'; // Usamos tu archivo de conexión


if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No hay una sesión de aprendiz activa.']);
    exit;
}

$id_aprendiz = $_SESSION['usuario_id'];

try {
    // 1. Generar Token y Código Único
    $token = bin2hex(random_bytes(16)); // Token de 32 caracteres (ej: 6f9e38364456...)
    $codigo_unico = 'QR-' . date('YmdHis') . '-' . strtoupper(substr($token, 0, 8));
    
    // Fechas (Ajusta la zona horaria si es necesario)
    date_default_timezone_set('America/Bogota');
    $fecha_generacion = date('Y-m-d H:i:s');
    // El QR solo será válido por 30 minutos (configurable)
    $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+30 minutes')); 

    // 2. Insertar en la tabla 'codigos_qr'
    $sql = "INSERT INTO codigos_qr (codigo_unico, id_aprendiz, token, fecha_generacion, fecha_expiracion, estado, veces_usado) 
            VALUES (?, ?, ?, ?, ?, 'activo', 0)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $codigo_unico, $id_aprendiz, $token, $fecha_generacion, $fecha_expiracion);
    
    if ($stmt->execute()) {
        
        // Asumiendo que guardaste los nombres en sesión al iniciar, o se podrían consultar
        $nombres = $_SESSION['nombres'] ?? 'Aprendiz ID: ' . $id_aprendiz;
        
        echo json_encode([
            'success' => true,
            'token' => $token, // Este es el dato que se codifica en la imagen QR
            'codigo_qr' => $codigo_unico,
            'fecha_expiracion' => $fecha_expiracion,
            'aprendiz' => $nombres
        ]);
    } else {
        throw new Exception("Error al insertar el QR en la base de datos.");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>