<?php include '../src/seguridad.php';?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Médica - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/modal-evaluacion-medica.css">
</head>

<body>
    <!-- Demo Button to Open Modal -->
    <button class="demo-button" onclick="openEvaluationModal()">
        <i class="fas fa-stethoscope"></i>
        Abrir Evaluación Médica
    </button>

    <!-- Medical Evaluation Modal -->
    <div class="modal-overlay" id="evaluationModal">
        <div class="modal-container">
            <button class="modal-close" onclick="closeEvaluationModal()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">VALORACIÓN MÉDICA</h2>
            </div>

            <form id="createUserForm" method="post" action="../src/controlador_enfer.php" class="user-form">
                <!-- Selector de personas -->
                <div class="form-field">
                    <label class="field-label">Seleccione una persona</label>
                    <div class="select-wrapper">
                        <select class="select-field" id="id_personas" name="id_personas" required>
                            <option value=""> Seleccione una persona </option>
                            <?php
                            include '../src/conexion.php';
                            $sql = "SELECT * FROM personas WHERE rol = 'aprendiz'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row["id_persona"] . '">' . $row["nombres"] . ' ' . $row["apellidos"] . '</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Campo de observación -->
                <div class="form-field">
                    <label class="field-label">Observación</label>
                    <textarea class="textarea-field" id="observacion" name="observacion"
                        placeholder="Escriba sus observaciones médicas aquí..." required></textarea>
                </div>

                <!-- Botón enviar -->
                <button type="submit" name="btnEnviar" class="send-button">
                    <i class="fas fa-paper-plane"></i>
                    ENVIAR VALORACIÓN
                </button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="success-modal">
            <button class="modal-close" onclick="closeSuccessModal()">×</button>

            <div class="success-logo">Soft-In</div>

            <div class="success-message">
                La evaluación médica ha sido enviada correctamente. El reporte será procesado por bienestra al Aprendiz.
            </div>

            <button class="accept-button" onclick="closeSuccessModal()">
                <i class="fas fa-check"></i>
                Aceptar
            </button>
        </div>
    </div>

    <script>
        // Funciones para manejar los modales
        function openEvaluationModal() {
            document.getElementById('evaluationModal').classList.add('active');
        }

        function closeEvaluationModal() {
            document.getElementById('evaluationModal').classList.remove('active');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
        }
    </script>
</body>

</html>