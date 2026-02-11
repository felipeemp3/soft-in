<?php
$servername = getenv ('DB_HOST'); 
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD'); 
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error al conectar la base de datos: " . $conn->connect_error);
}
/// echo "¡Estoy conectado al local de la base de datos!";
?>