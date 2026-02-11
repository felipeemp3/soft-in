<?php
header('Content-Type: text/html');
require_once 'conexion.php';

// Seguridad: Verificar sesión y rol (Ajusta la lógica de seguridad según tu sistema)
// session_start();
// if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'bienestar') {
//     echo "No autorizado";
//     exit;
// }

$search = $_GET['search'] ?? '';

try {
    // ----------------------------------------
    // --- CORRECCIÓN APLICADA AQUÍ ABAJO ---
    // ----------------------------------------
    if (!empty($search)) {
        $sql = "SELECT h.id_historial, h.fecha_ingreso, h.observacion, 
                      p.nombres, p.apellidos, p.documento, p.rol
                FROM historial_ingreso h
                INNER JOIN personas p ON h.id_personas = p.id_persona 
                WHERE (CONCAT(p.nombres, ' ', p.apellidos) LIKE ? 
                   OR p.documento LIKE ? 
                   OR h.observacion LIKE ?)
                ORDER BY h.fecha_ingreso DESC";
        
        $searchTerm = "%" . $search . "%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    } else {
        // Consulta para obtener todos los registros (esta ya estaba correcta)
        $sql = "SELECT h.id_historial, h.fecha_ingreso, h.observacion, 
                      p.nombres, p.apellidos, p.documento, p.rol
                FROM historial_ingreso h
                INNER JOIN personas p ON h.id_personas = p.id_persona
                ORDER BY h.fecha_ingreso DESC";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fecha = date('Y-m-d', strtotime($row['fecha_ingreso']));
            $hora = date('H:i:s', strtotime($row['fecha_ingreso']));
            $tipo_ingreso = strpos(strtolower($row['observacion']), 'salida') !== false ? 'Salida' : 'Ingreso';

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nombres'] . ' ' . $row['apellidos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['documento']) . "</td>";
            echo "<td>" . htmlspecialchars($fecha) . "</td>";
            echo "<td>" . htmlspecialchars($hora) . "</td>";
            echo "<td><span class='badge " . ($tipo_ingreso == 'Salida' ? 'badge-danger' : 'badge-success') . "'>" . htmlspecialchars($tipo_ingreso) . "</span></td>";
            echo "<td><span class='badge badge-success'>Completado</span></td>"; // Estado Fijo
            echo "</tr>";
        }
    } else {
        echo '<tr><td colspan="7" style="text-align: center; color: #7f8c8d; padding: 20px;">No se encontraron registros en el historial.</td></tr>';
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Si hay un error, al menos muestra un mensaje en la tabla
    echo '<tr><td colspan="7" style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el historial: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
    if (isset($conn)) $conn->close();
}
?>