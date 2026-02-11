<?php
header('Content-Type: application/json');
require_once 'conexion.php';

// Fecha actual
$hoy = date('Y-m-d');

try {
    // Contar ingresos de hoy
    $sql = "SELECT COUNT(*) AS total_hoy 
            FROM historial_ingreso 
            WHERE DATE(fecha_ingreso) = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hoy);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();

    echo json_encode([
        'success' => true,
        'total_hoy' => (int)$row['total_hoy'],
        'fecha' => $hoy
    ]);

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    if (isset($conn)) $conn->close();
}
?>
