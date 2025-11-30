<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_persona'])) {
    $id_persona = $_POST['id_persona'];

    // Preparar la consulta para evitar inyecciones SQL
    $stmt = $conn->prepare("DELETE FROM personas WHERE id_persona = ?");
    $stmt->bind_param("i", $id_persona);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página principal
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud inválida";
}
