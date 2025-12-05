
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vigilante - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboard-vigilante.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="logo-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">SOFTWARE</div>
            </div>
        </div>
        <div class="header-center">
            VIGILANTE
        </div>
        <div class="header-right">
            <button class="logout-btn" onclick="logoutUser()">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">Sistema de Control de Acceso y Seguridad</h1>
        </div>

        <!-- Action Buttons -->
        <div class="admin-actions">
            <button class="action-btn primary" onclick="mostrarLectorQR()">
                <i class="fas fa-qrcode"></i>
                Leer QR
            </button>
            <button class="action-btn secondary" onclick="mostrarHistorial()">
                <i class="fas fa-history"></i>
                Historial de Ingreso
            </button>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">47</div>
                    <div class="stat-label">Ingresos Hoy</div>
                </div>
            </div>
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
                <div id="qr-result" class="hidden" style="background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h4 style="color: #27ae60; margin-bottom: 10px;">✅ Código Escaneado</h4>
                    <p><strong>Persona:</strong> <span id="qr-person-name"></span></p>
                    <p><strong>Documento:</strong> <span id="qr-person-id"></span></p>
                    <p><strong>Rol:</strong> <span id="qr-person-role"></span></p>
                    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: center;">
                        <button onclick="registrarIngreso()" class="btn-submit" style="background: #27ae60;">
                            <i class="fas fa-sign-in-alt"></i> Registrar Ingreso
                        </button>
                        <button onclick="registrarSalida()" class="btn-submit" style="background: #e74c3c;">
                            <i class="fas fa-sign-out-alt"></i> Registrar Salida
                        </button>
                    </div>
                </div>
                <div class="qr-instructions">
                    <p style="margin-bottom: 20px; color: #7f8c8d;">Posiciona el código QR frente a la cámara</p>
                    <button onclick="iniciarEscaner()" class="action-btn primary">
                        <i class="fas fa-camera"></i> Iniciar Escáner
                    </button>
                </div>
            </div>
        </div>

        <!-- Historial Section -->
        <div class="users-section hidden" id="historial-section">
            <div class="section-header">
                <h2><i class="fas fa-history"></i> Historial de Ingreso</h2>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn-action btn-edit" onclick="cerrarHistorial()">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>

            <!-- Search Box -->
            <div style="padding: 0 30px 20px;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar por nombre, documento, rol..." id="search-input">
                    <button onclick="buscarRegistros()" class="btn-submit" style="margin-left: 10px; padding: 10px 20px;">
                        Buscar
                    </button>
                </div>
            </div>

            <!-- Filters Panel -->
            <div id="filtros-panel" class="hidden" style="background: #f8f9fa; margin: 0 30px 20px; padding: 20px; border-radius: 10px; border: 1px solid #e9ecef;">
                <h4 style="margin-bottom: 15px; color: #2c3e50;">📅 Filtrar Registros</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Inicio:</label>
                        <input type="date" id="fecha-inicio" style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Fin:</label>
                        <input type="date" id="fecha-fin" style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo:</label>
                        <select id="tipo-select" style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                            <option value="">Todos los tipos</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Salida">Salida</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Rol:</label>
                        <select id="rol-select" style="width: 100%; padding: 10px; border: 2px solid #e9ecef; border-radius: 8px;">
                            <option value="">Todos los roles</option>
                            <option value="Estudiante">Estudiante</option>
                            <option value="Docente">Docente</option>
                            <option value="Administrativo">Administrativo</option>
                            <option value="Visitante">Visitante</option>
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
                <table class="users-table" id="historial-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Rol</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="records-tbody">
                        <!-- Los registros se cargan dinámicamente -->
                    </tbody>
                </table>
            </div>

            <div id="no-records" class="hidden" style="text-align: center; padding: 40px; color: #7f8c8d;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                <p>No se encontraron registros</p>
            </div>

            <div style="text-align: center; padding: 20px; color: #7f8c8d; font-size: 14px;">
                <span id="records-info">Mostrando 0 de 0 registros</span>
            </div>
        </div>
    </main>

    <!-- User Menu Modal -->
    <div class="modal-overlay" id="userMenuModal">
        <div class="modal-container" style="max-width: 350px;">
            <button class="modal-close" onclick="closeUserMenu()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">Nombre del Vigilante</h2>
                <p class="modal-subtitle">VIGILANTE - Turno Diurno</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button class="action-btn primary" onclick="abrirPerfil()" style="justify-content: flex-start; padding: 15px 20px;">
                    <i class="fas fa-user"></i>
                    Mi Perfil
                </button>
                <button class="action-btn secondary" onclick="abrirConfiguracion()" style="justify-content: flex-start; padding: 15px 20px;">
                    <i class="fas fa-cog"></i>
                    Configuración
                </button>
                <button class="action-btn" onclick="confirmarCerrarSesion()" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; justify-content: flex-start; padding: 15px 20px; box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
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
                <button class="btn-submit" onclick="cerrarSesion()" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <i class="fas fa-sign-out-alt"></i>
                    Sí, Cerrar Sesión
                </button>
            </div>
        </div>
    </div>

    <!-- Person Details Modal -->
    <div class="modal-overlay" id="person-modal">
        <div class="modal-container">
            <button class="modal-close" onclick="cerrarModalPersona()">×</button>

            <div class="modal-header">
                <h2 class="modal-title">Detalles del Registro</h2>
                <p class="modal-subtitle">Información completa del acceso</p>
            </div>

            <div id="person-details">
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

    <!-- Print Area (Hidden) -->
    <div id="print-area" style="display: none;">
        <div class="print-header">
            <h1>SOFT-IN - Historial de Acceso</h1>
            <p>Reporte generado el: <span id="print-date"></span></p>
            <p>Vigilante: <span id="print-guard"></span></p>
        </div>
        <table class="print-table" id="print-table">
            <!-- Se llena dinámicamente -->
        </table>
    </div>

    <script>
        // Funciones principales del dashboard
        function mostrarLectorQR() {
            console.log("Mostrando lector QR")
            document.getElementById("qr-section").classList.remove("hidden")
            document.getElementById("historial-section").classList.add("hidden")
        }

        function cerrarLectorQR() {
            console.log("Cerrando lector QR")
            document.getElementById("qr-section").classList.add("hidden")
            if (qrCodeScanner) {
                qrCodeScanner.clear()
                qrCodeScanner = null
            }
            document.getElementById("qr-result").classList.add("hidden")
        }

        function mostrarHistorial() {
            console.log("Mostrando historial")
            document.getElementById("historial-section").classList.remove("hidden")
            document.getElementById("qr-section").classList.add("hidden")
            cargarRegistros()
        }

        function cerrarHistorial() {
            console.log("Cerrando historial")
            document.getElementById("historial-section").classList.add("hidden")
        }

        // Función para cerrar sesión
        function logoutUser() {
            window.location.href = '../src/logout.php';
        }

        // Funciones del lector QR
        function iniciarEscaner() {
            console.log("Iniciando escáner QR")
            const qrReaderElement = document.getElementById("qr-reader")
            qrReaderElement.innerHTML = ""

            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0,
                disableFlip: false,
            }

            const Html5QrcodeScanner = window.Html5QrcodeScanner
            qrCodeScanner = new Html5QrcodeScanner("qr-reader", config, false)

            qrCodeScanner.render(
                (decodedText, decodedResult) => {
                    onScanSuccess(decodedText, decodedResult)
                },
                (error) => {
                    console.warn(`Error de escaneo QR: ${error}`)
                },
            )

            document.querySelector(".qr-instructions").style.display = "none"
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log("QR escaneado exitosamente:", decodedText)
            if (qrCodeScanner) {
                qrCodeScanner.clear()
            }

            personaEscaneada = procesarCodigoQR(decodedText)

            document.getElementById("qr-person-name").textContent = personaEscaneada.nombre
            document.getElementById("qr-person-id").textContent = personaEscaneada.documento
            document.getElementById("qr-person-role").textContent = personaEscaneada.rol
            document.getElementById("qr-result").classList.remove("hidden")

            showSuccessMessage("Código QR escaneado exitosamente")
        }

        function cargarRegistros() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    const tbody = document.getElementById('records-tbody');
    const noRecords = document.getElementById('no-records');
    const recordsInfo = document.getElementById('records-info');
    
    loadingOverlay.style.display = 'flex';
    
    // Obtener parámetros de filtros
    const search = document.getElementById('search-input').value || '';
    const fechaInicio = document.getElementById('fecha-inicio').value || '';
    const fechaFin = document.getElementById('fecha-fin').value || '';
    const tipo = document.getElementById('tipo-select').value || '';
    const rol = document.getElementById('rol-select').value || '';
    
    const url = `../src/vigilante_historial.php?search=${encodeURIComponent(search)}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.registros.length === 0) {
                    noRecords.classList.remove('hidden');
                    tbody.innerHTML = '';
                } else {
                    noRecords.classList.add('hidden');
                    tbody.innerHTML = data.registros.map(registro => {
                        // Formatear fecha y hora
                        const fecha = new Date(registro.fecha_escaneo);
                        const fechaFormateada = fecha.toLocaleDateString('es-CO');
                        const horaFormateada = fecha.toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' });
                        
                        // Determinar tipo de registro
                        let tipoRegistro = 'Ingreso';
                        if (registro.tipo_ingreso === 'salida') {
                            tipoRegistro = 'Salida';
                        }
                        
                        // Determinar estado
                        let estadoClass = 'status-completed';
                        let estadoText = 'Completado';
                        
                        if (registro.estado === 'escaneado') {
                            estadoClass = 'status-pending';
                            estadoText = 'Pendiente';
                        } else if (registro.estado === 'en_bienestar') {
                            estadoClass = 'status-process';
                            estadoText = 'En Bienestar';
                        } else if (registro.estado === 'en_enfermeria') {
                            estadoClass = 'status-attention';
                            estadoText = 'En Enfermería';
                        }
                        
                        return `
                            <tr>
                                <td>${fechaFormateada}</td>
                                <td>${horaFormateada}</td>
                                <td>${registro.nombres} ${registro.apellidos}</td>
                                <td>${registro.documento}</td>
                                <td>${registro.rol}</td>
                                <td>${tipoRegistro}</td>
                                <td><span class="${estadoClass}">${estadoText}</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="verDetalles(${registro.id_ingreso})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
                
                recordsInfo.textContent = `Mostrando ${data.registros.length} de ${data.total_registros} registros`;
            } else {
                console.error('Error al cargar los registros:', data.error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; color: #e74c3c; padding: 20px;">
                            Error al cargar los registros: ${data.error}
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; color: #e74c3c; padding: 20px;">
                        Error de conexión. Por favor, intenta nuevamente.
                    </td>
                </tr>
            `;
        })
        .finally(() => {
            loadingOverlay.style.display = 'none';
        });
}
    </script>

</body>

</html>