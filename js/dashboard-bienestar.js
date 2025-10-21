// Datos de ejemplo para el sistema de bienestar
const registrosBienestar = [
  {
    id: 1,
    estudiante: "Carlos Mendoza",
    documento: "1234567890",
    fechaIngreso: "2024-01-15",
    horaIngreso: "08:30",
    tipoIngreso: "Consulta Psicológica",
    motivo: "Ansiedad académica",
    estado: "Atendido",
    responsableBienestar: "Dra. Ana García",
    observaciones: "Estudiante presenta síntomas de estrés por exámenes finales. Se programa seguimiento semanal.",
  },
  {
    id: 2,
    estudiante: "María Rodríguez",
    documento: "0987654321",
    fechaIngreso: "2024-01-15",
    horaIngreso: "10:15",
    tipoIngreso: "Apoyo Social",
    motivo: "Dificultades económicas",
    estado: "En proceso",
    responsableBienestar: "Lic. Pedro López",
    observaciones: "Se inicia proceso de apoyo financiero. Documentación en revisión.",
  },
  {
    id: 3,
    estudiante: "Juan Pérez",
    documento: "1122334455",
    fechaIngreso: "2024-01-14",
    horaIngreso: "14:20",
    tipoIngreso: "Enfermería",
    motivo: "Control de presión arterial",
    estado: "Completado",
    responsableBienestar: "Enf. Carmen Silva",
    observaciones: "Presión arterial normal (120/80). Se programa control mensual.",
  },
  {
    id: 4,
    estudiante: "Laura Torres",
    documento: "5566778899",
    fechaIngreso: "2024-01-13",
    horaIngreso: "09:45",
    tipoIngreso: "Orientación Académica",
    motivo: "Cambio de programa",
    estado: "Programado",
    responsableBienestar: "Coord. Miguel Ruiz",
    observaciones: "Cita programada para revisión de expediente académico el 20/01/2024.",
  },
  {
    id: 5,
    estudiante: "Ana Martínez",
    documento: "9988776655",
    fechaIngreso: "2024-01-12",
    horaIngreso: "11:30",
    tipoIngreso: "Consulta Psicológica",
    motivo: "Problemas de adaptación",
    estado: "Atendido",
    responsableBienestar: "Psic. Roberto Díaz",
    observaciones: "Primera sesión completada. Estudiante muestra buena disposición al tratamiento.",
  },
  {
    id: 6,
    estudiante: "Diego Ramírez",
    documento: "4455667788",
    fechaIngreso: "2024-01-11",
    horaIngreso: "15:00",
    tipoIngreso: "Apoyo Social",
    motivo: "Problemas familiares",
    estado: "En proceso",
    responsableBienestar: "T.S. Elena Vargas",
    observaciones: "Caso requiere intervención familiar. Se programa visita domiciliaria.",
  },
  {
    id: 7,
    estudiante: "Sofía González",
    documento: "3344556677",
    fechaIngreso: "2024-01-10",
    horaIngreso: "13:15",
    tipoIngreso: "Enfermería",
    motivo: "Dolor de cabeza frecuente",
    estado: "Atendido",
    responsableBienestar: "Enf. Patricia Morales",
    observaciones: "Se recomienda evaluación neurológica. Medicamento para el dolor prescrito.",
  },
  {
    id: 8,
    estudiante: "Andrés Castillo",
    documento: "7788990011",
    fechaIngreso: "2024-01-09",
    horaIngreso: "16:30",
    tipoIngreso: "Consulta Psicológica",
    motivo: "Depresión",
    estado: "En proceso",
    responsableBienestar: "Dra. Ana García",
    observaciones: "Tratamiento psicológico iniciado. Seguimiento semanal programado.",
  },
  {
    id: 9,
    estudiante: "Valentina Herrera",
    documento: "2233445566",
    fechaIngreso: "2024-01-08",
    horaIngreso: "10:00",
    tipoIngreso: "Orientación Académica",
    motivo: "Bajo rendimiento académico",
    estado: "Completado",
    responsableBienestar: "Coord. Miguel Ruiz",
    observaciones: "Plan de mejoramiento académico establecido. Seguimiento mensual.",
  },
  {
    id: 10,
    estudiante: "Camilo Vargas",
    documento: "5566778800",
    fechaIngreso: "2024-01-07",
    horaIngreso: "14:45",
    tipoIngreso: "Apoyo Social",
    motivo: "Problemas de vivienda",
    estado: "Programado",
    responsableBienestar: "T.S. Elena Vargas",
    observaciones: "Cita programada para evaluar opciones de alojamiento estudiantil.",
  },
  {
    id: 11,
    estudiante: "Isabella Moreno",
    documento: "8899001122",
    fechaIngreso: "2024-01-06",
    horaIngreso: "09:20",
    tipoIngreso: "Enfermería",
    motivo: "Control de diabetes",
    estado: "Atendido",
    responsableBienestar: "Enf. Carmen Silva",
    observaciones: "Niveles de glucosa estables. Continuar con tratamiento actual.",
  },
  {
    id: 12,
    estudiante: "Sebastián López",
    documento: "1122334400",
    fechaIngreso: "2024-01-05",
    horaIngreso: "11:10",
    tipoIngreso: "Consulta Psicológica",
    motivo: "Problemas de autoestima",
    estado: "En proceso",
    responsableBienestar: "Psic. Roberto Díaz",
    observaciones: "Terapia cognitivo-conductual iniciada. Progreso favorable.",
  },
  {
    id: 13,
    estudiante: "Natalia Jiménez",
    documento: "6677889900",
    fechaIngreso: "2024-01-04",
    horaIngreso: "15:30",
    tipoIngreso: "Orientación Académica",
    motivo: "Orientación vocacional",
    estado: "Completado",
    responsableBienestar: "Coord. Miguel Ruiz",
    observaciones: "Pruebas vocacionales aplicadas. Recomendaciones entregadas.",
  },
  {
    id: 14,
    estudiante: "Mateo Sánchez",
    documento: "9900112233",
    fechaIngreso: "2024-01-03",
    horaIngreso: "12:00",
    tipoIngreso: "Apoyo Social",
    motivo: "Beca de alimentación",
    estado: "Atendido",
    responsableBienestar: "Lic. Pedro López",
    observaciones: "Beca de alimentación aprobada. Documentos procesados correctamente.",
  },
  {
    id: 15,
    estudiante: "Gabriela Ruiz",
    documento: "4455667700",
    fechaIngreso: "2024-01-02",
    horaIngreso: "08:45",
    tipoIngreso: "Enfermería",
    motivo: "Vacunación",
    estado: "Completado",
    responsableBienestar: "Enf. Patricia Morales",
    observaciones: "Vacuna contra la influenza aplicada. Sin reacciones adversas.",
  },
]

