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
      window.location.href = "./dashboards/inicio-sesion.html"
    }, 800)
  }, 500)
}

// Precargar recursos críticos (opcional)
function preloadResources() {
  const resources = [
    "./dashboards/inicio-sesion.html",
    "./dashboards/dashboard.html",
    "./public/js/dashboard.js"
  ]

  resources.forEach((resource) => {
    const link = document.createElement("link")
    link.rel = "prefetch"
    link.href = resource
    document.head.appendChild(link)
  })
}

// Inicializar splash screen
document.addEventListener("DOMContentLoaded", () => {
  simulateLoading()
  setTimeout(preloadResources, 1000)
  console.log("Splash screen iniciado")
})
