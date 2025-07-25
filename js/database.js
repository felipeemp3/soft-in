// Simulación de base de datos PostgreSQL basada en el esquema real
class SoftInDatabase {
  constructor() {
    this.initializeDatabase()
  }

  // Inicializar base de datos con datos de ejemplo
  initializeDatabase() {
    // Verificar si ya existen datos
    if (!localStorage.getItem("soft_in_persona")) {
      this.seedDatabase()
    }
  }

  // Poblar base de datos con usuarios de ejemplo (basado en el esquema real)
  seedDatabase() {
    const personas = [
      {
        id_persona: 1,
        nombre_completo: "María García López",
        documento: "12345678",
        tipo_documento: "CC",
        rol: "enfermera",
        programa_formacion: "Auxiliar de Enfermería",
        no_ficha: "ENF001",
        estado_formacion: "Activo",
        contrasena: "enf123",
      },
      {
        id_persona: 2,
        nombre_completo: "Juan Pérez González",
        documento: "87654321",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Técnico en Sistemas",
        no_ficha: "2758493",
        estado_formacion: "Activo",
        contrasena: "user123",
      },
      {
        id_persona: 3,
        nombre_completo: "Ana López Martínez",
        documento: "11111111",
        tipo_documento: "CC",
        rol: "enfermera",
        programa_formacion: "Técnico en Enfermería",
        no_ficha: "ENF002",
        estado_formacion: "Activo",
        contrasena: "enf123",
      },
      {
        id_persona: 4,
        nombre_completo: "Laura Martínez Ruiz",
        documento: "22222222",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Auxiliar de Enfermería",
        no_ficha: "2758494",
        estado_formacion: "Activo",
        contrasena: "user123",
      },
      {
        id_persona: 5,
        nombre_completo: "Roberto Jiménez Vargas",
        documento: "66666666",
        tipo_documento: "CC",
        rol: "bienestar",
        programa_formacion: "Psicología",
        no_ficha: "BIE001",
        estado_formacion: "Activo",
        contrasena: "bien123",
      },
      {
        id_persona: 6,
        nombre_completo: "Miguel Ángel Ramírez",
        documento: "88888888",
        tipo_documento: "CC",
        rol: "vigilante",
        programa_formacion: "Seguridad y Vigilancia",
        no_ficha: "VIG001",
        estado_formacion: "Activo",
        contrasena: "vig123",
      },
      {
        id_persona: 7,
        nombre_completo: "Sandra Mejía Ospina",
        documento: "10101010",
        tipo_documento: "CC",
        rol: "administrativo",
        programa_formacion: "Administración",
        no_ficha: "ADM001",
        estado_formacion: "Activo",
        contrasena: "admin123",
      },
    ]

    // Historial de ingreso (tabla historial_ingreso)
    const historialIngreso = [
      {
        id_historial: 1,
        id_persona: 2,
        fecha_ingreso: "2024-01-15",
        hora_ingreso: "07:30:00",
        observacion: "Ingreso normal",
      },
      {
        id_historial: 2,
        id_persona: 2,
        fecha_ingreso: "2024-01-14",
        hora_ingreso: "08:00:00",
        observacion: "Ingreso normal",
      },
      {
        id_historial: 3,
        id_persona: 4,
        fecha_ingreso: "2024-01-15",
        hora_ingreso: "08:15:00",
        observacion: "Ingreso normal",
      },
      {
        id_historial: 4,
        id_persona: 4,
        fecha_ingreso: "2024-01-14",
        hora_ingreso: "08:10:00",
        observacion: "Llegada tardía",
      },
    ]

    // Permisos (tabla permiso)
    const permisos = [
      {
        id_permiso: 1,
        id_persona: 2,
        fecha_solicitud: "2024-01-10",
        motivo: "Cita médica especializada en el hospital universitario",
        estado: "Aprobado",
      },
      {
        id_permiso: 2,
        id_persona: 4,
        fecha_solicitud: "2024-01-12",
        motivo: "Diligencias personales en entidades bancarias",
        estado: "Pendiente",
      },
      {
        id_permiso: 3,
        id_persona: 4,
        fecha_solicitud: "2024-01-13",
        motivo: "Emergencia familiar - hospitalización de familiar directo",
        estado: "Aprobado",
      },
    ]

    // Reportes médicos (tabla reporte_medico)
    const reportesMedicos = [
      {
        id_reporte: 1,
        id_persona: 2,
        descripcion: "Revisión médica general - Sin novedades. Signos vitales normales.",
        fecha: "2024-01-08",
      },
      {
        id_reporte: 2,
        id_persona: 4,
        descripcion: "Control de presión arterial - Valores dentro del rango normal.",
        fecha: "2024-01-10",
      },
      {
        id_reporte: 3,
        id_persona: 4,
        descripcion: "Evaluación nutricional - Se recomienda dieta balanceada y ejercicio.",
        fecha: "2024-01-12",
      },
    ]

    // Códigos QR de aprendices (tabla aprendiz_qr)
    const aprendizQr = [
      {
        id_aprendiz_qr: 1,
        id_persona: 2,
        codigo_qr: "QR_2_20240115_ABC",
        fecha_generado: "2024-01-15",
      },
      {
        id_aprendiz_qr: 2,
        id_persona: 4,
        codigo_qr: "QR_4_20240115_DEF",
        fecha_generado: "2024-01-15",
      },
    ]

    // Lecturas QR por bienestar (tabla bienestar_leer_qr)
    const bienestarLeerQr = [
      {
        id_bienestar_qr: 1,
        id_bienestar: 5,
        id_aprendiz: 2,
        fecha_lectura: "2024-01-15",
      },
      {
        id_bienestar_qr: 2,
        id_bienestar: 5,
        id_aprendiz: 4,
        fecha_lectura: "2024-01-15",
      },
    ]

    // Lecturas QR por vigilantes (tabla vigilante_leer_qr)
    const vigilanteLeerQr = [
      {
        id_vigilante_qr: 1,
        id_vigilante: 6,
        id_aprendiz: 2,
        fecha_lectura: "2024-01-15",
      },
      {
        id_vigilante_qr: 2,
        id_vigilante: 6,
        id_aprendiz: 4,
        fecha_lectura: "2024-01-15",
      },
    ]

    // Valoraciones de enfermería (tabla enfermera_valoracion)
    const enfermeraValoracion = [
      {
        id_enfermera_valoracion: 1,
        id_enfermera: 1,
        id_aprendiz: 2,
        id_reporte: 1,
      },
      {
        id_enfermera_valoracion: 2,
        id_enfermera: 3,
        id_aprendiz: 4,
        id_reporte: 2,
      },
    ]

    // Registros de usuario (tabla registro_usuario)
    const registroUsuario = [
      {
        id_registro: 1,
        id_administrativo: 7,
        id_persona: 2,
        fecha_registro: "2024-01-01",
      },
      {
        id_registro: 2,
        id_administrativo: 7,
        id_persona: 4,
        fecha_registro: "2024-01-01",
      },
    ]

    // Guardar todas las tablas en localStorage
    localStorage.setItem("soft_in_persona", JSON.stringify(personas))
    localStorage.setItem("soft_in_historial_ingreso", JSON.stringify(historialIngreso))
    localStorage.setItem("soft_in_permiso", JSON.stringify(permisos))
    localStorage.setItem("soft_in_reporte_medico", JSON.stringify(reportesMedicos))
    localStorage.setItem("soft_in_aprendiz_qr", JSON.stringify(aprendizQr))
    localStorage.setItem("soft_in_bienestar_leer_qr", JSON.stringify(bienestarLeerQr))
    localStorage.setItem("soft_in_vigilante_leer_qr", JSON.stringify(vigilanteLeerQr))
    localStorage.setItem("soft_in_enfermera_valoracion", JSON.stringify(enfermeraValoracion))
    localStorage.setItem("soft_in_registro_usuario", JSON.stringify(registroUsuario))

    console.log("✅ Base de datos inicializada con esquema PostgreSQL real")
    console.log("📊 Tablas creadas:")
    console.log("  - persona (usuarios)")
    console.log("  - historial_ingreso")
    console.log("  - permiso")
    console.log("  - reporte_medico")
    console.log("  - aprendiz_qr")
    console.log("  - bienestar_leer_qr")
    console.log("  - vigilante_leer_qr")
    console.log("  - enfermera_valoracion")
    console.log("  - registro_usuario")
    console.log("\n👥 Usuarios disponibles:")
    console.log("👩‍⚕️ Enfermera: 12345678 / enf123")
    console.log("👨‍🎓 Aprendiz: 87654321 / user123")
    console.log("🏥 Bienestar: 66666666 / bien123")
    console.log("🛡️ Vigilante: 88888888 / vig123")
    console.log("👨‍💼 Admin: 10101010 / admin123")
  }

