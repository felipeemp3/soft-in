<?php
// Iniciar sesión SIEMPRE al principio
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no hay usuario logueado, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

// Verificar que el rol esté definido
if (!isset($_SESSION['rol'])) {
    session_destroy();
    header('Location: ../index.html');
    exit();
}

// Determinar en qué dashboard estamos
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Verificar si el usuario tiene acceso a esta página según su rol
$rol_permitido = '';

switch ($pagina_actual) {
    case 'aprendiz.php':
        $rol_permitido = 'aprendiz';
        break;
    case 'vigilante.php':
        $rol_permitido = 'vigilante';
        break;
    case 'bienestar.php':
        $rol_permitido = 'bienestar';
        break;
    case 'enfermera.php':
        $rol_permitido = 'enfermera';
        break;
    default:
        $rol_permitido = '';
}

// Si la página no requiere un rol específico o el rol no coincide, redirigir
if ($rol_permitido && $_SESSION['rol'] !== $rol_permitido) {
    // Redirigir al dashboard correspondiente según el rol
    switch ($_SESSION['rol']) {
        case 'aprendiz':
            header('Location: aprendiz.php');
            exit();
        case 'vigilante':
            header('Location: vigilante.php');
            exit();
        case 'bienestar':
            header('Location: bienestar.php');
            exit();
        case 'enfermera':
            header('Location: enfermera.php');
            exit();
        default:
            // Rol no reconocido, cerrar sesión
            session_destroy();
            header('Location: ../index.html');
            exit();
    }
}

// Solo para aprendices: verificar que los datos estén completos
if ($_SESSION['rol'] === 'aprendiz') {
    // Si no tenemos el id_persona en sesión, obtenerlo de la BD
    if (!isset($_SESSION['id_persona']) && isset($_SESSION['usuario_id'])) {
        $_SESSION['id_persona'] = $_SESSION['usuario_id'];
    }
    
    // Si no tenemos nombres o documento, intentar obtener de la BD
    if (!isset($_SESSION['nombres']) || !isset($_SESSION['documento'])) {
        require_once 'conexion.php';
        
        $usuario_id = $_SESSION['usuario_id'];
        $query = "SELECT nombres, apellidos, documento, programa_formacion, no_ficha 
                  FROM personas 
                  WHERE id_persona = ? AND rol = 'aprendiz'";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $aprendiz = $result->fetch_assoc();
                $_SESSION['nombres'] = $aprendiz['nombres'];
                $_SESSION['apellidos'] = $aprendiz['apellidos'];
                $_SESSION['documento'] = $aprendiz['documento'];
                $_SESSION['programa_formacion'] = $aprendiz['programa_formacion'] ?? '';
                $_SESSION['no_ficha'] = $aprendiz['no_ficha'] ?? '';
            } else {
                // Si no encuentra datos, usar valores por defecto
                $_SESSION['nombres'] = 'Aprendiz';
                $_SESSION['apellidos'] = '';
                $_SESSION['documento'] = 'Sin documento';
                $_SESSION['programa_formacion'] = '';
                $_SESSION['no_ficha'] = '';
            }
            
            $stmt->close();
        }
        $conn->close();
    }
}
?>