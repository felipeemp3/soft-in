const express = require("express");
const router = express.Router();

const personaRouter = require("./persona");
const authRouter = require("./auth");

router.use("/personas", personaRouter);
router.use("/", authRouter); // aquí vive /api/login

module.exports = router;
