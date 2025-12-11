<?php
include '../src/seguridad.php';

// Obtener datos de la sesión
$nombres = htmlspecialchars($_SESSION['nombres'] ?? 'Aprendiz');
$apellidos = htmlspecialchars($_SESSION['apellidos'] ?? '');
$nombre_completo = trim($nombres . ' ' . $apellidos);
$documento = htmlspecialchars($_SESSION['documento'] ?? '');
$programa = htmlspecialchars($_SESSION['programa_formacion'] ?? '');
$ficha = htmlspecialchars($_SESSION['no_ficha'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aprendiz - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboard-aprendiz.css">
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
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">APRENDIZ</div>
            </div>
        </div>
        <div class="header-center">
            <div style="text-align: center;">
                <strong><?php echo $nombre_completo; ?></strong><br>
                <small style="font-size: 12px; color: #666;">
                    Doc: <?php echo $documento; ?> |
                    <?php if ($programa): ?>
                        Programa: <?php echo $programa; ?>
                        <?php if ($ficha): ?> | Ficha: <?php echo $ficha; ?><?php endif; ?>
                        <?php endif; ?>
                </small>
            </div>
        </div>
        <div class="header-right">
            <button class="logout-btn" onclick="logoutUser()">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Left Section -->
        <div class="left-section">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1 class="welcome-title">
                    Hola, <?php echo $nombres; ?> 👋
                </h1>
                <p class="welcome-subtitle">
                    Bienvenido a tu panel de control.
                    <?php if ($programa): ?>
                        Estás en el programa de <strong><?php echo $programa; ?></strong>
                    <?php endif; ?>
                </p>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn" onclick="generateCode()" name="Generarcod_btn">
                        <i class="fas fa-qrcode"></i>
                        Generar Código QR
                    </button>
                    <button class="action-btn" onclick="generatePermission()">
                        <i class="fas fa-file-alt"></i>
                        Generar Permiso
                    </button>
                    <button class="action-btn" onclick="viewHistory()">
                        <i class="fas fa-history"></i>
                        Historial QR
                    </button>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stat-item">
                    <div class="stat-number" id="codesGenerated">0</div>
                    <div class="stat-label">Códigos Generados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="permissionsActive">0</div>
                    <div class="stat-label">Permisos Activos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="daysActive">0</div>
                    <div class="stat-label">Días Activo</div>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="info-section" style="background: #f8f9fa; padding: 20px; border-radius: 15px; margin-top: 20px;">
                <h3 style="margin-bottom: 15px; color: #2c3e50;">
                    <i class="fas fa-lightbulb"></i> Instrucciones Rápidas
                </h3>
                <ul style="padding-left: 20px; color: #555;">
                    <li>Genera un código QR para ingresar al centro</li>
                    <li>Cada QR es válido por 30 minutos</li>
                    <li>Muestra el QR al vigilante en la entrada</li>
                    <li>Revisa tu historial de códigos generados</li>
                    <li>Solicita permisos cuando necesites ausentarte</li>
                </ul>
            </div>
        </div>

        <!-- Right Section - Image Gallery -->
        <div class="right-section">
            <div class="image-card">
                <div>
                    <img src="../public/img/image4.jpg" alt="">
                    <i class="fas fa-qrcode" style="font-size: 60px; color: white;"></i>
                </div>
                <div class="image-caption">Aprendizaje</div>
            </div>
            <div class="image-card"> 
                <div>
                    <img src="../public/img/image3.jpg" alt="">
                    <i class="fas fa-shield-alt" style="font-size: 60px; color: white;"></i>
                </div>
                <div class="image-caption">Trabajo en equipo</div>
            </div>
            <div class="image-card">
                <div>
                    <img src="../public/img/image2.jpeg" alt="">
                    <i class="fas fa-clock" style="font-size: 60px; color: white;"></i>
                </div>
                <div class="image-caption">Curos</div>
            </div>
            <div class="image-card">
                <div>
                     <img src="../public/img/image1.jpg" alt="">
                    <i class="fas fa-chart-line" style="font-size: 60px; color: white;"></i>
                   
                </div>
                <div class="image-caption">Estadísticas</div>
            </div>
        </div>
    </main>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-container" id="modalContainer">
            <button class="modal-close" onclick="closeModal()">×</button>
            <div id="modalContent">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>

    <!-- LIBRERÍA QRCode - VERSIÓN ALTERNATIVA -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js" integrity="sha256-8f7J7qk6Kqy6w0l9ZDKZz5v1nWlqGMjXZQ5wQqCX0zQ=" crossorigin="anonymous"></script>

    <script>
        // Datos del aprendiz desde PHP
        const aprendizData = {
            id: <?php echo $_SESSION['usuario_id']; ?>,
            nombres: "<?php echo addslashes($nombres); ?>",
            apellidos: "<?php echo addslashes($apellidos); ?>",
            nombreCompleto: "<?php echo addslashes($nombre_completo); ?>",
            documento: "<?php echo addslashes($documento); ?>",
            programa: "<?php echo addslashes($programa); ?>",
            ficha: "<?php echo addslashes($ficha); ?>"
        };

        // Cargar estadísticas al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            console.log('Dashboard cargado para:', aprendizData.nombreCompleto);
            console.log('QRCode disponible:', typeof QRCode);

            // Verificar si la librería QRCode se cargó correctamente
            if (typeof QRCode === 'undefined') {
                console.error('ERROR: La librería QRCode no se cargó correctamente');
                // Intentar cargar una versión alternativa
                loadQRCodeFallback();
            }
        });

        // Función para cargar librería QRCode alternativa si falla
        function loadQRCodeFallback() {
            console.log('Intentando cargar librería QRCode alternativa...');
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js';
            script.onload = function() {
                console.log('Librería QRCode alternativa cargada:', typeof QRCode);
            };
            script.onerror = function() {
                console.error('ERROR: No se pudo cargar ninguna librería QRCode');
                alert('⚠️ No se pudo cargar el generador de QR. Recarga la página.');
            };
            document.head.appendChild(script);
        }

        // Función para mostrar/ocultar loading
        function showLoading() {
            document.getElementById("loadingOverlay").classList.add("active");
        }

        function hideLoading() {
            document.getElementById("loadingOverlay").classList.remove("active");
        }

        // Función para generar código QR REAL
        async function generateCode() {
            showLoading();

            try {
                console.log('Solicitando generación de QR...');
                const response = await fetch('../src/generar_qr.php');
                const data = await response.json();

                hideLoading();

                if (data.success) {
                    console.log('QR generado exitosamente:', data);
                    showQRModal(data);
                    updateStats();
                    showNotification(data.mensaje || "✅ QR generado exitosamente", "success");
                } else {
                    console.error('Error al generar QR:', data);
                    showNotification("❌ Error: " + (data.error || 'Error desconocido'), "error");
                }
            } catch (error) {
                hideLoading();
                console.error('Error de red:', error);
                showNotification("❌ Error de conexión: " + error.message, "error");
            }
        }

        // Función para mostrar modal de QR REAL (reemplaza la existente)
        function showQRModal(qrData) {
            const modalContent = document.getElementById("modalContent");

            // Formatear fechas (mantengo tu función en línea)
            const formatDate = (dateStr) => {
                try {
                    const date = new Date(dateStr);
                    return date.toLocaleString('es-CO', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } catch (e) {
                    return dateStr;
                }
            };

            const fechaGenerado = formatDate(qrData.fecha_generado);
            const fechaExpiracion = formatDate(qrData.fecha_expiracion);

            // URL efectiva que se codifica en el QR
            const qrUrl = `../src/procesar_qr_vigilante.php?token=${encodeURIComponent(qrData.token)}`;

            modalContent.innerHTML = `
        <h2 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">
            <i class="fas fa-qrcode" style="color: #4CAF50;"></i>
            Código QR Generado
        </h2>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <div id="qrcode-container">
                <!-- contenedor del QR: vacío inicialmente -->
                <div id="qrcode-real" style="width: 220px; height: 220px; margin: 0 auto;"></div>
            </div>
            <p style="margin-top: 10px; color: #666; font-size: 14px;">
                <i class="fas fa-info-circle"></i> Escanea este código en la entrada
            </p>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <h3 style="color: #2c3e50; margin-bottom: 10px; font-size: 16px;">
                <i class="fas fa-user"></i> Información del Aprendiz
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                <div>
                    <strong>Nombre:</strong><br>
                    <span>${qrData.aprendiz || aprendizData.nombreCompleto}</span>
                </div>
                <div>
                    <strong>Documento:</strong><br>
                    <span>${qrData.documento || aprendizData.documento}</span>
                </div>
                ${aprendizData.programa ? `
                <div>
                    <strong>Programa:</strong><br>
                    <span>${aprendizData.programa}</span>
                </div>
                ` : ''}
                ${aprendizData.ficha ? `
                <div>
                    <strong>Ficha:</strong><br>
                    <span>${aprendizData.ficha}</span>
                </div>
                ` : ''}
            </div>
            
            <h3 style="color: #2c3e50; margin-bottom: 10px; font-size: 16px;">
                <i class="fas fa-info-circle"></i> Detalles del QR
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <strong>Código:</strong><br>
                    <code style="background: #e9ecef; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-weight: bold; font-size: 12px;">${qrData.codigo_qr}</code>
                </div>
                <div>
                    <strong>Estado:</strong><br>
                    <span style="color: #4CAF50; font-weight: bold;">ACTIVO</span>
                </div>
                <div>
                    <strong>Generado:</strong><br>
                    <span style="font-size: 13px;">${fechaGenerado}</span>
                </div>
                <div>
                    <strong>Expira:</strong><br>
                    <span style="font-size: 13px;">${fechaExpiracion}</span>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <button id="downloadBtn" class="qr-btn download-btn">
                <i class="fas fa-download"></i> Descargar QR
            </button>
            <button id="testBtn" class="qr-btn" style="background: #FF9800; color: white;">
                <i class="fas fa-check"></i> Probar QR
            </button>
        </div>
    `;

            // Generar la imagen del QR en el contenedor (solo 1)
            generateQRCodeImage(qrUrl);

            // Asignar handlers a botones (evitamos inline onclick para mayor control)
            document.getElementById('downloadBtn').addEventListener('click', () => downloadQR(qrData.codigo_qr));
            document.getElementById('testBtn').addEventListener('click', () => testQR(qrData.token));

            // Mostrar el modal
            document.getElementById("modalOverlay").classList.add("active");
        }
        // Función para cerrar el modal
        function closeModal() {

            // Generar la imagen del QR
            generateQRCodeImage(qrUrl);

            // Mostrar el modal
            document.getElementById("modalOverlay").classList.add("active");
        }

        // Función para generar la imagen del QR — evita duplicados
        function generateQRCodeImage(url) {
            const qrDiv = document.getElementById("qrcode-real");
            if (!qrDiv) return console.error('Contenedor #qrcode-real no encontrado');

            // LIMPIAR completamente antes de crear (elimina canvas, img o nodos previos)
            while (qrDiv.firstChild) {
                qrDiv.removeChild(qrDiv.firstChild);
            }

            // Protección: si la librería no está disponible, mostrar fallback textual
            if (typeof QRCode === 'undefined') {
                console.error('QRCode no disponible, usando representación textual');
                qrDiv.innerHTML = createTextQR(url);
                return;
            }

            try {
                // Crear el QR — usamos un único constructor y aseguramos que no haya duplicados
                const qrInstance = new QRCode(qrDiv, {
                    text: url,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#FFFFFF",
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Después de creado, normalizamos el DOM para mantener solo un elemento visible
                setTimeout(() => {
                    const canvas = qrDiv.querySelector('canvas');
                    const img = qrDiv.querySelector('img');

                    // Si existen ambos, preferimos canvas y removemos img para evitar duplicados
                    if (canvas && img) {
                        img.remove();
                    }

                    // Si existe canvas, le aplicamos estilos consistentes
                    const finalElem = canvas || img;
                    if (finalElem) {
                        finalElem.style.display = 'block';
                        finalElem.style.margin = '0 auto';
                        finalElem.style.border = '2px solid #ddd';
                        finalElem.style.borderRadius = '8px';
                        // data-url para descargar si es canvas
                        if (canvas) {
                            try {
                                // guardamos dataURL en dataset para usar en descarga
                                qrDiv.dataset.dataUrl = canvas.toDataURL('image/png');
                            } catch (e) {
                                // en navegadores con restricciones, esto puede fallar; no es crítico
                                console.warn('No se pudo extraer dataURL del canvas:', e);
                            }
                        } else if (img) {
                            qrDiv.dataset.dataUrl = img.src;
                        }
                    } else {
                        // Si por alguna razón no hay canvas ni img, mostramos fallback textual
                        qrDiv.innerHTML = createTextQR(url);
                    }
                }, 150);

            } catch (error) {
                console.error('Error al generar QR:', error);
                qrDiv.innerHTML = createTextQR(url);
            }
        }


        function createTextQR(url) {
            return `
        <div style="width: 100%; height: 100%; display:flex;flex-direction:column;justify-content:center;align-items:center;background:white;border:2px dashed #ddd;border-radius:8px;padding:10px;">
            <div style="font-size:48px;color:#4CAF50;margin-bottom:10px;"><i class="fas fa-qrcode"></i></div>
            <div style="text-align:center;">
                <p style="font-size:12px;color:#333;word-break:break-all;">${url}</p>
                <small style="color:#666;">Token incluido (corta y pega si es necesario)</small>
            </div>
        </div>
    `;
        }


        // Función para descargar QR
        function downloadQR(codigo) {
            const qrDiv = document.getElementById("qrcode-real");
            const canvas = qrDiv.querySelector('canvas');

            if (canvas) {
                try {
                    const link = document.createElement('a');
                    const fecha = new Date().toLocaleDateString('es-CO', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    }).replace(/[/:, ]/g, '-');

                    link.download = `QR-${codigo}-${fecha}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.style.display = 'none';

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    showNotification("✅ QR descargado correctamente", "success");
                } catch (error) {
                    console.error('Error al descargar:', error);
                    showNotification("❌ Error al descargar el QR", "error");
                }
            } else {
                showNotification("⚠️ No se pudo generar la imagen del QR para descargar", "warning");
            }
        }

        // Función para probar el QR
        async function testQR(token) {
            showLoading();

            try {
                const response = await fetch(`../src/procesar_qr_vigilante.php?token=${token}`);
                const data = await response.json();

                hideLoading();

                if (data.success) {
                    showNotification("✅ QR válido: " + data.mensaje, "success");

                    // Mostrar detalles en el modal
                    const modalContent = document.getElementById("modalContent");
                    const successDiv = document.createElement('div');
                    successDiv.innerHTML = `
                    <div style="margin-top: 20px; padding: 15px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;">
                        <h4 style="color: #155724; margin-bottom: 10px;">
                            <i class="fas fa-check-circle"></i> Prueba Exitosa
                        </h4>
                        <p style="color: #155724;">
                            <strong>Aprendiz:</strong> ${data.aprendiz.nombre}<br>
                            <strong>Documento:</strong> ${data.aprendiz.documento}<br>
                            <strong>Programa:</strong> ${data.aprendiz.programa}<br>
                            <strong>Ficha:</strong> ${data.aprendiz.ficha}
                        </p>
                    </div>
                `;
                    modalContent.appendChild(successDiv);
                } else {
                    showNotification("❌ QR inválido: " + data.error, "error");
                }
            } catch (error) {
                hideLoading();
                showNotification("❌ Error de conexión: " + error.message, "error");
            }
        }

        // Función para generar permiso
        function generatePermission() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                showNotification("📄 Abriendo formulario de permiso...", "info");
                setTimeout(() => {
                    window.location.href = "permiso_form.php";
                }, 1000);
            }, 1500);
        }

        // Función para ver historial
        async function viewHistory() {
            showLoading();

            try {
                const response = await fetch('../src/get_historial_qr.php');
                const data = await response.json();

                hideLoading();

                const modalContent = document.getElementById("modalContent");

                if (data.success && data.historial && data.historial.length > 0) {
                    modalContent.innerHTML = `
                    <h2 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-history"></i> Historial de Códigos QR
                    </h2>
                    
                    <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                        ${data.historial.map(item => `
                            <div style="padding: 12px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>${item.codigo_qr}</strong><br>
                                    <small style="color: #666;">Generado: ${item.fecha_generacion}</small><br>
                                    <small style="color: #666;">Expira: ${item.fecha_expiracion}</small>
                                </div>
                                <div>
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: ${getStatusColor(item.estado)}; color: white;">
                                        ${item.estado.toUpperCase()}
                                    </span>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div style="text-align: center;">
                        <button onclick="generateCode()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-qrcode"></i> Generar Nuevo QR
                        </button>
                    </div>
                `;
                } else {
                    modalContent.innerHTML = `
                    <h2 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-history"></i> Historial de Códigos QR
                    </h2>
                    <div style="text-align: center; padding: 40px 20px;">
                        <div style="font-size: 48px; color: #ddd; margin-bottom: 20px;">
                            <i class="fas fa-history"></i>
                        </div>
                        <p style="color: #666;">No has generado códigos QR aún</p>
                        <button onclick="generateCode()" style="margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-qrcode"></i> Generar Primer Código
                        </button>
                    </div>
                `;
                }

                document.getElementById("modalOverlay").classList.add("active");

            } catch (error) {
                hideLoading();
                showNotification("❌ Error al cargar historial", "error");
                console.error('Error:', error);
            }
        }

        // Función para obtener color según estado
        function getStatusColor(estado) {
            switch (estado.toLowerCase()) {
                case 'activo':
                    return '#4CAF50';
                case 'usado':
                    return '#2196F3';
                case 'expirado':
                    return '#f44336';
                case 'inactivo':
                    return '#9e9e9e';
                default:
                    return '#666';
            }
        }

        // Función para actualizar estadísticas
        async function updateStats() {
            try {
                const response = await fetch('../src/get_stats.php');
                const data = await response.json();

                if (data.success) {
                    document.getElementById('codesGenerated').textContent = data.codigos_generados || 0;
                    document.getElementById('permissionsActive').textContent = data.permisos_activos || 0;
                    document.getElementById('daysActive').textContent = data.dias_activo || 0;
                }
            } catch (error) {
                console.error('Error actualizando stats:', error);
            }
        }

        // Función para mostrar notificaciones
        function showNotification(message, type = 'info') {
            const existingNotification = document.querySelector(".notification");
            if (existingNotification) {
                existingNotification.remove();
            }

            const colors = {
                success: '#28a745',
                error: '#dc3545',
                warning: '#ffc107',
                info: '#17a2b8'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            const notification = document.createElement("div");
            notification.className = "notification";
            notification.innerHTML = `
            <i class="fas ${icons[type] || 'fa-info-circle'}" style="margin-right: 10px;"></i>
            ${message}
        `;

            Object.assign(notification.style, {
                position: "fixed",
                top: "25px",
                right: "25px",
                background: colors[type] || '#17a2b8',
                color: "white",
                padding: "15px 20px",
                borderRadius: "10px",
                boxShadow: "0 5px 15px rgba(0,0,0,0.2)",
                zIndex: "1001",
                display: "flex",
                alignItems: "center",
                animation: "slideInRight 0.3s ease-out",
                fontSize: "14px",
                fontWeight: "500",
            });

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = "slideOutRight 0.3s ease-in forwards";
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 3000);
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        // Función para cerrar sesión
        function logoutUser() {
            if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
                window.location.href = '../src/logout.php';
            }
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>

</html>