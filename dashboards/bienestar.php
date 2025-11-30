<?php include '../src/seguridad.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bienestar - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboard-bienestar.css">
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
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="logo-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">SOFTWARE</div>
            </div>
        </div>
        <div class="header-center">
            BIENESTAR
        </div>
        <div class="header-right">
            <button class="logout-btn" onclick="confirmarCerrarSesion()" title="Cerrar sesión">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title"> </h1>
            <p class="welcome-subtitle">Sistema de gestion bienestar</p>
        </div>

        <!-- Action Buttons -->
        <div class="admin-actions">
            <button class="action-btn primary" onclick="mostrarLectorQR()">
                <i class="fas fa-qrcode"></i>
                Leer QR
            </button>
            <button class="action-btn secondary" onclick="mostrarHistorial()">
                <i class="fas fa-history"></i>
                Historial
            </button>
        </div>
        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number"></div>
                    <div class="stat-label">Ingresos Hoy</div>
                </div>
            </div>
        </div>

        <!-- QR Section -->
        <div class="users-section hidden" id="qr-section">
            <div class="section-header">
                <h2><i class="fas fa-qrcode"></i> Lector de Código QR</h2>
                <button class="btn-action btn-edit" onclick="cerrarLectorQR()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
            <div style="padding: 30px; text-align: center;">
                <div id="qr-reader" style="max-width: 500px; margin: 0 auto 20px;"></div>
                <div id="qr-result" class="hidden"
                    style="background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h4 style="color: #27ae60; margin-bottom: 10px;">✅ Código Escaneado</h4>
                    <p>Estudiante: <span id="qr-student-name"></span></p>
                    <p>Documento: <span id="qr-student-id"></span></p>
                    <button onclick="procesarQR()" class="btn-submit" style="margin-top: 15px;">
                        <i class="fas fa-check"></i> Procesar Ingreso
                    </button>
                </div>
                <div class="qr-instructions">
                    <p style="margin-bottom: 20px; color: #7f8c8d;">📷 Posiciona el código QR del estudiante frente a la
                        cámara</p>
                    <button onclick="iniciarEscaner()" class="action-btn primary">
                        <i class="fas fa-camera"></i> Iniciar Escáner
                    </button>
                </div>
            </div>
        </div>

        <!-- Historial Section -->
        <div class="users-section hidden" id="historial-section">
            <div class="section-header">
                <h2><i class="fas fa-history"></i> Historial de Ingresos</h2>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn-action btn-edit" onclick="toggleFiltros()">
                        <i class="fas fa-filter"></i> Filtros
                    </button>
                    <button class="btn-action btn-delete" onclick="descargarHistorialPDF()">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button class="btn-action btn-edit" onclick="cerrarHistorial()">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>

            <!-- Search Box -->
            <div style="padding: 0 30px 20px;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar por estudiante, documento, tipo..." id="search-input">
                    <button onclick="buscarRegistros()" class="btn-submit"
                        style="margin-left: 10px; padding: 10px 20px;">
                        Buscar
                    </button>
                </div>
            </div>

            <!-- Filters Panel -->
            <div id="filtros-panel" class="hidden"
                style="background: #f8f9fa; margin: 0 30px 20px; padding: 20px; border-radius: 10px; border: 1px solid #e9ecef;">
                <h4 style="margin-bottom: 15px; color: #2c3e50;">📅 Filtrar por Fecha</h4>
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Inicio:</label>
                        <input type="date" id="fecha-inicio"
                            style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Fin:</label>
                        <input type="date" id="fecha-fin"
                            style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Año:</label>
                        <select id="year-select"
                            style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                            <option value="">Todos los años</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button onclick="aplicarFiltros()" class="btn-submit">
                        <i class="fas fa-check"></i> Aplicar
                    </button>
                    <button onclick="limpiarFiltros()" class="btn-cancel">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
            </div>

            <!-- Records Table -->
            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo Ingreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="records-tbody">
                        <!-- Los registros se cargan dinámicamente aquí -->
                    </tbody>

                </table>
            </div>
        </div>
    </main>

    <!-- User Menu Modal -->
    <div class="modal-overlay" id="userMenuModal">
        <div class="modal-container" style="max-width: 350px;">
            <button class="modal-close" onclick="closeUserMenu()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">Nombre del Usuario</h2>
                <p class="modal-subtitle">BIENESTAR - Especialidad del Usuario</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button class="action-btn primary" onclick="abrirPerfil()"
                    style="justify-content: flex-start; padding: 15px 20px;">
                    <i class="fas fa-user"></i>
                    Mi Perfil
                </button>
                <button class="action-btn secondary" onclick="abrirConfiguracion()"
                    style="justify-content: flex-start; padding: 15px 20px;">
                    <i class="fas fa-cog"></i>
                    Configuración
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal-container" style="max-width: 400px;">
            <button class="modal-close" onclick="cancelarCerrarSesion()">×</button>

            <div class="modal-header">
                <div style="text-align: center;">
                    <i class="fas fa-sign-out-alt" style="font-size: 48px; color: #e74c3c; margin-bottom: 15px;"></i>
                    <h2 class="modal-title">Cerrar Sesión</h2>
                    <p class="modal-subtitle">¿Estás seguro que deseas cerrar sesión?</p>
                </div>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <p style="color: #7f8c8d; margin-bottom: 10px;">Se perderán los datos no guardados</p>
            </div>

            <div class="form-actions">
                <button class="btn-cancel" onclick="cancelarCerrarSesion()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn-submit" onclick="cerrarSesion()"
                    style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <i class="fas fa-sign-out-alt"></i>
                    Sí, Cerrar Sesión
                </button>
            </div>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div class="modal-overlay" id="student-modal">
        <div class="modal-container">
            <button class="modal-close" onclick="cerrarModalEstudiante()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">Detalles del Estudiante</h2>
                <p class="modal-subtitle">Información completa del registro</p>
            </div>

            <div id="student-details">
                <!-- Los detalles se cargan dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="success-title">¡Operación Exitosa!</h3>
            <p class="success-message" id="successMessage">La operación se completó correctamente.</p>
            <button class="btn-accept" onclick="closeSuccessModal()">
                Aceptar
            </button>
        </div>
    </div>
