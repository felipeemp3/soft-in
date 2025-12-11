<?php
session_start();
header('Content-Type: application/json');
include 'conexion.php'; 

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No hay una sesión activa.']);
    exit;
}

$id_aprendiz = $_SESSION['usuario_id'];

try {
    // Consulta para obtener el historial de QR del aprendiz
    // Se seleccionan las columnas relevantes de la tabla codigos_qr
    $sql = "SELECT codigo_unico, fecha_generacion, fecha_expiracion, estado, veces_usado 
            FROM codigos_qr 
            WHERE id_aprendiz = ? 
            ORDER BY fecha_generacion DESC 
            LIMIT 20"; // Limitar a los últimos 20 registros

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_aprendiz);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $history = [];
    while ($row = $resultado->fetch_assoc()) {
        $history[] = $row;
    }

    echo json_encode(['success' => true, 'history' => $history]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error al consultar el historial: ' . $e->getMessage()]);
}
?>