let registrosFiltrados = [...registrosBienestar]
let qrCodeScanner = null

// Funciones principales del dashboard
function mostrarLectorQR() {
  console.log("Mostrando lector QR")
  document.getElementById("qr-section").classList.remove("hidden")
  document.getElementById("historial-section").classList.add("hidden")
}

function cerrarLectorQR() {
  console.log("Cerrando lector QR")
  document.getElementById("qr-section").classList.add("hidden")
  if (qrCodeScanner) {
    qrCodeScanner.clear()
    qrCodeScanner = null
  }
  document.getElementById("qr-result").classList.add("hidden")
}

function mostrarHistorial() {
  console.log("Mostrando historial")
  document.getElementById("historial-section").classList.remove("hidden")
  document.getElementById("qr-section").classList.add("hidden")
  cargarRegistros()
}

function cerrarHistorial() {
  console.log("Cerrando historial")
  document.getElementById("historial-section").classList.add("hidden")
}

// Funciones del historial
function cargarRegistros() {
  console.log("Cargando registros:", registrosFiltrados.length)
  const tbody = document.getElementById("records-tbody")
  const noRecords = document.getElementById("no-records")
  const recordsInfo = document.getElementById("records-info")

  if (!tbody) {
    console.error("No se encontró el elemento records-tbody")
    return
  }

  tbody.innerHTML = ""

  if (registrosFiltrados.length === 0) {
    noRecords.classList.remove("hidden")
    recordsInfo.textContent = "Mostrando 0 de 0 registros"
    return
  }

  noRecords.classList.add("hidden")

  registrosFiltrados.forEach((registro) => {
    const fila = document.createElement("tr")
    fila.innerHTML = `
      <td><strong>${registro.estudiante}</strong></td>
      <td>${registro.documento}</td>
      <td>${formatearFecha(registro.fechaIngreso)}</td>
      <td><i class="fas fa-clock"></i> ${registro.horaIngreso}</td>
      <td><span class="role-badge ${getTipoBadgeClass(registro.tipoIngreso)}">${registro.tipoIngreso}</span></td>
      <td><span class="status-badge ${getEstadoBadgeClass(registro.estado)}">${registro.estado}</span></td>
      <td>${registro.responsableBienestar}</td>
      <td>
        <div class="action-buttons">
          <button onclick="verDetallesEstudiante(${registro.id})" class="btn-action btn-edit" title="Ver detalles">
            <i class="fas fa-eye"></i>
          </button>
          <button onclick="editarRegistro(${registro.id})" class="btn-action btn-delete" title="Editar registro">
            <i class="fas fa-edit"></i>
          </button>
        </div>
      </td>
    `
    tbody.appendChild(fila)
  })

  recordsInfo.textContent = `Mostrando ${registrosFiltrados.length} de ${registrosBienestar.length} registros`
}