</body>

<script>
    // Funciones para mostrar/ocultar secciones
    function mostrarHistorial() {
        console.log("Mostrando historial")
        document.getElementById("historial-section").classList.remove("hidden")
        document.getElementById("qr-section").classList.add("hidden")
        buscarRegistros()
    }

    function cerrarHistorial() {
        console.log("Cerrando historial")
        document.getElementById("historial-section").classList.add("hidden")
    }

    function mostrarLectorQR() {
        document.getElementById("qr-section").classList.remove("hidden")
        document.getElementById("historial-section").classList.add("hidden")
    }

    function cerrarLectorQR() {
        document.getElementById("qr-section").classList.add("hidden")
    }

    function iniciarEscaner() {
        alert("Funcionalidad de escáner de QR no implementada.")
    }


 // Función para cerrar sesión
        function confirmarCerrarSesion() {
            window.location.href = '../src/logout.php';
        }

    // Funciones para el historial
    function buscarRegistros() {
        const input = document.getElementById('search-input');
        const q = input ? input.value.trim() : '';
        const url = '../src/bienestar_mostrar.php' + (q ? ('?search=' + encodeURIComponent(q)) : '');

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                const tbody = document.getElementById('records-tbody');
                const noRecords = document.getElementById('no-records');
                const recordsInfo = document.getElementById('records-info');
                if (!tbody) return;
                tbody.innerHTML = html;

                // Determinar si el backend devolvió la fila de "no hay registros"
                const hasNoRecords = !!tbody.querySelector('td[colspan]');
                if (hasNoRecords) {
                    noRecords.classList.remove('hidden');
                    recordsInfo.textContent = 'Mostrando 0 de 0 registros';
                } else {
                    noRecords.classList.add('hidden');
                    const rows = tbody.querySelectorAll('tr');
                    let total = 0;
                    rows.forEach(tr => {
                        if (!tr.querySelector('td[colspan]')) total++;
                    });
                    recordsInfo.textContent = `Mostrando ${total} de ${total} registros`;
                }
            })
            .catch(err => {
                console.error('Error cargando registros de bienestar:', err);
                document.getElementById('loadingOverlay').style.display = 'none';
            });
    }

    // Evento para búsqueda con Enter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarRegistros();
                }
            });
        }
    });


    // Función para limpiar la búsqueda
    function limpiarBusqueda() {
        document.getElementById("search-input").value = "";
        buscarRegistros();
    }

    // También puedes añadir un evento para el botón de limpiar si lo tienes
    document.addEventListener('DOMContentLoaded', function() {
        const clearBtn = document.getElementById('clear-search-btn');
        if (clearBtn) {
            clearBtn.addEventListener('click', limpiarBusqueda);
        }
    });

    // Función para cargar el conteo de ingresos hoy
function cargarConteoIngresosHoy() {
    fetch('../src/conteo_bienestar.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar el contador en la interfaz
                const statCards = document.querySelectorAll('.stat-card');
                if (statCards.length > 0) {
                    // El primer stat-card es para "Ingresos Hoy"
                    const statNumber = statCards[0].querySelector('.stat-number');
                    if (statNumber) {
                        statNumber.textContent = data.total_hoy;
                        
                        // Efecto de animación al actualizar
                        statNumber.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            statNumber.style.transform = 'scale(1)';
                        }, 300);
                    }
                }
            } else {
                console.error('Error al cargar el conteo:', data.error);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
}

// Cargar el conteo cuando la página esté lista
document.addEventListener('DOMContentLoaded', function() {
    cargarConteoIngresosHoy();
    
    // Recargar el conteo cada 30 segundos para mantenerlo actualizado
    setInterval(cargarConteoIngresosHoy, 10000);
});
</script>
</html>