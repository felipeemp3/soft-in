<?php 
include '../src/seguridad.php';
include '../src/conexion.php';

// Obtener el documento de la sesión
$documento = $_SESSION['documento'];

// Obtener datos del aprendiz usando el documento
$sql = "SELECT * FROM personas WHERE documento = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $documento);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo '<script>alert("Usuario no encontrado en la base de datos");</script>';
    echo '<script>window.location.href = "../inicio-sesion.html";</script>';
    exit();
}

$aprendiz = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Obtener nombre completo
$nombre_completo = trim(($aprendiz['nombres'] ?? '') . ' ' . ($aprendiz['apellidos'] ?? ''));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permiso Formación - Aprendiz</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/permiso-formacion-aprendiz.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="header-title">
                <div class="header-icon">📋</div>
                Soft-In
            </div>
            <button class="close-button" onclick="goBack()" aria-label="Volver">×</button>
        </div>

        <div class="form-body">
            <h2 class="form-title">PERMISO FORMACIÓN</h2>

            <form method="POST" action="../src/permiso_apr_contol.php" enctype="multipart/form-data">
                <!-- Mostrar información del aprendiz --> 
                <div class="form-group">
                    <label class="form-label">Nombre del Aprendiz</label>
                    <input 
                        type="text" 
                        class="form-input"
                        value="<?php echo htmlspecialchars($nombre_completo ?: 'Nombre no disponible'); ?>"
                        readonly>
                    
                    <!-- Campos ocultos necesarios para el controlador -->
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre_completo); ?>">
                    <input type="hidden" name="id_persona" value="<?php echo htmlspecialchars($aprendiz['id_persona']); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="programa">Programa de Formación *</label>
                    <input 
                        type="text" 
                        id="programa"
                        name="programa"
                        class="form-input"
                        value="<?php echo htmlspecialchars($aprendiz['programa_formacion'] ?? ''); ?>"
                        readonly
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_ficha">N° Ficha *</label>
                    <input 
                        type="text" 
                        id="no_ficha"
                        name="no_ficha"
                        class="form-input"
                        value="<?php 
                            $ficha = $aprendiz['no_ficha'] ?? 
                                     $aprendiz['_no_ficha'] ?? 
                                     $aprendiz['num_ficha'] ?? 
                                     $aprendiz['ficha'] ?? 
                                     $aprendiz['numero_ficha'] ?? 
                                     '';
                            echo htmlspecialchars($ficha);
                        ?>"
                        readonly
                        required
                        placeholder="Número de ficha no encontrado">
                </div>

                <div class="form-group">
                    <label class="form-label" for="fecha">Fecha del Permiso *</label>
                    <input 
                        type="date" 
                        id="fecha" 
                        name="fecha" 
                        class="form-input" 
                        required
                        min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="observacion">Observación</label>
                    <textarea 
                        id="observacion" 
                        name="observacion" 
                        class="form-textarea" 
                        placeholder="Escribe aquí cualquier observación adicional..."
                        rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="archivo_pdf">Anexar PDF (Opcional)</label>
                    <input 
                        type="file" 
                        id="archivo_pdf" 
                        name="archivo_pdf" 
                        class="form-input"
                        accept=".pdf">
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" onclick="goBack()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" name="btnPermiso">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        // Establecer fecha mínima como hoy
        document.getElementById('fecha').min = new Date().toISOString().split('T')[0];

        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                goBack();
            }
        });
        
        // Validación simple antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const fecha = document.getElementById('fecha').value;
            if (!fecha) {
                e.preventDefault();
                alert('Por favor, selecciona una fecha para el permiso.');
                document.getElementById('fecha').focus();
            }
        });
    </script>
</body>
</html>