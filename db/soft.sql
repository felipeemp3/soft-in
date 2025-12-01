-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2025 a las 15:30:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `softin`
--
CREATE DATABASE IF NOT EXISTS `softin` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `softin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendiz_qr`
--

CREATE TABLE `aprendiz_qr` (
  `id_aprendiz_qr` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `codigo_qr` varchar(255) NOT NULL,
  `fecha_generado` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienestar_leer_qr`
--

CREATE TABLE `bienestar_leer_qr` (
  `id_bienestar_qr` int(11) NOT NULL,
  `id_bienestar` int(11) DEFAULT NULL,
  `id_aprendiz` int(11) DEFAULT NULL,
  `fecha_lectura` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermera_valoracion`
--

CREATE TABLE `enfermera_valoracion` (
  `id_enfermera_valoracion` int(11) NOT NULL,
  `id_enfermera` int(11) DEFAULT NULL,
  `id_aprendiz` int(11) DEFAULT NULL,
  `id_reporte` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ingreso`
--

CREATE TABLE `historial_ingreso` (
  `id_historial` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `observacion` longtext DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(11) NOT NULL,
  `id_personas` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `motivo` longtext DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `id_personas`, `fecha_solicitud`, `motivo`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(4, 12, '2025-11-29', 'idk', NULL, '2025-11-29 23:46:53', '2025-11-29 23:46:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `rol` varchar(20) NOT NULL,
  `programa_formacion` varchar(100) DEFAULT NULL,
  `no_ficha` varchar(20) DEFAULT NULL,
  `estado_formacion` varchar(20) NOT NULL DEFAULT 'Activo',
  `tip_aprendiz` varchar(10) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombres`, `apellidos`, `documento`, `tipo_documento`, `rol`, `programa_formacion`, `no_ficha`, `estado_formacion`, `tip_aprendiz`, `password_hash`, `correo`, `telefono`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Jesus David', 'Garcia Lopez', '1', 'CC', 'Bienestar', 'idk', NULL, 'Activo', 'interno', '1', NULL, NULL, '2025-11-27 09:26:19', '2025-11-30 00:38:25'),
(12, 'Andres ', 'Felipe', '1003046497', 'CC', 'aprendiz', 'adso', '8677', 'Activo', '', '1233', NULL, NULL, '2025-11-29 17:53:48', '2025-11-29 17:53:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuario`
--

CREATE TABLE `registro_usuario` (
  `id_registro` int(11) NOT NULL,
  `id_administrativo` int(11) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_medico`
--

CREATE TABLE `reporte_medico` (
  `id_reporte` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `descripcion` longtext NOT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vigilante_leer_qr`
--

CREATE TABLE `vigilante_leer_qr` (
  `id_vigilante_qr` int(11) NOT NULL,
  `id_vigilante` int(11) DEFAULT NULL,
  `id_aprendiz` int(11) DEFAULT NULL,
  `fecha_lectura` datetime NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_ingreso`
--

CREATE TABLE IF NOT EXISTS `registro_ingreso` (
  `id_ingreso` INT(11) NOT NULL AUTO_INCREMENT,
  `id_aprendiz` INT(11) NOT NULL,
  `id_vigilante` INT(11) DEFAULT NULL,
  `id_bienestar` INT(11) DEFAULT NULL,
  `id_enfermeria` INT(11) DEFAULT NULL,
  `fecha_escaneo` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_atencion_bienestar` DATETIME DEFAULT NULL,
  `fecha_atencion_enfermeria` DATETIME DEFAULT NULL,
  `estado` ENUM('escaneado','en_bienestar','en_enfermeria','completado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'escaneado',
  `observaciones` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_ingreso` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'normal',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ingreso`),
  KEY `id_aprendiz` (`id_aprendiz`),
  KEY `id_vigilante` (`id_vigilante`),
  KEY `id_bienestar` (`id_bienestar`),
  KEY `id_enfermeria` (`id_enfermeria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  ADD PRIMARY KEY (`id_aprendiz_qr`),
  ADD KEY `idx_aprendiz_qr_persona` (`id_persona`),
  ADD KEY `idx_aprendiz_qr_fecha` (`fecha_generado`);

--
-- Indices de la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  ADD PRIMARY KEY (`id_bienestar_qr`),
  ADD KEY `idx_bienestar_qr_fecha` (`fecha_lectura`),
  ADD KEY `bienestar_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  ADD KEY `bienestar_leer_qr_id_bienestar_fkey` (`id_bienestar`);

--
-- Indices de la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  ADD PRIMARY KEY (`id_enfermera_valoracion`),
  ADD KEY `enfermera_valoracion_id_aprendiz_fkey` (`id_aprendiz`),
  ADD KEY `enfermera_valoracion_id_enfermera_fkey` (`id_enfermera`),
  ADD KEY `enfermera_valoracion_id_reporte_fkey` (`id_reporte`);

--
-- Indices de la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_fecha` (`fecha_ingreso`),
  ADD KEY `idx_historial_persona` (`id_persona`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `idx_permiso_estado` (`estado`),
  ADD KEY `idx_permiso_persona` (`id_personas`),
  ADD KEY `idx_permiso_fecha` (`fecha_solicitud`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `persona_documento_key` (`documento`),
  ADD KEY `idx_persona_rol` (`rol`),
  ADD KEY `idx_persona_estado` (`estado_formacion`);

--
-- Indices de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `registro_usuario_id_administrativo_fkey` (`id_administrativo`),
  ADD KEY `registro_usuario_id_persona_fkey` (`id_persona`);

--
-- Indices de la tabla `reporte_medico`
--
ALTER TABLE `reporte_medico`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `idx_reporte_fecha` (`fecha`),
  ADD KEY `idx_reporte_persona` (`id_persona`);

--
-- Indices de la tabla `vigilante_leer_qr`
--
ALTER TABLE `vigilante_leer_qr`
  ADD PRIMARY KEY (`id_vigilante_qr`),
  ADD KEY `idx_vigilante_qr_fecha` (`fecha_lectura`),
  ADD KEY `vigilante_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  ADD KEY `vigilante_leer_qr_id_vigilante_fkey` (`id_vigilante`);

--
-- Indices de la tabla `registro_ingreso`
--
ALTER TABLE `registro_ingreso`
  ADD CONSTRAINT `fk_registro_aprendiz` 
  FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

ALTER TABLE `registro_ingreso`
  ADD CONSTRAINT `fk_registro_vigilante` 
  FOREIGN KEY (`id_vigilante`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;

ALTER TABLE `registro_ingreso`
  ADD CONSTRAINT `fk_registro_bienestar` 
  FOREIGN KEY (`id_bienestar`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;

ALTER TABLE `registro_ingreso`
  ADD CONSTRAINT `fk_registro_enfermeria` 
  FOREIGN KEY (`id_enfermeria`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  MODIFY `id_aprendiz_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  MODIFY `id_bienestar_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  MODIFY `id_enfermera_valoracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_medico`
--
ALTER TABLE `reporte_medico`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vigilante_leer_qr`
--
ALTER TABLE `vigilante_leer_qr`
  MODIFY `id_vigilante_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_ingreso`
--
ALTER TABLE `registro_ingreso`
  MODIFY `id_ingreso` INT(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  ADD CONSTRAINT `aprendiz_qr_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  ADD CONSTRAINT `bienestar_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `bienestar_leer_qr_id_bienestar_fkey` FOREIGN KEY (`id_bienestar`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  ADD CONSTRAINT `enfermera_valoracion_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `enfermera_valoracion_id_enfermera_fkey` FOREIGN KEY (`id_enfermera`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `enfermera_valoracion_id_reporte_fkey` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_medico` (`id_reporte`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  ADD CONSTRAINT `historial_ingreso_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_id_persona_fkey` FOREIGN KEY (`id_personas`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  ADD CONSTRAINT `registro_usuario_id_administrativo_fkey` FOREIGN KEY (`id_administrativo`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_usuario_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reporte_medico`
--
ALTER TABLE `reporte_medico`
  ADD CONSTRAINT `reporte_medico_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vigilante_leer_qr`
--
ALTER TABLE `vigilante_leer_qr`
  ADD CONSTRAINT `vigilante_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `vigilante_leer_qr_id_vigilante_fkey` FOREIGN KEY (`id_vigilante`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
