<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-button'])) {
    $documento = trim($_POST['documento'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($documento) || empty($password)) {
        header('Location: ../index.html?login=error');
        exit();
    }

    // Buscar usuario por documento
    $query = "SELECT id_persona, documento, password_hash, nombres, apellidos, rol, programa_formacion, no_ficha 
              FROM personas 
              WHERE documento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar contraseña (en tu BD está en texto plano como '123')
        if ($password === $user['password_hash']) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $user['id_persona'];
            $_SESSION['nombres'] = $user['nombres'];
            $_SESSION['apellidos'] = $user['apellidos'];
            $_SESSION['documento'] = $user['documento'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['programa_formacion'] = $user['programa_formacion'];
            $_SESSION['no_ficha'] = $user['no_ficha'];
            $_SESSION['id_persona'] = $user['id_persona']; // Añadir esta línea

            // Redirigir según el rol
            switch ($user['rol']) {
                case 'aprendiz':
                    header('Location: ../dashboards/aprendiz.php');
                    exit();

                case 'vigilante':
                    header('Location: ../dashboards/vigilante.php');
                    exit();

                case 'bienestar':
                    header('Location: ../dashboards/bienestar.php');
                    exit();

                case 'enfermera':
                    header('Location: ../dashboards/enfermera.php');
                    exit();  // ← AQUÍ ESTABA EL PROBLEMA

                case 'admin':
                    header('Location: ../dashboards/admin.php');
                    exit();

                default:
                    header('Location: ../index.html?login=error');
                    exit();
            }
        } else {
            header('Location: ../index.html?login=error');
            exit();
        }
    } else {
        header('Location: ../index.html?login=error');
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../index.html');
    exit();
}