function getTipoBadgeClass(tipo) {
  const clases = {
    "Consulta Psicológica": "psicologia",
    "Apoyo Social": "social",
    Enfermería: "enfermeria",
    "Orientación Académica": "academica",
  }
  return clases[tipo] || "psicologia"
}

function getEstadoBadgeClass(estado) {
  const clases = {
    Atendido: "atendido",
    "En proceso": "en-proceso",
    Completado: "completado",
    Programado: "programado",
  }
  return clases[estado] || "programado"
}

// Funciones de búsqueda y filtros
function buscarRegistros() {
  console.log("Buscando registros")
  const termino = document.getElementById("search-input").value.toLowerCase().trim()

  if (termino === "") {
    registrosFiltrados = [...registrosBienestar]
  } else {
    registrosFiltrados = registrosBienestar.filter(
      (registro) =>
        registro.estudiante.toLowerCase().includes(termino) ||
        registro.documento.includes(termino) ||
        registro.tipoIngreso.toLowerCase().includes(termino) ||
        registro.motivo.toLowerCase().includes(termino) ||
        registro.responsableBienestar.toLowerCase().includes(termino),
    )
  }

  cargarRegistros()
  showSuccessMessage(`Se encontraron ${registrosFiltrados.length} registros`)
}

function toggleFiltros() {
  console.log("Toggle filtros")
  const panel = document.getElementById("filtros-panel")
  panel.classList.toggle("hidden")
}

function aplicarFiltros() {
  console.log("Aplicando filtros")
  const fechaInicio = document.getElementById("fecha-inicio").value
  const fechaFin = document.getElementById("fecha-fin").value
  const año = document.getElementById("year-select").value

  let registrosTemp = [...registrosBienestar]

  if (fechaInicio && fechaFin) {
    registrosTemp = registrosTemp.filter((registro) => {
      const fechaRegistro = new Date(registro.fechaIngreso)
      const inicio = new Date(fechaInicio)
      const fin = new Date(fechaFin)
      return fechaRegistro >= inicio && fechaRegistro <= fin
    })
  }

  if (año) {
    registrosTemp = registrosTemp.filter((registro) => registro.fechaIngreso.startsWith(año))
  }

  registrosFiltrados = registrosTemp
  cargarRegistros()
  toggleFiltros()
  showSuccessMessage(`Filtros aplicados. ${registrosFiltrados.length} registros encontrados`)
}

function limpiarFiltros() {
  console.log("Limpiando filtros")
  document.getElementById("search-input").value = ""
  document.getElementById("fecha-inicio").value = ""
  document.getElementById("fecha-fin").value = ""
  document.getElementById("year-select").value = ""

  registrosFiltrados = [...registrosBienestar]
  cargarRegistros()
  toggleFiltros()
  showSuccessMessage("Filtros limpiados")
}

