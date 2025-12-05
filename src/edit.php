<?php


if (isset($_POST["btnActualizar"])) {

    //Entrada
    $id_persona = $_POST["userId"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $rol = $_POST["rol"];
    $estado_formacion = $_POST["estado_formacion"];
    $tip_aprendiz = $_POST["tip_aprendiz"];

    //$sql = "UPDATE `personas` SET ( `nombres`, `apellidos`, `rol`, `estado_formacion`)  VALUES ( '$nombres', '$apellidos', '$rol', '$estado_formacion') WHERE `personas`.`id_persona` = 5;";
    $sql = "UPDATE `personas` SET `nombres` = '$nombres', `apellidos` = '$apellidos', `rol` = '$rol', `estado_formacion` = '$estado_formacion', `tip_aprendiz` = '$tip_aprendiz'WHERE `personas`.`id_persona` = $id_persona;";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            window.location.href = '../dashboards/admin.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_errno($conn);
    }
    mysqli_close($conn);
}
