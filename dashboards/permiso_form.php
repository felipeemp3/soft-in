<?php include '../src/seguridad.php'; ?>
<!DOCTYPE html>

    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Permiso Formación</title>
        <link rel="stylesheet" href="../public/css/permiso-formacion-aprendiz.css">
    </head>

    <body>

        <div class="form-container">
            <div class="form-header">
                <div class="header-title">
                    <div class="header-icon">📋</div>
                    Soft-In
                </div>
                <button class="close-button" onclick="goBack()" aria-label="Volver a la página anterior">×</button>
            </div>

            <div class="form-body">
                <h2 class="form-title">PERMISO FORMACIÓN</h2>

                <form id="permisoForm" action="../src/permiso_apr_contol.php" method="get">
                    <div class="form-group">
                    </div>

                    <label class="form-label" for="id_personas">Seleccione su usuario</label>
                    <select id="id_personas" name="id_personas" class="form-input">
                        <!-- opciones aquí -->

                    <?php
                    include '../src/conexion.php';

                    $sql = "SELECT * FROM personas";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Salida de datos de cada fila
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Usar el id correcto (id_persona) y mostrar nombre completo
                            $id = isset($row['id_persona']) ? $row['id_persona'] : (isset($row['id_personas']) ? $row['id_personas'] : '');
                            $label = trim(($row["nombres"] ?? '') . ' ' . ($row["apellidos"] ?? '')) ?: ($row["nombres"] ?? '');
                            echo '<option value="' . $id . '">' . htmlspecialchars($label) . '</option>';
                        }
                    }
                    ?>
                    </select>

                    <div class="form-group">
                        <label class="form-label" for="programa">Programa de Formación *</label>
                        <select
                            id="programa"
                            name="programa"
                            class="form-input"
                            required>
                            <option value="">Seleccione un programa</option>
                            <?php
                            include '../src/conexion.php';

                            // Obtener programas únicos de formación de la tabla personas
                            $sql = "SELECT DISTINCT `programa_formacion` FROM personas WHERE `programa_formacion` IS NOT NULL AND `programa_formacion` != '' ORDER BY `programa_formacion`";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $programa = htmlspecialchars($row['programa_formacion']);
                                    echo '<option value="' . $programa . '">' . $programa . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fecha">Fecha</label>
                        <input
                            type="date"
                            id="fecha"
                            name="fecha"
                            class="form-input"
                            required>
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

                    <div class="button-group">
                        <button type="button" class="btn btn-secondary" onclick="attachPDF()">
                            Adjuntar PDF
                        </button>
                        <button type="submit" class="btn btn-primary" name="btnPermiso">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function goBack() {
                // Navegar a la página anterior
                window.history.back();
            }

            function attachPDF() {
                // Crear un input file temporal para seleccionar PDF
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = '.pdf';
                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        alert('Archivo seleccionado: ' + file.name);
                        // Aquí puedes agregar la lógica para manejar el archivo PDF
                    }
                };
                input.click();
            }
            // Permitir cerrar con la tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    goBack();
                }
            });
        </script>
    </body>

    </html>