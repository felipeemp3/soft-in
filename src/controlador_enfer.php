<?php
include('conexion.php');
if (isset($_POST["btnEnviar"])) {

    //Entrada
    $id_personas = $_POST["id_personas"];
    $observacion = $_POST["observacion"];

    // Validar que no estén vacíos
    if (empty($id_personas) || empty($observacion)) {
        echo '<script>
                alert("❌ Error: Todos los campos son obligatorios");
                window.history.back();
              </script>';
        exit();
    }

    // ID de la enfermera fijo
    $id_enfermera = "1";

    // Insertar en la tabla enfermera_valoracion
    $sql = "INSERT INTO `enfermera_valoracion` (`id_enfermera`, `id_personas`, `observacion`, `fecha_creacion`, `fecha_actualizacion`) 
            VALUES ('$id_enfermera', '$id_personas', '$observacion', NOW(), NOW())";

    if (mysqli_query($conn, $sql)) {
        echo '<script>
                alert("✅ Valoración médica guardada exitosamente");
                window.location.href = "../dashboards/enfermera.php";
              </script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
