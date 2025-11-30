// Datos de ejemplo para el sistema de vigilancia
const registrosAcceso = [
  {
    id: 1,
    fecha: "2024-01-15",
    hora: "08:30",
    nombre: "Carlos Mendoza",
    documento: "1234567890",
    rol: "Estudiante",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Ingreso normal al campus",
  },
  {
    id: 2,
    fecha: "2024-01-15",
    hora: "08:45",
    nombre: "María Rodríguez",
    documento: "0987654321",
    rol: "Docente",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Ingreso para clases matutinas",
  },
  {
    id: 3,
    fecha: "2024-01-15",
    hora: "09:15",
    nombre: "Juan Pérez",
    documento: "1122334455",
    rol: "Administrativo",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Personal administrativo",
  },
  {
    id: 4,
    fecha: "2024-01-15",
    hora: "10:30",
    nombre: "Ana García",
    documento: "5566778899",
    rol: "Visitante",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Visita programada - Reunión con dirección",
  },
  {
    id: 5,
    fecha: "2024-01-15",
    hora: "12:00",
    nombre: "Luis Torres",
    documento: "9988776655",
    rol: "Estudiante",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Salida para almuerzo",
  },
  {
    id: 6,
    fecha: "2024-01-15",
    hora: "13:30",
    nombre: "Luis Torres",
    documento: "9988776655",
    rol: "Estudiante",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Regreso de almuerzo",
  },
  {
    id: 7,
    fecha: "2024-01-15",
    hora: "14:15",
    nombre: "Sofia González",
    documento: "4455667788",
    rol: "Docente",
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Clases vespertinas",
  },
  {
    id: 8,
    fecha: "2024-01-15",
    hora: "15:45",
    nombre: "Diego Ramírez",
    documento: "7788990011",
    rol: "Estudiante",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Fin de jornada académica",
  },
  {
    id: 9,
    fecha: "2024-01-15",
    hora: "16:20",
    nombre: "Carmen Silva",
    documento: "2233445566",
    rol: "Administrativo",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Fin de jornada laboral",
  },
  {
    id: 10,
    fecha: "2024-01-15",
    hora: "17:00",
    nombre: "Ana García",
    documento: "5566778899",
    rol: "Visitante",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Fin de visita programada",
  },
  {
    id: 11,
    fecha: "2024-01-14",
    hora: "08:15",
    nombre: "Roberto Díaz",
    documento: "8899001122",
    rol: "Docente",
    tipo: "Ingreso",
    estado: "Fuera",
    observaciones: "Ingreso temprano",
  },
  {
    id: 12,
    fecha: "2024-01-14",
    hora: "09:30",
    nombre: "Elena Vargas",
    documento: "1122334400",
    rol: "Administrativo",
    tipo: "Ingreso",
    estado: "Fuera",
    observaciones: "Horario normal de trabajo",
  },
  {
    id: 13,
    fecha: "2024-01-14",
    hora: "11:45",
    nombre: "Miguel Ruiz",
    documento: "6677889900",
    rol: "Visitante",
    tipo: "Ingreso",
    estado: "Fuera",
    observaciones: "Proveedor de servicios",
  },
  {
    id: 14,
    fecha: "2024-01-14",
    hora: "14:30",
    nombre: "Patricia Morales",
    documento: "9900112233",
    rol: "Docente",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Salida por cita médica",
  },
  {
    id: 15,
    fecha: "2024-01-14",
    hora: "16:00",
    nombre: "Miguel Ruiz",
    documento: "6677889900",
    rol: "Visitante",
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Fin de servicio",
  },
]

let registrosFiltrados = [...registrosAcceso]
let qrCodeScanner = null
let personaEscaneada = null

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

  personaEscaneada = procesarCodigoQR(decodedText)

  document.getElementById("qr-person-name").textContent = personaEscaneada.nombre
  document.getElementById("qr-person-id").textContent = personaEscaneada.documento
  document.getElementById("qr-person-role").textContent = personaEscaneada.rol
  document.getElementById("qr-result").classList.remove("hidden")

  showSuccessMessage("Código QR escaneado exitosamente")
}

function procesarCodigoQR(codigoQR) {
  const personas = [
    { codigo: "EST001", nombre: "Carlos Mendoza", documento: "1234567890", rol: "Estudiante" },
    { codigo: "DOC001", nombre: "María Rodríguez", documento: "0987654321", rol: "Docente" },
    { codigo: "ADM001", nombre: "Juan Pérez", documento: "1122334455", rol: "Administrativo" },
    { codigo: "VIS001", nombre: "Ana García", documento: "5566778899", rol: "Visitante" },
    { codigo: "EST002", nombre: "Luis Torres", documento: "9988776655", rol: "Estudiante" },
  ]

  const persona = personas.find((p) => p.codigo === codigoQR) || {
    nombre: "Persona Desconocida",
    documento: codigoQR,
    rol: "Desconocido",
  }

  return persona
}

