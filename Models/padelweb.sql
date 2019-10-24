-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generaciÃ³n: 21-10-2019 a las 20:38:24
-- VersiÃ³n del servidor: 10.4.8-MariaDB
-- VersiÃ³n de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `padelweb`
--

-- --------------------------------------------------------
DROP DATABASE IF EXISTS `padelweb`;
CREATE DATABASE `padelweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `LOGIN` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NOMBRE` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `APELLIDOS` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `PASSWORD` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA_NAC` date NOT NULL,
  `TELEFONO` varchar(21) COLLATE latin1_spanish_ci DEFAULT NULL,
  `EMAIL` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `GENERO` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `PERMISO` int(1) NOT NULL,

  PRIMARY KEY(`LOGIN`),
  UNIQUE KEY `EMAIL` (`EMAIL`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `pista`
--

CREATE TABLE `pista` (
  `ID_PISTA` int(45)  NOT NULL,
  `ESTADO` tinyint(1) NOT NULL,

PRIMARY KEY(`ID_PISTA`)  

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `ID` int(45) NOT NULL AUTO_INCREMENT,
  `HORA` time NOT NULL,

 PRIMARY KEY(`ID`)  


) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;



--
-- Estructura de tabla para la tabla `campeonato`
--

CREATE TABLE `campeonato` (
  `ID_CAMPEONATO` int(45) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA_INICIO` datetime NOT NULL,
  `FECHA_FIN` datetime NOT NULL,
  `FECHA_INICIO_INSCRIPCIONES` datetime NOT NULL,
  `FECHA_FIN_INSCRIPCIONES` datetime NOT NULL,

PRIMARY KEY (`ID_CAMPEONATO`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;




--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(45) NOT NULL AUTO_INCREMENT,
  `SEXO` varchar(2) COLLATE latin1_spanish_ci NOT NULL,
  `NIVEL` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `N_PLAZAS` int(2) DEFAULT NULL,

PRIMARY KEY (`ID_CATEGORIA`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `ID_RESERVA` int(45) NOT NULL AUTO_INCREMENT,
  `ID_PISTA` int(45) NOT NULL,
  `HORA` time NOT NULL,
  `FECHA` date NOT NULL,
  `LOGIN` varchar(45) COLLATE latin1_spanish_ci NOT NULL,

PRIMARY KEY (`ID_RESERVA`),
FOREIGN KEY(`ID_PISTA`) REFERENCES `pista` (`ID_PISTA`),
FOREIGN KEY(`LOGIN`) REFERENCES `usuario` (`LOGIN`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `campeonato_categoria`
--

CREATE TABLE `campeonato_categoria` (
  `ID_CATCAMP` int(45) NOT NULL AUTO_INCREMENT,
  `ID_CAMPEONATO` int(45) NOT NULL,
  `ID_CATEGORIA` int(45) NOT NULL,
  
PRIMARY KEY (`ID_CATCAMP`),
FOREIGN KEY(`ID_CAMPEONATO`) REFERENCES `campeonato` (`ID_CAMPEONATO`),
FOREIGN KEY(`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `ID_GRUPO` int(45) NOT NULL AUTO_INCREMENT,
  `ID_CATCAMP` int(45) NOT NULL,

PRIMARY KEY (`ID_GRUPO`),
FOREIGN KEY(`ID_CATCAMP`) REFERENCES `campeonato_categoria` (`ID_CATCAMP`)


) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `pareja`
--

CREATE TABLE `pareja` (
  `ID_PAREJA` int(45) NOT NULL AUTO_INCREMENT,
  `NOMBRE_PAREJA` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `CAPITAN` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `MIEMBRO` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA_INSCRIP` datetime NOT NULL,
  `ID_GRUPO` int(45) DEFAULT NULL,
  `ID_CATCAMP` int(45) NOT NULL,

PRIMARY KEY (`ID_PAREJA`),
FOREIGN KEY(`CAPITAN`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`MIEMBRO`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`),
FOREIGN KEY(`ID_CATCAMP`) REFERENCES `campeonato_categoria` (`ID_CATCAMP`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `partido_promocionado`
-- 

CREATE TABLE `partido` (
  `ID_PARTIDO` int(45) NOT NULL AUTO_INCREMENT,
  `HORA` time NOT NULL,
  `FECHA` date NOT NULL,
  `PROMOCION` tinyint(1) NOT NULL,
  `LOGIN1` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `LOGIN2` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `LOGIN3` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `LOGIN4` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ID_PISTA` int(45) DEFAULT NULL,

PRIMARY KEY (`ID_PARTIDO`),
FOREIGN KEY(`LOGIN1`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`LOGIN2`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`LOGIN3`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`LOGIN4`) REFERENCES `usuario` (`LOGIN`),
FOREIGN KEY(`ID_PISTA`) REFERENCES `pista` (`ID_PISTA`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `enfrentamiento`
--

CREATE TABLE `enfrentamiento` (
  `ID_ENFRENTAMIENTO` int(45) NOT NULL AUTO_INCREMENT,
  `RESULTADO` varchar(3) COLLATE latin1_spanish_ci DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `HORA` time DEFAULT NULL,
  `SET1` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `SET2` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `SET3` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `PAREJA1` int(45) NOT NULL,
  `PAREJA2` int(45) NOT NULL,
  `ID_PISTA` int(45) DEFAULT NULL,

PRIMARY KEY (`ID_ENFRENTAMIENTO`),
FOREIGN KEY(`PAREJA1`) REFERENCES `pareja` (`ID_PAREJA`),
FOREIGN KEY(`PAREJA2`) REFERENCES `pareja` (`ID_PAREJA`),
FOREIGN KEY(`ID_PISTA`) REFERENCES `pista` (`ID_PISTA`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;





--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
