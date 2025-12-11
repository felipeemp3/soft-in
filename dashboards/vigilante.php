<?php include('../src/seguridad.php');
if ($_SESSION['rol'] !== 'vigilante') {
    header("Location: ../index.php");
    exit();
}
include('../src/conexion.php');
// Obtener estadísticas de ingresos hoy
$ingresos_hoy = 0;
$sql_ingresos_hoy = "SELECT COUNT(*) as total FROM vigilante_leer_qr WHERE DATE (fecha_lectura) = CURDATE()";
$result_ingresos_hoy = mysqli_query($conn, $sql_ingresos_hoy);
if ($result_ingresos_hoy) {
    $row = mysqli_fetch_assoc($result_ingresos_hoy);
    $ingresos_hoy = $row['total'];
}
$conn->close();

?>


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

    /* Estilos para el modal de éxito */
    .success-modal {
        background: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    .success-icon {
        font-size: 60px;
        color: #4CAF50;
        margin-bottom: 20px;
        animation: successBounce 0.5s ease-out;
    }

    .success-title {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 24px;
    }

    .success-message {
        color: #7f8c8d;
        margin-bottom: 25px;
        font-size: 16px;
        line-height: 1.5;
    }

    .btn-accept {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }

    .btn-accept:hover {
        background: #388E3C;
        transform: translateY(-2px);
    }

    @keyframes successBounce {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Estilos para los estados en la tabla */
    .status-completed {
        background: #d4edda;
        color: #155724;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-process {
        background: #cce5ff;
        color: #004085;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-attention {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .hidden {
        display: none !important;
    }

    /* Estilos para el lector QR */
    #qr-reader {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }

    #qr-reader__dashboard_section_csr {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .qr-instructions {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
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
                    <div class="stat-number" id="ingresosHoy">0</div>
                    <div class="stat-label">Ingresos Hoy
                        <?php $ingresos_hoy; ?>
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
    <div class="modal-overlay hidden" id="successModal">
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

    <script>
        // Variables globales
        let qrCodeScanner = null;
        let tokenActual = null;
        let qrDataCache = null;

        // Cargar estadísticas al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarEstadisticas();
        });

        // ===================== FUNCIONES PRINCIPALES =====================

        function mostrarLectorQR() {
            console.log("Mostrando lector QR");
            document.getElementById("qr-section").classList.remove("hidden");
            document.getElementById("historial-section").classList.add("hidden");

            // Iniciar escáner automáticamente
            setTimeout(() => {
                iniciarEscaner();
            }, 500);
        }

        function cerrarLectorQR() {
            console.log("Cerrando lector QR");
            document.getElementById("qr-section").classList.add("hidden");
            if (qrCodeScanner) {
                qrCodeScanner.clear();
                qrCodeScanner = null;
            }
            document.getElementById("qr-result").classList.add("hidden");
            document.querySelector('.qr-instructions').style.display = 'block';
        }

        function mostrarHistorial() {
            console.log("Mostrando historial");
            document.getElementById("historial-section").classList.remove("hidden");
            document.getElementById("qr-section").classList.add("hidden");
            cargarRegistros();
        }

        function cerrarHistorial() {
            console.log("Cerrando historial");
            document.getElementById("historial-section").classList.add("hidden");
        }

        // ===================== FUNCIONES QR ESCÁNER =====================

        function iniciarEscaner() {
            console.log("Iniciando escáner QR");
            const qrReaderElement = document.getElementById("qr-reader");
        

            // Limpiar contenido previo
            qrReaderElement.innerHTML = "";

            // Ocultar instrucciones y resultados previos
            document.querySelector('.qr-instructions').style.display = 'none';
            document.getElementById("qr-result").classList.add("hidden");

            // Configuración del escáner
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0,
                disableFlip: false,
            };

            // Crear instancia del escáner
            const Html5QrcodeScanner = window.Html5QrcodeScanner;
            qrCodeScanner = new Html5QrcodeScanner("qr-reader", config, false);

            qrCodeScanner.render(
                (decodedText, decodedResult) => {
                    console.log("QR escaneado:", decodedText);

                    // Detener el escáner cuando se detecta un código
                    if (qrCodeScanner) {
                        qrCodeScanner.clear();
                        qrCodeScanner = null;
                    }

                    // Procesar el código escaneado
                    procesarCodigoQR(decodedText);
                },
                (error) => {
                    // Solo mostrar errores importantes en consola
                    console.warn(`Error de escaneo: ${error}`);
                }
            );
        }

        function procesarCodigoQR(codigoEscaneado) {
            console.log("Procesando código QR:", codigoEscaneado);

            // Mostrar loading
            document.getElementById('loadingOverlay').style.display = 'flex';

            // Extraer token de la URL
            let token = extraerTokenDeURL(codigoEscaneado);

            if (!token) {
                // Si no es una URL, usar el código directamente como token
                token = codigoEscaneado;
            }

            console.log("Token extraído:", token);
            tokenActual = token;

            // Enviar el token al servidor para validar
            fetch(`../src/procesar_qr_vigilante.php?token=${encodeURIComponent(token)}&tipo=validar`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';

                    if (data.success) {
                        // Guardar datos en caché
                        qrDataCache = data;

                        // Mostrar sección de resultados
                        document.getElementById('qr-result').classList.remove('hidden');

                        // Mostrar mensaje de éxito
                        mostrarMensajeExito("✅ Código QR válido detectado");
                    } else {
                        // Mostrar mensaje de error
                        mostrarMensajeError("❌ " + data.error);

                        // Reiniciar escáner después de 2 segundos
                        setTimeout(() => {
                            iniciarEscaner();
                        }, 2000);
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    mostrarMensajeError("❌ Error de conexión: " + error.message);

                    // Reiniciar escáner después de 2 segundos
                    setTimeout(() => {
                        iniciarEscaner();
                    }, 2000);
                });
        }

        function extraerTokenDeURL(codigo) {
            try {
                // Si es una URL completa
                if (codigo.includes('procesar_qr_vigilante.php') && codigo.includes('token=')) {
                    const urlParams = new URLSearchParams(codigo.split('?')[1]);
                    return urlParams.get('token');
                }

                // Si es solo el token (formato: token=abc123)
                if (codigo.includes('token=')) {
                    const match = codigo.match(/token=([^&]+)/);
                    return match ? match[1] : null;
                }

                // Si parece ser solo el token (formato hexadecimal)
                if (/^[a-f0-9]{32}$/i.test(codigo)) {
                    return codigo;
                }

                return null;
            } catch (e) {
                console.log("No es una URL válida, usando código directamente");
                return codigo;
            }
        }

        function registrarIngreso() {
            if (!tokenActual) {
                mostrarMensajeError("No hay un token válido para registrar");
                return;
            }

            console.log("Registrando ingreso con token:", tokenActual);
            document.getElementById('loadingOverlay').style.display = 'flex';

            fetch(`../src/procesar_qr_vigilante.php?token=${encodeURIComponent(tokenActual)}&tipo=ingreso`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';

                    if (data.success) {
                        // Mostrar mensaje de éxito
                        mostrarMensajeExito(data.mensaje);

                        // Actualizar estadísticas
                        actualizarEstadisticas();

                        // Ocultar resultados después de 3 segundos
                        setTimeout(() => {
                            document.getElementById('qr-result').classList.add('hidden');

                            // Reiniciar escáner
                            iniciarEscaner();

                            // Mostrar instrucciones nuevamente
                            document.querySelector('.qr-instructions').style.display = 'block';
                        }, 3000);
                    } else {
                        mostrarMensajeError("❌ Error al registrar ingreso: " + data.error);

                        // Reiniciar escáner después de 2 segundos
                        setTimeout(() => {
                            iniciarEscaner();
                        }, 2000);
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    mostrarMensajeError("❌ Error de conexión: " + error.message);

                    // Reiniciar escáner después de 2 segundos
                    setTimeout(() => {
                        iniciarEscaner();
                    }, 2000);
                });
        }

        function registrarSalida() {
            if (!tokenActual) {
                mostrarMensajeError("No hay un token válido para registrar");
                return;
            }

            console.log("Registrando salida con token:", tokenActual);
            document.getElementById('loadingOverlay').style.display = 'flex';

            fetch(`../src/procesar_qr_vigilante.php?token=${encodeURIComponent(tokenActual)}&tipo=salida`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';

                    if (data.success) {
                        // Mostrar mensaje de éxito
                        mostrarMensajeExito(data.mensaje);

                        // Actualizar estadísticas
                        actualizarEstadisticas();

                        // Ocultar resultados después de 3 segundos
                        setTimeout(() => {
                            document.getElementById('qr-result').classList.add('hidden');

                            // Reiniciar escáner
                            iniciarEscaner();

                            // Mostrar instrucciones nuevamente
                            document.querySelector('.qr-instructions').style.display = 'block';
                        }, 3000);
                    } else {
                        mostrarMensajeError("❌ Error al registrar salida: " + data.error);

                        // Reiniciar escáner después de 2 segundos
                        setTimeout(() => {
                            iniciarEscaner();
                        }, 2000);
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    mostrarMensajeError("❌ Error de conexión: " + error.message);

                    // Reiniciar escáner después de 2 segundos
                    setTimeout(() => {
                        iniciarEscaner();
                    }, 2000);
                });
        }

        // ===================== FUNCIONES AUXILIARES =====================

        function mostrarMensajeExito(mensaje) {
            const successModal = document.getElementById('successModal');
            const successMessage = document.getElementById('successMessage');

            successMessage.textContent = mensaje;
            successModal.classList.remove('hidden');

            // Ocultar automáticamente después de 3 segundos
            setTimeout(() => {
                successModal.classList.add('hidden');
            }, 3000);
        }

        function mostrarMensajeError(mensaje) {
            alert(mensaje);
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        function cargarEstadisticas() {
            // Aquí puedes cargar estadísticas desde el servidor
            fetch('../src/vigilante_historial.php?estadisticas=true')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.ingresos_hoy !== undefined) {
                        document.getElementById('ingresosHoy').textContent = data.ingresos_hoy;
                    }
                })
                .catch(error => {
                    console.error('Error cargando estadísticas:', error);
                });
        }

        function actualizarEstadisticas() {
            // Incrementar contador local
            const statNumber = document.getElementById('ingresosHoy');
            const current = parseInt(statNumber.textContent) || 0;
            statNumber.textContent = current + 1;

            // También actualizar en servidor (opcional)
            console.log("Estadísticas actualizadas");
        }

    //Funcion historial

        function buscarRegistros() {
            cargarRegistros();
        }

        function cargarRegistros() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            const tbody = document.getElementById('records-tbody');
            const noRecords = document.getElementById('no-records');
            const recordsInfo = document.getElementById('records-info');
            const search = document.getElementById('search-input').value || '';

            loadingOverlay.style.display = 'flex';
            tbody.innerHTML = '';

            fetch(`../src/vigilante_historial.php?search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    loadingOverlay.style.display = 'none';

                    if (data.success) {
                        if (data.registros.length === 0) {
                            noRecords.classList.remove('hidden');
                            tbody.innerHTML = '';
                        } else {
                            noRecords.classList.add('hidden');

                            tbody.innerHTML = data.registros.map(registro => {
                                const fecha = new Date(registro.fecha_escaneo);
                                const fechaFormateada = fecha.toLocaleDateString('es-CO');
                                const horaFormateada = fecha.toLocaleTimeString('es-CO', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                let tipoRegistro = 'Ingreso';
                                if (registro.tipo_ingreso === 'salida') {
                                    tipoRegistro = 'Salida';
                                }

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

                        recordsInfo.textContent = `Mostrando ${data.registros.length} registros`;
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" style="text-align: center; color: #e74c3c; padding: 20px;">
                                    Error: ${data.error}
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    loadingOverlay.style.display = 'none';
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="8" style="text-align: center; color: #e74c3c; padding: 20px;">
                                Error de conexión: ${error.message}
                            </td>
                        </tr>
                    `;
                });
        }

        function verDetalles(idIngreso) {
            console.log("Ver detalles del registro:", idIngreso);
            // Aquí puedes implementar la funcionalidad para ver detalles
            mostrarMensajeExito("Detalles del registro " + idIngreso);
        }

        // ===================== FUNCIONES LOGOUT =====================

        function logoutUser() {
            if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
                window.location.href = '../src/logout.php';
            }
        }

        function cancelarCerrarSesion() {
            document.getElementById('logoutModal').classList.add('hidden');
        }

        function cerrarSesion() {
            window.location.href = '../src/logout.php';
        }

        // ===================== FUNCIONES MODALES =====================

        function cerrarModalPersona() {
            document.getElementById('person-modal').classList.add('hidden');
        }

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Dashboard de vigilante cargado");
            // Cargar estadísticas iniciales
            cargarEstadisticas();
        });

        function registrarIngreso() {
            // Implementar función para registrar ingres
 
        }
    </script>

</body>

</html>