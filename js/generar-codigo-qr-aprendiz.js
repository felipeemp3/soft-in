// Función para volver a la página anterior
function goBack() {
  // Agregar animación de salida
  const modal = document.querySelector(".modal-container")
  modal.style.animation = "modalSlideOut 0.3s ease-in forwards"

  setTimeout(() => {
    window.history.back()
  }, 300)
}

// Función para renovar el código QR
function refreshQR() {
  const btn = event.target.closest(".btn-primary")
  const icon = btn.querySelector("i")
  const originalText = btn.innerHTML

  // Mostrar loading
  btn.innerHTML = '<div class="loading"></div> Renovando...'
  btn.disabled = true

  // Simular renovación
  setTimeout(() => {
    btn.innerHTML = originalText
    btn.disabled = false

    // Animar el QR
    const qrWrapper = document.querySelector(".qr-wrapper")
    qrWrapper.style.animation = "qrRefresh 0.6s ease-in-out"

    // Actualizar tiempo de expiración
    updateExpiryTime()

    // Mostrar notificación
    showNotification("Código QR renovado exitosamente", "success")
  }, 2000)
}

// Función para compartir el código QR
function shareQR() {
  if (navigator.share) {
    navigator.share({
      title: "Código de Ingreso QR",
      text: "Código QR para acceso al sistema Soft-In",
      url: window.location.href,
    })
  } else {
    // Fallback para navegadores que no soportan Web Share API
    copyToClipboard(window.location.href)
    showNotification("Enlace copiado al portapapeles", "info")
  }
}

// Función para copiar al portapapeles
function copyToClipboard(text) {
  navigator.clipboard.writeText(text).catch(() => {
    // Fallback para navegadores más antiguos
    const textArea = document.createElement("textarea")
    textArea.value = text
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand("copy")
    document.body.removeChild(textArea)
  })
}

// Función para mostrar notificaciones
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <i class="fas fa-${type === "success" ? "check-circle" : "info-circle"}"></i>
        <span>${message}</span>
    `

  // Estilos para la notificación
  Object.assign(notification.style, {
    position: "fixed",
    top: "20px",
    right: "20px",
    background: type === "success" ? "#4CAF50" : "#2196F3",
    color: "white",
    padding: "15px 20px",
    borderRadius: "10px",
    boxShadow: "0 5px 15px rgba(0,0,0,0.2)",
    zIndex: "1000",
    display: "flex",
    alignItems: "center",
    gap: "10px",
    animation: "slideInRight 0.3s ease-out",
    fontSize: "14px",
    fontWeight: "500",
  })

  document.body.appendChild(notification)

  // Remover después de 3 segundos
  setTimeout(() => {
    notification.style.animation = "slideOutRight 0.3s ease-in forwards"
    setTimeout(() => {
      document.body.removeChild(notification)
    }, 300)
  }, 3000)
}

// Función para actualizar el tiempo de expiración
function updateExpiryTime() {
  const now = new Date()
  const expiry = new Date(now.getTime() + 30 * 60000) // 30 minutos
  const timeString = expiry.toLocaleTimeString("es-ES", {
    hour: "2-digit",
    minute: "2-digit",
  })

  document.getElementById("expiry-time").textContent = timeString
}

// Función para manejar teclas especiales
function handleKeyDown(e) {
  if (e.key === "Escape") {
    goBack()
  } else if (e.key === "r" || e.key === "R") {
    if (e.ctrlKey || e.metaKey) {
      e.preventDefault()
      refreshQR()
    }
  }
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Actualizar tiempo de expiración inicial
  updateExpiryTime()

  // Agregar event listeners
  document.addEventListener("keydown", handleKeyDown)

  // Agregar estilos de animación adicionales
  const style = document.createElement("style")
  style.textContent = `
        @keyframes modalSlideOut {
            to {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
        }
        
        @keyframes qrRefresh {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }
        
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

  console.log("QR Modal cargado correctamente")
})

// Auto-renovar el código cada 30 minutos
setInterval(() => {
  updateExpiryTime()
  showNotification("Código QR renovado automáticamente", "info")
}, 30 * 60000)
