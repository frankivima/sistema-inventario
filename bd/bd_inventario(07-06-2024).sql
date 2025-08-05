-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 20:32:48
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
-- Base de datos: `bd_inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso_routers`
--

CREATE TABLE `acceso_routers` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `direccion_ip` varchar(15) NOT NULL,
  `wan_ip` varchar(15) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `contraseña` varchar(60) NOT NULL,
  `usuario_acceso` varchar(60) NOT NULL,
  `contraseña_acceso` varchar(60) NOT NULL,
  `visibilidad` varchar(25) NOT NULL,
  `filtro_mac` varchar(10) NOT NULL,
  `uso` varchar(255) NOT NULL,
  `ubicacion` text NOT NULL,
  `fecha_registro` date NOT NULL,
  `encargado_registro` int(11) NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `encargado_modificacion` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceso_routers`
--

INSERT INTO `acceso_routers` (`id`, `id_equipo`, `direccion_ip`, `wan_ip`, `nombre`, `contraseña`, `usuario_acceso`, `contraseña_acceso`, `visibilidad`, `filtro_mac`, `uso`, `ubicacion`, `fecha_registro`, `encargado_registro`, `fecha_modificacion`, `encargado_modificacion`, `estado`) VALUES
(6, 46, '192.168.10.1', '192.168.15.179', 'clinica', 'clinicdelostrabajores', 'admin', 'FasGanZ19', 'Visible', 'No', 'Wifi para todos', 'Cuarto de Datos', '2024-06-04', 2, '2024-06-05', 2, 'Activo'),
(7, 47, '192.168.1.1', '192.168.15.101', 'clinica', 'clinicadelostrabajadores', 'admin', 'FasGanZ19', 'Visible', 'No', 'Wifi para todos', 'Techo de Oficina Médicos de Emergencias', '2024-06-04', 2, '2024-06-05', 2, 'Activo'),
(8, 50, '192.168.5.1', '192.168.15.231', 'Presidencia', 'Fasganz2022*', 'admin', 'FasGanZ19', 'Visible', 'Sí', 'Wifi restringidos para administración', 'Oficina de Administración detrás de impresora canon', '2024-06-04', 2, '2024-06-05', 2, 'Activo'),
(9, 48, 'PUENTE 15.1', '192.168.15.1', 'ADMINFAS', 'FasganZ*2023', '', '', 'Oculto', 'No', 'Wifi extensor de la red principal 15.1, interno para laptops de administración, presidencia y tlf principales.', 'Oficina de Administración, escritorio de Lcda. Lirimar.', '2024-06-04', 2, '2024-06-05', 2, 'Activo'),
(10, 45, '192.168.15.1', '192.168.101.1', 'rrhh', 'Fasganz2022*', 'admin', 'FasGanZ19', 'Oculto', 'No', 'Router principal de la red 15.1, wifi para laptos de recursos humanos.', 'Cuarto de datos', '2024-06-05', 2, '0000-00-00', 0, 'Activo'),
(11, 49, '192.168.20.1', '192.168.15.46', 'Infra', 'Fasganz2022*', '', 'FasGanz19', 'Visible', 'No', 'Wifi de la Oficina de Infraestructura', 'Oficina de Infraestructura', '2024-06-05', 2, '0000-00-00', 0, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acta_revision`
--

CREATE TABLE `acta_revision` (
  `id_acta` int(11) NOT NULL,
  `fecha_revision` date NOT NULL,
  `unidad_trabajo` text NOT NULL,
  `responsable_uso` text NOT NULL,
  `descripcion_equipo` text NOT NULL,
  `serial` text NOT NULL,
  `codigo_bienes` text NOT NULL,
  `estado_equipo` text NOT NULL,
  `operatividad` text NOT NULL,
  `accesorios_perifericos` text NOT NULL,
  `resultado_revision` text NOT NULL,
  `conclusion_revision` text NOT NULL,
  `user_elaboracion` text NOT NULL,
  `user_revision` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre_departamento` varchar(60) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `encargado_registro` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre_departamento`, `estado`, `fecha_registro`, `encargado_registro`) VALUES
