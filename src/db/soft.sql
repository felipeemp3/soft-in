-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2025 a las 20:47:58
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendiz_qr`
--

CREATE TABLE `aprendiz_qr` (
  `id_aprendiz_qr` int(11) NOT NULL,
  `id_aprendiz` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `codigo_qr` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo','usado') NOT NULL DEFAULT 'activo',
  `fecha_generado` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
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
-- Estructura de tabla para la tabla `codigos_qr`
--

CREATE TABLE `codigos_qr` (
  `id_qr` int(11) NOT NULL,
  `codigo_unico` varchar(50) NOT NULL,
  `id_aprendiz` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` datetime NOT NULL,
  `estado` enum('activo','usado','expirado','inactivo') DEFAULT 'activo',
  `veces_usado` int(11) NOT NULL DEFAULT 0,
  `data_qr` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermera_valoracion`
--

CREATE TABLE `enfermera_valoracion` (
  `id_enfermera_valoracion` int(11) NOT NULL,
  `id_enfermera` int(11) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_aprendiz` int(11) DEFAULT NULL,
  `id_reporte` int(11) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_escaneos_qr`
--

CREATE TABLE `historial_escaneos_qr` (
  `id_escaneo` int(11) NOT NULL,
  `codigo_qr_id` int(11) NOT NULL,
  `vigilante_id` int(11) DEFAULT NULL,
  `fecha_escaneo` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_escaneo` enum('ingreso','salida','verificacion') DEFAULT 'verificacion',
  `ubicacion` varchar(100) DEFAULT NULL,
  `dispositivo` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ingreso`
--

CREATE TABLE `historial_ingreso` (
  `id_historial` int(11) NOT NULL,
  `id_personas` int(11) NOT NULL,
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
  `id_persona` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `observacion` longtext DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pdf` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
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
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `usuario`, `nombres`, `apellidos`, `documento`, `tipo_documento`, `rol`, `programa_formacion`, `no_ficha`, `estado_formacion`, `tip_aprendiz`, `password_hash`, `correo`, `telefono`, `fecha_registro`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(21, NULL, '', '', 'admin', NULL, 'admin', NULL, NULL, 'Activo', NULL, 'admin', NULL, NULL, '2025-12-11 18:59:09', '2025-12-11 13:59:09', '2025-12-11 13:59:09'),
(22, NULL, '', '', 'bienestar', NULL, 'bienestar', NULL, NULL, 'Activo', NULL, 'bienestar', NULL, NULL, '2025-12-11 18:59:40', '2025-12-11 13:59:40', '2025-12-11 13:59:40'),
(23, NULL, '', '', 'vigilante', NULL, 'vigilante', NULL, NULL, 'Activo', NULL, 'vigilante', NULL, NULL, '2025-12-11 19:00:01', '2025-12-11 14:00:01', '2025-12-11 14:00:11'),
(24, NULL, '', '', 'aprendiz', NULL, 'aprendiz', NULL, NULL, 'Activo', NULL, 'aprendiz', NULL, NULL, '2025-12-11 19:00:33', '2025-12-11 14:00:33', '2025-12-11 14:00:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_ingreso`
--

CREATE TABLE `registro_ingreso` (
  `id_ingreso` int(11) NOT NULL,
  `id_aprendiz` int(11) NOT NULL,
  `id_vigilante` int(11) DEFAULT NULL,
  `id_bienestar` int(11) DEFAULT NULL,
  `id_enfermeria` int(11) DEFAULT NULL,
  `fecha_escaneo` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_atencion_bienestar` datetime DEFAULT NULL,
  `fecha_atencion_enfermeria` datetime DEFAULT NULL,
  `estado` enum('escaneado','en_bienestar','en_enfermeria','completado') DEFAULT 'escaneado',
  `observaciones` text DEFAULT NULL,
  `tipo_ingreso` varchar(50) DEFAULT 'normal',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  ADD PRIMARY KEY (`id_aprendiz_qr`),
  ADD KEY `idx_aprendiz_qr_persona` (`id_persona`),
  ADD KEY `idx_aprendiz_qr_fecha` (`fecha_generado`),
  ADD KEY `fk_aprendiz_qr_aprendiz` (`id_aprendiz`);

--
-- Indices de la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  ADD PRIMARY KEY (`id_bienestar_qr`),
  ADD KEY `idx_bienestar_qr_fecha` (`fecha_lectura`),
  ADD KEY `bienestar_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  ADD KEY `bienestar_leer_qr_id_bienestar_fkey` (`id_bienestar`);

--
-- Indices de la tabla `codigos_qr`
--
ALTER TABLE `codigos_qr`
  ADD PRIMARY KEY (`id_qr`),
  ADD UNIQUE KEY `codigo_unico` (`codigo_unico`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_aprendiz` (`id_aprendiz`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_expiracion` (`fecha_expiracion`);

--
-- Indices de la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  ADD PRIMARY KEY (`id_enfermera_valoracion`),
  ADD KEY `enfermera_valoracion_id_enfermera_fkey` (`id_enfermera`),
  ADD KEY `enfermera_valoracion_id_reporte_fkey` (`id_reporte`),
  ADD KEY `fk_enfermera_valoracion_aprendiz` (`id_aprendiz`),
  ADD KEY `enfermera_valoracion_id_persona_fkey` (`id_persona`);

--
-- Indices de la tabla `historial_escaneos_qr`
--
ALTER TABLE `historial_escaneos_qr`
  ADD PRIMARY KEY (`id_escaneo`),
  ADD KEY `idx_codigo_qr` (`codigo_qr_id`),
  ADD KEY `idx_vigilante` (`vigilante_id`),
  ADD KEY `idx_fecha` (`fecha_escaneo`);

--
-- Indices de la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_fecha` (`fecha_ingreso`),
  ADD KEY `idx_historial_persona` (`id_personas`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `idx_permiso_estado` (`estado`),
  ADD KEY `idx_permiso_persona` (`id_persona`),
  ADD KEY `idx_permiso_fecha` (`fecha_solicitud`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `persona_documento_key` (`documento`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `idx_persona_rol` (`rol`),
  ADD KEY `idx_persona_estado` (`estado_formacion`);

--
-- Indices de la tabla `registro_ingreso`
--
ALTER TABLE `registro_ingreso`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_aprendiz` (`id_aprendiz`),
  ADD KEY `id_vigilante` (`id_vigilante`),
  ADD KEY `id_bienestar` (`id_bienestar`),
  ADD KEY `id_enfermeria` (`id_enfermeria`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  MODIFY `id_aprendiz_qr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  MODIFY `id_bienestar_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigos_qr`
--
ALTER TABLE `codigos_qr`
  MODIFY `id_qr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  MODIFY `id_enfermera_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historial_escaneos_qr`
--
ALTER TABLE `historial_escaneos_qr`
  MODIFY `id_escaneo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `registro_ingreso`
--
ALTER TABLE `registro_ingreso`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendiz_qr`
--
ALTER TABLE `aprendiz_qr`
  ADD CONSTRAINT `fk_aprendiz_qr_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_aprendiz_qr_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bienestar_leer_qr`
--
ALTER TABLE `bienestar_leer_qr`
  ADD CONSTRAINT `fk_bienestar_qr_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bienestar_qr_bienestar` FOREIGN KEY (`id_bienestar`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;

--
-- Filtros para la tabla `codigos_qr`
--
ALTER TABLE `codigos_qr`
  ADD CONSTRAINT `fk_qr_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `enfermera_valoracion`
--
ALTER TABLE `enfermera_valoracion`
  ADD CONSTRAINT `enfermera_valoracion_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `enfermera_valoracion_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enfermera_valoracion_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enfermera_valoracion_enfermera` FOREIGN KEY (`id_enfermera`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_enfermera_valoracion_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_medico` (`id_reporte`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_ingreso`
--
ALTER TABLE `historial_ingreso`
  ADD CONSTRAINT `fk_historial_ingreso_persona` FOREIGN KEY (`id_personas`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `fk_permiso_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_ingreso`
--
ALTER TABLE `registro_ingreso`
  ADD CONSTRAINT `fk_registro_ingreso_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_registro_ingreso_bienestar` FOREIGN KEY (`id_bienestar`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_registro_ingreso_enfermeria` FOREIGN KEY (`id_enfermeria`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_registro_ingreso_vigilante` FOREIGN KEY (`id_vigilante`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;

--
-- Filtros para la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  ADD CONSTRAINT `fk_registro_usuario_administrativo` FOREIGN KEY (`id_administrativo`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_registro_usuario_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reporte_medico`
--
ALTER TABLE `reporte_medico`
  ADD CONSTRAINT `fk_reporte_medico_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vigilante_leer_qr`
--
ALTER TABLE `vigilante_leer_qr`
  ADD CONSTRAINT `fk_vigilante_qr_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vigilante_qr_vigilante` FOREIGN KEY (`id_vigilante`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
