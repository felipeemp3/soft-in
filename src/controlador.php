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

  if ($rol == "Aprendiz") {
    header("Location: ../dashboards/aprendiz.php");
  } elseif ($rol == "Admin") {
    header("Location: ../dashboards/admin.php");
  } elseif ($rol == "Bienestar") {
    header("Location: ../dashboards/bienestar.php");
  } elseif ($rol == "Vigilante") {
    header("Location: ../dashboards/vigilante.php");
  } elseif ($rol == "Enfermera") {
    header("Location: ../dashboards/enfermera.php");
  }
} else {
  header("Location: ../dashboards/inicio-sesion.html?login=error");
  exit();
}
