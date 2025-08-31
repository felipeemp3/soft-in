const express = require("express");
const router = express.Router();
const pool = require("../db");
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");

// Login
router.post("/login", async (req, res) => {
  const { documento, contrasena } = req.body;

  try {
    // Buscar usuario en la BD
    const result = await pool.query(
      "SELECT * FROM persona WHERE documento = $1",
      [documento]
    );

    if (result.rows.length === 0) {
      return res.status(401).json({ error: "Usuario no encontrado" });
    }

    const user = result.rows[0];

    // Comparar contraseña
    const match = await bcrypt.compare(contrasena, user.contrasena);

    if (!match) {
      return res.status(401).json({ error: "Contraseña incorrecta" });
    }

    // Generar token con rol
    const token = jwt.sign(
      { id: user.id_persona, rol: user.rol },
      process.env.JWT_SECRET || "secreto123",
      { expiresIn: "1h" }
    );

    res.json({ token, rol: user.rol });
  } catch (err) {
    console.error("Error en login:", err);
    res.status(500).json({ error: "Error en servidor" });
  }
});

module.exports = router;