  // Autenticar usuario (basado en tabla persona)
  async authenticateUser(documento, password) {
    const personas = JSON.parse(localStorage.getItem("soft_in_persona") || "[]")
    const persona = personas.find(
      (p) => p.documento === documento && p.contrasena === password && p.estado_formacion === "Activo",
    )

    if (persona) {
      // Registrar ingreso en historial_ingreso
      this.registrarIngreso(persona.id_persona)

      return {
        id: persona.id_persona,
        nombre: persona.nombre_completo,
        documento: persona.documento,
        rol: persona.rol,
        programa: persona.programa_formacion,
        ficha: persona.no_ficha,
        especialidad: this.getEspecialidad(persona.rol, persona.programa_formacion),
      }
    }

    return null
  }

  // Registrar ingreso en historial_ingreso
  registrarIngreso(idPersona) {
    const historial = JSON.parse(localStorage.getItem("soft_in_historial_ingreso") || "[]")
    const now = new Date()
    const fecha = now.toISOString().split("T")[0]
    const hora = now.toTimeString().split(" ")[0]

    const newEntry = {
      id_historial: historial.length + 1,
      id_persona: idPersona,
      fecha_ingreso: fecha,
      hora_ingreso: hora,
      observacion: "Login web",
    }

    historial.push(newEntry)
    localStorage.setItem("soft_in_historial_ingreso", JSON.stringify(historial))
  }

