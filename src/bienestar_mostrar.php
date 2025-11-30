<?php
// Incluir el archivo de conexión existente
include 'conexion.php';

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('<tr><td colspan="7" style="text-align: center; padding: 20px; color: #e74c3c;">
    <strong>Error:</strong> No se pudo establecer conexión con la base de datos.
    </td></tr>');
}

// Obtener parámetro de búsqueda si existe
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Mostrar mensaje de diagnóstico para depuración (puedes eliminarlo después)
if (isset($_GET['debug'])) {
    echo '<tr><td colspan="7" style="padding: 10px; background: #e8f4f8; color: #2980b9; font-family: monospace; font-size: 12px;">';
    echo 'Modo depuración activado<br>';
    echo 'Término de búsqueda: "' . htmlspecialchars($search) . '"<br>';
    echo 'Conexión a base de datos: OK';
    echo '</td></tr>';
}

// Preparar la consulta SQL
if (!empty($search)) {
    $sql = "SELECT h.id_historial, h.fecha_ingreso, h.observacion, 
                   p.nombres, p.apellidos, p.documento, p.rol
            FROM historial_ingreso h
            INNER JOIN personas p ON h.id_persona = p.id_persona
            WHERE (CONCAT(p.nombres, ' ', p.apellidos) LIKE ? 
               OR p.documento LIKE ? 
               OR p.rol LIKE ?)
            ORDER BY h.fecha_ingreso DESC";
    
    $stmt = $conn->prepare($sql);
    $searchParam = "%$search%";
    $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
} else {
    // Consulta para obtener todos los registros
    $sql = "SELECT h.id_historial, h.fecha_ingreso, h.observacion, 
         p.nombres, p.apellidos, p.documento, p.rol
            FROM historial_ingreso h
            INNER JOIN personas p ON h.id_persona = p.id_persona
            ORDER BY h.fecha_ingreso DESC";
    
    $stmt = $conn->prepare($sql);
}

// Verificar si la preparación fue exitosa
if (!$stmt) {
    die('<tr><td colspan="7" style="text-align: center; padding: 20px; color: #e74c3c;">
        <strong>Error en la consulta SQL:</strong> ' . htmlspecialchars($conn->error) . '
    </td></tr>');
}

// Ejecutar la consulta
if (!$stmt->execute()) {
    die('<tr><td colspan="7" style="text-align: center; padding: 20px; color: #e74c3c;">
        <strong>Error al ejecutar la consulta:</strong> ' . htmlspecialchars($stmt->error) . '
    </td></tr>');
}

$result = $stmt->get_result();

// Mostrar resultados
if ($result->num_rows === 0) {
    // Verificar si hay registros en la tabla sin filtros
    $checkAll = $conn->query("SELECT COUNT(*) as total FROM historial_ingreso");
    $totalRegistros = $checkAll->fetch_assoc()['total'];
    
    echo '<tr><td colspan="7" style="text-align: center; padding: 30px; color: #7f8c8d;">';
    if (!empty($search)) {
        echo '<div style="margin-bottom: 15px;">';
        echo '<i class="fas fa-search" style="font-size: 48px; opacity: 0.5; margin-bottom: 15px;"></i><br>';
        echo 'No se encontraron registros con los criterios: "<strong>' . htmlspecialchars($search) . '</strong>"';
        echo '</div>';
        echo '<button onclick="limpiarBusqueda()" style="background: #3498db; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">';
        echo '<i class="fas fa-times"></i> Limpiar búsqueda';
        echo '</button>';
    } else {
        if ($totalRegistros == 0) {
            echo '<i class="fas fa-inbox" style="font-size: 48px; opacity: 0.5; margin-bottom: 15px;"></i><br>';
            echo 'No hay registros de ingresos aún.<br>';
            echo '<span style="font-size: 14px; display: block; margin-top: 10px;">El vigilante debe escanear QRs de estudiantes para que aparezcan aquí.</span>';
        } else {
            echo '<i class="fas fa-exclamation-triangle" style="font-size: 48px; opacity: 0.5; margin-bottom: 15px;"></i><br>';
            echo 'Error inesperado: La consulta no devolvió resultados pero la tabla contiene registros.';
        }
    }
    echo '</td></tr>';
} else {
    // Mostrar los registros encontrados
    while ($registro = $result->fetch_assoc()) {
        // Formatear fecha y hora
        $fecha = date('Y-m-d', strtotime($registro['fecha_ingreso']));
        $hora = date('H:i:s', strtotime($registro['fecha_ingreso']));
        
        // Determinar el tipo de ingreso basado en el rol o en la observación
        $tipoIngreso = 'Normal';
        if (stripos($registro['observacion'] ?? '', 'permiso') !== false) {
            $tipoIngreso = 'Con permiso';
        }
        
        // Determinar estado según el rol o tiempo transcurrido
        $estado = 'Ingresado';
        $estadoClass = 'status-completed';
        
        // Mostrar fila
        echo '<tr>';
        echo '<td>' . htmlspecialchars($registro['nombres'] . ' ' . $registro['apellidos']) . '</td>';
        echo '<td>' . htmlspecialchars($registro['documento']) . '</td>';
        echo '<td>' . $fecha . '</td>';
        echo '<td>' . $hora . '</td>';
        echo '<td>' . htmlspecialchars($tipoIngreso) . '</td>';
        echo '<td><span class="' . $estadoClass . '">' . $estado . '</span></td>';
        echo '<td>
                <button class="btn-action btn-view" title="Ver detalles" onclick="verDetalles(' . $registro['id_historial'] . ')">
                    <i class="fas fa-eye"></i>
                </button>
              </td>';
        echo '</tr>';
    }
}

// Cerrar statement
$stmt->close();

