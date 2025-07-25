const bcrypt = require("bcryptjs")
const { query } = require("../config/database")

async function seedDatabase() {
  try {
    console.log("🌱 Poblando base de datos con datos de ejemplo...")

    // Usuarios de ejemplo
    const users = [
      {
        nombre_completo: "María García López",
        documento: "12345678",
        tipo_documento: "CC",
        rol: "enfermera",
        programa_formacion: "Auxiliar de Enfermería",
        no_ficha: "ENF001",
        password: "enf123",
      },
      {
        nombre_completo: "Juan Pérez González",
        documento: "87654321",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Técnico en Sistemas",
        no_ficha: "2758493",
        password: "user123",
      },
      {
        nombre_completo: "Ana López Martínez",
        documento: "11111111",
        tipo_documento: "CC",
        rol: "enfermera",
        programa_formacion: "Técnico en Enfermería",
        no_ficha: "ENF002",
        password: "enf123",
      },
      {
        nombre_completo: "Laura Martínez Ruiz",
        documento: "22222222",
        tipo_documento: "CC",
        rol: "aprendiz",
        programa_formacion: "Auxiliar de Enfermería",
        no_ficha: "2758494",
        password: "user123",
      },
      {
        nombre_completo: "Roberto Jiménez Vargas",
        documento: "66666666",
        tipo_documento: "CC",
        rol: "bienestar",
        programa_formacion: "Psicología",
        no_ficha: "BIE001",
        password: "bien123",
      },
      {
        nombre_completo: "Miguel Ángel Ramírez",
        documento: "88888888",
        tipo_documento: "CC",
        rol: "vigilante",
        programa_formacion: "Seguridad y Vigilancia",
        no_ficha: "VIG001",
        password: "vig123",
      },
      {
        nombre_completo: "Sandra Mejía Ospina",
        documento: "10101010",
        tipo_documento: "CC",
        rol: "administrativo",
        programa_formacion: "Administración",
        no_ficha: "ADM001",
        password: "admin123",
      },
    ]

    // Insertar usuarios
    for (const user of users) {
      const hashedPassword = await bcrypt.hash(user.password, 12)

      const insertQuery = `
        INSERT INTO persona (
          nombre_completo, documento, tipo_documento, rol, 
          programa_formacion, no_ficha, estado_formacion, contrasena
        ) VALUES ($1, $2, $3, $4, $5, $6, 'Activo', $7)
        ON CONFLICT (documento) DO NOTHING
        RETURNING id_persona
      `

      const result = await query(insertQuery, [
        user.nombre_completo,
        user.documento,
        user.tipo_documento,
        user.rol,
        user.programa_formacion,
        user.no_ficha,
        hashedPassword,
      ])

      if (result.rows.length > 0) {
        console.log(`✅ Usuario creado: ${user.nombre_completo} (${user.documento})`)
      } else {
        console.log(`ℹ️  Usuario ya existe: ${user.documento}`)
      }
    }

    // Insertar datos de ejemplo adicionales
    await insertSampleData()

    console.log("🎉 Base de datos poblada exitosamente")
    console.log("\n📋 Usuarios de prueba:")
    console.log("👩‍⚕️ Enfermera: 12345678 / enf123")
    console.log("👨‍🎓 Aprendiz: 87654321 / user123")
    console.log("🏥 Bienestar: 66666666 / bien123")
    console.log("🛡️ Vigilante: 88888888 / vig123")
    console.log("👨‍💼 Admin: 10101010 / admin123")
  } catch (error) {
    console.error("❌ Error poblando base de datos:", error)
  }
}

async function insertSampleData() {
  try {
    // Insertar historial de ingresos
    const historialData = [
      [2, "2024-01-15", "07:30:00", "Ingreso normal"],
      [2, "2024-01-14", "08:00:00", "Ingreso normal"],
      [4, "2024-01-15", "08:15:00", "Ingreso normal"],
      [4, "2024-01-14", "08:10:00", "Llegada tardía"],
    ]

    for (const [id_persona, fecha, hora, observacion] of historialData) {
      await query(
        "INSERT INTO historial_ingreso (id_persona, fecha_ingreso, hora_ingreso, observacion) VALUES ($1, $2, $3, $4) ON CONFLICT DO NOTHING",
        [id_persona, fecha, hora, observacion],
      )
    }

    // Insertar permisos
    const permisosData = [
      [2, "2024-01-10", "Cita médica", "Aprobado"],
      [4, "2024-01-12", "Diligencias personales", "Pendiente"],
      [4, "2024-01-13", "Emergencia familiar", "Aprobado"],
    ]

    for (const [id_persona, fecha, motivo, estado] of permisosData) {
      await query(
        "INSERT INTO permiso (id_persona, fecha_solicitud, motivo, estado) VALUES ($1, $2, $3, $4) ON CONFLICT DO NOTHING",
        [id_persona, fecha, motivo, estado],
      )
    }

    // Insertar reportes médicos
    const reportesData = [
      [2, "Revisión médica general - Sin novedades", "2024-01-08"],
      [4, "Control de presión arterial - Normal", "2024-01-10"],
      [4, "Evaluación nutricional - Recomendaciones dietéticas", "2024-01-12"],
    ]

    for (const [id_persona, descripcion, fecha] of reportesData) {
      await query(
        "INSERT INTO reporte_medico (id_persona, descripcion, fecha) VALUES ($1, $2, $3) ON CONFLICT DO NOTHING",
        [id_persona, descripcion, fecha],
      )
    }

    console.log("✅ Datos de ejemplo insertados")
  } catch (error) {
    console.error("❌ Error insertando datos de ejemplo:", error)
  }
}

// Ejecutar si se llama directamente
if (require.main === module) {
  seedDatabase().catch(console.error)
}

module.exports = { seedDatabase }
