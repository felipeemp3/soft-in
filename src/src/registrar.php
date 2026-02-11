<?php
include('conexion.php');

if (isset($_POST["btnGuardar"])) {
    // Entrada
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $tipo_documento = $_POST["tipo_documento"];
    $documento = $_POST["documento"];
    $rol = $_POST["rol"];
    $programa_formacion = $_POST["programa_formacion"];
    $no_ficha = $_POST["no_ficha"];
    $estado_formacion = $_POST["estado_formacion"];
    $tip_aprendiz = $_POST["tip_aprendiz"];
    $password_hash = $_POST["password_hash"];
    
    // Primero verificamos si el documento ya existe
    $sql_verificar = "SELECT documento FROM personas WHERE documento = '$documento'";
    $resultado = mysqli_query($conn, $sql_verificar);
    
    if (mysqli_num_rows($resultado) > 0) {

        echo '<script>
            alert("Error: El documento ' . $documento . ' ya está registrado en el sistema");
            window.history.back(); // Regresa al formulario manteniendo los datos
        </script>';
    } else {
        // El documento no existe, procedemos con la inserción
        $sql = "INSERT INTO `personas` (`nombres`, `apellidos`, `documento`, `tipo_documento`, `rol`, `programa_formacion`, `no_ficha`, `estado_formacion`, `tip_aprendiz`, `password_hash`) 
                VALUES ('$nombres', '$apellidos', '$documento', '$tipo_documento', '$rol', '$programa_formacion', '$no_ficha', '$estado_formacion', '$tip_aprendiz', '$password_hash')";

        if (mysqli_query($conn, $sql)) {
            echo '<script>
                alert("Registro exitoso");
                window.location.href = "../dashboards/admin.php";
            </script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
}
?>  