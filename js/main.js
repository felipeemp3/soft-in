// Función para volver a la página anterior
function goBack() {
  window.history.back()
}

// Función para adjuntar PDF
function attachPDF() {
  // Crear un input file temporal para seleccionar PDF
  const input = document.createElement("input")
  input.type = "file"
  input.accept = ".pdf"
  input.onchange = (e) => {
    const file = e.target.files[0]
    if (file) {
      alert("Archivo seleccionado: " + file.name)
      // Aquí puedes agregar la lógica para manejar el archivo PDF
      console.log("Archivo PDF seleccionado:", file)
    }
  }
  input.click()
}

// Función para validar el formulario
function validateForm(data) {
  const errors = []

  if (!data.nombre || data.nombre.trim().length < 2) {
    errors.push("El nombre debe tener al menos 2 caracteres")
  }

  if (!data.programa || data.programa.trim().length < 3) {
    errors.push("El programa debe tener al menos 3 caracteres")
  }

  if (!data.fecha) {
    errors.push("La fecha es requerida")
  }

  return errors
}

// Función para manejar el envío del formulario
function handleFormSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const data = Object.fromEntries(formData)

  // Validar formulario
  const errors = validateForm(data)

  if (errors.length > 0) {
    alert("Errores en el formulario:\n" + errors.join("\n"))
    return
  }

  // Simular envío del formulario
  console.log("Datos del formulario:", data)
  alert(
    "Formulario enviado correctamente:\n" +
      "Nombre: " +
      data.nombre +
      "\n" +
      "Programa: " +
      data.programa +
      "\n" +
      "Fecha: " +
      data.fecha +
      "\n" +
      "Observación: " +
      (data.observacion || "Sin observaciones"),
  )

  // Aquí puedes agregar la lógica para enviar los datos al servidor
  // Por ejemplo: sendDataToServer(data);
}

// Función para manejar teclas especiales
function handleKeyDown(e) {
  if (e.key === "Escape") {
    goBack()
  }
}

// Inicializar eventos cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Agregar event listener al formulario
  const form = document.getElementById("permisoForm")
  if (form) {
    form.addEventListener("submit", handleFormSubmit)
  }

  // Agregar event listener para teclas
  document.addEventListener("keydown", handleKeyDown)

  // Log para confirmar que el script se cargó
  console.log("Script main.js cargado correctamente")
})

// Función opcional para enviar datos al servidor
function sendDataToServer(data) {
  // Ejemplo de cómo podrías enviar los datos
  /*
    fetch('/api/permiso-formacion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Respuesta del servidor:', result);
        alert('Datos enviados correctamente al servidor');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar los datos');
    });
    */
}
