<?php

include('conexion.php');

session_start();

if (isset($_POST["login-button"]))

  $usuario = $_POST["documento"];
$password = $_POST["password"];
$rol = "";

$sql = "SELECT * FROM personas WHERE documento = '$usuario'  AND password_hash = '$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $rol = $row["rol"];
  }

  $_SESSION['rol'] = $rol;
  $_SESSION['documento'] = $usuario;

  if ($rol == "Aprendiz" || $rol == "aprendiz") {
    header("Location: ../dashboards/aprendiz.php");
  } elseif ($rol == "Admin" || $rol == "admin") {
    header("Location: ../dashboards/admin.php");
  } elseif ($rol == "Bienestar" || $rol == "bienestar") {
    header("Location: ../dashboards/bienestar.php");
  } elseif ($rol == "Vigilante" || $rol == "vigilante") {
    header("Location: ../dashboards/vigilante.php");
  } elseif ($rol == "Enfermera" || $rol == "enfermera") {
    header("Location: ../dashboards/enfermera.php");
  }
} else {
  header("Location: ../dashboards/inicio-sesion.html?login=error");
  exit();
}