// Funciones de reportes
function generarReporte() {
  console.log("Generando PDF")
  showLoadingOverlay()

  setTimeout(() => {
    try {
      const { jsPDF } = window.jspdf
      const doc = new jsPDF()

      // Título
      doc.setFontSize(20)
      doc.text("SOFT-IN - Historial de Bienestar", 20, 20)

      // Información del reporte
      doc.setFontSize(12)
      doc.text(`Fecha del reporte: ${new Date().toLocaleDateString("es-CO")}`, 20, 35)
      const currentUser = window.getCurrentUser()
      doc.text(`Bienestar: ${currentUser.nombre || "Usuario"}`, 20, 45)
      doc.text(`Total de registros: ${registrosFiltrados.length}`, 20, 55)

      // Encabezados de tabla
      let yPosition = 75
      doc.setFontSize(10)
      doc.text("Fecha", 20, yPosition)
      doc.text("Hora", 50, yPosition)
      doc.text("Estudiante", 75, yPosition)
      doc.text("Documento", 120, yPosition)
      doc.text("Tipo", 155, yPosition)
      doc.text("Estado", 180, yPosition)

      // Línea separadora
      doc.line(20, yPosition + 2, 190, yPosition + 2)

      // Datos
      yPosition += 10
      registrosFiltrados.slice(0, 30).forEach((registro) => {
        if (yPosition > 270) {
          doc.addPage()
          yPosition = 20
        }
        doc.text(formatearFecha(registro.fechaIngreso), 20, yPosition)
        doc.text(registro.horaIngreso, 50, yPosition)
        doc.text(registro.estudiante.substring(0, 15), 75, yPosition)
        doc.text(registro.documento, 120, yPosition)
        doc.text(registro.tipoIngreso, 155, yPosition)
        doc.text(registro.estado, 180, yPosition)
        yPosition += 8
      })

      // Guardar PDF
      doc.save(`bienestar-historial-${new Date().toISOString().split("T")[0]}.pdf`)

      hideLoadingOverlay()
      showSuccessMessage("PDF generado y descargado exitosamente")
    } catch (error) {
      console.error("Error generando PDF:", error)
      hideLoadingOverlay()
      showSuccessMessage("Error al generar PDF. Verifique que jsPDF esté cargado.")
    }
  }, 1000)
}

function descargarHistorialPDF() {
  showLoadingOverlay()
  setTimeout(() => {
    try {
      const { jsPDF } = window.jspdf
      const doc = new jsPDF("p", "mm", "a4")

      // Título principal
      doc.setFontSize(18)
      doc.text("SOFT-IN - Historial de Bienestar", 20, 20)

      // Datos del usuario actual
      const currentUser = window.getCurrentUser()
      doc.setFontSize(12)
      doc.text(`Bienestar: ${currentUser.nombre || "Usuario"}`, 20, 30)
      doc.text(`Fecha del reporte: ${new Date().toLocaleDateString("es-CO")}`, 20, 37)
      doc.text(`Total de registros: ${registrosFiltrados.length}`, 20, 44)

      // Encabezados de la tabla
      let y = 55
      doc.setFontSize(10)
      doc.text("Estudiante", 20, y)
      doc.text("Documento", 55, y)
      doc.text("Fecha", 85, y)
      doc.text("Hora", 110, y)
      doc.text("Tipo", 130, y)
      doc.text("Estado", 155, y)
      doc.text("Responsable", 175, y)

      doc.line(20, y + 2, 200, y + 2)
      y += 8

      // Registros
      registrosFiltrados.forEach((registro, idx) => {
        if (y > 280) {
          doc.addPage()
          y = 20
        }
        doc.text(registro.estudiante, 20, y)
        doc.text(registro.documento, 55, y)
        doc.text(formatearFecha(registro.fechaIngreso), 85, y)
        doc.text(registro.horaIngreso, 110, y)
        doc.text(registro.tipoIngreso, 130, y)
        doc.text(registro.estado, 155, y)
        doc.text(registro.responsableBienestar, 175, y)
        y += 7
      })

      doc.save(`bienestar-historial-${new Date().toISOString().split("T")[0]}.pdf`)
      hideLoadingOverlay()
      showSuccessMessage("PDF generado y descargado exitosamente")
    } catch (error) {
      hideLoadingOverlay()
      showSuccessMessage("Error al generar PDF. Verifique que jsPDF esté cargado.")
    }
  }, 800)
}

