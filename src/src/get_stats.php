<?php
session_start();
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
// Asegúrate de que 'conexion.php' contenga la lógica para establecer la conexión ($conn)
include 'conexion.php'; 

// 1. Verificar sesión activa
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No hay una sesión de usuario activa.']);
    exit;
}

$id_aprendiz = $_SESSION['usuario_id'];
$stats = [
    'codigos_generados' => 0,
    'permisos_activos' => 0,
    'dias_activo' => 0
];

try {
    // 2. Contar Códigos QR Generados
    $sql_qr = "SELECT COUNT(*) AS total_qr FROM codigos_qr WHERE id_aprendiz = ?";
    $stmt_qr = $conn->prepare($sql_qr);
    $stmt_qr->bind_param("i", $id_aprendiz);
    $stmt_qr->execute();
    $result_qr = $stmt_qr->get_result();
    if ($row_qr = $result_qr->fetch_assoc()) {
        $stats['codigos_generados'] = $row_qr['total_qr'];
    }
    $stmt_qr->close();

    // 3. Contar Permisos Activos
    // Un permiso está activo si su fecha de fin es mayor o igual a la fecha actual Y el estado es 'aprobado'
    $sql_permisos = "SELECT COUNT(*) AS total_permisos 
                     FROM permisos 
                     WHERE id_aprendiz = ? 
                     AND estado = 'aprobado' 
                     AND fecha_fin >= CURDATE()"; 
                     
    $stmt_permisos = $conn->prepare($sql_permisos);
    $stmt_permisos->bind_param("i", $id_aprendiz);
    $stmt_permisos->execute();
    $result_permisos = $stmt_permisos->get_result();
    if ($row_permisos = $result_permisos->fetch_assoc()) {
        $stats['permisos_activos'] = $row_permisos['total_permisos'];
    }
    $stmt_permisos->close();
    
    // 4. Contar Días Activos (Días distintos en que se generó un QR)
    // Esto da una idea de los días que el aprendiz ha ingresado al centro
    $sql_dias = "SELECT COUNT(DISTINCT DATE(fecha_generacion)) AS total_dias 
                 FROM codigos_qr 
                 WHERE id_aprendiz = ?";
    $stmt_dias = $conn->prepare($sql_dias);
    $stmt_dias->bind_param("i", $id_aprendiz);
    $stmt_dias->execute();
    $result_dias = $stmt_dias->get_result();
    if ($row_dias = $result_dias->fetch_assoc()) {
        $stats['dias_activo'] = $row_dias['total_dias'];
    }
    $stmt_dias->close();
    
    // 5. Cerrar la conexión
    $conn->close();

    // Devolver las estadísticas en JSON
    echo json_encode(['success' => true, 'codigos_generados' => $stats['codigos_generados'], 'permisos_activos' => $stats['permisos_activos'], 'dias_activo' => $stats['dias_activo']]);

} catch (Exception $e) {
    // Manejo de errores
    if (isset($conn) && $conn->error) {
        $error_message = $conn->error;
    } else {
        $error_message = $e->getMessage();
    }
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos: ' . $error_message]);
    
    // Asegurar el cierre de la conexión en caso de excepción
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>