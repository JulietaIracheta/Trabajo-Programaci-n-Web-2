CREATE DATABASE  IF NOT EXISTS `gauchorocket` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
USE `gauchorocket`;
-- MySQL dump 10.13  Distrib 8.0.15, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gauchorocket
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cabina`
--

DROP TABLE IF EXISTS `cabina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cabina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cabinaNombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabina`
--

LOCK TABLES `cabina` WRITE;
/*!40000 ALTER TABLE `cabina` DISABLE KEYS */;
INSERT INTO `cabina` VALUES (1,'General'),(2,'Familiar'),(3,'Suite');
/*!40000 ALTER TABLE `cabina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capacidad`
--

DROP TABLE IF EXISTS `capacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `capacidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` int(11) DEFAULT NULL,
  `tipo_cabina` int(11) DEFAULT NULL,
  `filas` int(11) DEFAULT NULL,
  `columnas` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modelo` (`modelo`),
  KEY `tipo_cabina` (`tipo_cabina`),
  CONSTRAINT `capacidad_ibfk_1` FOREIGN KEY (`modelo`) REFERENCES `modelos_naves` (`id`),
  CONSTRAINT `capacidad_ibfk_2` FOREIGN KEY (`tipo_cabina`) REFERENCES `cabina` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capacidad`
--