function registrarIngreso() {
  if (!personaEscaneada) return

  const nuevoRegistro = {
    id: registrosAcceso.length + 1,
    fecha: new Date().toISOString().split("T")[0],
    hora: new Date().toTimeString().slice(0, 5),
    nombre: personaEscaneada.nombre,
    documento: personaEscaneada.documento,
    rol: personaEscaneada.rol,
    tipo: "Ingreso",
    estado: "Dentro",
    observaciones: "Ingreso registrado por vigilancia",
  }

  registrosAcceso.unshift(nuevoRegistro)
  registrosFiltrados = [...registrosAcceso]

  showSuccessMessage(`Ingreso registrado: ${personaEscaneada.nombre}`)
  cerrarLectorQR()
}

function registrarSalida() {
  if (!personaEscaneada) return

  const nuevoRegistro = {
    id: registrosAcceso.length + 1,
    fecha: new Date().toISOString().split("T")[0],
    hora: new Date().toTimeString().slice(0, 5),
    nombre: personaEscaneada.nombre,
    documento: personaEscaneada.documento,
    rol: personaEscaneada.rol,
    tipo: "Salida",
    estado: "Fuera",
    observaciones: "Salida registrada por vigilancia",
  }

  registrosAcceso.unshift(nuevoRegistro)
  registrosFiltrados = [...registrosAcceso]

  showSuccessMessage(`Salida registrada: ${personaEscaneada.nombre}`)
  cerrarLectorQR()
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
      <td>${formatearFecha(registro.fecha)}</td>
      <td><i class="fas fa-clock"></i> ${registro.hora}</td>
      <td><strong>${registro.nombre}</strong></td>
      <td>${registro.documento}</td>
      <td><span class="role-badge ${getRolBadgeClass(registro.rol)}">${registro.rol}</span></td>
      <td><span class="status-badge ${getTipoBadgeClass(registro.tipo)}">${registro.tipo}</span></td>
      <td><span class="status-badge ${getEstadoBadgeClass(registro.estado)}">${registro.estado}</span></td>
      <td>
        <div class="action-buttons">
          <button onclick="verDetallesPersona(${registro.id})" class="btn-action btn-edit" title="Ver detalles">
            <i class="fas fa-eye"></i>
          </button>
        </div>
      </td>
    `
    tbody.appendChild(fila)
  })

  recordsInfo.textContent = `Mostrando ${registrosFiltrados.length} de ${registrosAcceso.length} registros`
}

function getRolBadgeClass(rol) {
  const clases = {
    Estudiante: "estudiante",
    Docente: "docente",
    Administrativo: "administrativo",
    Visitante: "visitante",
  }
  return clases[rol] || "estudiante"
}

function getTipoBadgeClass(tipo) {
  const clases = {
    Ingreso: "ingreso",
    Salida: "salida",
  }
  return clases[tipo] || "ingreso"
}

function getEstadoBadgeClass(estado) {
  const clases = {
    Dentro: "dentro",
    Fuera: "salida",
  }
  return clases[estado] || "dentro"
}

// Funciones de búsqueda y filtros
function buscarRegistros() {
  console.log("Buscando registros")
  const termino = document.getElementById("search-input").value.toLowerCase().trim()

  if (termino === "") {
    registrosFiltrados = [...registrosAcceso]
  } else {
    registrosFiltrados = registrosAcceso.filter(
      (registro) =>
        registro.nombre.toLowerCase().includes(termino) ||
        registro.documento.includes(termino) ||
        registro.rol.toLowerCase().includes(termino) ||
        registro.tipo.toLowerCase().includes(termino) ||
        registro.observaciones.toLowerCase().includes(termino),
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
  const tipo = document.getElementById("tipo-select").value
  const rol = document.getElementById("rol-select").value

  let registrosTemp = [...registrosAcceso]

  if (fechaInicio && fechaFin) {
    registrosTemp = registrosTemp.filter((registro) => {
      const fechaRegistro = new Date(registro.fecha)
      const inicio = new Date(fechaInicio)
      const fin = new Date(fechaFin)
      return fechaRegistro >= inicio && fechaRegistro <= fin
    })
  }

  if (tipo) {
    registrosTemp = registrosTemp.filter((registro) => registro.tipo === tipo)
  }

  if (rol) {
    registrosTemp = registrosTemp.filter((registro) => registro.rol === rol)
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
  document.getElementById("tipo-select").value = ""
  document.getElementById("rol-select").value = ""

  registrosFiltrados = [...registrosAcceso]
  cargarRegistros()
  toggleFiltros()
  showSuccessMessage("Filtros limpiados")
}

// Funciones de reportes y impresión
function generarPDF() {
  console.log("Generando PDF")
  showLoadingOverlay()

  setTimeout(() => {
    try {
      const { jsPDF } = window.jspdf

      const doc = new jsPDF()

      // Título
      doc.setFontSize(20)
      doc.text("SOFT-IN - Historial de Acceso", 20, 20)

      // Información del reporte
      doc.setFontSize(12)
      doc.text(`Fecha del reporte: ${new Date().toLocaleDateString("es-CO")}`, 20, 35)
      doc.text(`Vigilante: Nombre del Vigilante`, 20, 45)
      doc.text(`Total de registros: ${registrosFiltrados.length}`, 20, 55)

      // Encabezados de tabla
      let yPosition = 75
      doc.setFontSize(10)
      doc.text("Fecha", 20, yPosition)
      doc.text("Hora", 50, yPosition)
      doc.text("Nombre", 75, yPosition)
      doc.text("Documento", 120, yPosition)
      doc.text("Rol", 155, yPosition)
      doc.text("Tipo", 180, yPosition)

      // Línea separadora
      doc.line(20, yPosition + 2, 190, yPosition + 2)

      // Datos
      yPosition += 10
      registrosFiltrados.slice(0, 30).forEach((registro) => {
        if (yPosition > 270) {
          doc.addPage()
          yPosition = 20
        }

        doc.text(registro.fecha, 20, yPosition)
        doc.text(registro.hora, 50, yPosition)
        doc.text(registro.nombre.substring(0, 15), 75, yPosition)
        doc.text(registro.documento, 120, yPosition)
        doc.text(registro.rol, 155, yPosition)
        doc.text(registro.tipo, 180, yPosition)

        yPosition += 8
      })

      // Guardar PDF
      doc.save(`historial-acceso-${new Date().toISOString().split("T")[0]}.pdf`)

      hideLoadingOverlay()
      showSuccessMessage("PDF generado y descargado exitosamente")
    } catch (error) {
      console.error("Error generando PDF:", error)
      hideLoadingOverlay()
      showSuccessMessage("Error al generar PDF. Verifique que jsPDF esté cargado.")
    }
  }, 1000)
}

function imprimirHistorial() {
  console.log("Preparando impresión")
  showLoadingOverlay()

  setTimeout(() => {
    // Preparar datos para impresión
    const printArea = document.getElementById("print-area")
    const printTable = document.getElementById("print-table")
    const printDate = document.getElementById("print-date")
    const printGuard = document.getElementById("print-guard")

    printDate.textContent = new Date().toLocaleDateString("es-CO")
    printGuard.textContent = "Nombre del Vigilante"

    // Limpiar tabla
    printTable.innerHTML = ""

    // Crear encabezados
    const thead = document.createElement("thead")
    thead.innerHTML = `
      <tr>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Rol</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Observaciones</th>
      </tr>
    `
    printTable.appendChild(thead)

    // Crear cuerpo de tabla
    const tbody = document.createElement("tbody")
    registrosFiltrados.forEach((registro) => {
      const fila = document.createElement("tr")
      fila.innerHTML = `
        <td>${registro.fecha}</td>
        <td>${registro.hora}</td>
        <td>${registro.nombre}</td>
        <td>${registro.documento}</td>
        <td>${registro.rol}</td>
        <td>${registro.tipo}</td>
        <td>${registro.estado}</td>
        <td>${registro.observaciones}</td>
      `
      tbody.appendChild(fila)
    })
    printTable.appendChild(tbody)

    hideLoadingOverlay()

    // Imprimir
    window.print()

    showSuccessMessage("Documento enviado a impresión")
  }, 1000)
}

// Funciones de modales
function verDetallesPersona(registroId) {
  console.log("Ver detalles persona:", registroId)
  const registro = registrosAcceso.find((r) => r.id === registroId)
  if (!registro) return

  const detallesHTML = `
    <div style="display: grid; gap: 20px;">
      <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h4 style="color: #2c3e50; margin-bottom: 15px;"><i class="fas fa-user"></i> Información Personal</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
          <div><strong>Nombre:</strong> ${registro.nombre}</div>
          <div><strong>Documento:</strong> ${registro.documento}</div>
          <div><strong>Rol:</strong> <span class="role-badge ${getRolBadgeClass(registro.rol)}">${registro.rol}</span></div>
        </div>
      </div>
      <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h4 style="color: #2c3e50; margin-bottom: 15px;"><i class="fas fa-clock"></i> Detalles del Acceso</h4>
        <div style="display: grid; gap: 10px;">
          <div><strong>Fecha:</strong> ${formatearFecha(registro.fecha)}</div>
          <div><strong>Hora:</strong> ${registro.hora}</div>
          <div><strong>Tipo:</strong> <span class="status-badge ${getTipoBadgeClass(registro.tipo)}">${registro.tipo}</span></div>
          <div><strong>Estado:</strong> <span class="status-badge ${getEstadoBadgeClass(registro.estado)}">${registro.estado}</span></div>
          <div><strong>Observaciones:</strong> ${registro.observaciones}</div>
        </div>
      </div>
    </div>
  `

  document.getElementById("person-details").innerHTML = detallesHTML
  showModal("person-modal")
}

function cerrarModalPersona() {
  console.log("Cerrando modal persona")
  hideModal("person-modal")
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
    // 
    setTimeout(() => {
      window.location.href = "index-inicio-sesion.html"
    }, 2000)
  }, 1500)
}

function showMainMenu() {
  console.log("Mostrando menú principal")
  showSuccessMessage("Menú principal")
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
  console.log("DOM cargado, inicializando sistema de vigilancia")

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
  console.log(`📊 ${registrosAcceso.length} registros de acceso cargados`)

})