<?php include '../src/seguridad.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboard-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

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

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <header class="header">
        <div class="header-left">
            <div class="logo-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">SOFTWARE</div>
            </div>
        </div>
        <div class="header-center">
            ADMINISTRADOR
        </div>
            <button class="logout-btn" onclick="logoutUser()">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </div>
    </header>

    <main class="main-content">
        <div class="welcome-section">
            <h1 class="welcome-title" id="welcomeMessage">Panel de Administración</h1>
            <p class="welcome-subtitle">Gestiona usuarios, roles y permisos del sistema Soft-In</p>
        </div>

        <div class="admin-actions">
            <button class="action-btn primary" onclick="openCreateUserModal()">
                <i class="fas fa-user-plus"></i>
                Registrar Usuario
            </button>
        </div>

        <!-- Tarjetas de estadisticas -->
        <div class="stats-section">
            <?php include('../src/estadisticas_admin.php'); ?>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalUsers"><?php echo $total_usuarios; ?></div>
                    <div class="stat-label">Total Usuarios</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalAdministrativo"><?php echo $administrativo; ?></div>
                    <div class="stat-label">Administrativo</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalAprendices"><?php echo $aprendices; ?></div>
                    <div class="stat-label">Aprendices</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalEnfermeras"><?php echo $enfermeras; ?></div>
                    <div class="stat-label">Enfermeras</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalVigilantes"><?php echo $vigilantes; ?></div>
                    <div class="stat-label">Vigilantes</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="totalBienestar"><?php echo $bienestar; ?></div>
                    <div class="stat-label">Bienestar</div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="users-section" id="usersSection">
            <div class="section-header">
                <h2>Usuarios Registrados</h2>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar usuario..." id="searchInput">
                </div>
            </div>
            <div class="users-table-container">
                <table class="users-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Rol</th>
                            <th>Programa</th>
                            <th>Estado</th>
                            <th>Tipo de Aprendiz</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Los usuarios se mostraran en el dasbhoard-->
                        <?php
                        include('../src/mostrar.php');
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Pop up De registro de usuario -->
    <div class="modal-overlay" id="createUserModal">
        <div class="modal-container">
            <button class="modal-close" onclick="closeCreateUserModal()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">Registrar Nuevo Usuario</h2>
                <p class="modal-subtitle">Complete todos los campos para crear un nuevo usuario</p>
            </div>

            <form id="createUserForm" method="post" action="../src/registrar.php" class="user-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombres" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos *</label>
                        <input type="text" id="apellidos" name="apellidos" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tipoDoc">Tipo Doc *</label>
                        <select id="tipoDoc" name="tipo_documento" required>
                            <option value="">Seleccionar</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="PP">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="noDoc">No. Documento *</label>
                        <input type="text" id="documento" name="documento" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rol">Rol *</label>
                        <select id="rol" name="rol" required>
                            <option value="">Seleccionar Rol</option>
                            <option value="aprendiz">aprendiz</option>
                            <option value="enfermera">enfermera</option>
                            <option value="bienestar">bienestar</option>
                            <option value="vigilante">vigilante</option>
                            <option value="administrativo">administrativo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="programa">Programa de Formación *</label>
                        <select id="programa_formacion" name="programa_formacion">
                            <option value="">Seleccionar Programa</option>
                            <option value="adso">ADSO</option>
                            <option value="tga">TGA</option>
                            <option value="agricultura de presicion">Agricultura de presicion</option>
                            <option value="especies menores">Especies menores</option>
                            <option value="gestion Agropecuaria">Gestion Agropecuaria</option>
                            <option value="acuilcultura">Acuilcultura</option>
                            <option value="produccion ganadera">Produccion ganadera</option>
                            <option value="gestion agroempresarial">Gestion agroempresarial</option>
                            <option value="gestion ambiental">Gestion ambiental</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="noFicha">No. Ficha</label>
                        <input type="text" id="no_ficha" name="no_ficha">
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select id="estado_formacion" name="estado_formacion" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="Suspension temporal">Suspensión Temporal</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tipoAprendiz">Tipo de Aprendiz</label>
                        <select id="tipoAprendiz" name="tip_aprendiz">
                            <option value="">Seleccionar</option>
                            <option value="interno">Interno</option>
                            <option value="externo">Externo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña *</label>
                        <div class="password-input">
                            <input type="password" id="password_hash" name="password_hash" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeCreateUserModal()">
                        Cancelar
                    </button>
                    <button name="btnGuardar" type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i>
                        Guardar
                    </button>
                </div>
            </form>

            <!-- Pop Up Editar usuario -->
            <div class="modal-overlay" id="editUserModal">
                <div class="modal-container">
                    <button class="modal-close" name="onclick" onclick="closeEditUserModal()">×</button>

                    <div class="modal-header">
                        <h2 class="modal-title">Editar Usuario</h2>
                        <p class="modal-subtitle">Modifique los datos del usuario</p>
                    </div>

                    <form id="editUserForm" method="post" action=" ../src/edit.php" class="user-form">
                        <input type="hidden" id="editUserId" name="userId" value="">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="editNombre">Nombre *</label>
                                <input type="text" id="editNombre" name="nombres" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="editApellidos">Apellidos *</label>
                                <input type="text" id="editApellidos" name="apellidos" value="" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="editRol">Rol *</label>
                                <select id="editRol" name="rol" required>
                                    <option value="aprendiz">Aprendiz</option>
                                    <option value="enfermera">Enfermera</option>
                                    <option value="bienestar">Bienestar</option>
                                    <option value="vigilante">Vigilante</option>
                                    <option value="administrativo">Administrativo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editEstado">Estado *</label>
                                <select id="editEstado" name="estado_formacion" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                    <option value="Suspension temporal">Suspensión Temporal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeEditUserModal()">
                                Cancelar
                            </button>
                            <button name="btnActualizar" type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pop up mensaje exitoso -->
            <div class="modal-overlay" id="successModal">
                <div class="success-modal">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="success-title">¡Operación Exitosa!</h3>
                    <p class="success-message" id="successMessage">El usuario ha sido registrado correctamente.</p>
                    <button class="btn-accept" onclick="closeSuccessModal()">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para abrir modal de crear usuario
        function openCreateUserModal() {
            document.getElementById("createUserModal").classList.add("active")
            document.getElementById("createUserForm").reset()
        }

        // Función para cerrar modal de crear usuario
        function closeCreateUserModal() {
            document.getElementById("createUserModal").classList.remove("active")
        }

        function editarUsuario(documento) {
            // Mostrar modal de edición
            document.getElementById("editUserModal").classList.add("active")
        }

        // Función para cerrar modal de editar usuario
        function closeEditUserModal() {
            document.getElementById("editUserModal").classList.remove("active")
        }

        // Function para eliminar usuario
        function eliminarUsuario(userId) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                // Crear formulario dinámico para enviar la solicitud
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../src/delete_user.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_persona';
                input.value = userId;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
        // Función para cerrar sesión
        function logoutUser() {
            window.location.href = '../src/logout.php';
        }
function togglePassword() {
            const passwordInput = document.getElementById('password_hash');
            const toggleButton = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }

        // Función para cerrar modal de éxito
        function closeSuccessModal() {
            document.getElementById("successModal").classList.remove("active")
            // Recargar la página para reflejar los cambios
            location.reload();
        }
        
        // Búsqueda por Enter en el input de búsqueda
        (function() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            // Función que realiza la petición al backend y actualiza la tabla
            function performSearch() {
                const q = searchInput.value.trim();
                const url = '../src/buscar_user_admin.php' + (q ? ('?search=' + encodeURIComponent(q)) : '');

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        const tbody = document.getElementById('usersTableBody');
                        if (tbody) tbody.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Error buscando usuarios:', err);
                    });
            }
        })();
    </script>
</body>

</html>