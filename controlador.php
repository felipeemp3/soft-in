<?php

include('conexion.php');

session_start();

if (isset($_POST["login-button"])) {

  $usuario = $_POST["documento"];
  $password = $_POST["password"];
  $rol = "";

  $sql = "SELECT * FROM personas WHERE documento = '$usuario'  AND password_hash = '$password'";
  echo "<br>" . $sql . "<br>";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $rol = $row["rol"];
    }
    $_SESSION['rol'] = $rol;
    $_SESSION['documento'] = $usuario;


    if ($rol == "Aprendiz") {
      header("location: dashboard-aprendiz.html");
    } elseif ($rol == "Administrativo") {
      header("location: dashboard-admin.html");
    } elseif ($rol == "Bienestra") {
      header("location: dashboard-bienestar.html");
    } elseif ($rol == "Vigilante") {
      header("location: dashboard-vigilante.html");
    } elseif ($rol == "Enfermera") {
      header("location: dashboard-enfermera.html");
    }
    
    
  } else {
    echo "el usuario o contraseña son incorrectos";
  };

}