  // Obtener historial de ingreso
  getHistorialIngreso(idPersona, limit = 10) {
    const historial = JSON.parse(localStorage.getItem("soft_in_historial_ingreso") || "[]")
    return historial
      .filter((h) => h.id_persona === idPersona)
      .sort(
        (a, b) => new Date(b.fecha_ingreso + " " + b.hora_ingreso) - new Date(a.fecha_ingreso + " " + a.hora_ingreso),
      )
      .slice(0, limit)
  }

  // Obtener permisos
  getPermisos(idPersona) {
    const permisos = JSON.parse(localStorage.getItem("soft_in_permiso") || "[]")
    return permisos
      .filter((p) => p.id_persona === idPersona)
      .sort((a, b) => new Date(b.fecha_solicitud) - new Date(a.fecha_solicitud))
  }

  // Obtener reportes médicos
  getReportesMedicos(idPersona) {
    const reportes = JSON.parse(localStorage.getItem("soft_in_reporte_medico") || "[]")
    return reportes.filter((r) => r.id_persona === idPersona).sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
  }

  // Solicitar permiso (insertar en tabla permiso)
  solicitarPermiso(idPersona, motivo, fecha = null) {
    const permisos = JSON.parse(localStorage.getItem("soft_in_permiso") || "[]")

    const newPermiso = {
      id_permiso: permisos.length + 1,
      id_persona: idPersona,
      fecha_solicitud: fecha || new Date().toISOString().split("T")[0],
      motivo: motivo,
      estado: "Pendiente",
    }

    permisos.push(newPermiso)
    localStorage.setItem("soft_in_permiso", JSON.stringify(permisos))

    return newPermiso
  }

  // Generar código QR (insertar en tabla aprendiz_qr)
  generateQRCode(idPersona) {
    const qrCodes = JSON.parse(localStorage.getItem("soft_in_aprendiz_qr") || "[]")
    const timestamp = new Date().toISOString().slice(0, 10).replace(/-/g, "")
    const codigoQR = `QR_${idPersona}_${timestamp}_${Math.random().toString(36).substr(2, 3).toUpperCase()}`

    const newQR = {
      id_aprendiz_qr: qrCodes.length + 1,
      id_persona: idPersona,
      codigo_qr: codigoQR,
      fecha_generado: new Date().toISOString().split("T")[0],
    }

    qrCodes.push(newQR)
    localStorage.setItem("soft_in_aprendiz_qr", JSON.stringify(qrCodes))

    return newQR
  }

  // Crear reporte médico (insertar en tabla reporte_medico)
  crearReporteMedico(idPersona, descripcion) {
    const reportes = JSON.parse(localStorage.getItem("soft_in_reporte_medico") || "[]")

    const newReporte = {
      id_reporte: reportes.length + 1,
      id_persona: idPersona,
      descripcion: descripcion,
      fecha: new Date().toISOString().split("T")[0],
    }

    reportes.push(newReporte)
    localStorage.setItem("soft_in_reporte_medico", JSON.stringify(reportes))

    return newReporte
  }

