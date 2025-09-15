-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: soft_in
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aprendiz_qr`
--

DROP TABLE IF EXISTS `aprendiz_qr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aprendiz_qr` (
  `id_aprendiz_qr` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_persona` int NOT NULL COMMENT 'TRIAL',
  `codigo_qr` varchar(255) NOT NULL COMMENT 'TRIAL',
  `fecha_generado` datetime NOT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_aprendiz_qr`),
  KEY `idx_aprendiz_qr_persona` (`id_persona`),
  KEY `idx_aprendiz_qr_fecha` (`fecha_generado`),
  CONSTRAINT `aprendiz_qr_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aprendiz_qr`
--

LOCK TABLES `aprendiz_qr` WRITE;
/*!40000 ALTER TABLE `aprendiz_qr` DISABLE KEYS */;
/*!40000 ALTER TABLE `aprendiz_qr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bienestar_leer_qr`
--

DROP TABLE IF EXISTS `bienestar_leer_qr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bienestar_leer_qr` (
  `id_bienestar_qr` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_bienestar` int DEFAULT NULL COMMENT 'TRIAL',
  `id_aprendiz` int DEFAULT NULL COMMENT 'TRIAL',
  `fecha_lectura` datetime NOT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_bienestar_qr`),
  KEY `idx_bienestar_qr_fecha` (`fecha_lectura`),
  KEY `bienestar_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `bienestar_leer_qr_id_bienestar_fkey` (`id_bienestar`),
  CONSTRAINT `bienestar_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `bienestar_leer_qr_id_bienestar_fkey` FOREIGN KEY (`id_bienestar`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bienestar_leer_qr`
--