LOCK TABLES `capacidad` WRITE;
/*!40000 ALTER TABLE `capacidad` DISABLE KEYS */;
INSERT INTO `capacidad` VALUES (1,1,1,20,10,1000),(2,1,2,15,5,1500),(3,1,3,5,5,2500),(4,2,1,20,5,800),(5,2,2,3,6,1300),(6,2,3,1,2,2300),(7,3,1,10,5,1300),(8,3,2,10,5,3500),(9,4,1,11,10,1200),(10,5,2,10,5,2600),(11,5,3,5,2,3700),(12,6,2,14,5,2600),(13,6,3,5,2,3700),(14,7,1,20,10,1600),(15,7,2,15,5,3000),(16,7,3,5,5,4100),(17,8,1,30,10,1600),(18,8,2,5,2,3000),(19,8,3,8,5,4100),(20,9,1,15,10,1600),(21,9,2,5,5,3000),(22,9,3,5,5,4100),(23,10,3,10,10,10000);
/*!40000 ALTER TABLE `capacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centros_medicos`
--

DROP TABLE IF EXISTS `centros_medicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `centros_medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `turnos_diarios` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centros_medicos`
--

LOCK TABLES `centros_medicos` WRITE;
/*!40000 ALTER TABLE `centros_medicos` DISABLE KEYS */;
INSERT INTO `centros_medicos` VALUES (1,'Buenos Aires',300),(2,'Shanghai',210),(3,'Ankara',200);
/*!40000 ALTER TABLE `centros_medicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circuitos`
--

DROP TABLE IF EXISTS `circuitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `circuitos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `sentido` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circuitos`
--

LOCK TABLES `circuitos` WRITE;
/*!40000 ALTER TABLE `circuitos` DISABLE KEYS */;
INSERT INTO `circuitos` VALUES (1,'Circuito 1 - Ida','ida'),(2,'Circuito 2 - Ida','ida'),(3,'Bs As',NULL),(4,'Ankara',NULL),(5,'Circuito 1 - Vuelta','vuelta'),(6,'Circuito 2 - Vuelta','vuelta');
/*!40000 ALTER TABLE `circuitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circuitos_estaciones`
--

DROP TABLE IF EXISTS `circuitos_estaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `circuitos_estaciones` (
  `circuito_id` int(11) NOT NULL,
  `estacion_id` int(11) NOT NULL,
  PRIMARY KEY (`circuito_id`,`estacion_id`),
  KEY `estacion_id` (`estacion_id`),
  CONSTRAINT `circuitos_estaciones_ibfk_1` FOREIGN KEY (`circuito_id`) REFERENCES `circuitos` (`id`),
  CONSTRAINT `circuitos_estaciones_ibfk_2` FOREIGN KEY (`estacion_id`) REFERENCES `estaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circuitos_estaciones`
--

LOCK TABLES `circuitos_estaciones` WRITE;
/*!40000 ALTER TABLE `circuitos_estaciones` DISABLE KEYS */;
INSERT INTO `circuitos_estaciones` VALUES (1,1),(2,1),(3,1),(5,1),(6,1),(1,2),(2,2),(4,2),(5,2),(6,2),(1,3),(2,3),(5,3),(6,3),(1,4),(5,4),(1,5),(2,5),(5,5),(6,5),(1,6),(5,6),(2,7),(6,7),(2,8),(6,8),(2,9),(6,9),(2,10),(6,10),(2,11),(6,11);
/*!40000 ALTER TABLE `circuitos_estaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credenciales`
--

DROP TABLE IF EXISTS `credenciales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `rol` int(11) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `rol` (`rol`),
  CONSTRAINT `credenciales_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `credenciales_ibfk_2` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credenciales`
--

LOCK TABLES `credenciales` WRITE;
/*!40000 ALTER TABLE `credenciales` DISABLE KEYS */;
INSERT INTO `credenciales` VALUES (1,'Alejandro',1,'81dc9bdb52d04dc20036dbd8313ed055',1),(2,'Tomas',2,'81dc9bdb52d04dc20036dbd8313ed055',2),(3,'Sebastian',2,'81dc9bdb52d04dc20036dbd8313ed055',3),(4,'Julieta',2,'81dc9bdb52d04dc20036dbd8313ed055',4),(5,'gallo',2,'81dc9bdb52d04dc20036dbd8313ed055',8),(6,'vincent',2,'81dc9bdb52d04dc20036dbd8313ed055',10),(7,'miguel',2,'81dc9bdb52d04dc20036dbd8313ed055',11),(8,'fabian',2,'81dc9bdb52d04dc20036dbd8313ed055',12),(9,'matias',2,'81dc9bdb52d04dc20036dbd8313ed055',13),(10,'pablo',2,'81dc9bdb52d04dc20036dbd8313ed055',9);
/*!40000 ALTER TABLE `credenciales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estaciones`
--

DROP TABLE IF EXISTS `estaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `estaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estaciones`
--

LOCK TABLES `estaciones` WRITE;
/*!40000 ALTER TABLE `estaciones` DISABLE KEYS */;
INSERT INTO `estaciones` VALUES (1,'Buenos Aires'),(2,'Ankara'),(3,'EEI'),(4,'Orbital Hotel'),(5,'Luna'),(6,'Marte'),(7,'Ganimedes'),(8,'Europa'),(9,'Io'),(10,'Encedalo'),(11,'Titan');
/*!40000 ALTER TABLE `estaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturacion`
--

DROP TABLE IF EXISTS `facturacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `facturacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_pago` date DEFAULT NULL,
  `monto_pago` int(11) DEFAULT NULL,
  `id_reserva` int(11) DEFAULT NULL,
  `numero_tarjeta` int(11) DEFAULT NULL,
  `tipo_de_tarjeta` int(11) DEFAULT NULL,
  `titular` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reserva` (`id_reserva`),
  KEY `tipo_de_tarjeta` (`tipo_de_tarjeta`),
  CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id`),
  CONSTRAINT `facturacion_ibfk_2` FOREIGN KEY (`tipo_de_tarjeta`) REFERENCES `tarjetas_credito` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturacion`
--

LOCK TABLES `facturacion` WRITE;
/*!40000 ALTER TABLE `facturacion` DISABLE KEYS */;
INSERT INTO `facturacion` VALUES (1,'2019-11-29',3000,3,1215,2,'Alejandro Rusticeini'),(2,'2019-11-30',1300,8,1789,2,'Carlos Fuentes'),(3,'2019-12-03',161000,15,8426,2,'J R Tolkien'),(4,'2019-12-03',3500,14,4871,2,'Franz Kafka'),(5,'2019-12-03',10500,16,8463,2,'George Orwell'),(6,'2019-12-03',10500,17,3251,2,'Philip K. Dick'),(7,'2019-12-03',10000,23,9643,2,'Larry Niven'),(8,'2019-12-03',1600,24,8746,2,'Stephen King'),(9,'2019-12-03',1000,25,1548,2,'Antoine de Saint Exupery'),(10,'2019-12-03',2500,26,8961,2,'Nieztche'),(11,'2019-12-03',1000,28,1584,2,'Julio Cortazar'),(12,'2019-12-03',3700,27,9418,2,'Monet');
/*!40000 ALTER TABLE `facturacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integrantes_viaje`
--

DROP TABLE IF EXISTS `integrantes_viaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `integrantes_viaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) DEFAULT NULL,
  `id_reserva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuarios` (`id_usuarios`),
  KEY `id_reserva` (`id_reserva`),
  CONSTRAINT `integrantes_viaje_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `integrantes_viaje_ibfk_2` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integrantes_viaje`
--

LOCK TABLES `integrantes_viaje` WRITE;
/*!40000 ALTER TABLE `integrantes_viaje` DISABLE KEYS */;
INSERT INTO `integrantes_viaje` VALUES (1,5,1),(2,6,1),(3,4,1),(4,7,2),(5,4,2),(6,8,3),(7,8,4),(8,8,5),(9,8,6),(10,8,7),(11,8,8),(12,8,9),(13,8,10),(14,9,11),(15,8,11),(16,10,12),(17,8,12),(18,11,13),(19,8,13),(20,8,14),(21,8,15),(22,8,16),(23,8,17),(24,8,18),(25,8,19),(26,12,20),(27,8,20),(28,12,21),(29,8,21),(30,13,22),(31,8,22),(32,9,23),(33,9,24),(34,3,25),(35,3,26),(36,12,27),(37,12,28);
/*!40000 ALTER TABLE `integrantes_viaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_menu` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Standard'),(2,'Gourmet'),(3,'Spa');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meses`
--

DROP TABLE IF EXISTS `meses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `meses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meses` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meses`
--

LOCK TABLES `meses` WRITE;
/*!40000 ALTER TABLE `meses` DISABLE KEYS */;
INSERT INTO `meses` VALUES (1,'Enero'),(2,'Febrero'),(3,'Marzo'),(4,'Abril'),(5,'Mayo'),(6,'Junio'),(7,'Julio'),(8,'Agosto'),(9,'Septiembre'),(10,'Octubre'),(11,'Noviembre'),(12,'Diciembre');
/*!40000 ALTER TABLE `meses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos_naves`
--

DROP TABLE IF EXISTS `modelos_naves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `modelos_naves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naveNombre` varchar(20) DEFAULT NULL,
  `tipo_aceleracion` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos_naves`
--

LOCK TABLES `modelos_naves` WRITE;
/*!40000 ALTER TABLE `modelos_naves` DISABLE KEYS */;
INSERT INTO `modelos_naves` VALUES (1,'Calandria','O'),(2,'Colibrí','O'),(3,'Zorzal','BA'),(4,'Carancho','BA'),(5,'Aguilucho','BA'),(6,'Canario','BA'),(7,'Águila','AA'),(8,'Condor','AA'),(9,'Halcón','AA'),(10,'Guanaco','AA');
/*!40000 ALTER TABLE `modelos_naves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `naves`
--

DROP TABLE IF EXISTS `naves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `naves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(8) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modelo` (`modelo`),
  CONSTRAINT `naves_ibfk_1` FOREIGN KEY (`modelo`) REFERENCES `modelos_naves` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `naves`
--

LOCK TABLES `naves` WRITE;
/*!40000 ALTER TABLE `naves` DISABLE KEYS */;
INSERT INTO `naves` VALUES (1,'O1',1),(2,'O2',1),(3,'O3',2),(4,'O4',2),(5,'O5',2),(6,'O6',1),(7,'O7',1),(8,'O8',2),(9,'O9',2),(10,'BA1',3),(11,'BA2',3),(12,'BA3',3),(13,'BA4',4),(14,'BA5',4),(15,'BA6',4),(16,'BA7',4),(17,'BA8',5),(18,'BA9',5),(19,'BA10',5),(20,'BA11',5),(21,'BA12',5),(22,'BA13',6),(23,'BA14',6),(24,'BA15',6),(25,'BA16',6),(26,'BA17',6),(27,'AA1',7),(28,'AA2',8),(29,'AA3',9),(30,'AA4',10),(31,'AA5',7),(32,'AA6',8),(33,'AA7',9),(34,'AA8',10),(35,'AA9',7),(36,'AA10',8),(37,'AA11',9),(38,'AA12',10),(39,'AA13',7),(40,'AA14',8),(41,'AA15',9),(42,'AA16',10),(43,'AA17',7),(44,'AA18',8),(45,'AA19',9);
/*!40000 ALTER TABLE `naves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_viajes` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cod_reserva` varchar(8) DEFAULT NULL,
  `estacion_origen` int(11) DEFAULT NULL,
  `estacion_destino` int(11) DEFAULT NULL,
  `idCapacidadCabina` int(11) DEFAULT NULL,
  `lista_espera` tinyint(1) DEFAULT NULL,
  `reserva_activa` tinyint(1) DEFAULT NULL,
  `codigo_vuelo` varchar(7) DEFAULT NULL,
  `pago` tinyint(1) DEFAULT NULL,
  `check_in` tinyint(1) DEFAULT NULL,
  `menu_elegido` int(11) DEFAULT NULL,
  `codigo_qr` varchar(70) DEFAULT NULL,
  `codigo_embarque` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_viajes` (`id_viajes`),
  KEY `id_usuario` (`id_usuario`),
  KEY `estacion_origen` (`estacion_origen`),
  KEY `estacion_destino` (`estacion_destino`),
  KEY `menu_elegido` (`menu_elegido`),
  KEY `idCapacidadCabina` (`idCapacidadCabina`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_viajes`) REFERENCES `viajes` (`id`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `credenciales` (`id`),
  CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`estacion_origen`) REFERENCES `estaciones` (`id`),
  CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`estacion_destino`) REFERENCES `estaciones` (`id`),
  CONSTRAINT `reservas_ibfk_5` FOREIGN KEY (`menu_elegido`) REFERENCES `menu` (`id_menu`),
  CONSTRAINT `reservas_ibfk_6` FOREIGN KEY (`idCapacidadCabina`) REFERENCES `capacidad` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES (1,323,3,4,'KXl5xD1',1,7,18,0,1,'ED524-I',0,0,NULL,NULL,NULL),(2,33,2,4,'ltnD4EU',1,1,23,0,0,'TR801',0,0,NULL,NULL,NULL),(3,345,1,5,'6shkjwb',1,9,21,0,1,'ED159-I',1,0,NULL,NULL,NULL),(4,345,1,5,'MpYQyhA',1,9,21,0,1,'ED159-I',0,0,NULL,NULL,NULL),(5,361,1,5,'sESgGhS',4,6,18,0,1,'ED624-I',0,0,NULL,NULL,NULL),(6,389,1,5,'jd3CXpM',1,11,18,0,1,'ED446-I',0,0,NULL,NULL,NULL),(7,1,1,5,'UNk0zRt',1,1,23,0,1,'TR236',0,0,NULL,NULL,NULL),(8,89,1,5,'oJEDajw',1,1,5,0,1,'OR191',1,1,3,'codigo-oJEDajw.png','U0TT'),(9,128,1,5,'BRrgNXJ',2,2,5,0,1,'OR499',0,0,NULL,NULL,NULL),(10,81,1,5,'0oUsR8m',1,1,4,0,1,'OR426',0,0,NULL,NULL,NULL),(11,127,2,5,'wccqvv5',1,1,1,0,1,'OR411',0,0,NULL,NULL,NULL),(12,36,2,5,'toNyQ0x',1,1,23,0,0,'TR449',0,0,NULL,NULL,NULL),(13,221,2,5,'abZtql4',10,5,10,0,1,'ED143-V',0,0,NULL,NULL,NULL),(14,161,1,5,'uN2pvLX',1,6,8,0,1,'ED462-I',1,1,1,'codigo-uN2pvLX.png','VA4B'),(15,162,46,5,'v4rVqlS',3,6,8,0,1,'ED462-I',1,1,2,'codigo-v4rVqlS.png','SA84'),(16,162,1,5,'lLpRt3Y',3,5,8,1,0,'ED462-I',0,0,NULL,NULL,NULL),(17,161,3,5,'slezFss',1,5,8,0,1,'ED462-I',1,0,NULL,NULL,NULL),(18,163,1,5,'ckuE1Yh',4,6,8,1,0,'ED462-I',0,0,NULL,NULL,NULL),(19,163,1,5,'Ae3S7fQ',4,6,8,1,0,'ED462-I',0,0,NULL,NULL,NULL),(20,125,2,5,'yrYv7T5',2,2,2,0,1,'OR951',0,0,NULL,NULL,NULL),(21,40,2,5,'6e32dmI',1,1,23,0,1,'TR658',0,0,NULL,NULL,NULL),(22,375,2,5,'q9tZbUQ',10,2,20,0,1,'ED118-V',0,0,NULL,NULL,NULL),(23,41,1,10,'Llgogv3',1,1,23,0,1,'TR871',1,0,NULL,NULL,NULL),(24,283,1,10,'GTFJAZL',8,10,17,0,1,'ED913-I',1,0,NULL,NULL,NULL),(25,119,1,3,'ya984K7',1,1,1,0,1,'OR209',1,0,NULL,NULL,NULL),(26,133,1,3,'qwXSL6p',2,2,3,0,1,'OR084',1,0,NULL,NULL,NULL),(27,251,1,8,'hf1NP2y',4,5,13,0,1,'ED023-I',1,0,NULL,NULL,NULL),(28,135,1,8,'V45QJSU',1,1,1,0,1,'OR468',1,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Usuario');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarjetas_credito`
--

DROP TABLE IF EXISTS `tarjetas_credito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tarjetas_credito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_tarjeta` varchar(30) DEFAULT NULL,
  `validacion_tarjeta` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarjetas_credito`
--

LOCK TABLES `tarjetas_credito` WRITE;
/*!40000 ALTER TABLE `tarjetas_credito` DISABLE KEYS */;
INSERT INTO `tarjetas_credito` VALUES (1,'American Express','/^([34|37]{2})([0-9]{13})$/'),(2,'Visa','/^([4]{1})([0-9]{12,15})$/'),(3,'MasterCard','/^([51|52|53|54|55]{2})([0-9]{14})$/');
/*!40000 ALTER TABLE `tarjetas_credito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_viajes`
--

DROP TABLE IF EXISTS `tipo_viajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipo_viajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_viaje` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_viajes`
--

LOCK TABLES `tipo_viajes` WRITE;
/*!40000 ALTER TABLE `tipo_viajes` DISABLE KEYS */;
INSERT INTO `tipo_viajes` VALUES (1,'Tour'),(2,'Suborbitales'),(3,'Entre destinos');
/*!40000 ALTER TABLE `tipo_viajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turnos`
--

DROP TABLE IF EXISTS `turnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `turnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `centro_medico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `centro_medico` (`centro_medico`),
  CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`centro_medico`) REFERENCES `centros_medicos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turnos`
--

LOCK TABLES `turnos` WRITE;
/*!40000 ALTER TABLE `turnos` DISABLE KEYS */;
INSERT INTO `turnos` VALUES (1,'2019-11-29',8,2),(2,'2019-11-29',10,3),(3,'2019-12-02',9,1);
/*!40000 ALTER TABLE `turnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicacion`
--

DROP TABLE IF EXISTS `ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_vuelo` varchar(7) DEFAULT NULL,
  `codigo_reserva` varchar(7) DEFAULT NULL,
  `asiento` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion`
--

LOCK TABLES `ubicacion` WRITE;
/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
INSERT INTO `ubicacion` VALUES (1,'OR191','oJEDajw','c3f3'),(2,'ED462-I','v4rVqlS','c1f1'),(3,'ED462-I','v4rVqlS','c3f1'),(4,'ED462-I','v4rVqlS','c4f1'),(5,'ED462-I','v4rVqlS','c5f1'),(6,'ED462-I','v4rVqlS','c2f2'),(7,'ED462-I','v4rVqlS','c3f2'),(8,'ED462-I','v4rVqlS','c4f2'),(9,'ED462-I','v4rVqlS','c5f2'),(10,'ED462-I','v4rVqlS','c1f3'),(11,'ED462-I','v4rVqlS','c2f3'),(12,'ED462-I','v4rVqlS','c3f3'),(13,'ED462-I','v4rVqlS','c4f3'),(14,'ED462-I','v4rVqlS','c5f3'),(15,'ED462-I','v4rVqlS','c1f4'),(16,'ED462-I','v4rVqlS','c2f4'),(17,'ED462-I','v4rVqlS','c3f4'),(18,'ED462-I','v4rVqlS','c4f4'),(19,'ED462-I','v4rVqlS','c5f4'),(20,'ED462-I','v4rVqlS','c1f5'),(21,'ED462-I','v4rVqlS','c2f5'),(22,'ED462-I','v4rVqlS','c3f5'),(23,'ED462-I','v4rVqlS','c4f5'),(24,'ED462-I','v4rVqlS','c5f5'),(25,'ED462-I','v4rVqlS','c1f6'),(26,'ED462-I','v4rVqlS','c2f6'),(27,'ED462-I','v4rVqlS','c4f6'),(28,'ED462-I','v4rVqlS','c1f7'),(29,'ED462-I','v4rVqlS','c2f7'),(30,'ED462-I','v4rVqlS','c3f7'),(31,'ED462-I','v4rVqlS','c4f7'),(32,'ED462-I','v4rVqlS','c5f7'),(33,'ED462-I','v4rVqlS','c1f8'),(34,'ED462-I','v4rVqlS','c2f8'),(35,'ED462-I','v4rVqlS','c3f8'),(36,'ED462-I','v4rVqlS','c4f8'),(37,'ED462-I','v4rVqlS','c5f8'),(38,'ED462-I','v4rVqlS','c1f9'),(39,'ED462-I','v4rVqlS','c2f9'),(40,'ED462-I','v4rVqlS','c3f9'),(41,'ED462-I','v4rVqlS','c4f9'),(42,'ED462-I','v4rVqlS','c5f9'),(43,'ED462-I','v4rVqlS','c1f10'),(44,'ED462-I','v4rVqlS','c2f10'),(45,'ED462-I','v4rVqlS','c3f10'),(46,'ED462-I','v4rVqlS','c4f10'),(47,'ED462-I','v4rVqlS','c5f10'),(48,'ED462-I','uN2pvLX','c5f6');
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) DEFAULT NULL,
  `apellido` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nivel_vuelo` int(11) DEFAULT NULL,
  `se_chequeo` tinyint(4) DEFAULT NULL,
  `confirmacion_mail` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Alejandro','Rusticeini','alejandro.rusticeini@gmail.com',NULL,NULL,1),(2,'Tomas','Seijas','tomas.seijas10@gmail.com',0,0,1),(3,'Sebastian','Dominikow','sebidomi@hotmail.com',1,1,1),(4,'Julieta','Iracheta','julietairacheta96@gmail.com ',0,0,1),(5,'Pablo','Maldonado','pablo.maldonado@gmail.com',0,0,0),(6,'Pedro','Zabzalman','pedroz@gmail.com',0,0,0),(7,'Martin','Ninotti','mninotti@gmail.com',0,0,0),(8,'Claudio','Vazquez','galloclaudio69@gmail.com',3,1,1),(9,'Pablo','Picasso','picasso@gmail.com',3,1,1),(10,'Vincent','VanGogh','vangogh@gmail.com',2,1,1),(11,'Miguel','Zamudio','mzamudio@gmail.com',0,0,1),(12,'Fabian','Cardarelli','fabcar@gmail.com',1,1,1),(13,'Matias','Tapak','matpak@gmail.com',0,0,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viajes`
--

DROP TABLE IF EXISTS `viajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `viajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime DEFAULT NULL,
  `tipo_viaje` int(11) DEFAULT NULL,
  `duracion` varchar(15) DEFAULT NULL,
  `nave` int(11) DEFAULT NULL,
  `circuito_id` int(11) DEFAULT NULL,
  `codigo_vuelo` varchar(7) DEFAULT NULL,
  `origen` int(11) DEFAULT NULL,
  `destino` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_viaje` (`tipo_viaje`),
  KEY `circuito_id` (`circuito_id`),
  KEY `origen` (`origen`),
  KEY `destino` (`destino`),
  CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`tipo_viaje`) REFERENCES `tipo_viajes` (`id`),
  CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`circuito_id`) REFERENCES `circuitos` (`id`),
  CONSTRAINT `viajes_ibfk_3` FOREIGN KEY (`origen`) REFERENCES `estaciones` (`id`),
  CONSTRAINT `viajes_ibfk_4` FOREIGN KEY (`destino`) REFERENCES `estaciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viajes`
--

LOCK TABLES `viajes` WRITE;
/*!40000 ALTER TABLE `viajes` DISABLE KEYS */;
INSERT INTO `viajes` VALUES (1,'2019-11-24 10:00:00',1,'35 dias',30,3,'TR236',1,1),(2,'2019-11-25 07:00:00',2,'8 horas',1,4,'OR155',2,2),(3,'2019-11-25 09:00:00',2,'8 horas',6,3,'OR172',1,1),(4,'2019-11-25 11:00:00',2,'8 horas',2,4,'OR784',2,2),(5,'2019-11-25 13:00:00',2,'8 horas',3,3,'OR634',1,1),(6,'2019-11-25 16:00:00',2,'8 horas',7,3,'OR811',1,1),(7,'2019-11-25 13:00:00',2,'8 horas',4,4,'OR235',2,2),(8,'2019-11-25 07:00:00',2,'8 horas',5,3,'OR641',1,1),(9,'2019-11-25 11:00:00',2,'8 horas',8,3,'OR369',1,1),(10,'2019-12-01 16:00:00',3,'4 horas',22,1,'ED075-I',1,3),(11,'2019-12-01 20:00:00',3,'1 horas',22,1,'ED075-I',3,4),(12,'2019-12-01 21:00:00',3,'16 horas',22,1,'ED075-I',4,5),(13,'2019-12-02 13:00:00',3,'26 horas',22,1,'ED075-I',5,6),(14,'2019-12-01 10:00:00',3,'26 horas',12,5,'ED662-V',6,5),(15,'2019-12-02 12:00:00',3,'16 horas',12,5,'ED662-V',5,4),(16,'2019-12-03 04:00:00',3,'1 horas',12,5,'ED662-V',4,3),(17,'2019-12-03 05:00:00',3,'4 horas',12,5,'ED662-V',3,1),(18,'2019-12-01 16:00:00',3,'4 horas',13,2,'ED560-I',1,3),(19,'2019-12-01 20:00:00',3,'14 horas',13,2,'ED560-I',3,5),(20,'2019-12-02 10:00:00',3,'48 horas',13,2,'ED560-I',5,7),(21,'2019-12-04 10:00:00',3,'50 horas',13,2,'ED560-I',7,8),(22,'2019-12-06 12:00:00',3,'51 horas',13,2,'ED560-I',8,9),(23,'2019-12-08 15:00:00',3,'70 horas',13,2,'ED560-I',9,10),(24,'2019-12-11 13:00:00',3,'77 horas',13,2,'ED560-I',10,11),(25,'2019-12-01 10:00:00',3,'77 horas',17,6,'ED284-V',11,10),(26,'2019-12-04 15:00:00',3,'70 horas',17,6,'ED284-V',10,9),(27,'2019-12-07 13:00:00',3,'51 horas',17,6,'ED284-V',9,8),(28,'2019-12-09 16:00:00',3,'50 horas',17,6,'ED284-V',8,7),(29,'2019-12-11 18:00:00',3,'48 horas',17,6,'ED284-V',7,5),(30,'2019-12-13 18:00:00',3,'14 horas',17,6,'ED284-V',5,3),(31,'2019-12-14 08:00:00',3,'4 horas',17,6,'ED284-V',3,1),(32,'2019-11-24 22:00:00',1,'35 dias',34,3,'TR512',1,1),(33,'2019-12-01 10:00:00',1,'35 dias',38,3,'TR801',1,1),(34,'2019-12-01 22:00:00',1,'35 dias',42,3,'TR327',1,1),(35,'2019-12-08 10:00:00',1,'35 dias',30,3,'TR725',1,1),(36,'2019-12-08 22:00:00',1,'35 dias',34,3,'TR449',1,1),(37,'2019-12-15 10:00:00',1,'35 dias',38,3,'TR315',1,1),(38,'2019-12-15 22:00:00',1,'35 dias',42,3,'TR069',1,1),(39,'2019-12-22 10:00:00',1,'35 dias',30,3,'TR143',1,1),(40,'2019-12-22 22:00:00',1,'35 dias',34,3,'TR658',1,1),(41,'2019-12-29 10:00:00',1,'35 dias',38,3,'TR871',1,1),(42,'2019-12-29 22:00:00',1,'35 dias',42,3,'TR942',1,1),(43,'2019-11-26 07:00:00',2,'8 horas',1,4,'OR325',2,2),(44,'2019-11-26 09:00:00',2,'8 horas',6,3,'OR482',1,1),(45,'2019-11-26 11:00:00',2,'8 horas',2,4,'OR115',2,2),(46,'2019-11-26 13:00:00',2,'8 horas',3,3,'OR063',1,1),(47,'2019-11-26 16:00:00',2,'8 horas',7,3,'OR947',1,1),(48,'2019-11-26 13:00:00',2,'8 horas',4,4,'OR362',2,2),(49,'2019-11-26 07:00:00',2,'8 horas',5,3,'OR478',1,1),(50,'2019-11-26 11:00:00',2,'8 horas',8,3,'OR090',1,1),(51,'2019-11-27 07:00:00',2,'8 horas',1,4,'OR475',2,2),(52,'2019-11-27 09:00:00',2,'8 horas',6,3,'OR271',1,1),(53,'2019-11-27 11:00:00',2,'8 horas',2,4,'OR314',2,2),(54,'2019-11-27 13:00:00',2,'8 horas',3,3,'OR964',1,1),(55,'2019-11-27 16:00:00',2,'8 horas',7,3,'OR761',1,1),(56,'2019-11-27 13:00:00',2,'8 horas',4,4,'OR555',2,2),(57,'2019-11-27 07:00:00',2,'8 horas',5,3,'OR321',1,1),(58,'2019-11-27 11:00:00',2,'8 horas',8,3,'OR729',1,1),(59,'2019-11-28 07:00:00',2,'8 horas',1,4,'OR005',2,2),(60,'2019-11-28 09:00:00',2,'8 horas',6,3,'OR762',1,1),(61,'2019-11-28 11:00:00',2,'8 horas',2,4,'OR943',2,2),(62,'2019-11-28 13:00:00',2,'8 horas',3,3,'OR163',1,1),(63,'2019-11-28 16:00:00',2,'8 horas',7,3,'OR847',1,1),(64,'2019-11-28 13:00:00',2,'8 horas',4,4,'OR532',2,2),(65,'2019-11-28 07:00:00',2,'8 horas',5,3,'OR461',1,1),(66,'2019-11-28 11:00:00',2,'8 horas',8,3,'OR119',1,1),(67,'2019-11-29 07:00:00',2,'8 horas',1,4,'OR515',2,2),(68,'2019-11-29 09:00:00',2,'8 horas',6,3,'OR694',1,1),(69,'2019-11-29 11:00:00',2,'8 horas',2,4,'OR327',2,2),(70,'2019-11-29 13:00:00',2,'8 horas',3,3,'OR571',1,1),(71,'2019-11-29 16:00:00',2,'8 horas',7,3,'OR457',1,1),(72,'2019-11-29 13:00:00',2,'8 horas',4,4,'OR236',2,2),(73,'2019-11-29 07:00:00',2,'8 horas',5,3,'OR639',1,1),(74,'2019-11-29 11:00:00',2,'8 horas',8,3,'OR829',1,1),(75,'2019-11-30 07:00:00',2,'8 horas',1,4,'OR135',2,2),(76,'2019-11-30 09:00:00',2,'8 horas',6,3,'OR322',1,1),(77,'2019-11-30 11:00:00',2,'8 horas',2,4,'OR662',2,2),(78,'2019-11-30 13:00:00',2,'8 horas',3,3,'OR328',1,1),(79,'2019-11-30 16:00:00',2,'8 horas',7,3,'OR684',1,1),(80,'2019-11-30 13:00:00',2,'8 horas',4,4,'OR352',2,2),(81,'2019-11-30 07:00:00',2,'8 horas',5,3,'OR426',1,1),(82,'2019-11-30 11:00:00',2,'8 horas',8,3,'OR912',1,1),(83,'2019-12-01 07:00:00',2,'8 horas',1,4,'OR985',2,2),(84,'2019-12-01 09:00:00',2,'8 horas',6,3,'OR432',1,1),(85,'2019-12-01 11:00:00',2,'8 horas',2,4,'OR584',2,2),(86,'2019-12-01 13:00:00',2,'8 horas',3,3,'OR704',1,1),(87,'2019-12-01 16:00:00',2,'8 horas',7,3,'OR841',1,1),(88,'2019-12-01 13:00:00',2,'8 horas',4,4,'OR255',2,2),(89,'2019-12-01 07:00:00',2,'8 horas',5,3,'OR191',1,1),(90,'2019-12-01 11:00:00',2,'8 horas',8,3,'OR079',1,1),(91,'2019-12-02 07:00:00',2,'8 horas',1,4,'OR185',2,2),(92,'2019-12-02 09:00:00',2,'8 horas',6,3,'OR242',1,1),(93,'2019-12-02 11:00:00',2,'8 horas',2,4,'OR754',2,2),(94,'2019-12-02 13:00:00',2,'8 horas',3,3,'OR384',1,1),(95,'2019-12-02 16:00:00',2,'8 horas',7,3,'OR415',1,1),(96,'2019-12-02 13:00:00',2,'8 horas',4,4,'OR580',2,2),(97,'2019-12-02 07:00:00',2,'8 horas',5,3,'OR923',1,1),(98,'2019-12-02 11:00:00',2,'8 horas',8,3,'OR380',1,1),(99,'2019-12-03 07:00:00',2,'8 horas',1,4,'OR052',2,2),(100,'2019-12-03 09:00:00',2,'8 horas',6,3,'OR315',1,1),(101,'2019-12-03 11:00:00',2,'8 horas',2,4,'OR479',2,2),(102,'2019-12-03 13:00:00',2,'8 horas',3,3,'OR640',1,1),(103,'2019-12-03 16:00:00',2,'8 horas',7,3,'OR249',1,1),(104,'2019-12-03 13:00:00',2,'8 horas',4,4,'OR670',2,2),(105,'2019-12-03 07:00:00',2,'8 horas',5,3,'OR956',1,1),(106,'2019-12-03 11:00:00',2,'8 horas',8,3,'OR141',1,1),(107,'2019-12-04 07:00:00',2,'8 horas',1,4,'OR043',2,2),(108,'2019-12-04 09:00:00',2,'8 horas',6,3,'OR122',1,1),(109,'2019-12-04 11:00:00',2,'8 horas',2,4,'OR785',2,2),(110,'2019-12-04 13:00:00',2,'8 horas',3,3,'OR644',1,1),(111,'2019-12-04 16:00:00',2,'8 horas',7,3,'OR401',1,1),(112,'2019-12-04 13:00:00',2,'8 horas',4,4,'OR963',2,2),(113,'2019-12-04 07:00:00',2,'8 horas',5,3,'OR587',1,1),(114,'2019-12-04 11:00:00',2,'8 horas',8,3,'OR169',1,1),(115,'2019-12-05 07:00:00',2,'8 horas',1,4,'OR975',2,2),(116,'2019-12-05 09:00:00',2,'8 horas',6,3,'OR622',1,1),(117,'2019-12-05 11:00:00',2,'8 horas',2,4,'OR715',2,2),(118,'2019-12-05 13:00:00',2,'8 horas',3,3,'OR501',1,1),(119,'2019-12-05 16:00:00',2,'8 horas',7,3,'OR209',1,1),(120,'2019-12-05 13:00:00',2,'8 horas',4,4,'OR158',2,2),(121,'2019-12-05 07:00:00',2,'8 horas',5,3,'OR220',1,1),(122,'2019-12-05 11:00:00',2,'8 horas',8,3,'OR343',1,1),(123,'2019-12-06 07:00:00',2,'8 horas',1,4,'OR874',2,2),(124,'2019-12-06 09:00:00',2,'8 horas',6,3,'OR712',1,1),(125,'2019-12-06 11:00:00',2,'8 horas',2,4,'OR951',2,2),(126,'2019-12-06 13:00:00',2,'8 horas',3,3,'OR659',1,1),(127,'2019-12-06 16:00:00',2,'8 horas',7,3,'OR411',1,1),(128,'2019-12-06 13:00:00',2,'8 horas',4,4,'OR499',2,2),(129,'2019-12-06 07:00:00',2,'8 horas',5,3,'OR291',1,1),(130,'2019-12-06 11:00:00',2,'8 horas',8,3,'OR177',1,1),(131,'2019-12-07 07:00:00',2,'8 horas',1,4,'OR305',2,2),(132,'2019-12-07 09:00:00',2,'8 horas',6,3,'OR240',1,1),(133,'2019-12-07 11:00:00',2,'8 horas',2,4,'OR084',2,2),(134,'2019-12-07 13:00:00',2,'8 horas',3,3,'OR131',1,1),(135,'2019-12-07 16:00:00',2,'8 horas',7,3,'OR468',1,1),(136,'2019-12-07 13:00:00',2,'8 horas',4,4,'OR651',2,2),(137,'2019-12-07 07:00:00',2,'8 horas',5,3,'OR863',1,1),(138,'2019-12-07 11:00:00',2,'8 horas',8,3,'OR468',1,1),(139,'2019-12-02 16:00:00',3,'4 horas',10,1,'ED103-I',1,3),(140,'2019-12-02 20:00:00',3,'1 horas',10,1,'ED103-I',3,4),(141,'2019-12-02 21:00:00',3,'16 horas',10,1,'ED103-I',4,5),(142,'2019-12-03 13:00:00',3,'26 horas',10,1,'ED103-I',5,6),(143,'2019-12-02 10:00:00',3,'26 horas',15,5,'ED228-V',6,5),(144,'2019-12-03 12:00:00',3,'16 horas',15,5,'ED228-V',5,4),(145,'2019-12-04 04:00:00',3,'1 horas',15,5,'ED228-V',4,3),(146,'2019-12-04 05:00:00',3,'4 horas',15,5,'ED228-V',3,1),(147,'2019-12-02 16:00:00',3,'4 horas',18,2,'ED736-I',1,3),(148,'2019-12-02 20:00:00',3,'14 horas',18,2,'ED736-I',3,5),(149,'2019-12-03 10:00:00',3,'48 horas',18,2,'ED736-I',5,7),(150,'2019-12-05 10:00:00',3,'50 horas',18,2,'ED736-I',7,8),(151,'2019-12-07 12:00:00',3,'51 horas',18,2,'ED736-I',8,9),(152,'2019-12-09 15:00:00',3,'70 horas',18,2,'ED736-I',9,10),(153,'2019-12-12 13:00:00',3,'77 horas',18,2,'ED736-I',10,11),(154,'2019-12-02 10:00:00',3,'77 horas',23,6,'ED546-V',11,10),(155,'2019-12-05 15:00:00',3,'70 horas',23,6,'ED546-V',10,9),(156,'2019-12-08 13:00:00',3,'51 horas',23,6,'ED546-V',9,8),(157,'2019-12-10 16:00:00',3,'50 horas',23,6,'ED546-V',8,7),(158,'2019-12-12 18:00:00',3,'48 horas',23,6,'ED546-V',7,5),(159,'2019-12-14 18:00:00',3,'14 horas',23,6,'ED546-V',5,3),(160,'2019-12-15 08:00:00',3,'4 horas',23,6,'ED546-V',3,1),(161,'2019-12-03 21:00:00',3,'4 horas',11,1,'ED462-I',1,3),(162,'2019-12-04 01:00:00',3,'1 horas',11,1,'ED462-I',3,4),(163,'2019-12-04 02:00:00',3,'16 horas',11,1,'ED462-I',4,5),(164,'2019-12-04 18:00:00',3,'26 horas',11,1,'ED462-I',5,6),(165,'2019-12-03 10:00:00',3,'26 horas',14,5,'ED056-V',6,5),(166,'2019-12-05 12:00:00',3,'16 horas',14,5,'ED056-V',5,4),(167,'2019-12-05 04:00:00',3,'1 horas',14,5,'ED056-V',4,3),(168,'2019-12-05 05:00:00',3,'4 horas',14,5,'ED056-V',3,1),(169,'2019-12-03 16:00:00',3,'4 horas',19,2,'ED861-I',1,3),(170,'2019-12-03 20:00:00',3,'14 horas',19,2,'ED861-I',3,5),(171,'2019-12-04 10:00:00',3,'48 horas',19,2,'ED861-I',5,7),(172,'2019-12-06 10:00:00',3,'50 horas',19,2,'ED861-I',7,8),(173,'2019-12-08 12:00:00',3,'51 horas',19,2,'ED861-I',8,9),(174,'2019-12-10 15:00:00',3,'70 horas',19,2,'ED861-I',9,10),(175,'2019-12-13 13:00:00',3,'77 horas',19,2,'ED861-I',10,11),(176,'2019-12-03 10:00:00',3,'77 horas',24,6,'ED324-V',11,10),(177,'2019-12-06 15:00:00',3,'70 horas',24,6,'ED324-V',10,9),(178,'2019-12-09 13:00:00',3,'51 horas',24,6,'ED324-V',9,8),(179,'2019-12-10 16:00:00',3,'50 horas',24,6,'ED324-V',8,7),(180,'2019-12-13 18:00:00',3,'48 horas',24,6,'ED324-V',7,5),(181,'2019-12-15 18:00:00',3,'14 horas',24,6,'ED324-V',5,3),(182,'2019-12-16 08:00:00',3,'4 horas',24,6,'ED324-V',3,1),(183,'2019-12-04 16:00:00',3,'4 horas',16,1,'ED163-I',1,3),(184,'2019-12-04 20:00:00',3,'1 horas',16,1,'ED163-I',3,4),(185,'2019-12-04 21:00:00',3,'16 horas',16,1,'ED163-I',4,5),(186,'2019-12-05 13:00:00',3,'26 horas',16,1,'ED163-I',5,6),(187,'2019-12-04 10:00:00',3,'26 horas',20,5,'ED598-V',6,5),(188,'2019-12-05 12:00:00',3,'16 horas',20,5,'ED598-V',5,4),(189,'2019-12-06 04:00:00',3,'1 horas',20,5,'ED598-V',4,3),(190,'2019-12-06 05:00:00',3,'4 horas',20,5,'ED598-V',3,1),(191,'2019-12-04 16:00:00',3,'4 horas',25,2,'ED315-I',1,3),(192,'2019-12-04 20:00:00',3,'14 horas',25,2,'ED315-I',3,5),(193,'2019-12-05 10:00:00',3,'48 horas',25,2,'ED315-I',5,7),(194,'2019-12-07 10:00:00',3,'50 horas',25,2,'ED315-I',7,8),(195,'2019-12-09 12:00:00',3,'51 horas',25,2,'ED315-I',8,9),(196,'2019-12-11 15:00:00',3,'70 horas',25,2,'ED315-I',9,10),(197,'2019-12-14 13:00:00',3,'77 horas',25,2,'ED315-I',10,11),(198,'2019-12-04 10:00:00',3,'77 horas',21,6,'ED722-V',11,10),(199,'2019-12-07 15:00:00',3,'70 horas',21,6,'ED722-V',10,9),(200,'2019-12-10 13:00:00',3,'51 horas',21,6,'ED722-V',9,8),(201,'2019-12-12 16:00:00',3,'50 horas',21,6,'ED722-V',8,7),(202,'2019-12-14 18:00:00',3,'48 horas',21,6,'ED722-V',7,5),(203,'2019-12-16 18:00:00',3,'14 horas',21,6,'ED722-V',5,3),(204,'2019-12-17 08:00:00',3,'4 horas',21,6,'ED722-V',3,1),(205,'2019-12-05 16:00:00',3,'4 horas',26,1,'ED414-I',1,3),(206,'2019-12-05 20:00:00',3,'1 horas',26,1,'ED414-I',3,4),(207,'2019-12-05 21:00:00',3,'16 horas',26,1,'ED414-I',4,5),(208,'2019-12-06 13:00:00',3,'26 horas',26,1,'ED414-I',5,6),(209,'2019-12-05 10:00:00',3,'26 horas',10,5,'ED279-V',6,5),(210,'2019-12-06 12:00:00',3,'16 horas',10,5,'ED279-V',5,4),(211,'2019-12-07 04:00:00',3,'1 horas',10,5,'ED279-V',4,3),(212,'2019-12-07 05:00:00',3,'4 horas',10,5,'ED279-V',3,1),(213,'2019-12-05 16:00:00',3,'4 horas',13,2,'ED647-I',1,3),(214,'2019-12-05 20:00:00',3,'14 horas',13,2,'ED647-I',3,5),(215,'2019-12-06 10:00:00',3,'48 horas',13,2,'ED647-I',5,7),(216,'2019-12-08 10:00:00',3,'50 horas',13,2,'ED647-I',7,8),(217,'2019-12-10 12:00:00',3,'51 horas',13,2,'ED647-I',8,9),(218,'2019-12-12 15:00:00',3,'70 horas',13,2,'ED647-I',9,10),(219,'2019-12-15 13:00:00',3,'77 horas',13,2,'ED647-I',10,11),(220,'2019-12-05 10:00:00',3,'77 horas',17,6,'ED143-V',11,10),(221,'2019-12-08 15:00:00',3,'70 horas',17,6,'ED143-V',10,9),(222,'2019-12-11 13:00:00',3,'51 horas',17,6,'ED143-V',9,8),(223,'2019-12-13 16:00:00',3,'50 horas',17,6,'ED143-V',8,7),(224,'2019-12-15 18:00:00',3,'48 horas',17,6,'ED143-V',7,5),(225,'2019-12-17 18:00:00',3,'14 horas',17,6,'ED143-V',5,3),(226,'2019-12-18 08:00:00',3,'4 horas',17,6,'ED143-V',3,1),(227,'2019-12-06 16:00:00',3,'4 horas',22,1,'ED963-I',1,3),(228,'2019-12-06 20:00:00',3,'1 horas',22,1,'ED963-I',3,4),(229,'2019-12-06 21:00:00',3,'16 horas',22,1,'ED963-I',4,5),(230,'2019-12-07 13:00:00',3,'26 horas',22,1,'ED963-I',5,6),(231,'2019-12-06 10:00:00',3,'26 horas',12,5,'ED457-V',6,5),(232,'2019-12-07 12:00:00',3,'16 horas',12,5,'ED457-V',5,4),(233,'2019-12-08 04:00:00',3,'1 horas',12,5,'ED457-V',4,3),(234,'2019-12-08 05:00:00',3,'4 horas',12,5,'ED457-V',3,1),(235,'2019-12-06 16:00:00',3,'4 horas',14,2,'ED844-I',1,3),(236,'2019-12-06 20:00:00',3,'14 horas',14,2,'ED844-I',3,5),(237,'2019-12-07 10:00:00',3,'48 horas',14,2,'ED844-I',5,7),(238,'2019-12-09 10:00:00',3,'50 horas',14,2,'ED844-I',7,8),(239,'2019-12-11 12:00:00',3,'51 horas',14,2,'ED844-I',8,9),(240,'2019-12-13 15:00:00',3,'70 horas',14,2,'ED844-I',9,10),(241,'2019-12-16 13:00:00',3,'77 horas',14,2,'ED844-I',10,11),(242,'2019-12-06 10:00:00',3,'77 horas',18,6,'ED239-V',11,10),(243,'2019-12-09 15:00:00',3,'70 horas',18,6,'ED239-V',10,9),(244,'2019-12-12 13:00:00',3,'51 horas',18,6,'ED239-V',9,8),(245,'2019-12-14 16:00:00',3,'50 horas',18,6,'ED239-V',8,7),(246,'2019-12-16 18:00:00',3,'48 horas',18,6,'ED239-V',7,5),(247,'2019-12-18 18:00:00',3,'14 horas',18,6,'ED239-V',5,3),(248,'2019-12-19 08:00:00',3,'4 horas',18,6,'ED239-V',3,1),(249,'2019-12-07 16:00:00',3,'4 horas',23,1,'ED023-I',1,3),(250,'2019-12-07 20:00:00',3,'1 horas',23,1,'ED023-I',3,4),(251,'2019-12-07 21:00:00',3,'16 horas',23,1,'ED023-I',4,5),(252,'2019-12-08 13:00:00',3,'26 horas',23,1,'ED023-I',5,6),(253,'2019-12-07 10:00:00',3,'26 horas',11,5,'ED511-V',6,5),(254,'2019-12-08 12:00:00',3,'16 horas',11,5,'ED511-V',5,4),(255,'2019-12-09 04:00:00',3,'1 horas',11,5,'ED511-V',4,3),(256,'2019-12-09 05:00:00',3,'4 horas',11,5,'ED511-V',3,1),(257,'2019-12-07 16:00:00',3,'4 horas',15,2,'ED678-I',1,3),(258,'2019-12-07 20:00:00',3,'14 horas',15,2,'ED678-I',3,5),(259,'2019-12-08 10:00:00',3,'48 horas',15,2,'ED678-I',5,7),(260,'2019-12-10 10:00:00',3,'50 horas',15,2,'ED678-I',7,8),(261,'2019-12-12 12:00:00',3,'51 horas',15,2,'ED678-I',8,9),(262,'2019-12-14 15:00:00',3,'70 horas',15,2,'ED678-I',9,10),(263,'2019-12-17 13:00:00',3,'77 horas',15,2,'ED678-I',10,11),(264,'2019-12-07 10:00:00',3,'77 horas',20,6,'ED781-V',11,10),(265,'2019-12-10 15:00:00',3,'70 horas',20,6,'ED781-V',10,9),(266,'2019-12-13 13:00:00',3,'51 horas',20,6,'ED781-V',9,8),(267,'2019-12-15 16:00:00',3,'50 horas',20,6,'ED781-V',8,7),(268,'2019-12-17 18:00:00',3,'48 horas',20,6,'ED781-V',7,5),(269,'2019-12-19 18:00:00',3,'14 horas',20,6,'ED781-V',5,3),(270,'2019-12-20 08:00:00',3,'4 horas',20,6,'ED781-V',3,1),(271,'2019-12-01 09:00:00',3,'3 horas',27,1,'ED012-I',1,3),(272,'2019-12-01 12:00:00',3,'1 horas',27,1,'ED012-I',3,4),(273,'2019-12-01 13:00:00',3,'9 horas',27,1,'ED012-I',4,5),(274,'2019-12-01 22:00:00',3,'22 horas',27,1,'ED012-I',5,6),(275,'2019-12-01 06:00:00',3,'22 horas',28,5,'ED752-V',6,5),(276,'2019-12-02 04:00:00',3,'9 horas',28,5,'ED752-V',5,4),(277,'2019-12-02 13:00:00',3,'1 horas',28,5,'ED752-V',4,3),(278,'2019-12-02 14:00:00',3,'3 horas',28,5,'ED752-V',3,1),(279,'2019-12-01 16:00:00',3,'3 horas',32,2,'ED913-I',1,3),(280,'2019-12-01 20:00:00',3,'10 horas',32,2,'ED913-I',3,5),(281,'2019-12-02 10:00:00',3,'32 horas',32,2,'ED913-I',5,7),(282,'2019-12-04 10:00:00',3,'33 horas',32,2,'ED913-I',7,8),(283,'2019-12-06 12:00:00',3,'35 horas',32,2,'ED913-I',8,9),(284,'2019-12-08 15:00:00',3,'50 horas',32,2,'ED913-I',9,10),(285,'2019-12-11 13:00:00',3,'52 horas',32,2,'ED913-I',10,11),(286,'2019-12-01 10:00:00',3,'52 horas',33,6,'ED354-V',11,10),(287,'2019-12-04 15:00:00',3,'50 horas',33,6,'ED354-V',10,9),(288,'2019-12-07 13:00:00',3,'35 horas',33,6,'ED354-V',9,8),(289,'2019-12-09 16:00:00',3,'33 horas',33,6,'ED354-V',8,7),(290,'2019-12-11 18:00:00',3,'32 horas',33,6,'ED354-V',7,5),(291,'2019-12-13 18:00:00',3,'10 horas',33,6,'ED354-V',5,3),(292,'2019-12-14 08:00:00',3,'3 horas',33,6,'ED354-V',3,1),(293,'2019-12-02 09:00:00',3,'3 horas',31,1,'ED258-I',1,3),(294,'2019-12-02 12:00:00',3,'1 horas',31,1,'ED258-I',3,4),(295,'2019-12-02 13:00:00',3,'9 horas',31,1,'ED258-I',4,5),(296,'2019-12-02 22:00:00',3,'22 horas',31,1,'ED258-I',5,6),(297,'2019-12-02 06:00:00',3,'22 horas',29,5,'ED764-V',6,5),(298,'2019-12-03 04:00:00',3,'9 horas',29,5,'ED764-V',5,4),(299,'2019-12-03 13:00:00',3,'1 horas',29,5,'ED764-V',4,3),(300,'2019-12-03 14:00:00',3,'3 horas',29,5,'ED764-V',3,1),(301,'2019-12-02 16:00:00',3,'3 horas',35,2,'ED487-I',1,3),(302,'2019-12-02 20:00:00',3,'10 horas',35,2,'ED487-I',3,5),(303,'2019-12-03 10:00:00',3,'32 horas',35,2,'ED487-I',5,7),(304,'2019-12-05 10:00:00',3,'33 horas',35,2,'ED487-I',7,8),(305,'2019-12-07 12:00:00',3,'35 horas',35,2,'ED487-I',8,9),(306,'2019-12-09 15:00:00',3,'50 horas',35,2,'ED487-I',9,10),(307,'2019-12-12 13:00:00',3,'52 horas',35,2,'ED487-I',10,11),(308,'2019-12-02 10:00:00',3,'52 horas',36,6,'ED432-V',11,10),(309,'2019-12-05 15:00:00',3,'50 horas',36,6,'ED432-V',10,9),(310,'2019-12-08 13:00:00',3,'35 horas',36,6,'ED432-V',9,8),(311,'2019-12-10 16:00:00',3,'33 horas',36,6,'ED432-V',8,7),(312,'2019-12-12 18:00:00',3,'32 horas',36,6,'ED432-V',7,5),(313,'2019-12-14 18:00:00',3,'10 horas',36,6,'ED432-V',5,3),(314,'2019-12-15 08:00:00',3,'3 horas',36,6,'ED432-V',3,1),(315,'2019-12-03 09:00:00',3,'3 horas',37,1,'ED121-I',1,3),(316,'2019-12-03 12:00:00',3,'1 horas',37,1,'ED121-I',3,4),(317,'2019-12-03 13:00:00',3,'9 horas',37,1,'ED121-I',4,5),(318,'2019-12-03 22:00:00',3,'22 horas',37,1,'ED121-I',5,6),(319,'2019-12-03 06:00:00',3,'22 horas',39,5,'ED295-V',6,5),(320,'2019-12-04 04:00:00',3,'9 horas',39,5,'ED295-V',5,4),(321,'2019-12-04 13:00:00',3,'1 horas',39,5,'ED295-V',4,3),(322,'2019-12-04 14:00:00',3,'3 horas',39,5,'ED295-V',3,1),(323,'2019-12-03 16:00:00',3,'3 horas',40,2,'ED524-I',1,3),(324,'2019-12-03 20:00:00',3,'10 horas',40,2,'ED524-I',3,5),(325,'2019-12-04 10:00:00',3,'32 horas',40,2,'ED524-I',5,7),(326,'2019-12-06 10:00:00',3,'33 horas',40,2,'ED524-I',7,8),(327,'2019-12-08 12:00:00',3,'35 horas',40,2,'ED524-I',8,9),(328,'2019-12-10 15:00:00',3,'50 horas',40,2,'ED524-I',9,10),(329,'2019-12-13 13:00:00',3,'52 horas',40,2,'ED524-I',10,11),(330,'2019-12-03 10:00:00',3,'52 horas',41,6,'ED896-V',11,10),(331,'2019-12-06 15:00:00',3,'50 horas',41,6,'ED896-V',10,9),(332,'2019-12-09 13:00:00',3,'35 horas',41,6,'ED896-V',9,8),(333,'2019-12-11 16:00:00',3,'33 horas',41,6,'ED896-V',8,7),(334,'2019-12-13 18:00:00',3,'32 horas',41,6,'ED896-V',7,5),(335,'2019-12-15 18:00:00',3,'10 horas',41,6,'ED896-V',5,3),(336,'2019-12-16 08:00:00',3,'3 horas',41,6,'ED896-V',3,1),(337,'2019-12-04 09:00:00',3,'3 horas',43,1,'ED216-I',1,3),(338,'2019-12-04 12:00:00',3,'1 horas',43,1,'ED216-I',3,4),(339,'2019-12-04 13:00:00',3,'9 horas',43,1,'ED216-I',4,5),(340,'2019-12-04 22:00:00',3,'22 horas',43,1,'ED216-I',5,6),(341,'2019-12-04 06:00:00',3,'22 horas',44,5,'ED983-V',6,5),(342,'2019-12-05 04:00:00',3,'9 horas',44,5,'ED983-V',5,4),(343,'2019-12-05 13:00:00',3,'1 horas',44,5,'ED983-V',4,3),(344,'2019-12-05 14:00:00',3,'3 horas',44,5,'ED983-V',3,1),(345,'2019-12-04 16:00:00',3,'3 horas',45,2,'ED159-I',1,3),(346,'2019-12-04 20:00:00',3,'10 horas',45,2,'ED159-I',3,5),(347,'2019-12-05 10:00:00',3,'32 horas',45,2,'ED159-I',5,7),(348,'2019-12-07 10:00:00',3,'33 horas',45,2,'ED159-I',7,8),(349,'2019-12-09 12:00:00',3,'35 horas',45,2,'ED159-I',8,9),(350,'2019-12-11 15:00:00',3,'50 horas',45,2,'ED159-I',9,10),(351,'2019-12-14 13:00:00',3,'52 horas',45,2,'ED159-I',10,11),(352,'2019-12-04 10:00:00',3,'52 horas',27,6,'ED308-V',11,10),(353,'2019-12-07 15:00:00',3,'50 horas',27,6,'ED308-V',10,9),(354,'2019-12-10 13:00:00',3,'35 horas',27,6,'ED308-V',9,8),(355,'2019-12-12 16:00:00',3,'33 horas',27,6,'ED308-V',8,7),(356,'2019-12-14 18:00:00',3,'32 horas',27,6,'ED308-V',7,5),(357,'2019-12-16 18:00:00',3,'10 horas',27,6,'ED308-V',5,3),(358,'2019-12-17 08:00:00',3,'3 horas',27,6,'ED308-V',3,1),(359,'2019-12-05 09:00:00',3,'3 horas',28,1,'ED624-I',1,3),(360,'2019-12-05 12:00:00',3,'1 horas',28,1,'ED624-I',3,4),(361,'2019-12-05 13:00:00',3,'9 horas',28,1,'ED624-I',4,5),(362,'2019-12-05 22:00:00',3,'22 horas',28,1,'ED624-I',5,6),(363,'2019-12-05 06:00:00',3,'22 horas',29,5,'ED821-V',6,5),(364,'2019-12-06 04:00:00',3,'9 horas',29,5,'ED821-V',5,4),(365,'2019-12-06 13:00:00',3,'1 horas',29,5,'ED821-V',4,3),(366,'2019-12-06 14:00:00',3,'3 horas',29,5,'ED821-V',3,1),(367,'2019-12-05 16:00:00',3,'3 horas',32,2,'ED366-I',1,3),(368,'2019-12-05 20:00:00',3,'10 horas',32,2,'ED366-I',3,5),(369,'2019-12-06 10:00:00',3,'32 horas',32,2,'ED366-I',5,7),(370,'2019-12-08 10:00:00',3,'33 horas',32,2,'ED366-I',7,8),(371,'2019-12-10 12:00:00',3,'35 horas',32,2,'ED366-I',8,9),(372,'2019-12-12 15:00:00',3,'50 horas',32,2,'ED366-I',9,10),(373,'2019-12-15 13:00:00',3,'52 horas',32,2,'ED366-I',10,11),(374,'2019-12-05 10:00:00',3,'52 horas',33,6,'ED118-V',11,10),(375,'2019-12-08 15:00:00',3,'50 horas',33,6,'ED118-V',10,9),(376,'2019-12-11 13:00:00',3,'35 horas',33,6,'ED118-V',9,8),(377,'2019-12-13 16:00:00',3,'33 horas',33,6,'ED118-V',8,7),(378,'2019-12-15 18:00:00',3,'32 horas',33,6,'ED118-V',7,5),(379,'2019-12-17 18:00:00',3,'10 horas',33,6,'ED118-V',5,3),(380,'2019-12-18 08:00:00',3,'3 horas',33,6,'ED118-V',3,1),(381,'2019-12-06 09:00:00',3,'3 horas',31,1,'ED428-I',1,3),(382,'2019-12-06 12:00:00',3,'1 horas',31,1,'ED428-I',3,4),(383,'2019-12-06 13:00:00',3,'9 horas',31,1,'ED428-I',4,5),(384,'2019-12-06 22:00:00',3,'22 horas',31,1,'ED428-I',5,6),(385,'2019-12-06 06:00:00',3,'22 horas',35,5,'ED775-V',6,5),(386,'2019-12-07 04:00:00',3,'9 horas',35,5,'ED775-V',5,4),(387,'2019-12-07 13:00:00',3,'1 horas',35,5,'ED775-V',4,3),(388,'2019-12-07 14:00:00',3,'3 horas',35,5,'ED775-V',3,1),(389,'2019-12-06 16:00:00',3,'3 horas',36,2,'ED446-I',1,3),(390,'2019-12-06 20:00:00',3,'10 horas',36,2,'ED446-I',3,5),(391,'2019-12-07 10:00:00',3,'32 horas',36,2,'ED446-I',5,7),(392,'2019-12-09 10:00:00',3,'33 horas',36,2,'ED446-I',7,8),(393,'2019-12-11 12:00:00',3,'35 horas',36,2,'ED446-I',8,9),(394,'2019-12-13 15:00:00',3,'50 horas',36,2,'ED446-I',9,10),(395,'2019-12-16 13:00:00',3,'52 horas',36,2,'ED446-I',10,11),(396,'2019-12-06 10:00:00',3,'52 horas',37,6,'ED195-V',11,10),(397,'2019-12-09 15:00:00',3,'50 horas',37,6,'ED195-V',10,9),(398,'2019-12-12 13:00:00',3,'35 horas',37,6,'ED195-V',9,8),(399,'2019-12-14 16:00:00',3,'33 horas',37,6,'ED195-V',8,7),(400,'2019-12-16 18:00:00',3,'32 horas',37,6,'ED195-V',7,5),(401,'2019-12-18 18:00:00',3,'10 horas',37,6,'ED195-V',5,3),(402,'2019-12-19 08:00:00',3,'3 horas',37,6,'ED195-V',3,1),(403,'2019-12-07 09:00:00',3,'3 horas',39,1,'ED612-I',1,3),(404,'2019-12-07 12:00:00',3,'1 horas',39,1,'ED612-I',3,4),(405,'2019-12-07 13:00:00',3,'9 horas',39,1,'ED612-I',4,5),(406,'2019-12-07 22:00:00',3,'22 horas',39,1,'ED612-I',5,6),(407,'2019-12-07 06:00:00',3,'22 horas',40,5,'ED389-V',6,5),(408,'2019-12-08 04:00:00',3,'9 horas',40,5,'ED389-V',5,4),(409,'2019-12-08 13:00:00',3,'1 horas',40,5,'ED389-V',4,3),(410,'2019-12-08 14:00:00',3,'3 horas',40,5,'ED389-V',3,1),(411,'2019-12-07 16:00:00',3,'3 horas',41,2,'ED951-I',1,3),(412,'2019-12-07 20:00:00',3,'10 horas',41,2,'ED951-I',3,5),(413,'2019-12-08 10:00:00',3,'32 horas',41,2,'ED951-I',5,7),(414,'2019-12-10 10:00:00',3,'33 horas',41,2,'ED951-I',7,8),(415,'2019-12-12 12:00:00',3,'35 horas',41,2,'ED951-I',8,9),(416,'2019-12-14 15:00:00',3,'50 horas',41,2,'ED951-I',9,10),(417,'2019-12-17 13:00:00',3,'52 horas',41,2,'ED951-I',10,11),(418,'2019-12-07 10:00:00',3,'52 horas',43,6,'ED803-V',11,10),(419,'2019-12-10 15:00:00',3,'50 horas',43,6,'ED803-V',10,9),(420,'2019-12-13 13:00:00',3,'35 horas',43,6,'ED803-V',9,8),(421,'2019-12-15 16:00:00',3,'33 horas',43,6,'ED803-V',8,7),(422,'2019-12-17 18:00:00',3,'32 horas',43,6,'ED803-V',7,5),(423,'2019-12-19 18:00:00',3,'10 horas',43,6,'ED803-V',5,3),(424,'2019-12-20 08:00:00',3,'3 horas',43,6,'ED803-V',3,1);
/*!40000 ALTER TABLE `viajes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-03  9:57:01