  // Registrar lectura QR por bienestar (insertar en tabla bienestar_leer_qr)
  registrarLecturaQRBienestar(idBienestar, idAprendiz) {
    const lecturas = JSON.parse(localStorage.getItem("soft_in_bienestar_leer_qr") || "[]")

    const newLectura = {
      id_bienestar_qr: lecturas.length + 1,
      id_bienestar: idBienestar,
      id_aprendiz: idAprendiz,
      fecha_lectura: new Date().toISOString().split("T")[0],
    }

    lecturas.push(newLectura)
    localStorage.setItem("soft_in_bienestar_leer_qr", JSON.stringify(lecturas))

    return newLectura
  }

  // Registrar lectura QR por vigilante (insertar en tabla vigilante_leer_qr)
  registrarLecturaQRVigilante(idVigilante, idAprendiz) {
    const lecturas = JSON.parse(localStorage.getItem("soft_in_vigilante_leer_qr") || "[]")

    const newLectura = {
      id_vigilante_qr: lecturas.length + 1,
      id_vigilante: idVigilante,
      id_aprendiz: idAprendiz,
      fecha_lectura: new Date().toISOString().split("T")[0],
    }

    lecturas.push(newLectura)
    localStorage.setItem("soft_in_vigilante_leer_qr", JSON.stringify(lecturas))

    return newLectura
  }

  // Crear valoración de enfermería (insertar en tabla enfermera_valoracion)
  crearValoracionEnfermeria(idEnfermera, idAprendiz, idReporte) {
    const valoraciones = JSON.parse(localStorage.getItem("soft_in_enfermera_valoracion") || "[]")

    const newValoracion = {
      id_enfermera_valoracion: valoraciones.length + 1,
      id_enfermera: idEnfermera,
      id_aprendiz: idAprendiz,
      id_reporte: idReporte,
    }

    valoraciones.push(newValoracion)
    localStorage.setItem("soft_in_enfermera_valoracion", JSON.stringify(valoraciones))

    return newValoracion
  }

  // Registrar usuario (insertar en tabla registro_usuario)
  registrarUsuario(idAdministrativo, idPersona) {
    const registros = JSON.parse(localStorage.getItem("soft_in_registro_usuario") || "[]")

    const newRegistro = {
      id_registro: registros.length + 1,
      id_administrativo: idAdministrativo,
      id_persona: idPersona,
      fecha_registro: new Date().toISOString().split("T")[0],
    }

    registros.push(newRegistro)
    localStorage.setItem("soft_in_registro_usuario", JSON.stringify(registros))

    return newRegistro
  }

  // Obtener especialidad según rol y programa
  getEspecialidad(rol, programa) {
    const especialidades = {
      enfermera: {
        "Auxiliar de Enfermería": "Cuidados Básicos",
        "Técnico en Enfermería": "Cuidados Especializados",
      },
      aprendiz: {
        "Técnico en Sistemas": "Desarrollo de Software",
        "Auxiliar de Enfermería": "Cuidados de Salud",
        "Técnico en Contabilidad": "Gestión Financiera",
      },
      bienestar: {
        Psicología: "Bienestar Estudiantil",
        "Trabajo Social": "Apoyo Social",
      },
      vigilante: {
        "Seguridad y Vigilancia": "Seguridad Institucional",
      },
      administrativo: {
        Administración: "Gestión Administrativa",
        Sistemas: "Soporte Técnico",
      },
    }

    return especialidades[rol]?.[programa] || programa
  }

  // Obtener persona por ID
  getPersonaById(idPersona) {
    const personas = JSON.parse(localStorage.getItem("soft_in_persona") || "[]")
    return personas.find((p) => p.id_persona === idPersona)
  }

  // Obtener todas las personas
  getAllPersonas() {
    return JSON.parse(localStorage.getItem("soft_in_persona") || "[]")
  }

  // Validar roles según el esquema PostgreSQL
  isValidRole(rol) {
    const validRoles = ["aprendiz", "bienestar", "vigilante", "enfermera", "administrativo"]
    return validRoles.includes(rol)
  }

  // Validar estados de formación según el esquema PostgreSQL
  isValidEstadoFormacion(estado) {
    const validEstados = ["Activo", "Inactivo", "Suspension temporal"]
    return validEstados.includes(estado)
  }

