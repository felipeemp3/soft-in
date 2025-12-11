<?php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'aprendiz') {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

$id_aprendiz = $_SESSION['usuario_id'];

try {
    $sql = "SELECT codigo_unico as codigo_qr, fecha_generacion, fecha_expiracion, estado 
            FROM codigos_qr 
            WHERE id_aprendiz = ? 
            ORDER BY fecha_generacion DESC 
            LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_aprendiz);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $historial = [];
    
    while ($row = $result->fetch_assoc()) {
        $historial[] = $row;
    }
    
    $stmt->close();
    
    echo json_encode([
        'success' => true,
        'historial' => $historial
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>