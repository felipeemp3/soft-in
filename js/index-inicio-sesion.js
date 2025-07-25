// Función para redirigir según el rol
function redirectByRole(rol) {
  const roleRoutes = {
    enfermera: "dashboard-enfermera.html",
    aprendiz: "dashboard-aprendiz.html",
    bienestar: "dashboard-bienestar.html",
    vigilante: "dashboard-vigilante.html",
    administrativo: "dashboard-admin.html",
  }

  const route = roleRoutes[rol] || "dashboard-aprendiz.html"
  window.location.href = route
}

// Función para manejar el envío del formulario
async function handleLogin(e) {
  e.preventDefault()

  const documento = document.getElementById("documento").value.trim()
  const password = document.getElementById("password").value.trim()
  const loginBtn = document.getElementById("loginBtn")

  hideMessages()

  if (!documento || !password) {
    showError("Por favor, completa todos los campos")
    return
  }

  if (!/^\d+$/.test(documento)) {
    showError("El documento debe contener solo números")
    return
  }

  showLoading(loginBtn)

  try {
    await new Promise((resolve) => setTimeout(resolve, 1000))

    const user = await window.database.authenticateUser(documento, password)

    if (user) {
      showSuccess(`Bienvenido ${user.nombre} - ${user.rol.toUpperCase()}`)

      sessionStorage.setItem("currentUser", JSON.stringify(user))
      localStorage.setItem("currentUser", JSON.stringify(user))

      setTimeout(() => {
        redirectByRole(user.rol)
      }, 1500)
    } else {
      showError("Documento o contraseña incorrectos")
      hideLoading(loginBtn)
    }
  } catch (error) {
    console.error("Error en login:", error)
    showError("Error de conexión. Intente nuevamente.")
    hideLoading(loginBtn)
  }
}

// Resto de funciones auxiliares...
function showLoading(button) {
  const originalText = button.innerHTML
  button.innerHTML = '<div class="loading"></div>Iniciando sesión...'
  button.disabled = true
  button.dataset.originalText = originalText
}

function hideLoading(button) {
  button.innerHTML = button.dataset.originalText || "Iniciar Sesión"
  button.disabled = false
}

function showError(message) {
  const errorDiv = document.getElementById("errorMessage")
  if (errorDiv) {
    errorDiv.textContent = message
    errorDiv.style.display = "block"
    setTimeout(() => {
      errorDiv.style.display = "none"
    }, 5000)
  }
}

function showSuccess(message) {
  const successDiv = document.getElementById("successMessage")
  if (successDiv) {
    successDiv.textContent = message
    successDiv.style.display = "block"
  }
}

function hideMessages() {
  const errorDiv = document.getElementById("errorMessage")
  const successDiv = document.getElementById("successMessage")

  if (errorDiv) errorDiv.style.display = "none"
  if (successDiv) successDiv.style.display = "none"
}

function forgotPassword() {
  alert(
    "Funcionalidad de recuperación de contraseña en desarrollo.\n\nUsuarios de prueba:\n👩‍⚕️ Enfermera: 12345678 / enf123\n👨‍🎓 Aprendiz: 87654321 / user123\n🏥 Bienestar: 66666666 / bien123\n🛡️ Vigilante: 88888888 / vig123\n👨‍💼 Admin: 10101010 / admin123",
  )
}

// Event listeners
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("loginForm").addEventListener("submit", handleLogin)
  document.getElementById("documento").focus()

  document.getElementById("documento").addEventListener("input", (e) => {
    e.target.value = e.target.value.replace(/\D/g, "")
  })

  console.log("Sistema de login cargado correctamente")
})
