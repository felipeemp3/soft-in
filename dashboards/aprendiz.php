<?php include '../src/seguridad.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboard-aprendiz.css">
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
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">SOFTWARE</div>
            </div>
        </div>
        <div class="header-center">
            APRENDIZ
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
                <h1 class="welcome-title" id="welcomeMessage">Hola, Aprendiz</h1>
                <p class="welcome-subtitle">Bienvenido a tu panel de control. Aquí puedes gestionar tus códigos, permisos y revisar tu historial.</p>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn" onclick="generateCode()" name="Generarcod_btn">
                        <i class="fas fa-qrcode"></i>
                        Generar Código
                    </button>
                    <button class="action-btn" onclick="generatePermission()">
                        <i class="fas fa-file-alt"></i>
                        Generar Permiso
                    </button>
                    <button class="action-btn" onclick="viewHistory()">
                        <i class="fas fa-history"></i>
                        Historial
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
        </div>

        <!-- Right Section - Image Gallery -->
        <div class="right-section">
            <div class="image-card">
                <img src="" alt="Estudiantes colaborando">
                <div class="image-caption">Trabajo en Equipo</div>
            </div>
            <div class="image-card">
                <img src="" alt="Aprendizaje digital">
                <div class="image-caption">Aprendizaje Digital</div>
            </div>
            <div class="image-card">
                <img src="" alt="Formación práctica">
                <div class="image-caption">Formación Práctica</div>
            </div>
            <div class="image-card">
                <img src="" alt="Desarrollo profesional">
                <div class="image-caption">Desarrollo Profesional</div>
            </div>
        </div>
    </main>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-container" id="modalContainer">
            <button class="modal-close" onclick="closeModal()">×</button>
            <div id="modalContent">
                <!-- El contenido se carga dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar menú principal
        function showMainMenu() {
            showNotification("Menú principal en desarrollo...")
            console.log("funciona showNotification");
        }

        // Función para mostrar loading
        function showLoading() {
            const overlay = document.getElementById("loadingOverlay")
            overlay.classList.add("active")
        }
        
        // Función para ocultar loading
        function hideLoading() {
            const overlay = document.getElementById("loadingOverlay")
            overlay.classList.remove("active")
        }

        // Función para generar código QR
        function generateCode() {
            showLoading()

            setTimeout(() => {
                hideLoading()
                console.log("Generando código QR...");
                const currentUser = "Zarky"
                const qrData = {
                    codigo_qr: 'QR-' + '<?php echo "zarky molina desde php"; ?>',
                    fecha_generado: new Date().toLocaleString(),
                    generado_por: currentUser
                }

                if (qrData) {
                    showQRModal(qrData)
                    updateAprendizStats() // Actualizar estadísticas
                } else {
                    showNotification("Error generando código QR")
                }
            }, 1500)
        }

        // Función para generar permiso
        function generatePermission() {
            showLoading()

            setTimeout(() => {
                hideLoading()
                showNotification("Abriendo formulario de permiso...")
                console.log("Generando código QR...");

                // Redirigir al formulario de permiso
                setTimeout(() => {
                    window.location.href = "permiso_form.php"
                }, 1000)
            }, 1500)
        }

        // Función para ver historial
        function viewHistory() {
            showLoading()

            setTimeout(() => {
                hideLoading()
                console.log("funciona hideloading");

                const currentUser = {
                    nombre: "Nombre del Usuario",
                    rol: "enfermera",
                    especialidad: "Especialidad del Usuario",
                }
                const dashboardData = {
                    historial: [],
                    permisos: [],
                    reportes: [],
                }

                const modalContent = document.getElementById("modalContent")
                modalContent.innerHTML = `
                    <h2 style="color: #2c3e50; margin-bottom: 20px;">Historial de Actividades</h2>
                    
                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #4CAF50; margin-bottom: 15px;">Ingresos Recientes</h3>
                        <div style="max-height: 200px; overflow-y: auto;">
                            <div style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                                <span>2024-01-15 - 08:00:00</span>
                                <span style="color: #7f8c8d; font-size: 12px;">Ingreso normal</span>
                            </div>
                            <div style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                                <span>2024-01-14 - 08:15:00</span>
                                <span style="color: #7f8c8d; font-size: 12px;">Ingreso normal</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 style="color: #4CAF50; margin-bottom: 15px;">Permisos</h3>
                        <div style="max-height: 200px; overflow-y: auto;">
                            <div style="padding: 10px; border-bottom: 1px solid #eee; margin-bottom: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <span style="font-weight: 600;">2024-01-10</span>
                                    <span style="padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #d4edda; color: #155724;">Aprobado</span>
                                </div>
                                <div style="color: #7f8c8d; font-size: 14px;">Cita médica especializada</div>
                            </div>
                        </div>
                    </div>
                `

                document.getElementById("modalOverlay").classList.add("active")
            }, 1500)
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        // Función para mostrar modal de QR
        function showQRModal(qrData) {
            const modalContent = document.getElementById("modalContent")
            modalContent.innerHTML = `
                <h2 style="color: #2c3e50; margin-bottom: 20px;">Código QR Generado</h2>
                <div class="qr-code">
                    <div style="font-size: 48px; color: #4CAF50;">
                        <i class="fas fa-qrcode"></i>
                    </div>
                </div>
                <p style="color: #7f8c8d; margin: 15px 0;">
                    <strong>Código:</strong> ${qrData.codigo_qr}
                </p>
                <p style="color: #7f8c8d; margin: 15px 0;">
                    <strong>Fecha:</strong> ${qrData.fecha_generado}
                </p>
                <p style="color: #7f8c8d; font-size: 12px;">
                    Presenta este código al personal autorizado
                </p>
            `

            document.getElementById("modalOverlay").classList.add("active")
        }

        // Función para mostrar notificaciones
        function showNotification(message) {
            const existingNotification = document.querySelector(".notification")
            if (existingNotification) {
                existingNotification.remove()
            }

            const notification = document.createElement("div")
            notification.className = "notification"
            notification.innerHTML = `
                <i class="fas fa-info-circle" style="margin-right: 10px;"></i>
                ${message}
            `

            Object.assign(notification.style, {
                position: "fixed",
                top: "20px",
                right: "20px",
                background: "#4CAF50",
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
            })

            document.body.appendChild(notification)

            setTimeout(() => {
                notification.style.animation = "slideOutRight 0.3s ease-in forwards"
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove()
                    }
                }, 300)
            }, 3000)
        }

        // Función para cerrar sesión
        function logoutUser() {
                window.location.href = '../src/logout.php';
            }
        
        // Función para cerrar menú de usuario
        function closeUserMenu() {
            if (window.currentUserMenu) {
                document.body.removeChild(window.currentUserMenu)
                window.currentUserMenu = null
            }
        }

        // Función para actualizar estadísticas (placeholder)
        function updateAprendizStats() {
            // Esta función debería actualizar las estadísticas del dashboard
            console.log("Actualizando estadísticas...");
        }
    </script>
</body>
</html>