  // Obtener estadísticas por rol
  getEstadisticasPorRol(idPersona, rol) {
    switch (rol) {
      case "enfermera":
        return this.getEstadisticasEnfermera(idPersona)
      case "aprendiz":
        return this.getEstadisticasAprendiz(idPersona)
      case "bienestar":
        return this.getEstadisticasBienestar(idPersona)
      case "vigilante":
        return this.getEstadisticasVigilante(idPersona)
      case "administrativo":
        return this.getEstadisticasAdministrativo(idPersona)
      default:
        return {}
    }
  }

  // Estadísticas específicas para enfermeras
  getEstadisticasEnfermera(idEnfermera) {
    const valoraciones = JSON.parse(localStorage.getItem("soft_in_enfermera_valoracion") || "[]")
    const reportes = JSON.parse(localStorage.getItem("soft_in_reporte_medico") || "[]")

    const valoracionesEnfermera = valoraciones.filter((v) => v.id_enfermera === idEnfermera)
    const reportesEnfermera = reportes.filter((r) => valoracionesEnfermera.some((v) => v.id_reporte === r.id_reporte))

    return {
      pacientes_atendidos: new Set(valoracionesEnfermera.map((v) => v.id_aprendiz)).size,
      reportes_creados: reportesEnfermera.length,
      valoraciones_realizadas: valoracionesEnfermera.length,
    }
  }

  // Estadísticas específicas para aprendices
  getEstadisticasAprendiz(idAprendiz) {
    const qrCodes = JSON.parse(localStorage.getItem("soft_in_aprendiz_qr") || "[]")
    const permisos = JSON.parse(localStorage.getItem("soft_in_permiso") || "[]")
    const historial = JSON.parse(localStorage.getItem("soft_in_historial_ingreso") || "[]")

    const qrAprendiz = qrCodes.filter((q) => q.id_persona === idAprendiz)
    const permisosAprendiz = permisos.filter((p) => p.id_persona === idAprendiz)
    const historialAprendiz = historial.filter((h) => h.id_persona === idAprendiz)

    return {
      codigos_generados: qrAprendiz.length,
      permisos_solicitados: permisosAprendiz.length,
      ingresos_registrados: historialAprendiz.length,
    }
  }

  // Estadísticas específicas para bienestar
  getEstadisticasBienestar(idBienestar) {
    const lecturas = JSON.parse(localStorage.getItem("soft_in_bienestar_leer_qr") || "[]")
    const lecturasBienestar = lecturas.filter((l) => l.id_bienestar === idBienestar)

    return {
      qr_leidos: lecturasBienestar.length,
      aprendices_atendidos: new Set(lecturasBienestar.map((l) => l.id_aprendiz)).size,
    }
  }

  // Estadísticas específicas para vigilantes
  getEstadisticasVigilante(idVigilante) {
    const lecturas = JSON.parse(localStorage.getItem("soft_in_vigilante_leer_qr") || "[]")
    const lecturasVigilante = lecturas.filter((l) => l.id_vigilante === idVigilante)

    return {
      qr_leidos: lecturasVigilante.length,
      aprendices_verificados: new Set(lecturasVigilante.map((l) => l.id_aprendiz)).size,
    }
  }

  // Estadísticas específicas para administrativos
  getEstadisticasAdministrativo(idAdministrativo) {
    const registros = JSON.parse(localStorage.getItem("soft_in_registro_usuario") || "[]")
    const registrosAdmin = registros.filter((r) => r.id_administrativo === idAdministrativo)

    return {
      usuarios_registrados: registrosAdmin.length,
    }
  }

  // Limpiar base de datos (para testing)
  clearDatabase() {
    const tables = [
      "soft_in_persona",
      "soft_in_historial_ingreso",
      "soft_in_permiso",
      "soft_in_reporte_medico",
      "soft_in_aprendiz_qr",
      "soft_in_bienestar_leer_qr",
      "soft_in_vigilante_leer_qr",
      "soft_in_enfermera_valoracion",
      "soft_in_registro_usuario",
    ]

    tables.forEach((table) => localStorage.removeItem(table))
    console.log("🗑️ Base de datos limpiada")
  }