(1, 'Informática', 'Activo', '2024-02-07 16:55:44', '1'),
(2, 'Administración ', 'Activo', '2024-02-07 20:21:58', '1'),
(3, 'Dirección Medica', 'Activo', '2024-02-07 20:22:17', '1'),
(4, 'Recursos Humanos', 'Activo', '2024-02-07 20:23:22', '1'),
(5, 'Presidencia', 'Activo', '2024-02-07 20:26:32', '1'),
(6, 'Auditoria', 'Activo', '2024-02-07 20:27:47', '1'),
(7, 'Historias Medicas ', 'Activo', '2024-02-07 20:28:00', '1'),
(8, 'Laboratorio', 'Activo', '2024-02-07 20:28:18', '1'),
(9, 'Atención al Usuario ', 'Activo', '2024-02-07 20:28:44', '1'),
(10, 'Bienes ', 'Activo', '2024-02-07 20:29:01', '1'),
(11, 'Almacén', 'Activo', '2024-02-07 20:29:12', '1'),
(12, 'Dirección General', 'Activo', '2024-02-07 20:30:11', '1'),
(13, 'Seguridad', 'Activo', '2024-02-07 20:31:17', '1'),
(14, 'Servicios Generales', 'Activo', '2024-02-07 20:31:38', '1'),
(15, 'Cuarto de Datos', 'Activo', '2024-02-07 20:43:05', '1'),
(16, 'Farmacia', 'Activo', '2024-02-15 20:37:14', '2'),
(17, 'Infraestructura', 'Activo', '2024-02-15 20:42:32', '2'),
(18, 'Call Center', 'Activo', '2024-02-28 16:00:20', '1'),
(19, 'Recepción ', 'Activo', '2024-02-28 16:07:18', '1'),
(20, 'Emergencia', 'Activo', '2024-06-05 21:21:24', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `departamento` varchar(60) NOT NULL,
  `usuario_responsable` varchar(50) NOT NULL,
  `tipo_equipo` varchar(60) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `codigo_bienes` varchar(100) NOT NULL,
  `procesador` varchar(100) NOT NULL,
  `tipo_ram` varchar(60) NOT NULL,
  `cant_memoria` int(11) NOT NULL,
  `tipo_disco` varchar(50) NOT NULL,
  `almacenamiento` varchar(60) NOT NULL,
  `sistema_operativo` varchar(60) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `encargado_registro` int(11) NOT NULL,
  `fecha_ultima_modificacion` datetime NOT NULL,
  `encargado_modificacion` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `ubicacion` text NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `departamento`, `usuario_responsable`, `tipo_equipo`, `marca`, `modelo`, `serial`, `codigo_bienes`, `procesador`, `tipo_ram`, `cant_memoria`, `tipo_disco`, `almacenamiento`, `sistema_operativo`, `fecha_registro`, `encargado_registro`, `fecha_ultima_modificacion`, `encargado_modificacion`, `estado`, `ubicacion`, `observaciones`) VALUES
