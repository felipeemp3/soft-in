<?php
include 'conexion.php';

if (isset($_GET["btnPermiso"])) {
    // Entrada y sanitización básica
    $nombre = isset($_GET["nombre"]) ? mysqli_real_escape_string($conn, $_GET["nombre"]) : '';
    $id_persona = isset($_GET["id_personas"]) ? mysqli_real_escape_string($conn, $_GET["id_personas"]) : '';
    $programa = isset($_GET["programa"]) ? mysqli_real_escape_string($conn, $_GET["programa"]) : '';
    $fecha = isset($_GET["fecha"]) ? mysqli_real_escape_string($conn, $_GET["fecha"]) : '';
    $observacion = isset($_GET["observacion"]) ? mysqli_real_escape_string($conn, $_GET["observacion"]) : '';

    // Validar campos obligatorios
    if (empty($id_persona) || empty($programa) || empty($fecha)) {
        echo "Faltan datos obligatorios: persona, programa y fecha son requeridos.";
        exit;
    }

    // Inserción: mapear correctamente los campos del formulario a las columnas de la BD
    // fecha_solicitud recibe la fecha del input date
    // motivo recibe la observacion
    $sql = "INSERT INTO `permiso` (`id_personas`, `fecha_solicitud`, `motivo`, `fecha_creacion`, `fecha_actualizacion`) 
            VALUES ('$id_persona', '$fecha', '$observacion', current_timestamp(), current_timestamp())";
    
    if (mysqli_query($conn, $sql)) {
        // Redirigir de vuelta al formulario con indicador de éxito
        header('Location: ../dashboards/permiso_form.php?success=1');
        exit;
    } else {
        echo "Error al crear registro: " . mysqli_error($conn);
    }
} else {
    echo "No se recibieron datos desde el formulario.";
}

mysqli_close($conn);

?>