// Función para abrir el modal de evaluación
function openEvaluationModal() {
  document.getElementById("evaluationModal").classList.add("active")
}

// Función para cerrar el modal de evaluación
function closeEvaluationModal() {
  document.getElementById("evaluationModal").classList.remove("active")
  resetForm()
}

// Función para abrir el modal de éxito
function openSuccessModal() {
  document.getElementById("successModal").classList.add("active")
}

// Función para cerrar el modal de éxito
function closeSuccessModal() {
  document.getElementById("successModal").classList.remove("active")
}

// Función para alternar campos de entrada
function toggleField(fieldId) {
  const input = document.getElementById(fieldId)
  const button = input.previousElementSibling

  if (input.classList.contains("active")) {
    input.classList.remove("active")
    button.style.display = "flex"
  } else {
    input.classList.add("active")
    button.style.display = "none"
    input.focus()
  }
}

// Función para resetear el formulario
function resetForm() {
  const inputs = document.querySelectorAll(".form-input, .form-textarea")
  const buttons = document.querySelectorAll(".field-button")

  inputs.forEach((input) => {
    input.classList.remove("active", "error", "success")
    input.value = ""
  })

  buttons.forEach((button) => {
    button.style.display = "flex"
  })
}

// Función para validar campos
function validateField(fieldId) {
  const field = document.getElementById(fieldId)
  const value = field.value.trim()

  field.classList.remove("error", "success")

  if (value.length > 0) {
    field.classList.add("success")
    return true
  } else {
    field.classList.add("error")
    return false
  }
}

// Función para mostrar loading en el botón
function showLoading(button) {
  button.classList.add("loading")
  button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...'
}

// Función para ocultar loading en el botón
function hideLoading(button) {
  button.classList.remove("loading")
  button.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar'
}

// Inicialización cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Manejar envío del formulario
  document.getElementById("evaluationForm").addEventListener("submit", (e) => {
    e.preventDefault()

    const sendButton = document.querySelector(".send-button")

    // Validar campos obligatorios
    const nombre = document.getElementById("nombre").value.trim()
    const apellido = document.getElementById("apellido").value.trim()
    const sintomas = document.getElementById("sintomas").value.trim()

    let isValid = true

    // Validar nombre
    if (!nombre) {
      document.getElementById("nombre").classList.add("error")
      isValid = false
    } else {
      document.getElementById("nombre").classList.add("success")
    }

    // Validar apellido
    if (!apellido) {
      document.getElementById("apellido").classList.add("error")
      isValid = false
    } else {
      document.getElementById("apellido").classList.add("success")
    }

    // Validar síntomas
    if (!sintomas) {
      document.getElementById("sintomas").classList.add("error")
      isValid = false
    } else {
      document.getElementById("sintomas").classList.add("success")
    }

    if (!isValid) {
      alert("Por favor complete los campos obligatorios: Nombre, Apellido y Síntomas.")
      return
    }

    // Mostrar loading
    showLoading(sendButton)

    // Simular envío
    setTimeout(() => {
      hideLoading(sendButton)
      closeEvaluationModal()
      setTimeout(() => {
        openSuccessModal()
      }, 300)
    }, 2000)
  })

  // Cerrar modales al hacer clic fuera
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-overlay")) {
      if (e.target.id === "evaluationModal") {
        closeEvaluationModal()
      } else if (e.target.id === "successModal") {
        closeSuccessModal()
      }
    }
  })

  // Manejar tecla Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeEvaluationModal()
      closeSuccessModal()
    }
  })

  // Validación en tiempo real
  const inputs = document.querySelectorAll(".form-input, .form-textarea")
  inputs.forEach((input) => {
    input.addEventListener("blur", function () {
      if (this.value.trim()) {
        validateField(this.id)
      }
    })

    input.addEventListener("input", function () {
      this.classList.remove("error")
    })
  })
})