(2, 'Informática', 'Omar Mendoza', 'Mouse', 'IMEXX', 'IME-26985', '993015825', '0005', '', '', 0, '', '', '', '2024-02-07 12:35:28', 1, '2024-02-29 13:54:59', 1, 'Activo', 'Infraestructura', ''),
(3, 'Informática', 'Omar Mendoza', 'CPU', 'VIT', 'E2220-03', 'A000710371', '20020-0012-435', 'Intel I7 3770K 3.40Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'WINDOWS 10 ', '2024-02-07 12:38:19', 1, '2024-02-07 15:33:19', 1, 'Activo', 'Infraestructura', ''),
(10, 'Informática', 'Omar Mendoza', 'Monitor', 'Aiteg', 'W90221S5-D', 'W921S5D-D7NZ2B15-01880L', '20020-XXX-397', '', '', 0, '', '', '', '2024-02-07 15:35:12', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Infraestructura', ''),
(11, 'Servicios Generales', 'Richard Rodríguez', 'CPU', 'SIRAGON', 'PC-1005', '150819P20276SP0272', '20020-XXXX-535', 'Intel G2030 3.00Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'Windows 10', '2024-02-07 15:43:30', 1, '2024-04-16 16:13:58', 2, 'Activo', 'Infraestructura', ''),
(12, 'Servicios Generales', 'Richard Rodríguez', 'Mouse', 'LOGITECH', 'M-105', '1230HC00SN18', '20020-XXXX-533', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-02-07 15:49:22', 1, '2024-04-16 16:15:13', 2, 'Activo', 'Infraestructura', ''),
(13, 'Administración ', 'Deinor Figuera', 'CPU', 'THERMAL MASTER', '', '', '', 'Intel Celeron CPU G1610@2.60Ghz', 'DDR3', 2, 'HDD / SATA', '1000', 'Windows 7', '2024-02-07 15:52:27', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Administración ', ''),
(14, 'Administración ', 'Katherine Álvarez', 'Laptop', 'Lenovo', 'G480', 'MB00354255', '', 'Intel Pentium B970 2.30 GHZ', 'DDR3', 4, 'HDD / SATA', '500', 'Windows 7', '2024-02-07 16:11:09', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Administración', ''),
(18, 'Farmacia', 'Lirida Almeida', 'Laptop', 'Lenovo', 'G485', 'MB00319591', '3-1800-1-37', 'AMD C-70', 'DDR3', 4, 'HDD / SATA', '500', 'WINDOWS 7', '2024-04-15 15:25:52', 2, '2024-04-16 12:48:48', 1, 'Activo', 'Farmacia', ''),
(19, 'Informática', 'Omar Mendoza', 'Monitor', 'Lg', '20M37A', '501NDDM1W610', '20020-XXXX-350', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:20:47', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(20, 'Informática', 'Omar Mendoza', 'Teclado', 'Hp', 'SK-2880', 'BDAEB0BCP3V7ME', '20020-XXXX-1037', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:24:53', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(21, 'Servicios Generales', 'Richart Rodriguez', 'Teclado', 'GENIUS', 'KL-0210', 'ZCA732900693', '20020-XXXX-527', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:37:06', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(22, 'Servicios Generales', 'Richart Rodriguez', 'Impresora', 'Hp', 'P1102W', 'VND3J74980', '20020-XXXX-530', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 16:08:22', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(23, 'Bienes ', 'Eudalys Rojas', 'CPU', 'SIRAGON', 'PC-1500', '150819P20276SP0272', '20020-XXXX-370', 'Intel G2030 3,00Ghz', 'DDR3', 4, 'HDD / SATA', '500', 'WINDOWS 10', '2024-04-16 16:15:49', 2, '2024-05-10 15:29:13', 1, 'Activo', 'Infraestructura', 'Se realizó mantenimiento el dia 08/05/2024'),
(24, 'Bienes ', 'Eudalys Rojas', 'Monitor', 'AOC ', 'Z15LM0041C-00134', 'FMYD5HA008605', '20020-XXXX-526', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 16:20:48', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(25, 'Bienes ', 'Eudalys Rojas', 'Mouse', 'MYO', '2550', '', '20020-XXXX-384', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 08:44:16', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(26, 'Bienes ', 'Eudalys Rojas', 'Teclado', 'SIRAGON', 'SVCPC-1005', 'K15001205008941', '20020-XXXX-368', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 08:47:37', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(27, 'Bienes ', 'Joseu Carrizales', 'Laptop', 'TOSHIBA', 'ATELITE E557-A5320', '13026497P', '', 'Intel I5 4200u 2.3Ghz', 'DDR3', 6, 'HDD / SATA', '500', 'WINDOWS 10', '2024-04-17 08:52:03', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(28, 'Bienes ', 'Eudalys Rojas', 'Impresora', 'HP', 'OFFICEJET 7500A', 'MY223310J0', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:06:27', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(29, 'Informática', 'Omar Mendoza', 'Teclado', 'LENOVO', 'KU-0225', '1S41A52892366101E', '20020-XXXX-1306', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:24:02', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura Sr. Carrizales', ''),
(30, 'Informática', 'Omar Mendoza', 'Mouse', 'IMEXX', '26985', '993015825', '20020-XXXX-1126', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:44:59', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura Sr. Carrizales', ''),
(31, 'Bienes ', 'Josue Carrizales', 'Monitor', 'SAMSUNG', 'S22D300NY', '02EYHCLFB03732L', '20020-XXXX-367', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:48:43', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(32, 'Informática', 'Omar Mendoza', 'Regulador de Voltaje', 'AVTEK', 'R8T-601', '', '3-1800-1-37-02-02-354', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 11:01:18', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(33, 'Informática', 'Frank Guiche', 'CPU', 'hp', 'ml110 g7', 'BRC2120X19', '20020-XXXX-1275', 'Intel Xeon E31220 3.10Ghz', 'DDR3', 4, 'HDD / SATA', '500', 'Windows 10', '2024-04-23 15:13:03', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', 'Cuenta con un Disco Duro Adicional de 500GB HDD.'),
(34, 'Informática', 'Frank Guiche', 'Teclado', 'HP', 'KU-0316', 'BBAVL0KGA1K2OI', '20020-XXXX-1267', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-23 15:20:58', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(35, 'Informática', 'Frank Guiche', 'Monitor', 'aoc', '185lmooo12', 'AOPC59A003455', '20020-XXXX-1269', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-23 15:23:34', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(36, 'Historias Medicas ', 'Jenni Guaiquirian', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-E08B', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 15:38:55', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Historias Medicas', ''),
(37, 'Historias Medicas ', 'Jenni Guaiquirian', 'CPU', 'DELL', '7010', 'HP7HB04', '', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'WINDOWS 11', '2024-04-25 16:28:34', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Registro de Citas', ''),
(38, 'Historias Medicas ', 'Jenni Guaiquirian', 'Mouse', 'DELL', 'MS116T1', 'CN-065K5F-L0300-360-0155', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:45:32', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Registro de Citas', ''),
(39, 'Historias Medicas ', 'Jenni Guaiquirian', 'Teclado', 'DELL', 'kb216t1', 'CN-0081N8-L0300-3A5-A2VH-A04', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:47:09', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Registro de Citas', ''),
(40, 'Recursos Humanos', 'José Ángel Hernández', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-DWYB-A08', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:50:33', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Oficina de Recursos Humanos', ''),
(41, 'Recursos Humanos', 'José Ángel Hernández', 'CPU', 'DELL', '7010', '', '', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'WINDOWS 11', '2024-04-25 16:54:38', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Oficina de Recursos Humanos', ''),
(42, 'Atención al Usuario ', 'Compartida', 'Monitor', 'BENQ', 'ET-0024-TA', 'ETWAB05621019', '20020-XXXX-432', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-05-14 14:35:31', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Recepción Emergencia', ''),
(43, 'Atención al Usuario ', 'Compartida', 'CPU', 'HP', 'Compaq dc5800', 'MXJ8350D7Q', '20020-0012-83', 'Pentium 4', 'DDR2', 2, 'HDD / SATA', '160', 'Windows 7', '2024-05-14 14:43:35', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Recepción Emergencia', ''),
(44, 'Atención al Usuario ', 'Compartida', 'Teclado', 'HP', 'sk-2880', 'BC337OFVBW43ZZ', '20020-XXXX-85', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-05-14 14:49:52', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Recepción Emergencia ', ''),
(45, 'Cuarto de Datos', 'Omar Mendoza', 'Router', 'TP-LINK', 'N750', '13972700587', '20020-XXXX-1270', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 10:58:55', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Cuarto de datos', 'Router principal'),
(46, 'Cuarto de Datos', 'Omar Mendoza', 'Router', 'DLINK', 'DIR-601', 'QB1O1A2010454', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 14:23:11', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Cuarto de Datos', 'Equipo pertenece al Ing. Geyker Rodriguez'),
(47, 'Emergencia', 'Dr. Andres Salazar', 'Router', 'MERCUSYS', '', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:21:59', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Encima de techo raso de oficina de médicos en emergencia.', 'Equipo propiedad del Dr. Salazar.'),
(48, 'Administración ', 'Omar Mendoza', 'Router', 'PIXLINK', '', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:24:22', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Administracion sobre escritorio de Lcda. Lirimar.', ''),
(49, 'Infraestructura', 'Omar Mendoza', 'Router', 'PIXLINK2', 'N300', '2021123478M', '20020-XXXX-1002', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:26:40', 2, '2024-06-05 15:30:01', 2, 'Activo', 'Oficina de infraestructura', ''),
(50, 'Administración ', 'Omar Mendoza', 'Router', 'Tp-LINK WA5210G', 'TL-WA5210G', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:44:54', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Administración detras del mueble de la impresora Canon. ', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios`
--

CREATE TABLE `historial_cambios` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `campo_modificado` varchar(50) NOT NULL,
  `valor_anterior` varchar(50) NOT NULL,
  `valor_nuevo` varchar(50) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  `encargado_modificacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_fijas`
--

CREATE TABLE `ip_fijas` (
  `id` int(11) NOT NULL,
  `departamento` varchar(60) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `fecha_registro` date NOT NULL,
  `encargado_registro` int(11) NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `encargado_modificacion` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ip_fijas`
--

INSERT INTO `ip_fijas` (`id`, `departamento`, `id_equipo`, `descripcion`, `ip`, `fecha_registro`, `encargado_registro`, `fecha_modificacion`, `encargado_modificacion`, `estado`) VALUES
(7, 'Informática', 3, '', '192.168.15.250', '2024-04-23', 1, '0000-00-00', 0, 'Activo'),
(8, 'Bienes ', 23, '', '192.168.15.253', '2024-04-23', 1, '0000-00-00', 0, 'Activo'),
(9, 'Servicios Generales', 11, '', '192.168.15.254', '2024-04-23', 1, '0000-00-00', 0, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_red`
--

CREATE TABLE `puntos_red` (
  `id` int(11) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `patch_panel` varchar(50) NOT NULL,
  `puerto_pp` int(2) NOT NULL,
  `switches` varchar(50) NOT NULL,
  `puerto_sw` int(2) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `encargado_registro` int(11) NOT NULL,
  `fecha_ultima_modificacion` datetime NOT NULL,
  `encargado_modificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puntos_red`
--

INSERT INTO `puntos_red` (`id`, `departamento`, `patch_panel`, `puerto_pp`, `switches`, `puerto_sw`, `descripcion`, `estado`, `fecha_registro`, `encargado_registro`, `fecha_ultima_modificacion`, `encargado_modificacion`) VALUES
(1, 'Dirección Medica', '1', 3, '', 0, 'Consultorio de Eco', 'Inactivo', '2024-02-28 10:48:30', 0, '0000-00-00 00:00:00', 0),
(3, 'Dirección Medica', '1', 14, '', 0, 'Consultorio Pediatría Teléfono', 'Inactivo', '2024-02-28 10:50:38', 0, '0000-00-00 00:00:00', 0),
(4, 'Dirección Medica', '1', 15, '', 0, 'Consultorio de Pediatría', 'Inactivo', '2024-02-28 10:55:47', 0, '2024-02-29 14:49:07', 0),
(5, 'Dirección Medica', '1', 16, '', 0, 'Consultorio de Ginecología ', 'Inactivo', '2024-02-28 10:56:20', 0, '0000-00-00 00:00:00', 0),
(6, 'Dirección Medica', '1', 17, '', 0, 'Estación de Trabajo Imagenología (RX)', 'Activo', '2024-02-28 10:57:01', 0, '2024-02-28 12:27:58', 0),
(7, 'Historias Medicas ', '1', 18, '1', 16, 'Puesto de Enfermera Consulta', 'Activo', '2024-02-28 10:57:47', 0, '2024-04-26 16:24:33', 0),
(8, 'Recursos Humanos', '1', 19, '1', 15, 'Recursos Humanos', 'Activo', '2024-02-28 10:58:54', 0, '2024-04-26 16:26:46', 0),
(9, 'Call Center', '1', 21, '', 0, 'Area de Call Center (Puesto 1)', 'Activo', '2024-02-28 11:00:43', 0, '0000-00-00 00:00:00', 0),
(10, 'Call Center', '1', 23, '', 0, 'Area de Call Center (Puesto 2)', 'Activo', '2024-02-28 11:02:24', 0, '0000-00-00 00:00:00', 0),
(11, 'Call Center', '1', 24, '', 0, 'Georgette Mardelli', 'Activo', '2024-02-28 11:03:10', 0, '0000-00-00 00:00:00', 0),
(12, 'Dirección Medica', '2', 1, '', 0, 'Consultorio Medicina Familiar', 'Inactivo', '2024-02-28 11:03:45', 0, '0000-00-00 00:00:00', 0),
(13, 'Dirección Medica', '2', 2, '', 0, 'Laboratorio', 'Inactivo', '2024-02-28 11:04:03', 0, '0000-00-00 00:00:00', 0),
(14, 'Call Center', '2', 5, '', 0, 'Area de Call Center (Puesto 4)', 'Inactivo', '2024-02-28 11:04:22', 0, '0000-00-00 00:00:00', 0),
(15, 'Seguridad', '2', 6, '', 0, 'Seguridad', 'Activo', '2024-02-28 11:04:58', 0, '0000-00-00 00:00:00', 0),
(16, 'Almacén', '2', 7, '', 0, 'Almacén', 'Activo', '2024-02-28 11:05:19', 0, '0000-00-00 00:00:00', 0),
(17, 'Farmacia', '2', 10, '', 0, 'Farmacia', 'Activo', '2024-02-28 11:05:36', 0, '0000-00-00 00:00:00', 0),
(18, 'Dirección Medica', '2', 13, '', 0, 'Consultorio Traumatologia', 'Inactivo', '2024-02-28 11:05:51', 0, '0000-00-00 00:00:00', 0),
(19, 'Recepción ', '2', 17, '', 0, 'Recepción ', 'Activo', '2024-02-28 11:07:29', 0, '0000-00-00 00:00:00', 0),
(20, 'Recepción ', '2', 18, '', 0, 'Recepción Teléfono ', 'Activo', '2024-02-28 11:07:46', 0, '0000-00-00 00:00:00', 0),
(21, 'Call Center', '2', 20, '', 0, 'Area de Call Center (Puesto 3)', 'Activo', '2024-02-28 11:08:11', 0, '0000-00-00 00:00:00', 0),
(22, 'Administración ', '1', 1, '', 0, 'Administración', 'Activo', '2024-02-28 11:09:56', 0, '2024-02-29 14:49:46', 0),
(23, 'Administración ', '1', 2, '', 0, 'Administración Deinor', 'Activo', '2024-02-28 11:10:24', 0, '0000-00-00 00:00:00', 0),
(24, 'Recursos Humanos', '1', 20, '1', 10, '2do pc dentro de la oficina de rrhh', 'Activo', '2024-04-26 16:28:15', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `username`, `password`, `rol`) VALUES
(1, 'Frank', 'Guiche', 'FrankGuiche', 'admin', 1),
(2, 'Omar', 'Mendoza', 'OmarM', 'admin', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso_routers`
--
ALTER TABLE `acceso_routers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `acta_revision`
--
ALTER TABLE `acta_revision`
  ADD PRIMARY KEY (`id_acta`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ip_fijas`
--
ALTER TABLE `ip_fijas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntos_red`
--
ALTER TABLE `puntos_red`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso_routers`
--
ALTER TABLE `acceso_routers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_fijas`
--
ALTER TABLE `ip_fijas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `puntos_red`
--
ALTER TABLE `puntos_red`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
