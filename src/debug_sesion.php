<?php
session_start();
echo "<h1>Datos de Sesión</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Verificar conexión a BD
require_once 'conexion.php';
echo "<h1>Prueba de conexión a BD</h1>";

$query = "SELECT id_persona, nombres, apellidos, documento, rol FROM personas WHERE rol = 'aprendiz'";
$result = $conn->query($query);

echo "<h2>Aprendices en la base de datos:</h2>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id_persona'] . " - Nombre: " . $row['nombres'] . " " . $row['apellidos'] . " - Documento: " . $row['documento'] . "<br>";
    }
} else {
    echo "No hay aprendices en la base de datos";
}
?>