// Funciones de modales
function verDetallesEstudiante(registroId) {
  console.log("Ver detalles estudiante:", registroId)
  const registro = registrosBienestar.find((r) => r.id === registroId)
  if (!registro) return

  const detallesHTML = `
    <div style="display: grid; gap: 20px;">
      <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h4 style="color: #2c3e50; margin-bottom: 15px;"><i class="fas fa-user"></i> Información del Estudiante</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
          <div><strong>Nombre:</strong> ${registro.estudiante}</div>
          <div><strong>Documento:</strong> ${registro.documento}</div>
          <div><strong>Fecha:</strong> ${formatearFecha(registro.fechaIngreso)}</div>
          <div><strong>Hora:</strong> ${registro.horaIngreso}</div>
        </div>
      </div>
      <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h4 style="color: #2c3e50; margin-bottom: 15px;"><i class="fas fa-clipboard"></i> Detalles de Atención</h4>
        <div style="display: grid; gap: 10px;">
          <div><strong>Tipo:</strong> <span class="role-badge ${getTipoBadgeClass(registro.tipoIngreso)}">${registro.tipoIngreso}</span></div>
          <div><strong>Estado:</strong> <span class="status-badge ${getEstadoBadgeClass(registro.estado)}">${registro.estado}</span></div>
          <div><strong>Motivo:</strong> ${registro.motivo}</div>
          <div><strong>Responsable:</strong> ${registro.responsableBienestar}</div>
          <div><strong>Observaciones:</strong> ${registro.observaciones}</div>
        </div>
      </div>
    </div>
  `

  document.getElementById("student-details").innerHTML = detallesHTML
  showModal("student-modal")
}

function cerrarModalEstudiante() {
  console.log("Cerrando modal estudiante")
  hideModal("student-modal")
}

function editarRegistro(registroId) {
  console.log("Editando registro:", registroId)
  showSuccessMessage(`Editando registro ID: ${registroId}`)
}

// Funciones del modal de usuario
function showUserMenu() {
  console.log("Mostrando menú de usuario")
  showModal("userMenuModal")
}

function closeUserMenu() {
  console.log("Cerrando menú de usuario")
  hideModal("userMenuModal")
}

function abrirPerfil() {
  console.log("Abriendo perfil")
  closeUserMenu()
  showSuccessMessage("Abriendo perfil de usuario...")
}

function abrirConfiguracion() {
  console.log("Abriendo configuración")
  closeUserMenu()
  showSuccessMessage("Abriendo configuración...")
}

function confirmarCerrarSesion() {
  console.log("Confirmando cerrar sesión")
  closeUserMenu()
  showModal("logoutModal")
}

function cancelarCerrarSesion() {
  console.log("Cancelando cerrar sesión")
  hideModal("logoutModal")
}

function cerrarSesion() {
  console.log("Cerrando sesión")
  showLoadingOverlay()

  setTimeout(() => {
    localStorage.clear()
    sessionStorage.clear()
    hideLoadingOverlay()
    hideModal("logoutModal")

    document.getElementById("successMessage").textContent = "👋 Sesión cerrada exitosamente. Redirigiendo..."
    showModal("successModal")

    setTimeout(() => {
      window.location.href = "index-inicio-sesion.html"
    }, 2000)
  }, 1500)
}


// Función para cargar datos del usuario
function loadUserData() {
  const currentUser = window.getCurrentUser()

  if (currentUser.nombre) {
    document.getElementById("welcomeMessage").textContent = `Bienvenido, ${currentUser.nombre}`
  }
}

function showMainMenu() {
  console.log("Mostrando menú principal")
  showSuccessMessage("Menú principal")
}

// Funciones del lector QR
function iniciarEscaner() {
  console.log("Iniciando escáner QR")
  const qrReaderElement = document.getElementById("qr-reader")
  qrReaderElement.innerHTML = ""

  const config = {
    fps: 10,
    qrbox: { width: 250, height: 250 },
    aspectRatio: 1.0,
    disableFlip: false,
  }

  // Declare Html5QrcodeScanner before using it
  const Html5QrcodeScanner = window.Html5QrcodeScanner
  qrCodeScanner = new Html5QrcodeScanner("qr-reader", config, false)

  qrCodeScanner.render(
    (decodedText, decodedResult) => {
      onScanSuccess(decodedText, decodedResult)
    },
    (error) => {
      console.warn(`Error de escaneo QR: ${error}`)
    },
  )

  document.querySelector(".qr-instructions").style.display = "none"
}

function onScanSuccess(decodedText, decodedResult) {
  console.log("QR escaneado exitosamente:", decodedText)
  if (qrCodeScanner) {
    qrCodeScanner.clear()
  }

  const datosEstudiante = procesarCodigoQR(decodedText)

  document.getElementById("qr-student-name").textContent = datosEstudiante.nombre
  document.getElementById("qr-student-id").textContent = datosEstudiante.documento
  document.getElementById("qr-result").classList.remove("hidden")

  showSuccessMessage("Código QR escaneado exitosamente")
}

