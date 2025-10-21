// Simulación de base de datos PostgreSQL basada en el esquema real
class SoftInDatabase {
  constructor() {
    this.initializeDatabase()
  }

  // Inicializar base de datos con datos de ejemplo
  initializeDatabase() {
    // Verificar si ya existen datos
    if (!localStorage.getItem("soft_in_personas")) {
      this.seedDatabase()
    }
  }

  // Poblar base de datos con usuarios de ejempl
  seedDatabase() {
    const personas = [
      {
        id_persona: 1,
        nombre_completo: "Andres Felipe Montiel Guerra",
        documento: "1003046497",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Técnico en Sistemas",
        no_ficha: "2924030",
        estado_formacion: "Activo",
        contrasena: "andresfelipey1"
      },
      {
        id_persona: 2,
        nombre_completo: "Elkin Junior Goenaga Narvaez",
        documento: "1048068781",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Analisis y Desarrollo De Software",
        no_ficha: "2924030",
        estado_formacion: "Activo",
        contrasena: "elkin2006"
      }, {
        id_persona: 3,
        nombre_completo: "Jesus David Garcia Lopez",
        documento: "1003049434",
        tipo_documento: "CC",
        rol: "administrativo",
        programa_formacion: "Administración",
        no_ficha: "null",
        estado_formacion: "Activo",
        contrasena: "jesus22"

      }, {
        id_persona: 4,
        nombre_completo:"Kelly Johana",
        documento: "1066177584",
        tipo_documento: "CC",
        rol: "enfermera",
        programa_formacion: "Enfermería",
        no_ficha: "null",
        estado_formacion: "Activo",
        contrasena: "kelly2007"
      }, {
        id_persona: 5,
        nombre_completo:"Josue Ayazo",
        documento:"1062435207",
        tipo_documento:"CC",
        rol:"bienestar",
        programa_formacion:"Psicología",
        no_ficha:"null",
        estado_formacion:"Activo",
        contrasena:"josusuecito234mcmonteria01",
      }, {
        id_persona: 6,
        nombre_completo: "Cristian Marquez",
        documento: "1138075713",
        tipo_documento: "CC",
        rol: "vigilante",
        programa_formacion: "Seguridad y Vigilancia",
        no_ficha: "null",
        estado_formacion: "Activo",
        contrasena: "cristian123"
      }, {}, {}, {}, {}, {}, {}, {}
    ]

    // Agregar programáticamente más usuarios (ej. 600 usuarios en total)
    const programas = [
      "Técnico en Sistemas",
      "Analisis y Desarrollo De Software",
      "Administración",
      "Enfermería",
      "Psicología",
      "Seguridad y Vigilancia",
      "Técnico en Contabilidad",
      "Auxiliar de Enfermería",
      "Sistemas",
      "Trabajo Social",
    ]

    const rolesPorPrograma = {
      "Técnico en Sistemas": "aprendiz",
      "Analisis y Desarrollo De Software": "aprendiz",
      "Administración": "administrativo",
      "Enfermería": "enfermera",
      "Psicología": "bienestar",
      "Seguridad y Vigilancia": "vigilante",
      "Técnico en Contabilidad": "aprendiz",
      "Auxiliar de Enfermería": "aprendiz",
      "Sistemas": "administrativo",
      "Trabajo Social": "bienestar",
    }

    // Nombres y apellidos de prueba para generar usuarios más realistas
    const nombres = [
      "Juan", "Carlos", "Luis", "María", "Ana", "Andrés", "David", "Diego", "Camila", "Laura",
      "Sofía", "Valentina", "Mateo", "Sebastián", "Daniel", "José", "Marta", "Lucía", "Paula", "Fernando",
      "Alejandro", "Miguel", "Natalia", "Javier", "Jorge", "Sandra", "Adriana", "Rosa", "Héctor", "Mónica",
      "Ricardo", "Isabella", "Martín", "Nicolás", "Esteban", "Katherine", "Hugo", "Emiliano", "Bruno", "Emilia",
      "Lorena", "Beatriz", "Pablo", "Anderson", "AndrésF", "Clara", "Verónica", "Juliana", "Camilo", "Raúl"
    ]

    const apellidos = [
      "González", "Rodríguez", "Gómez", "López", "Martínez", "Pérez", "Sánchez", "Ramírez", "Torres", "Flores",
      "Rivera", "Castro", "Vargas", "Rojas", "Herrera", "Mendoza", "Ortiz", "Romero", "Gutiérrez", "Silva",
      "Cruz", "García", "Álvarez", "Jiménez", "Ruiz", "Núñez", "Molina", "Pacheco", "Cardona", "Salazar",
      "Arias", "Valencia", "Pineda", "Suárez", "Vásquez", "Díaz", "Cárdenas", "Vega", "Roldán", "Agudelo",
      "Delgado", "Bernal", "Córdoba", "Mora", "Parra", "León", "Pérez", "Sotomayor", "Espinosa", "Cárdenas"
    ]

    const startId = personas.length + 1
    const totalToAdd = 600 - personas.length // aseguramos 600 en total

    for (let i = 0; i < totalToAdd; i++) {
      const id = startId + i
      const first = nombres[i % nombres.length]
      const last = apellidos[i % apellidos.length]
      const programa = programas[i % programas.length]
      const rol = rolesPorPrograma[programa] || "aprendiz"
      const documento = (1000000000 + id).toString()
      const ficha = rol === "aprendiz" ? (2900000 + (i % 100)).toString() : "null"

      personas.push({
        id_persona: id,
        nombre_completo: `${first} ${last}`,
        documento: documento,
        tipo_documento: "CC",
        rol: rol,
        programa_formacion: programa,
        no_ficha: ficha,
        estado_formacion: "Activo",
        contrasena: `pass${id}`,
      })
    }

    // Llenar estas tablas 
    const historialIngreso = [] 
    const permisos = []
    const reportesMedicos = []
    const aprendizQr = []
    const bienestarLeerQr = []
    const vigilanteLeerQr = []
    const enfermeraValoracion = []
    const registroUsuario = []

    // Generar registros de ingreso y salida para el mismo día (08:00:00 y 16:00:00)
    const today = new Date().toISOString().split("T")[0] // YYYY-MM-DD

    personas.forEach((p) => {
      // salto de los objetos vacíos que estaban al final
      if (!p || !p.id_persona) return

      const ingreso = {
        id_historial: historialIngreso.length + 1,
        id_persona: p.id_persona,
        fecha_ingreso: today,
        hora_ingreso: "08:00:00",
        observacion: "Ingreso programado",
      }

      historialIngreso.push(ingreso)

      const salida = {
        id_historial: historialIngreso.length + 1,
        id_persona: p.id_persona,
        fecha_ingreso: today,
        hora_ingreso: "16:00:00",
        observacion: "Salida programada",
      }

      historialIngreso.push(salida)
    })

    
  // Guardar con la misma clave usada en otras funciones: soft_in_persona
  localStorage.setItem("soft_in_persona", JSON.stringify(personas))
    localStorage.setItem("soft_in_historial_ingreso", JSON.stringify(historialIngreso))
    localStorage.setItem("soft_in_permiso", JSON.stringify(permisos))
    localStorage.setItem("soft_in_reporte_medico", JSON.stringify(reportesMedicos))
    localStorage.setItem("soft_in_aprendiz_qr", JSON.stringify(aprendizQr))
    localStorage.setItem("soft_in_bienestar_leer_qr", JSON.stringify(bienestarLeerQr))
    localStorage.setItem("soft_in_vigilante_leer_qr", JSON.stringify(vigilanteLeerQr))
    localStorage.setItem("soft_in_enfermera_valoracion", JSON.stringify(enfermeraValoracion))
    localStorage.setItem("soft_in_registro_usuario", JSON.stringify(registroUsuario))

    console.log("✅ Base de datos inicializada con espacios para más personas")
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
        Psicología: "Bienestar",
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


localStorage.removeItem('soft_in_personas')