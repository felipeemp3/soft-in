const express = require("express");
const router = express.Router();
const pool = require("../db");

// GET todas las personas
router.get("/", async (req, res) => {
  try {
    const result = await pool.query("SELECT * FROM persona");
    res.json(result.rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// GET persona por ID
router.get("/:id", async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query("SELECT * FROM persona WHERE id_persona = $1", [id]);
    if (result.rows.length === 0) {
      return res.status(404).json({ error: "Persona no encontrada" });
    }
    res.json(result.rows[0]);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
