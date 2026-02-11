<?php
include('conexion.php');

// Inicializar TODAS las variables
$total_usuarios = 0;
$administrativo = 0;
$aprendices = 0;
$enfermeras = 0;
$vigilantes = 0;
$bienestar = 0;

// Consulta para el total de usuarios
$sql_total = "SELECT COUNT(*) as total FROM personas";

$result_total = mysqli_query($conn, $sql_total);
if ($result_total) {
    $row_total = mysqli_fetch_assoc($result_total);
    $total_usuarios = $row_total['total'];
}

// Consulta para administrativos
$sql_admin = "SELECT COUNT(*) as count FROM personas WHERE rol = 'administrativo'";
$result_admin = mysqli_query($conn, $sql_admin);
if ($result_admin) {
    $row_admin = mysqli_fetch_assoc($result_admin);
    $administrativo = $row_admin['count'];
}

// Consulta para aprendices
$sql_aprendiz = "SELECT COUNT(*) as count FROM personas WHERE rol = 'aprendiz'";
$result_aprendiz = mysqli_query($conn, $sql_aprendiz);
if ($result_aprendiz) {
    $row_aprendiz = mysqli_fetch_assoc($result_aprendiz);
    $aprendices = $row_aprendiz['count'];
}

// Consulta para enfermeras
$sql_enfermera = "SELECT COUNT(*) as count FROM personas WHERE rol = 'enfermera'";
$result_enfermera = mysqli_query($conn, $sql_enfermera);
if ($result_enfermera) {
    $row_enfermera = mysqli_fetch_assoc($result_enfermera);
    $enfermeras = $row_enfermera['count'];
}

// Consulta para vigilantes
$sql_vigilante = "SELECT COUNT(*) as count FROM personas WHERE rol = 'vigilante'";
$result_vigilante = mysqli_query($conn, $sql_vigilante);
if ($result_vigilante) {
    $row_vigilante = mysqli_fetch_assoc($result_vigilante);
    $vigilantes = $row_vigilante['count'];
}

// Consulta para bienestar
$sql_bienestar = "SELECT COUNT(*) as count FROM personas WHERE rol = 'bienestar'";
$result_bienestar = mysqli_query($conn, $sql_bienestar);
if ($result_bienestar) {
    $row_bienestar = mysqli_fetch_assoc($result_bienestar);
    $bienestar = $row_bienestar['count'];
}

mysqli_close($conn);
