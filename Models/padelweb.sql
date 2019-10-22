-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2019 a las 14:56:46
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

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

--
-- Estructura de tabla para la tabla `campeonato`
--

CREATE TABLE `campeonato` (
  `ID_CAMPEONATO` int(45) NOT NULL,
  `NOMBRE` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `FECHA_INICIO_INSCRIPCIONES` date NOT NULL,
  `FECHA_FIN_INSCRIPCIONES` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campeonato_categoria`
--

CREATE TABLE `campeonato_categoria` (
  `ID_CAMPEONATO` int(45) NOT NULL,
  `ID_CATEGORIA` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(45) NOT NULL,
  `SEXO` varchar(2) COLLATE latin1_spanish_ci NOT NULL,
  `NIVEL` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamiento`
--

CREATE TABLE `enfrentamiento` (
  `ID_ENFRENTAMIENTO` int(45) NOT NULL,
  `RESULTADO` varchar(3) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA` date NOT NULL,
  `HORA` time DEFAULT NULL,
  `SET1` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `SET2` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `SET3` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `PAREJA1` int(45) NOT NULL,
  `PAREJA2` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `ID_GRUPO` int(45) NOT NULL,
  `ID_CAMPEONATO` int(45) NOT NULL,
  `ID_CATEGORIA` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `ID` int(45) NOT NULL,
  `HORA` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja`
--

CREATE TABLE `pareja` (
  `ID_PAREJA` int(45) NOT NULL,
  `NOMBRE_PAREJA` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `CAPITAN` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `MIEMBRO` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `ID_CATEGORIA` int(45) NOT NULL,
  `ID_GRUPO` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja_campeonato`
--

CREATE TABLE `pareja_campeonato` (
  `ID_CAMPEONATO` int(45) NOT NULL,
  `ID_PAREJA` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido_promocionado`
--

CREATE TABLE `partido_promocionado` (
  `ID_PARTIDO` int(45) NOT NULL,
  `HORA` time NOT NULL,
  `FECHA` date NOT NULL,
  `LOGIN1` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `LOGIN2` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `LOGIN3` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `LOGIN4` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `ID_PISTA` int(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pista`
--

CREATE TABLE `pista` (
  `ID_PISTA` int(45) NOT NULL,
  `ESTADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `ID_RESERVA` int(45) NOT NULL,
  `ID_PISTA` int(45) NOT NULL,
  `HORA` time NOT NULL,
  `FECHA` date NOT NULL,
  `LOGIN` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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
  `PERMISO` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `campeonato`
--
ALTER TABLE `campeonato`
  ADD PRIMARY KEY (`ID_CAMPEONATO`);

--
-- Indices de la tabla `campeonato_categoria`
--
ALTER TABLE `campeonato_categoria`
  ADD KEY `FK_IDCAMPEONATO` (`ID_CAMPEONATO`),
  ADD KEY `FK_CATEGORIA` (`ID_CATEGORIA`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_CATEGORIA`);

--
-- Indices de la tabla `enfrentamiento`
--
ALTER TABLE `enfrentamiento`
  ADD PRIMARY KEY (`ID_ENFRENTAMIENTO`),
  ADD KEY `FK_PAREJA1` (`PAREJA1`),
  ADD KEY `FK_PAREJA2` (`PAREJA2`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`ID_GRUPO`),
  ADD KEY `FK_IDCAMPEONATO2` (`ID_CAMPEONATO`),
  ADD KEY `FK_CATEGORIA2` (`ID_CATEGORIA`);

--
-- Indices de la tabla `pareja`
--
ALTER TABLE `pareja`
  ADD PRIMARY KEY (`ID_PAREJA`),
  ADD KEY `FK_USUARIO2` (`MIEMBRO`),
  ADD KEY `FK_USUARIO` (`CAPITAN`),
  ADD KEY `FK_CATEGORIAP` (`ID_CATEGORIA`),
  ADD KEY `FK_GRUPOP` (`ID_GRUPO`);

--
-- Indices de la tabla `pareja_campeonato`
--
ALTER TABLE `pareja_campeonato`
  ADD KEY `FK_PAREJAC` (`ID_PAREJA`),
  ADD KEY `FK_CAMPEONATOP` (`ID_CAMPEONATO`);

--
-- Indices de la tabla `partido_promocionado`
--
ALTER TABLE `partido_promocionado`
  ADD PRIMARY KEY (`ID_PARTIDO`),
  ADD KEY `FK_USUARIOP` (`LOGIN1`),
  ADD KEY `FK_USUARIOP3` (`LOGIN3`),
  ADD KEY `FK_USUARIOP2` (`LOGIN2`),
  ADD KEY `FK_USUARIOP4` (`LOGIN4`),
  ADD KEY `FK_PISTAP` (`ID_PISTA`);

--
-- Indices de la tabla `pista`
--
ALTER TABLE `pista`
  ADD PRIMARY KEY (`ID_PISTA`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`ID_RESERVA`),
  ADD KEY `FK_PISTAR` (`ID_PISTA`),
  ADD KEY `FK_NICKR` (`LOGIN`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`LOGIN`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `campeonato`
--
ALTER TABLE `campeonato`
  MODIFY `ID_CAMPEONATO` int(45) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_CATEGORIA` int(45) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfrentamiento`
--
ALTER TABLE `enfrentamiento`
  MODIFY `ID_ENFRENTAMIENTO` int(45) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `ID_GRUPO` int(45) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `campeonato_categoria`
--
ALTER TABLE `campeonato_categoria`
  ADD CONSTRAINT `FK_CATEGORIA` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IDCAMPEONATO` FOREIGN KEY (`ID_CAMPEONATO`) REFERENCES `campeonato` (`ID_CAMPEONATO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `enfrentamiento`
--
ALTER TABLE `enfrentamiento`
  ADD CONSTRAINT `FK_PAREJA1` FOREIGN KEY (`PAREJA1`) REFERENCES `pareja` (`ID_PAREJA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PAREJA2` FOREIGN KEY (`PAREJA2`) REFERENCES `pareja` (`ID_PAREJA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `FK_CATEGORIA2` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IDCAMPEONATO2` FOREIGN KEY (`ID_CAMPEONATO`) REFERENCES `campeonato` (`ID_CAMPEONATO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pareja`
--
ALTER TABLE `pareja`
  ADD CONSTRAINT `FK_CATEGORIAP` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GRUPOP` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIO` FOREIGN KEY (`CAPITAN`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIO2` FOREIGN KEY (`MIEMBRO`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pareja_campeonato`
--
ALTER TABLE `pareja_campeonato`
  ADD CONSTRAINT `FK_CAMPEONATOP` FOREIGN KEY (`ID_CAMPEONATO`) REFERENCES `campeonato` (`ID_CAMPEONATO`),
  ADD CONSTRAINT `FK_PAREJAC` FOREIGN KEY (`ID_PAREJA`) REFERENCES `pareja` (`ID_PAREJA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partido_promocionado`
--
ALTER TABLE `partido_promocionado`
  ADD CONSTRAINT `FK_PISTAP` FOREIGN KEY (`ID_PISTA`) REFERENCES `pista` (`ID_PISTA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOP` FOREIGN KEY (`LOGIN1`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOP2` FOREIGN KEY (`LOGIN2`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOP3` FOREIGN KEY (`LOGIN3`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOP4` FOREIGN KEY (`LOGIN4`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `FK_NICKR` FOREIGN KEY (`LOGIN`) REFERENCES `usuario` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PISTAR` FOREIGN KEY (`ID_PISTA`) REFERENCES `pista` (`ID_PISTA`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
