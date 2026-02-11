<?php

include ('conexion.php');

// Obtener parámetros de búsqueda y filtros
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$rol = isset($_GET['rol']) ? $_GET['rol'] : '';

// Construir la consulta SQL base
$sql = "SELECT ri.*, p.nombres, p.apellidos, p.documento, p.rol 
        FROM registro_ingreso ri
        JOIN personas p ON ri.id_aprendiz = p.id_persona
        WHERE 1=1";

// Añadir condiciones de búsqueda
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (CONCAT(p.nombres, ' ', p.apellidos) LIKE ? 
                OR p.documento LIKE ? 
                OR p.rol LIKE ?)";
    $searchParam = "%" . $search . "%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "sss";
}

// Añadir filtros de fecha
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND DATE(ri.fecha_escaneo) BETWEEN ? AND ?";
    $params[] = $fecha_inicio;
    $params[] = $fecha_fin;
    $types .= "ss";
} elseif (!empty($fecha_inicio)) {
    $sql .= " AND DATE(ri.fecha_escaneo) >= ?";
    $params[] = $fecha_inicio;
    $types .= "s";
} elseif (!empty($fecha_fin)) {
    $sql .= " AND DATE(ri.fecha_escaneo) <= ?";
    $params[] = $fecha_fin;
    $types .= "s";
}

// Añadir filtro por tipo
if (!empty($tipo)) {
    if ($tipo === 'Ingreso') {
        $sql .= " AND ri.tipo_ingreso IN ('normal', 'con_permiso')";
    } elseif ($tipo === 'Salida') {
        $sql .= " AND ri.tipo_ingreso = 'salida'";
    }
}

// Añadir filtro por rol
if (!empty($rol)) {
    $sql .= " AND p.rol = ?";
    $params[] = $rol;
    $types .= "s";
}

// Añadir ordenamiento
$sql .= " ORDER BY ri.fecha_escaneo DESC";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'error' => 'Error al ejecutar la consulta: ' . $stmt->error
    ]);
    exit();
}

$result = $stmt->get_result();

$registros = [];
while ($row = $result->fetch_assoc()) {
    $registros[] = $row;
}

// Contar registros totales
$total_registros = count($registros);

// Devolver los resultados en formato JSON
echo json_encode([
    'success' => true,
    'registros' => $registros,
    'total_registros' => $total_registros,
    'fecha_generacion' => date('Y-m-d H:i:s')
]);

// Cerrar la conexión
$stmt->close();
$conn->close();
?>