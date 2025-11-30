<?php include '../src/seguridad.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Enfermería - Soft-In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/dashboardcss-enfermera.css">
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
                <i class="fas fa-user-nurse"></i>
            </div>
            <div>
                <div class="logo-text">Soft-In</div>
                <div class="logo-subtitle">SOFTWARE</div>
            </div>
        </div>
        <div class="header-center">
            ENFERMERA
        </div>

        </div>
        <button class="logout-btn" onclick="logoutUser()">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
        </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Nursing Card -->
        <div class="nursing-card">
            <div class="nursing-header">
                <h2 class="nursing-title">Bienestar del Aprendiz<br>Enfermería</h2>
            </div>

            <div class="medical-equipment">
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-syringe"></i>
                    </div>
                </div>
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-thermometer-half"></i>
                    </div>
                </div>
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Assessment Section -->
        <div class="assessment-section">
            <h3 class="assessment-title">Valoración Médica del Aprendiz</h3>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="action-btn" onclick="medicalAssessment()">
                <i class="fas fa-clipboard-check"></i>
                Evaluación Médica
            </button>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stat-item">
                    <div class="stat-number" id="patientsToday">8</div>
                    <div class="stat-label">Pacientes Hoy</div>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>
<script>
    // Funcion para redirigir a la evaluación médica
    function medicalAssessment() {
        window.location.href = "evaluacion-medica.php";
    }
    // Función para cerrar sesión
    function logoutUser() {
        window.location.href = '../src/logout.php';
    }
</script>

</html>