function procesarCodigoQR(codigoQR) {
  const estudiantes = [
    { codigo: "EST001", nombre: "Carlos Mendoza", documento: "1234567890" },
    { codigo: "EST002", nombre: "María Rodríguez", documento: "0987654321" },
    { codigo: "EST003", nombre: "Juan Pérez", documento: "1122334455" },
    { codigo: "EST004", nombre: "Laura Torres", documento: "5566778899" },
  ]

  const estudiante = estudiantes.find((est) => est.codigo === codigoQR) || {
    nombre: "Estudiante Desconocido",
    documento: codigoQR,
  }

  return estudiante
}

function procesarQR() {
  console.log("Procesando QR")
  const nombreEstudiante = document.getElementById("qr-student-name").textContent
  const documentoEstudiante = document.getElementById("qr-student-id").textContent

  showSuccessMessage(`Procesando ingreso de ${nombreEstudiante}`)
  cerrarLectorQR()
}

// Funciones utilitarias
function formatearFecha(fecha) {
  const opciones = {
    year: "numeric",
    month: "long",
    day: "numeric",
  }
  return new Date(fecha).toLocaleDateString("es-CO", opciones)
}

function showModal(modalId) {
  console.log("Mostrando modal:", modalId)
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.add("active")
  } else {
    console.error("Modal no encontrado:", modalId)
  }
}

function hideModal(modalId) {
  console.log("Ocultando modal:", modalId)
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.remove("active")
  } else {
    console.error("Modal no encontrado:", modalId)
  }
}

function showLoadingOverlay() {
  console.log("Mostrando loading")
  const overlay = document.getElementById("loadingOverlay")
  if (overlay) {
    overlay.classList.add("active")
  }
}

function hideLoadingOverlay() {
  console.log("Ocultando loading")
  const overlay = document.getElementById("loadingOverlay")
  if (overlay) {
    overlay.classList.remove("active")
  }
}

function showSuccessMessage(message) {
  console.log("Mostrando mensaje:", message)
  const messageElement = document.getElementById("successMessage")
  if (messageElement) {
    messageElement.textContent = message
    showModal("successModal")
  }
}

function closeSuccessModal() {
  console.log("Cerrando modal de éxito")
  hideModal("successModal")
}

// Event Listeners
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM cargado, inicializando sistema")

  // Configurar fecha actual por defecto en filtros
  const hoy = new Date().toISOString().split("T")[0]
  const fechaInicio = document.getElementById("fecha-inicio")
  const fechaFin = document.getElementById("fecha-fin")

  if (fechaInicio) fechaInicio.value = hoy
  if (fechaFin) fechaFin.value = hoy

  // Event listener para búsqueda con Enter
  const searchInput = document.getElementById("search-input")
  if (searchInput) {
    searchInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        buscarRegistros()
      }
    })
  }

  // Cerrar modales al hacer clic fuera de ellos
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-overlay")) {
      e.target.classList.remove("active")
    }
  })

  // Mostrar nombre de usuario en el dashboard
  const currentUser = window.getCurrentUser()
  const welcomeTitle = document.querySelector(".welcome-title")
  if (welcomeTitle && currentUser.nombre) {
    welcomeTitle.textContent = `Bienvenido, ${currentUser.nombre}`
  }

  // Mostrar nombre en el modal de usuario
  const modalTitle = document.querySelector("#userMenuModal .modal-title")
  if (modalTitle && currentUser.nombre) {
    modalTitle.textContent = currentUser.nombre
  }
  const modalSubtitle = document.querySelector("#userMenuModal .modal-subtitle")
  if (modalSubtitle && currentUser.especialidad) {
    modalSubtitle.textContent = `BIENESTAR - ${currentUser.especialidad}`
  }

  console.log("🎉 Sistema de Bienestar SOFT-IN inicializado correctamente")
  console.log(`📊 ${registrosBienestar.length} registros de bienestar cargados`)

  // Mostrar mensaje de bienvenida
  setTimeout(() => {
    showSuccessMessage("Sistema de Bienestar cargado exitosamente")
  }, 500)
})

window.getCurrentUser = () => {
  // Busca el usuario en sessionStorage o localStorage
  return JSON.parse(sessionStorage.getItem("currentUser") || localStorage.getItem("currentUser") || "null") || {
    nombre: "Usuario",
    rol: "bienestar",
    especialidad: "",
  }
}
