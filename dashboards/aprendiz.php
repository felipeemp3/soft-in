<?php
include '../src/seguridad.php';

// Obtener datos de la sesión
$nombres = htmlspecialchars($_SESSION['nombres'] ?? 'Aprendiz');
$apellidos = htmlspecialchars($_SESSION['apellidos'] ?? '');
$nombre_completo = trim($nombres . ' ' . $apellidos);
$documento = htmlspecialchars($_SESSION['documento'] ?? '');
$programa = htmlspecialchars($_SESSION['programa_formacion'] ?? '');
$ficha = htmlspecialchars($_SESSION['no_ficha'] ?? '');

// Asumiendo que el ID de usuario está en la sesión
$usuario_id = $_SESSION['usuario_id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aprendiz - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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

    /* Estilo para el contenedor del QR dentro del modal */
    #qrcode-real canvas, #qrcode-real img {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
</style>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

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

    <main class="main-content">
        <div class="left-section">
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

        <div class="right-section">
            <div class="image-card">
                <div>
                    <img src="../public/img/image4.jpg" alt="">
                </div>
                <div class="image-caption">Aprendizaje</div>
            </div>
            <div class="image-card"> 
                <div>
                    <img src="../public/img/image3.jpg" alt="">
                </div>
                <div class="image-caption">Trabajo en equipo</div>
            </div>
            <div class="image-card">
                <div>
                    <img src="../public/img/image2.jpeg" alt="">
                </div>
                <div class="image-caption">Curos</div>
            </div>
            <div class="image-card">
                <div>
                     <img src="../public/img/image1.jpg" alt="">
                </div>
                <div class="image-caption">Estadísticas</div>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-container" id="modalContainer">
            <button class="modal-close" onclick="closeModal()">×</button>
            <div id="modalContent">
                </div>
        </div>
    </div>

<script>
    // Datos del aprendiz desde PHP
    const aprendizData = {
        id: <?php echo $usuario_id; ?>,
        nombres: "<?php echo addslashes($nombres); ?>",
        apellidos: "<?php echo addslashes($apellidos); ?>",
        nombreCompleto: "<?php echo addslashes($nombre_completo); ?>",
        documento: "<?php echo addslashes($documento); ?>",
        programa: "<?php echo addslashes($programa); ?>",
        ficha: "<?php echo addslashes($ficha); ?>"
    };

    document.addEventListener('DOMContentLoaded', function() {
        updateStats();
    });

    function showLoading() { document.getElementById("loadingOverlay").classList.add("active"); }
    function hideLoading() { document.getElementById("loadingOverlay").classList.remove("active"); }

    // --- funcion para generar el codigo qr ---
    async function generateCode() {
        showLoading();
        try {
            const response = await fetch('../src/generar_qr.php');
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("El servidor no devolvió JSON. Posible error de PHP.");
            }

            const data = await response.json();
            hideLoading();

            if (data.success) {
                if(!data.token) {
                    showNotification("⚠️ El servidor no envió el token.", "warning");
                    return;
                }
                showQRModal(data);
                updateStats();
                showNotification("✅ QR generado exitosamente", "success");
            } else {
                showNotification("❌ Error: " + (data.error || 'Desconocido'), "error");
            }
        } catch (error) {
            hideLoading();
            console.error(error);
            showNotification("❌ Error de conexión: " + error.message, "error");
        }
    }

    function showQRModal(qrData) {
        const modalContent = document.getElementById("modalContent");
        modalContent.innerHTML = ''; 
        
        const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
        const fullUrl = `${baseUrl}/../src/procesar_qr_vigilante.php?token=${qrData.token}`;
        
        const formatDate = (dateStr) => {
            const d = new Date(dateStr);
            return isNaN(d.getTime()) ? dateStr : d.toLocaleString('es-CO');
        };

        modalContent.innerHTML = `
            <h2 style="color: #2c3e50; text-align: center;">
                <i class="fas fa-qrcode" style="color: #4CAF50;"></i> Acceso Generado
            </h2>
            
            <div style="text-align: center; margin: 20px 0;">
                <div id="qrcode-real" style="display: flex; justify-content: center; margin-bottom: 15px;"></div>
                <p style="font-size: 12px; color: #666;">Código QR: ${qrData.codigo_qr}</p>
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; font-size: 14px;">
                <strong>Estado:</strong> <span style="color:green">ACTIVO</span><br>
                <strong>Vence:</strong> ${formatDate(qrData.fecha_expiracion)}
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                <button id="downloadBtn" class="qr-btn" style="background: #2c3e50; color: white; padding: 10px; border: none; border-radius: 5px;">
                    <i class="fas fa-download"></i> Guardar
                </button>
                <button id="testBtn" class="qr-btn" style="background: #FF9800; color: white; padding: 10px; border: none; border-radius: 5px;">
                    <i class="fas fa-sync"></i> Probar Token
                </button>
            </div>
        `;

        setTimeout(() => {
            const qrContainer = document.getElementById("qrcode-real");
            qrContainer.innerHTML = "";
            if (typeof QRCode !== 'undefined' && qrContainer) {
                new QRCode(qrContainer, {
                    text: fullUrl,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.M
                });
            }
        }, 100);

        document.getElementById('downloadBtn').onclick = () => downloadQR(qrData.codigo_qr);
        document.getElementById('testBtn').onclick = () => testQR(qrData.token);
        document.getElementById("modalOverlay").classList.add("active");
    }

    // --- NUEVA FUNCIÓN PARA MOSTRAR EL HISTORIAL (MODAL) ---
    async function viewHistory() {
        showLoading();
        try {
            const response = await fetch('../src/historial_qr.php');
            const data = await response.json();
            hideLoading();

            if (data.success) {
                showHistoryModal(data.history);
            } else {
                showNotification("❌ Error al cargar historial: " + (data.error || 'Desconocido'), "error");
            }
        } catch (error) {
            hideLoading();
            showNotification("❌ Error de conexión al obtener historial.", "error");
        }
    }

    function showHistoryModal(historyData) {
        const modalContent = document.getElementById("modalContent");
        modalContent.innerHTML = ''; // Limpiar contenido anterior

        let tableRows = historyData.map(item => {
            // Asigna un color al estado
            const statusStyle = {
                'activo': 'color: green; font-weight: bold;',
                'usado': 'color: #3498db; font-weight: bold;', // Azul para "usado"
                'expirado': 'color: red; font-weight: bold;',
                'inactivo': 'color: gray;'
            }[item.estado] || 'color: black;';

            return `
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #eee;">${item.codigo_unico}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee;">${new Date(item.fecha_generacion).toLocaleString('es-CO', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'})}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee;">${new Date(item.fecha_expiracion).toLocaleString('es-CO', {hour: '2-digit', minute: '2-digit'})}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; ${statusStyle}">${item.estado.toUpperCase()}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: center;">${item.veces_usado}</td>
                </tr>
            `;
        }).join('');

        if (historyData.length === 0) {
            tableRows = `<tr><td colspan="5" style="text-align:center; padding: 20px; color:#999;">No hay registros de códigos QR.</td></tr>`;
        }

        modalContent.innerHTML = `
            <h2 style="color: #2c3e50; text-align: center;">
                <i class="fas fa-history" style="color: #3498db;"></i> Historial de Códigos QR
            </h2>
            <div style="max-height: 400px; overflow-y: auto; margin-top: 20px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; background: white; border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: #ecf0f1; color: #2c3e50;">
                            <th style="padding: 10px; border-bottom: 2px solid #ddd; font-size: 13px;">Código Único</th>
                            <th style="padding: 10px; border-bottom: 2px solid #ddd; font-size: 13px;">Generado (Fecha)</th>
                            <th style="padding: 10px; border-bottom: 2px solid #ddd; font-size: 13px;">Vence (Hora)</th>
                            <th style="padding: 10px; border-bottom: 2px solid #ddd; font-size: 13px;">Estado</th>
                            <th style="padding: 10px; border-bottom: 2px solid #ddd; font-size: 13px; text-align: center;">Usos</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>
            </div>
        `;

        document.getElementById("modalOverlay").classList.add("active");
    }

    // --- FUNCIÓN DE REDIRECCIÓN DE PERMISO ---
    function generatePermission() {
        window.location.href = './permiso_form.php'; 
    }
    // ----------------------------------------


    function closeModal() {
        document.getElementById("modalOverlay").classList.remove("active");
    }

    function downloadQR(codigo) {
        const canvas = document.querySelector("#qrcode-real canvas");
        if(canvas) {
            const link = document.createElement('a');
            link.download = `QR-${codigo}.png`;
            link.href = canvas.toDataURL("image/png"); 
            link.click();
        } else {
             showNotification("No se encontró el QR para descargar.", "error");
        }
    }

    async function testQR(token) {
        showLoading();
        try {
            const response = await fetch(`../src/procesar_qr_vigilante.php?token=${token}`);
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification("✅ Token Válido y Usado Correctamente (Ingreso Registrado)", "success");
                closeModal(); 
                updateStats();
            } else {
                showNotification("❌ Prueba Fallida: " + data.error, "error");
            }
        } catch (error) {
            hideLoading();
            showNotification("❌ Error de red al probar", "error");
        }
    }

    // Funciones auxiliares de UI
    async function updateStats() {
        try {
            const res = await fetch('../src/get_stats.php');
            const data = await res.json();
            if(data.success) {
                if(document.getElementById('codesGenerated')) document.getElementById('codesGenerated').innerText = data.codigos_generados;
                if(document.getElementById('permissionsActive')) document.getElementById('permissionsActive').innerText = data.permisos_activos;
                if(document.getElementById('daysActive')) document.getElementById('daysActive').innerText = data.dias_activo;
            }
        } catch(e) {}
    }

    function showNotification(msg, type) {
        const div = document.createElement('div');
        div.style.cssText = "position:fixed; top:20px; right:20px; padding:15px; border-radius:5px; color:white; z-index:9999;";
        div.style.backgroundColor = type === 'success' ? '#28a745' : (type === 'error' ? '#dc3545' : '#ffc107');
        div.innerText = msg;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 3000);
    }
    
    function logoutUser() {
        
       window.location.href = '../src/logout.php';
    }
    
    document.getElementById('modalOverlay').addEventListener('click', (e) => {
        if(e.target.id === 'modalOverlay') closeModal();
    });
</script>
</body>

</html>