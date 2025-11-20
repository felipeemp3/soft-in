SET FOREIGN_KEY_CHECKS = 0;

-- =========================
-- 1️⃣ TABLA PERSONA
-- =========================
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `id_persona` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `rol` varchar(20) NOT NULL,
  `programa_formacion` varchar(100) DEFAULT NULL,
  `no_ficha` varchar(20) DEFAULT NULL,
  `estado_formacion` varchar(20) NOT NULL DEFAULT 'Activo',
  `password_hash` varchar(255) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password_salt` varchar(64) DEFAULT NULL,
  `nombre_completo` varchar(121) DEFAULT NULL,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_persona`),
  UNIQUE KEY `persona_documento_key` (`documento`),
  KEY `idx_persona_rol` (`rol`),
  KEY `idx_persona_estado` (`estado_formacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 2️⃣ TABLA APRENDIZ_QR
-- =========================
DROP TABLE IF EXISTS `aprendiz_qr`;
CREATE TABLE `aprendiz_qr` (
  `id_aprendiz_qr` int NOT NULL AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `codigo_qr` varchar(255) NOT NULL,
  `fecha_generado` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_aprendiz_qr`),
  KEY `idx_aprendiz_qr_persona` (`id_persona`),
  KEY `idx_aprendiz_qr_fecha` (`fecha_generado`),
  CONSTRAINT `aprendiz_qr_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 3️⃣ TABLA BIENESTAR_LEER_QR
-- =========================
DROP TABLE IF EXISTS `bienestar_leer_qr`;
CREATE TABLE `bienestar_leer_qr` (
  `id_bienestar_qr` int NOT NULL AUTO_INCREMENT,
  `id_bienestar` int DEFAULT NULL,
  `id_aprendiz` int DEFAULT NULL,
  `fecha_lectura` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_bienestar_qr`),
  KEY `idx_bienestar_qr_fecha` (`fecha_lectura`),
  KEY `bienestar_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `bienestar_leer_qr_id_bienestar_fkey` (`id_bienestar`),
  CONSTRAINT `bienestar_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `bienestar_leer_qr_id_bienestar_fkey` FOREIGN KEY (`id_bienestar`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 4️⃣ TABLA VIGILANTE_LEER_QR
-- =========================
DROP TABLE IF EXISTS `vigilante_leer_qr`;
CREATE TABLE `vigilante_leer_qr` (
  `id_vigilante_qr` int NOT NULL AUTO_INCREMENT,
  `id_vigilante` int DEFAULT NULL,
  `id_aprendiz` int DEFAULT NULL,
  `fecha_lectura` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial166` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_vigilante_qr`),
  KEY `idx_vigilante_qr_fecha` (`fecha_lectura`),
  KEY `vigilante_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `vigilante_leer_qr_id_vigilante_fkey` (`id_vigilante`),
  CONSTRAINT `vigilante_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `vigilante_leer_qr_id_vigilante_fkey` FOREIGN KEY (`id_vigilante`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 5️⃣ TABLA HISTORIAL_INGRESO
-- =========================
DROP TABLE IF EXISTS `historial_ingreso`;
CREATE TABLE `historial_ingreso` (
  `id_historial` int NOT NULL AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `observacion` longtext,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `idx_historial_fecha` (`fecha_ingreso`),
  KEY `idx_historial_persona` (`id_persona`),
  CONSTRAINT `historial_ingreso_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 6️⃣ TABLA REPORTE_MEDICO
-- =========================
DROP TABLE IF EXISTS `reporte_medico`;
CREATE TABLE `reporte_medico` (
  `id_reporte` int NOT NULL AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `descripcion` longtext NOT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_reporte`),
  KEY `idx_reporte_fecha` (`fecha`),
  KEY `idx_reporte_persona` (`id_persona`),
  CONSTRAINT `reporte_medico_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 7️⃣ TABLA ENFERMERA_VALORACION
-- =========================
DROP TABLE IF EXISTS `enfermera_valoracion`;
CREATE TABLE `enfermera_valoracion` (
  `id_enfermera_valoracion` int NOT NULL AUTO_INCREMENT,
  `id_enfermera` int DEFAULT NULL,
  `id_aprendiz` int DEFAULT NULL,
  `id_reporte` int DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial163` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_enfermera_valoracion`),
  KEY `enfermera_valoracion_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `enfermera_valoracion_id_enfermera_fkey` (`id_enfermera`),
  KEY `enfermera_valoracion_id_reporte_fkey` (`id_reporte`),
  CONSTRAINT `enfermera_valoracion_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `enfermera_valoracion_id_enfermera_fkey` FOREIGN KEY (`id_enfermera`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `enfermera_valoracion_id_reporte_fkey` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_medico` (`id_reporte`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 8️⃣ TABLA PERMISO
-- =========================
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `motivo` longtext,
  `estado` varchar(20) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial166` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `idx_permiso_estado` (`estado`),
  KEY `idx_permiso_persona` (`id_persona`),
  KEY `idx_permiso_fecha` (`fecha_solicitud`),
  CONSTRAINT `permiso_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 9️⃣ TABLA REGISTRO_USUARIO
-- =========================
DROP TABLE IF EXISTS `registro_usuario`;
CREATE TABLE `registro_usuario` (
  `id_registro` int NOT NULL AUTO_INCREMENT,
  `id_administrativo` int DEFAULT NULL,
  `id_persona` int DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trial166` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `registro_usuario_id_administrativo_fkey` (`id_administrativo`),
  KEY `registro_usuario_id_persona_fkey` (`id_persona`),
  CONSTRAINT `registro_usuario_id_administrativo_fkey` FOREIGN KEY (`id_administrativo`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `registro_usuario_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;