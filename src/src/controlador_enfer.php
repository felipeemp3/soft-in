<?php
session_start();
require_once 'conexion.php'; 


// Verificar si se envió el formulario
if (isset($_POST["btnEnviar"])) {
    
    // Entradas del formulario
    $id_persona = trim($_POST["id_personas"] ?? '');
    $id_permiso = trim($_POST["id_permiso"] ?? '');
    $observacion = trim($_POST["observacion"] ?? '');
    
    echo "<p>Datos recibidos:</p>";
    echo "<ul>";
    echo "<li>id_personas: " . htmlspecialchars($id_persona) . "</li>";
    echo "<li>id_permiso: " . htmlspecialchars($id_permiso) . "</li>";
    echo "<li>observacion: " . htmlspecialchars($observacion) . "</li>";
    echo "</ul>";

    // Validar datos vacíos
    if (empty($id_persona) || empty($observacion)) {
        echo '<div style="background: #ffcccc; padding: 10px; border: 1px solid red; margin: 10px;">
                ❌ Error: Todos los campos son obligatorios
              </div>';
        echo '<button onclick="window.history.back()">Volver</button>';
        exit();
    }

    // Obtener ID de la enfermera desde la sesión
    if (!isset($_SESSION['id_persona'])) {
        echo '<div style="background: #ffcccc; padding: 10px; border: 1px solid red; margin: 10px;">
                ❌ Error: Sesión no válida. ID de persona no encontrado en sesión.
              </div>';
        exit();
    }

    $id_enfermera = $_SESSION['id_persona'];
    echo "<p>ID Enfermera (desde sesión): " . $id_enfermera . "</p>";

    try {
        // Mostrar la consulta SQL que se va a ejecutar
        echo "<p>Consulta SQL a ejecutar:</p>";
        echo "<pre style='background: #e8f4f8; padding: 10px;'>";
        echo "INSERT INTO enfermera_valoracion (id_enfermera, id_persona, observacion, fecha_creacion, fecha_actualizacion) 
              VALUES ($id_enfermera, $id_persona, '$observacion', NOW(), NOW())";
        echo "</pre>";
        
        // Preparar la consulta
        $sql = "INSERT INTO enfermera_valoracion 
                (id_enfermera, id_persona, observacion, fecha_creacion, fecha_actualizacion) 
                VALUES (?, ?, ?, NOW(), NOW())";
        
        echo "<p>SQL preparado: " . htmlspecialchars($sql) . "</p>";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conn->error);
        }
        
        $stmt->bind_param("iis", $id_enfermera, $id_persona, $observacion);
        
        if ($stmt->execute()) {
            echo '<div style="background: #ccffcc; padding: 10px; border: 1px solid green; margin: 10px;">
                    ✅ Valoración médica insertada correctamente
                  </div>';
            
            // Actualizar estado del permiso si se proporcionó id_permiso
            if (!empty($id_permiso)) {
                $sql_update = "UPDATE permiso SET estado = 'Evaluado' WHERE id_permiso = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("i", $id_permiso);
                
                if ($stmt_update->execute()) {
                    echo '<div style="background: #ccffcc; padding: 10px; border: 1px solid green; margin: 10px;">
                            ✅ Estado del permiso actualizado a "Evaluado"
                          </div>';
                } else {
                    echo '<div style="background: #ffcccc; padding: 10px; border: 1px solid red; margin: 10px;">
                            ⚠️ Valoración guardada pero error al actualizar permiso: ' . $stmt_update->error . '
                          </div>';
                }
                $stmt_update->close();
            }
            
            // Redirigir después de 3 segundos
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "../dashboards/enfermera.php";
                    }, 3000);
                  </script>';
            echo '<p>Redirigiendo en 3 segundos... <a href="../dashboards/enfermera.php">Haz clic aquí si no redirige</a></p>';
            
        } else {
            throw new Exception("Error al ejecutar: " . $stmt->error);
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo '<div style="background: #ffcccc; padding: 10px; border: 1px solid red; margin: 10px;">
                ❌ Error: ' . htmlspecialchars($e->getMessage()) . '
              </div>';
        echo '<button onclick="window.history.back()">Volver</button>';
    }
    
    $conn->close();
    
} else {
    echo '<div style="background: #ffffcc; padding: 10px; border: 1px solid orange; margin: 10px;">
            ⚠️ No se recibió el formulario correctamente. El botón debe tener name="btnEnviar"
          </div>';
    echo '<p>Datos POST recibidos:</p>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
?>