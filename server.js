const express = require("express")
const path = require("path")
const cookieParser = require("cookie-parser")
const bcrypt = require("bcryptjs")
const { query } = require("./config/database")
require("dotenv").config()

const app = express()
const PORT = process.env.PORT || 3000

// Middleware básico
app.use(express.json())
app.use(express.urlencoded({ extended: true }))
app.use(cookieParser())

// Servir archivos estáticos
app.use(express.static(path.join(__dirname, "public")))

// Ruta principal
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "index.html"))
})

// Ruta de login
app.post("/login", async (req, res) => {
  try {
    const { documento, password } = req.body

    if (!documento || !password) {
      return res.status(400).json({ error: "Documento y contraseña requeridos" })
    }

    // Buscar usuario en la base de datos
    const userQuery = `
      SELECT id_persona, nombre_completo, documento, rol, programa_formacion, 
             no_ficha, estado_formacion, contrasena
      FROM persona 
      WHERE documento = $1 AND estado_formacion = 'Activo'
    `

    const result = await query(userQuery, [documento])

    if (result.rows.length === 0) {
      return res.status(401).json({ error: "Credenciales inválidas" })
    }

    const user = result.rows[0]

    // Verificar contraseña
    const isValidPassword = await bcrypt.compare(password, user.contrasena)
    if (!isValidPassword) {
      return res.status(401).json({ error: "Credenciales inválidas" })
    }

    // Registrar ingreso en historial
    const historialQuery = `
      INSERT INTO historial_ingreso (id_persona, fecha_ingreso, hora_ingreso, observacion)
      VALUES ($1, CURRENT_DATE, CURRENT_TIME, 'Login web')
    `
    await query(historialQuery, [user.id_persona])

    // Guardar usuario en cookie (simplificado)
    const userData = {
      id: user.id_persona,
      nombre: user.nombre_completo,
      documento: user.documento,
      rol: user.rol,
      programa: user.programa_formacion,
      ficha: user.no_ficha,
    }

    res.cookie("user", JSON.stringify(userData), {
      httpOnly: false, // Permitir acceso desde JavaScript
      maxAge: 8 * 60 * 60 * 1000, // 8 horas
    })

    res.json({
      success: true,
      message: "Login exitoso",
      user: userData,
    })
  } catch (error) {
    console.error("Error en login:", error)
    res.status(500).json({ error: "Error interno del servidor" })
  }
})

// Ruta de logout
app.post("/logout", (req, res) => {
  res.clearCookie("user")
  res.json({ success: true, message: "Logout exitoso" })
})

// Rutas para obtener datos de la base de datos
app.get("/api/historial/:userId", async (req, res) => {
  try {
    const { userId } = req.params
    const historialQuery = `
      SELECT fecha_ingreso, hora_ingreso, observacion
      FROM historial_ingreso 
      WHERE id_persona = $1 
      ORDER BY fecha_ingreso DESC, hora_ingreso DESC 
      LIMIT 10
    `
    const result = await query(historialQuery, [userId])
    res.json(result.rows)
  } catch (error) {
    console.error("Error obteniendo historial:", error)
    res.status(500).json({ error: "Error interno del servidor" })
  }
})

app.get("/api/permisos/:userId", async (req, res) => {
  try {
    const { userId } = req.params
    const permisosQuery = `
      SELECT fecha_solicitud, motivo, estado
      FROM permiso 
      WHERE id_persona = $1 
      ORDER BY fecha_solicitud DESC 
      LIMIT 10
    `
    const result = await query(permisosQuery, [userId])
    res.json(result.rows)
  } catch (error) {
    console.error("Error obteniendo permisos:", error)
    res.status(500).json({ error: "Error interno del servidor" })
  }
})

// Ruta para solicitar permiso
app.post("/api/permiso", async (req, res) => {
  try {
    const { userId, motivo } = req.body

    if (!motivo || motivo.trim().length < 10) {
      return res.status(400).json({ error: "El motivo debe tener al menos 10 caracteres" })
    }

    const insertQuery = `
      INSERT INTO permiso (id_persona, fecha_solicitud, motivo, estado)
      VALUES ($1, CURRENT_DATE, $2, 'Pendiente')
      RETURNING *
    `

    const result = await query(insertQuery, [userId, motivo])
    res.json({ success: true, permiso: result.rows[0] })
  } catch (error) {
    console.error("Error solicitando permiso:", error)
    res.status(500).json({ error: "Error interno del servidor" })
  }
})

// Ruta para generar código QR
app.post("/api/generate-qr", async (req, res) => {
  try {
    const { userId } = req.body
    const codigoQR = `QR_${userId}_${Date.now()}_${Math.random().toString(36).substr(2, 8)}`

    const insertQuery = `
      INSERT INTO aprendiz_qr (id_persona, codigo_qr, fecha_generado)
      VALUES ($1, $2, CURRENT_DATE)
      RETURNING *
    `
    const result = await query(insertQuery, [userId, codigoQR])

    res.json({
      success: true,
      qr: {
        codigo: codigoQR,
        fecha_generado: result.rows[0].fecha_generado,
      },
    })
  } catch (error) {
    console.error("Error generando QR:", error)
    res.status(500).json({ error: "Error interno del servidor" })
  }
})

// Manejo de errores
app.use((err, req, res, next) => {
  console.error("Error:", err)
  res.status(500).json({ error: "Error interno del servidor" })
})

// Ruta 404
app.use("*", (req, res) => {
  res.status(404).sendFile(path.join(__dirname, "public", "index.html"))
})

// Iniciar servidor
app.listen(PORT, () => {
  console.log(`🚀 Servidor Soft-In ejecutándose en puerto ${PORT}`)
  console.log(`📱 Accede a: http://localhost:${PORT}`)
  console.log(`🔧 Entorno: ${process.env.NODE_ENV || "development"}`)
})

module.exports = app
