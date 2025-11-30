<?php
header('Content-Type: application/json');
require_once 'conexion.php';

// Obtener la fecha de hoy en formato Y-m-d
$hoy = date('Y-m-d');

try {
    // Consulta para contar ingresos de hoy
    $sql = "SELECT COUNT(*) as total_hoy 
            FROM historial_ingreso 
            WHERE DATE(fecha_ingreso) = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hoy);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'total_hoy' => (int)$row['total_hoy'],
            'fecha' => $hoy
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'total_hoy' => 0,
            'fecha' => $hoy
        ]);
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    $conn->close();
}
?>