  // Exportar datos (para backup)
  exportData() {
    return {
      persona: JSON.parse(localStorage.getItem("soft_in_persona") || "[]"),
      historial_ingreso: JSON.parse(localStorage.getItem("soft_in_historial_ingreso") || "[]"),
      permiso: JSON.parse(localStorage.getItem("soft_in_permiso") || "[]"),
      reporte_medico: JSON.parse(localStorage.getItem("soft_in_reporte_medico") || "[]"),
      aprendiz_qr: JSON.parse(localStorage.getItem("soft_in_aprendiz_qr") || "[]"),
      bienestar_leer_qr: JSON.parse(localStorage.getItem("soft_in_bienestar_leer_qr") || "[]"),
      vigilante_leer_qr: JSON.parse(localStorage.getItem("soft_in_vigilante_leer_qr") || "[]"),
      enfermera_valoracion: JSON.parse(localStorage.getItem("soft_in_enfermera_valoracion") || "[]"),
      registro_usuario: JSON.parse(localStorage.getItem("soft_in_registro_usuario") || "[]"),
    }
  }

  // Importar datos (para restore)
  importData(data) {
    Object.keys(data).forEach((table) => {
      if (data[table]) {
        localStorage.setItem(`soft_in_${table}`, JSON.stringify(data[table]))
      }
    })
    console.log("📥 Datos importados exitosamente")
  }

  // Obtener esquema de la base de datos
  getSchema() {
    return {
      persona: {
        id_persona: "SERIAL PRIMARY KEY",
        nombre_completo: "VARCHAR(100) NOT NULL",
        documento: "VARCHAR(20) UNIQUE NOT NULL",
        tipo_documento: "VARCHAR(20)",
        rol: "VARCHAR(20) CHECK (rol IN ('aprendiz', 'bienestar', 'vigilante', 'enfermera', 'administrativo'))",
        programa_formacion: "VARCHAR(100)",
        no_ficha: "VARCHAR(20)",
        estado_formacion: "VARCHAR(20) CHECK (estado_formacion IN ('Activo', 'Inactivo', 'Suspension temporal'))",
        contrasena: "VARCHAR(255) NOT NULL",
      },
      historial_ingreso: {
        id_historial: "SERIAL PRIMARY KEY",
        id_persona: "INTEGER REFERENCES persona(id_persona)",
        fecha_ingreso: "DATE NOT NULL",
        hora_ingreso: "TIME NOT NULL",
        observacion: "TEXT",
      },
      permiso: {
        id_permiso: "SERIAL PRIMARY KEY",
        id_persona: "INTEGER REFERENCES persona(id_persona)",
        fecha_solicitud: "DATE NOT NULL",
        motivo: "TEXT",
        estado: "VARCHAR(20)",
      },
      reporte_medico: {
        id_reporte: "SERIAL PRIMARY KEY",
        id_persona: "INTEGER REFERENCES persona(id_persona)",
        descripcion: "TEXT NOT NULL",
        fecha: "DATE NOT NULL",
      },
      aprendiz_qr: {
        id_aprendiz_qr: "SERIAL PRIMARY KEY",
        id_persona: "INTEGER REFERENCES persona(id_persona)",
        codigo_qr: "VARCHAR(255) NOT NULL",
        fecha_generado: "DATE NOT NULL",
      },
      bienestar_leer_qr: {
        id_bienestar_qr: "SERIAL PRIMARY KEY",
        id_bienestar: "INTEGER REFERENCES persona(id_persona)",
        id_aprendiz: "INTEGER REFERENCES persona(id_persona)",
        fecha_lectura: "DATE NOT NULL",
      },
      vigilante_leer_qr: {
        id_vigilante_qr: "SERIAL PRIMARY KEY",
        id_vigilante: "INTEGER REFERENCES persona(id_persona)",
        id_aprendiz: "INTEGER REFERENCES persona(id_persona)",
        fecha_lectura: "DATE NOT NULL",
      },
      enfermera_valoracion: {
        id_enfermera_valoracion: "SERIAL PRIMARY KEY",
        id_enfermera: "INTEGER REFERENCES persona(id_persona)",
        id_aprendiz: "INTEGER REFERENCES persona(id_persona)",
        id_reporte: "INTEGER REFERENCES reporte_medico(id_reporte)",
      },
      registro_usuario: {
        id_registro: "SERIAL PRIMARY KEY",
        id_administrativo: "INTEGER REFERENCES persona(id_persona)",
        id_persona: "INTEGER REFERENCES persona(id_persona)",
        fecha_registro: "DATE NOT NULL",
      },
    }
  }
}

// Instancia global de la base de datos
window.database = new SoftInDatabase()
