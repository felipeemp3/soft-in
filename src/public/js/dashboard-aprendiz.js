


// Función para generar código QR
function generateCode() {
  showLoading()

  setTimeout(() => {
    hideLoading()

    const currentUser = window.getCurrentUser()
    const qrData = window.database.generateQRCode(currentUser.id)

    if (qrData) {
      showQRModal(qrData)
      updateAprendizStats() // Actualizar estadísticas
    } else {
      showNotification("Error generando código QR")
    }
  }, 1500)
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

// Función para generar permiso
function generatePermission() {
  showLoading()

  setTimeout(() => {
    hideLoading()
    showNotification("Abriendo formulario de permiso...")

    // Redirigir al formulario de permiso
    setTimeout(() => {
      window.location.href = "permiso-formacion-aprendiz.html"
    }, 1000)
  }, 1500)
}



// Función para mostrar menú de usuario
function showUserMenu() {
  const currentUser = window.getCurrentUser()

  const userMenu = document.createElement("div")
  userMenu.style.cssText = `
    position: fixed;
    top: 90px;
    right: 20px;
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    z-index: 1000;
    min-width: 250px;
  `

  userMenu.innerHTML = `
    <div style="text-align: center; margin-bottom: 15px;">
      <div style="font-weight: 600; color: #2c3e50;">${currentUser.nombre}</div>
      <div style="font-size: 12px; color: #7f8c8d; text-transform: uppercase;">${currentUser.rol}</div>
      ${currentUser.programa ? `<div style="font-size: 12px; color: #4CAF50;">${currentUser.programa}</div>` : ""}
    </div>
    <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">
    <button onclick="showProfile()" style="
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: none;
      background: #f8f9fa;
      border-radius: 8px;
      cursor: pointer;
      text-align: left;
    ">
      <i class="fas fa-user" style="margin-right: 10px;"></i>Mi Perfil
    </button>
    <button onclick="showSettings()" style="
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: none;
      background: #f8f9fa;
      border-radius: 8px;
      cursor: pointer;
      text-align: left;
    ">
      <i class="fas fa-cog" style="margin-right: 10px;"></i>Configuración
    </button>
    <button onclick="logout()" style="
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: none;
      background: #fee;
      color: #e74c3c;
      border-radius: 8px;
      cursor: pointer;
      text-align: left;
    ">
      <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Cerrar Sesión
    </button>
    <button onclick="closeUserMenu()" style="
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 16px;
      cursor: pointer;
      color: #7f8c8d;
    ">×</button>
  `

  document.body.appendChild(userMenu)
  window.currentUserMenu = userMenu
}

// Función para cerrar menú de usuario
function closeUserMenu() {
  if (window.currentUserMenu) {
    document.body.removeChild(window.currentUserMenu)
    window.currentUserMenu = null
  }
}

// Función para mostrar menú principal
function showMainMenu() {
  showNotification("Menú principal en desarrollo...")
}

// Función para mostrar perfil
function showProfile() {
  closeUserMenu()
  showNotification("Perfil de usuario en desarrollo...")
}

// Función para mostrar configuración
function showSettings() {
  closeUserMenu()
  showNotification("Configuración en desarrollo...")
}


// Función para cerrar modal
function closeModal() {
  document.getElementById("modalOverlay").classList.remove("active")
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

// Función para inicializar eventos
function initializeEvents() {
  // Cerrar menús al hacer clic fuera
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".user-avatar") && window.currentUserMenu) {
      closeUserMenu()
    }
  })

  // Cerrar modal al hacer clic fuera
  document.addEventListener("click", (e) => {
    const modal = document.getElementById("modalOverlay")
    if (modal && e.target === modal) {
      closeModal()
    }
  })

  // Actualizar estadísticas cada 5 minutos
  setInterval(updateAprendizStats, 5 * 60000)
}

// Agregar estilos de animación
document.addEventListener("DOMContentLoaded", () => {
  const style = document.createElement("style")
  style.textContent = `
    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(100%);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    @keyframes slideOutRight {
      to {
        opacity: 0;
        transform: translateX(100%);
      }
    }
  `
  document.head.appendChild(style)
})
