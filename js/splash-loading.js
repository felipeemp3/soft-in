// Textos de carga que van cambiando
const loadingTexts = [
  "Cargando aplicación...",
  "Inicializando sistema...",
  "Preparando interfaz...",
  "Configurando módulos...",
  "Casi listo...",
]

let currentTextIndex = 0

// Función para cambiar el texto de carga
function updateLoadingText() {
  const loadingTextElement = document.getElementById("loadingText")

  if (currentTextIndex < loadingTexts.length) {
    loadingTextElement.textContent = loadingTexts[currentTextIndex]
    currentTextIndex++
  }
}

// Función para simular progreso de carga
function simulateLoading() {
  // Cambiar texto cada 600ms
  const textInterval = setInterval(() => {
    updateLoadingText()

    if (currentTextIndex >= loadingTexts.length) {
      clearInterval(textInterval)
    }
  }, 600)

  // Después de 3.5 segundos, iniciar transición al login
  setTimeout(() => {
    startTransition()
  }, 3500)
}

// Función para iniciar la transición al login
function startTransition() {
  const splashContainer = document.getElementById("splashContainer")
  const loadingText = document.getElementById("loadingText")

  // Cambiar texto final
  loadingText.textContent = "¡Listo!"
  loadingText.style.color = "#4CAF50"
  loadingText.style.fontWeight = "600"

  // Agregar clase de fade out
  setTimeout(() => {
    splashContainer.classList.add("fade-out")

    // Redirigir al login después de la animación
    setTimeout(() => {
      window.location.href = "index-inicio-sesion.html"
    }, 800)
  }, 500)
}

// Función para manejar errores de carga (opcional)
function handleLoadingError() {
  const loadingText = document.getElementById("loadingText")
  loadingText.textContent = "Error al cargar. Reintentando..."
  loadingText.style.color = "#e74c3c"

  // Reintentar después de 2 segundos
  setTimeout(() => {
    location.reload()
  }, 2000)
}

// Función para detectar si hay conexión a internet
function checkConnection() {
  return navigator.onLine
}

// Inicializar splash screen
document.addEventListener("DOMContentLoaded", () => {
  // Verificar conexión
  if (!checkConnection()) {
    const loadingText = document.getElementById("loadingText")
    loadingText.textContent = "Sin conexión a internet"
    loadingText.style.color = "#e74c3c"
    return
  }

  // Iniciar simulación de carga
  simulateLoading()

  // Agregar listener para cambios de conexión
  window.addEventListener("online", () => {
    if (document.getElementById("loadingText").style.color === "rgb(231, 76, 60)") {
      location.reload()
    }
  })

  window.addEventListener("offline", () => {
    const loadingText = document.getElementById("loadingText")
    loadingText.textContent = "Conexión perdida..."
    loadingText.style.color = "#e74c3c"
  })

  console.log("Splash screen iniciado")
})

// Prevenir que el usuario navegue hacia atrás durante la carga
window.addEventListener("beforeunload", (e) => {
  // Solo prevenir si aún estamos en la pantalla de carga
  if (!document.querySelector(".fade-out")) {
    e.preventDefault()
    e.returnValue = ""
  }
})

// Función para saltar la pantalla de carga (para desarrollo)
document.addEventListener("keydown", (e) => {
  // Presionar 'S' para saltar (solo en desarrollo)
  if (e.key.toLowerCase() === "s" && e.ctrlKey) {
    startTransition()
  }
})

// Precargar recursos críticos
function preloadResources() {
  const resources = ["index-inicio-sesion.html", "dashboard.html", "js/dashboard.js"]

  resources.forEach((resource) => {
    const link = document.createElement("link")
    link.rel = "prefetch"
    link.href = resource
    document.head.appendChild(link)
  })
}

// Iniciar precarga de recursos
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(preloadResources, 1000)
})