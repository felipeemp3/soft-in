<?php
include '../src/seguridad.php';
include '../src/conexion.php';

// CONSULTA CON JOIN PARA OBTENER DATOS DE PERSONAS Y PERMISO
$sql = "SELECT p.*, per.nombres, per.apellidos, per.documento, 
                per.programa_formacion as programa, per.no_ficha as ficha,
                CONCAT(per.nombres, ' ', per.apellidos) as nombre_completo
        FROM permiso p
        INNER JOIN personas per ON p.id_persona = per.id_persona
        WHERE p.estado = 'Pendiente' OR p.estado = 'pendiente'";
$result = $conn->query($sql);

// TOTAL PERSONAS (solo aprendices, asumiendo rol='aprendiz')
$total = $conn->query("SELECT COUNT(*) AS total FROM personas WHERE rol='aprendiz'")
    ->fetch_assoc()['total'];

// PENDIENTES (tabla permiso con estado pendiente)
$pendientes = $conn->query("SELECT COUNT(*) AS pendiente FROM permiso WHERE estado='Pendiente' OR estado='pendiente'")
    ->fetch_assoc()['pendiente'];

// EVALUADOS (tabla permiso con estado evaluado)
$evaluados = $conn->query("SELECT COUNT(*) AS evaluados FROM permiso WHERE estado='Evaluado' OR estado='evaluado'")
    ->fetch_assoc()['evaluados'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Enfermera</title>
    <link rel="stylesheet" href="../public/css/dashboard-enfermera.css">
    <style>
        .logout-btn {
            background: #e63946;
            color: #fff;
            border: none;
            padding: 12px 22px;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.25s;
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.4);
        }

        .logout-btn:hover {
            background: #c92c38;
            transform: translateY(-2px);
        }

        .logout-btn:active {
            transform: scale(0.96);
        }
    </style>
</head>

<body>


<header class="header">
    <div class="container header-flex"> <div class="header-title"> <h1>Dashboard Enfermera</h1>
            <p>Gestión de Aprendices</p>
        </div>
        <div class="header-left"> <button class="logout-btn" onclick="logoutUser()" style="text-align: right;">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </div>
    </div>
</header>
    <main class="container">

        <!-- Tarjetas -->
        <section class="stats">
            <div class="stat-card">
                <h3>Total Aprendices</h3>
                <p class="stat-number"><?= $total ?></p>
            </div>

            <div class="stat-card">
                <h3>Pendientes</h3>
                <p class="stat-number"><?= $pendientes ?></p>
            </div>

            <div class="stat-card">
                <h3>Evaluados</h3>
                <p class="stat-number"><?= $evaluados ?></p>
            </div>
        </section>

        <!-- Tabla -->
        <section class="table-section">
            <h2>Aprendices Pendientes de Valoración</h2>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Programa</th>
                            <th>Ficha</th>
                            <th>Fecha Solicitud</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()):
                                $nombre_js = htmlspecialchars($row['nombre_completo'], ENT_QUOTES);
                                $documento_js = htmlspecialchars($row['documento'], ENT_QUOTES);
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nombre_completo']) ?></td>
                                    <td><?= htmlspecialchars($row['documento']) ?></td>
                                    <td><?= htmlspecialchars($row['programa']) ?></td>
                                    <td><?= htmlspecialchars($row['ficha']) ?></td>
                                    <td><?= htmlspecialchars($row['fecha_solicitud']) ?></td>
                                    <td><span class="badge pending"><?= htmlspecialchars($row['estado']) ?></span></td>
                                    <td>
                                        <button class="btn-valorar"
                                            onclick="openValoracionModal(
                                                    <?= $row['id_permiso'] ?>,
                                                    <?= $row['id_persona'] ?>,
                                                    '<?= $nombre_js ?>',
                                                    '<?= $documento_js ?>'
                                                )">
                                            Valorar
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            endwhile;
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No hay solicitudes pendientes</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- MODAL CORREGIDO -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>

            <h2>Valorar Aprendiz</h2>

            <form class="form-valoracion" method="POST" action="../src/controlador_enfer.php">
                <input type="hidden" id="id_permiso" name="id_permiso">
                <input type="hidden" id="id_persona" name="id_personas"> <!-- IMPORTANTE: nombre debe coincidir con controlador -->
                <input type="hidden" id="doc_aprendiz" name="documento">

                <div class="form-group">
                    <label for="nombre_aprendiz">Aprendiz:</label>
                    <input type="text" id="nombre_aprendiz" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones Médicas:</label>
                    <textarea id="observaciones" name="observacion" class="form-control" rows="8" required></textarea>
                    <!-- IMPORTANTE: name="observacion" debe coincidir con controlador -->
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                    <button type="submit" name="btnEnviar" class="btn btn-primary">Guardar Valoración</button>
                    <!-- IMPORTANTE: name="btnEnviar" debe coincidir con controlador -->
                </div>
            </form>
        </div>
    </div>

    <script>
        // Actualizar debug info
        document.getElementById('debugInfo').textContent = 'JS Loaded: Yes';

        // ABRIR MODAL - FUNCIÓN CORREGIDA
        function openValoracionModal(idPermiso, idPersona, nombre, documento) {
            console.log('Abriendo modal para:', {
                idPermiso: idPermiso,
                idPersona: idPersona,
                nombre: nombre,
                documento: documento
            });

            // Asignar valores a los campos ocultos
            document.getElementById("id_permiso").value = idPermiso;
            document.getElementById("id_persona").value = idPersona;
            document.getElementById("doc_aprendiz").value = documento;
            document.getElementById("nombre_aprendiz").value = nombre;

            // Mostrar el modal
            document.getElementById("modal").classList.add("active");

            // Focus en el textarea
            setTimeout(() => {
                document.getElementById("observaciones").focus();
            }, 100);
        }

        // CERRAR MODAL
        function closeModal() {
            console.log('Cerrando modal');
            document.getElementById("modal").classList.remove("active");

            // Limpiar formulario
            document.getElementById("observaciones").value = '';
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('modal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && document.getElementById('modal').classList.contains('active')) {
                closeModal();
            }
        });

        // Función de cierre de sesión (placeholder)
        function logoutUser() {
            window.location.href = '../src/logout.php';
        }
    </script>

</body>

</html>