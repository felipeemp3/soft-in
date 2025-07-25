const { Pool } = require("pg")
require("dotenv").config()

// Configuración de la base de datos
const pool = new Pool({
  user: process.env.DB_USER || "postgres",
  host: process.env.DB_HOST || "localhost",
  database: process.env.DB_NAME || "soft_in",
  password: process.env.DB_PASSWORD || "password",
  port: process.env.DB_PORT || 5432,
  ssl: process.env.NODE_ENV === "production" ? { rejectUnauthorized: false } : false,
  max: 20,
  idleTimeoutMillis: 30000,
  connectionTimeoutMillis: 2000,
})

// Evento de conexión exitosa
pool.on("connect", () => {
  console.log("✅ Conectado a PostgreSQL")
})

// Evento de error
pool.on("error", (err) => {
  console.error("❌ Error en PostgreSQL:", err)
  process.exit(-1)
})

// Función para ejecutar queries
const query = async (text, params) => {
  const start = Date.now()
  try {
    const res = await pool.query(text, params)
    const duration = Date.now() - start
    console.log("📊 Query ejecutado:", { text: text.substring(0, 50) + "...", duration, rows: res.rowCount })
    return res
  } catch (error) {
    console.error("❌ Error en query:", error)
    throw error
  }
}

module.exports = {
  query,
  pool,
}
