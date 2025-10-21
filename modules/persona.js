const pool = require("../db");

// Obtener todos
async function getPersonas() {
  const result = await pool.query("SELECT * FROM persona");
  return result.rows;
}

// Buscar por documento
async function getPersonaByDocumento(doc) {
  const result = await pool.query(
    "SELECT * FROM persona WHERE documento = $1",
    [doc]
  );
  return result.rows[0];
}

// Insertar
async function createPersona(data) {
  const { nombre_completo, documento, tipo_documento, rol, programa_formacion, no_ficha, estado_formacion, contrasena } = data;
  const result = await pool.query(
    `INSERT INTO persona 
    (nombre_completo, documento, tipo_documento, rol, programa_formacion, no_ficha, estado_formacion, contrasena) 
    VALUES ($1,$2,$3,$4,$5,$6,$7,$8) RETURNING *`,
    [nombre_completo, documento, tipo_documento, rol, programa_formacion, no_ficha, estado_formacion, contrasena]
  );
  return result.rows[0];
}

module.exports = { getPersonas, getPersonaByDocumento, createPersona };
