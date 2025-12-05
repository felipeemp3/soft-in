<?php
session_start();
if (!isset($_SESSION['documento'])) {
    echo '<script>alert("Acesso denegado, que esperas bro? creiste que iba a ser facil?");</script> ';
    header("Location: ../dashboards/inicio-sesion.html");
    exit();
}
