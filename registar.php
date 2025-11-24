<?php
include('conexion.php');
if (isset($_GET["btnGuardar"])) {

    //Entrada
    $user = $_GET["usuario"];
    $clave = $_GET["contraseña"];


    $sql = "INSERT INTO usuarios (user, clave VALUES ('$user', '$clave')";

    if (mysqli_query($comn, $sql)) {
        echo "Nuevo rgistro creado exitosamente";
    } else {
         echo "Error: " . $sql . "<br>" . mysqli_errno($comn);
    }
    mysqli_close($comn);
    header('location: mostrar.php');
}