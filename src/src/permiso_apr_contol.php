<?php
include 'conexion.php';

if (isset($_POST["btnPermiso"])) {
    // Entrada y sanitización básica
    $nombre = isset($_POST["nombre"]) ? mysqli_real_escape_string($conn, $_POST["nombre"]) : '';
    $id_persona = isset($_POST["id_persona"]) ? mysqli_real_escape_string($conn, $_POST["id_persona"]) : '';
    $programa = isset($_POST["programa"]) ? mysqli_real_escape_string($conn, $_POST["programa"]) : '';
    $fecha = isset($_POST["fecha"]) ? mysqli_real_escape_string($conn, $_POST["fecha"]) : '';
    $observacion = isset($_POST["observacion"]) ? mysqli_real_escape_string($conn, $_POST["observacion"]) : '';
    // $pdf = isset($_POST["pdf"]) ? mysqli_real_escape_string($conn, $_POST["pdf"]) : ''; // Esta línea la borras

    // NUEVO: Procesar archivo PDF si se subió
    $ruta_pdf = '';
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $directorio = "../uploads/permisos/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
        
        $nombre_unico = 'permiso_' . $id_persona . '_' . time() . '.pdf';
        $ruta_completa = $directorio . $nombre_unico;
        
        if (move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $ruta_completa)) {
            $ruta_pdf = $ruta_completa;
        }
    }

    // Validar campos obligatorios
    if (empty($id_persona) || empty($programa) || empty($fecha)) {
        echo "Faltan datos obligatorios: persona, programa y fecha son requeridos.";
        exit;
    }

    // NUEVO: Inserción con PDF si existe
    if (!empty($ruta_pdf)) {
        $sql = "INSERT INTO permiso (id_persona, fecha_solicitud, observacion, pdf, estado, fecha_creacion, fecha_actualizacion) 
                VALUES ('$id_persona', '$fecha', '$observacion', '$ruta_pdf', 'pendiente', current_timestamp(), current_timestamp())";
    } else {
        // Tu código original (sin PDF)
        $sql = "INSERT INTO permiso (id_persona, fecha_solicitud, observacion, estado, fecha_creacion, fecha_actualizacion) 
                VALUES ('$id_persona', '$fecha', '$observacion', 'pendiente', current_timestamp(), current_timestamp())";
    }
    
    if (mysqli_query($conn, $sql)) {
        // Mostrar mensaje de éxito con JavaScript y redirigir
        echo '<script>
            alert("¡Permiso enviado exitosamente!");
            window.location.href = "../dashboards/aprendiz.php";
        </script>';
        exit;
    } else {
        echo "Error al crear registro: " . mysqli_error($conn);
    }
} else {
    echo "No se recibieron datos desde el formulario.";
}

mysqli_close($conn);
?>