LOCK TABLES `bienestar_leer_qr` WRITE;
/*!40000 ALTER TABLE `bienestar_leer_qr` DISABLE KEYS */;
/*!40000 ALTER TABLE `bienestar_leer_qr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enfermera_valoracion`
--

DROP TABLE IF EXISTS `enfermera_valoracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enfermera_valoracion` (
  `id_enfermera_valoracion` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_enfermera` int DEFAULT NULL COMMENT 'TRIAL',
  `id_aprendiz` int DEFAULT NULL COMMENT 'TRIAL',
  `id_reporte` int DEFAULT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_enfermera_valoracion`),
  KEY `enfermera_valoracion_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `enfermera_valoracion_id_enfermera_fkey` (`id_enfermera`),
  KEY `enfermera_valoracion_id_reporte_fkey` (`id_reporte`),
  CONSTRAINT `enfermera_valoracion_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `enfermera_valoracion_id_enfermera_fkey` FOREIGN KEY (`id_enfermera`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `enfermera_valoracion_id_reporte_fkey` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_medico` (`id_reporte`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enfermera_valoracion`
--

LOCK TABLES `enfermera_valoracion` WRITE;
/*!40000 ALTER TABLE `enfermera_valoracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `enfermera_valoracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_ingreso`
--

DROP TABLE IF EXISTS `historial_ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_ingreso` (
  `id_historial` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_persona` int NOT NULL COMMENT 'TRIAL',
  `fecha_ingreso` datetime NOT NULL COMMENT 'TRIAL',
  `observacion` longtext COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_historial`),
  KEY `idx_historial_fecha` (`fecha_ingreso`),
  KEY `idx_historial_persona` (`id_persona`),
  CONSTRAINT `historial_ingreso_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_ingreso`
--

LOCK TABLES `historial_ingreso` WRITE;
/*!40000 ALTER TABLE `historial_ingreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_ingreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permiso` (
  `id_permiso` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_persona` int NOT NULL COMMENT 'TRIAL',
  `fecha_solicitud` date NOT NULL COMMENT 'TRIAL',
  `motivo` longtext COMMENT 'TRIAL',
  `estado` varchar(20) DEFAULT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial166` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_permiso`),
  KEY `idx_permiso_estado` (`estado`),
  KEY `idx_permiso_persona` (`id_persona`),
  KEY `idx_permiso_fecha` (`fecha_solicitud`),
  CONSTRAINT `permiso_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `id_persona` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nombres` varchar(60) NOT NULL COMMENT 'TRIAL',
  `apellidos` varchar(60) NOT NULL COMMENT 'TRIAL',
  `documento` varchar(20) NOT NULL COMMENT 'TRIAL',
  `tipo_documento` varchar(20) DEFAULT NULL COMMENT 'TRIAL',
  `rol` varchar(20) NOT NULL COMMENT 'TRIAL',
  `programa_formacion` varchar(100) DEFAULT NULL COMMENT 'TRIAL',
  `no_ficha` varchar(20) DEFAULT NULL COMMENT 'TRIAL',
  `estado_formacion` varchar(20) NOT NULL DEFAULT 'Activo' COMMENT 'TRIAL',
  `password_hash` varchar(255) NOT NULL COMMENT 'TRIAL',
  `correo` varchar(150) DEFAULT NULL COMMENT 'TRIAL',
  `telefono` varchar(30) DEFAULT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `password_salt` varchar(64) DEFAULT NULL COMMENT 'TRIAL',
  `nombre_completo` varchar(121) DEFAULT NULL COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_persona`),
  UNIQUE KEY `persona_documento_key` (`documento`),
  KEY `idx_persona_rol` (`rol`),
  KEY `idx_persona_estado` (`estado_formacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_usuario`
--

DROP TABLE IF EXISTS `registro_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_usuario` (
  `id_registro` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_administrativo` int DEFAULT NULL COMMENT 'TRIAL',
  `id_persona` int DEFAULT NULL COMMENT 'TRIAL',
  `fecha_registro` date NOT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial166` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_registro`),
  KEY `registro_usuario_id_administrativo_fkey` (`id_administrativo`),
  KEY `registro_usuario_id_persona_fkey` (`id_persona`),
  CONSTRAINT `registro_usuario_id_administrativo_fkey` FOREIGN KEY (`id_administrativo`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `registro_usuario_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuario`
--

LOCK TABLES `registro_usuario` WRITE;
/*!40000 ALTER TABLE `registro_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte_medico`
--

DROP TABLE IF EXISTS `reporte_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte_medico` (
  `id_reporte` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_persona` int NOT NULL COMMENT 'TRIAL',
  `descripcion` longtext NOT NULL COMMENT 'TRIAL',
  `fecha` date NOT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial163` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_reporte`),
  KEY `idx_reporte_fecha` (`fecha`),
  KEY `idx_reporte_persona` (`id_persona`),
  CONSTRAINT `reporte_medico_id_persona_fkey` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_medico`
--

LOCK TABLES `reporte_medico` WRITE;
/*!40000 ALTER TABLE `reporte_medico` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vigilante_leer_qr`
--

DROP TABLE IF EXISTS `vigilante_leer_qr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vigilante_leer_qr` (
  `id_vigilante_qr` int NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_vigilante` int DEFAULT NULL COMMENT 'TRIAL',
  `id_aprendiz` int DEFAULT NULL COMMENT 'TRIAL',
  `fecha_lectura` datetime NOT NULL COMMENT 'TRIAL',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'TRIAL',
  `trial166` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_vigilante_qr`),
  KEY `idx_vigilante_qr_fecha` (`fecha_lectura`),
  KEY `vigilante_leer_qr_id_aprendiz_fkey` (`id_aprendiz`),
  KEY `vigilante_leer_qr_id_vigilante_fkey` (`id_vigilante`),
  CONSTRAINT `vigilante_leer_qr_id_aprendiz_fkey` FOREIGN KEY (`id_aprendiz`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE,
  CONSTRAINT `vigilante_leer_qr_id_vigilante_fkey` FOREIGN KEY (`id_vigilante`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='TRIAL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vigilante_leer_qr`
--

LOCK TABLES `vigilante_leer_qr` WRITE;
/*!40000 ALTER TABLE `vigilante_leer_qr` DISABLE KEYS */;
/*!40000 ALTER TABLE `vigilante_leer_qr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-13 18:58:45
