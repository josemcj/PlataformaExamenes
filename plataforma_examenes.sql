-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: examenes
-- ------------------------------------------------------
-- Server version	5.7.36-log

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
-- Table structure for table `examen_preguntas`
--

DROP TABLE IF EXISTS `examen_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examen_preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(100) NOT NULL,
  `correcta` varchar(1) NOT NULL,
  `examen_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `examen_id` (`examen_id`),
  CONSTRAINT `examen_preguntas_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `examenes`
--

DROP TABLE IF EXISTS `examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inciso` varchar(1) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `examen_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pregunta_id` (`pregunta_id`),
  KEY `fk_respuestaexamen` (`examen_id`),
  CONSTRAINT `fk_respuestaexamen` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`),
  CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `examen_preguntas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `apellido_paterno` varchar(25) NOT NULL,
  `apellido_materno` varchar(25) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `es_admin` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_examenes`
--

DROP TABLE IF EXISTS `usuarios_examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_examenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `aciertos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `examen_id` (`examen_id`),
  CONSTRAINT `usuarios_examenes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `usuarios_examenes_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-14 22:44:55
