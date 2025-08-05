-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 18:27:45
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acceso_routers`
--

INSERT INTO `acceso_routers` (`id`, `id_equipo`, `direccion_ip`, `wan_ip`, `nombre`, `contraseña`, `usuario_acceso`, `contraseña_acceso`, `visibilidad`, `filtro_mac`, `uso`, `ubicacion`, `fecha_registro`, `encargado_registro`, `fecha_modificacion`, `encargado_modificacion`, `estado`) VALUES
(6, 17, '192.168.1.1', '192.168.15.101', 'clinica', 'clinicadelostrabajadores', '', 'FasGanZ19', 'Visible', 'No', 'Router', 'Emergencias', '2024-05-28', 1, '0000-00-00', 0, 'Activo');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acta_revision`
--

INSERT INTO `acta_revision` (`id_acta`, `fecha_revision`, `unidad_trabajo`, `responsable_uso`, `descripcion_equipo`, `serial`, `codigo_bienes`, `estado_equipo`, `operatividad`, `accesorios_perifericos`, `resultado_revision`, `conclusion_revision`, `user_elaboracion`, `user_revision`) VALUES
(1, '2024-06-05', 'Departamento de Reclutamiento y Selección ', 'Equis', 'CPU marca equis del modelo equis colo equis mas equis y equis', 'XXX34533', '20202020', 'BUENO', 'ENCIENDE', 'No aplica.', '-Se relizo equis cosa', '- Se hizo equis por dos.', '', ''),
(2, '2024-06-05', 'Infraestructura', 'Equis', 'Monitor', '54564556', '366', 'BUENO', 'ENCIENDE', '-No aplica.', '-Equisss', '-Equissjjjj', '', ''),
(3, '2024-05-08', 'Bienes', 'Eudalys Rojas', 'CPU SIRAGON PC-1500 COLOR NEGRO', '150819P20276SP0272', '3-1800-137-2-370', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Presentaba lentitud en su sistema operativo, lo que afectaba su rendimiento general.\r\n- El paquete de Office no se puede activar.\r\n- El equipo no cuenta con los requerimientos básicos para los programas de arquitectura y diseño. \r\n- Su procesador es doble núcleo y es de muy poca capacidad para el consumo de estos programas.\r\n- Con cada actualización que realiza el sistema operativo (Windows 10) el equipo queda mas cargado y consumiendo mas recursos.', '- Se realizó mantenimiento tanto de hardware como al software.\r\n- Se recomienda eliminar archivos que no sean necesarios para liberar espacio en el disco.\r\n- Realizar un respaldo para formatear e instalar el sistema operativo nuevamente.\r\n- Instalar los programas de diseño y arquitectura de versiones de años anteriores para que el equipo pueda funcionar de mejor manera.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(4, '2024-05-08', 'Recepción ', 'Equis', 'CPU SONEVIEW, PC-1005, COLOR NEGRO', '150716P20260SP0057', '20020-0012-353', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Equipo se encontraba en buen estado.', '- Se realizó mantenimiento preventivo tanto de hardware como de software.', 'Frank Guiche', 'Omar Mendoza'),
(5, '2022-10-26', 'Dirección Medica ', 'Equis', 'Regulador de voltaje Tonal, modelo RTL-1000 color negro', '13355501414', '20990-0001-60', 'REGULAR', 'ENCIENDE', '- No Aplica.', '-El transformador se encuentra dañado y es lo que produce un ruido fuerte en el equipo. ', '-Desconectando los cables internos del transformador el equipo se puede utilizar como regleta (sin ningún tipo de protección).\r\n-Sustituir el transformador por otro del mismo modelo de regulador que se encuentre en buen estado.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(19, 'Recepción ', 'Activo', '2024-02-28 16:07:18', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `departamento`, `usuario_responsable`, `tipo_equipo`, `marca`, `modelo`, `serial`, `codigo_bienes`, `procesador`, `tipo_ram`, `cant_memoria`, `tipo_disco`, `almacenamiento`, `sistema_operativo`, `fecha_registro`, `encargado_registro`, `fecha_ultima_modificacion`, `encargado_modificacion`, `estado`, `ubicacion`, `observaciones`) VALUES
(2, 'Informática', 'Omar Mendoza', 'Mouse', 'IMEXX', 'IME-26985', '993015825', '0005', '', '', 0, '', '', '', '2024-02-07 12:35:28', 1, '2024-02-29 13:54:59', 1, 'Activo', 'Infraestructura', ''),
(3, 'Informática', 'Omar Mendoza', 'CPU', 'VIT', 'E2220-03', 'A000710371', '20020-0012-435', 'Intel I7 3770K 3.40Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'WINDOWS 10 ', '2024-02-07 12:38:19', 1, '2024-02-07 15:33:19', 1, 'Activo', 'Infraestructura', ''),
(10, 'Informática', 'Omar Mendoza', 'Monitor', 'Aiteg', 'W90221S5-D', 'W921S5D-D7NZ2B15-01880L', '20020-XXX-397', '', '', 0, '', '', '', '2024-02-07 15:35:12', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Infraestructura', ''),
(11, 'Servicios Generales', 'Richard Rodríguez', 'CPU', 'SIRAGON', 'PC-1005', '150819P20276SP0272', '', 'Intel G2030 3.00Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'Windows 10', '2024-02-07 15:43:30', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Infraestructura', ''),
(12, 'Servicios Generales', 'Richard Rodríguez', 'Mouse', 'LOGITECH', 'M-105', '1230HC00SN18', '', '', '', 0, '', '', '', '2024-02-07 15:49:22', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Infraestructura', ''),
(13, 'Administración ', 'Deinor Figuera', 'CPU', 'THERMAL MASTER', '', '', '', 'Intel Celeron CPU G1610@2.60Ghz', 'DDR3', 2, 'HDD / SATA', '1000', 'Windows 7', '2024-02-07 15:52:27', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Administración ', ''),
(14, 'Administración ', 'Katherine Álvarez', 'Laptop', 'Lenovo', 'G480', 'MB00354255', '', 'Intel Pentium B970 2.30 GHZ', 'DDR3', 4, 'HDD / SATA', '500', 'Windows 7', '2024-02-07 16:11:09', 1, '0000-00-00 00:00:00', 1, 'Activo', 'Administración', ''),
(17, 'Informática', 'dd', 'Router', 'Equis', 'Equis 2', '202020', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-11 11:56:42', 1, '2024-04-11 14:48:06', 1, 'Inactivo', 'dsda', ''),
(18, 'Farmacia', 'Equis', 'Laptop', 'asas', 'asasa', 'sasas', '2000-52-525-32', 'asas', 'DDR2', 2, 'HDD / SATA', '200', 'asasas', '2019-12-07 05:20:44', 1, '0000-00-00 00:00:00', 0, 'Activo', 'ssnksnkdn', ''),
(19, 'Atención al Usuario ', 'asasas', 'Teclado', 'asas', 'asaasa', 'asasas', 'sasasasa', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 12:16:16', 1, '2024-04-17 12:20:53', 1, 'Activo', 'uvicaa', 'observacion equisasasss');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ip_fijas`
--

INSERT INTO `ip_fijas` (`id`, `departamento`, `id_equipo`, `descripcion`, `ip`, `fecha_registro`, `encargado_registro`, `fecha_modificacion`, `encargado_modificacion`, `estado`) VALUES
(5, 'Administración ', 13, '', '192.168.15.256', '2024-03-07', 1, '0000-00-00', 0, 'Activo'),
(6, 'Informática', 3, 'asasa', '192.168.15.250', '2024-03-07', 1, '2024-03-07', 1, 'Activo');

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
  `encargado_registro` varchar(50) NOT NULL,
  `fecha_ultima_modificacion` datetime NOT NULL,
  `encargado_modificacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puntos_red`
--

INSERT INTO `puntos_red` (`id`, `departamento`, `patch_panel`, `puerto_pp`, `switches`, `puerto_sw`, `descripcion`, `estado`, `fecha_registro`, `encargado_registro`, `fecha_ultima_modificacion`, `encargado_modificacion`) VALUES
(1, 'Dirección Medica', '1', 3, '', 0, 'Consultorio de Eco', 'Inactivo', '2024-02-28 10:48:30', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(3, 'Dirección Medica', '1', 14, '', 0, 'Consultorio Pediatría Teléfono', 'Inactivo', '2024-02-28 10:50:38', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(4, 'Dirección Medica', '1', 15, '', 0, 'Consultorio de Pediatría', 'Inactivo', '2024-02-28 10:55:47', 'Frank Guiche', '2024-02-29 14:49:07', 'Frank Guiche'),
(5, 'Dirección Medica', '1', 16, '', 0, 'Consultorio de Ginecología ', 'Inactivo', '2024-02-28 10:56:20', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(6, 'Dirección Medica', '1', 17, '', 0, 'Estación de Trabajo Imagenología (RX)', 'Activo', '2024-02-28 10:57:01', 'Frank Guiche', '2024-02-28 12:27:58', 'Frank Guiche'),
(7, 'Dirección Medica', '1', 18, '', 0, 'Puesto de Enfermera Consulta', 'Activo', '2024-02-28 10:57:47', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(8, 'Recursos Humanos', '1', 19, '', 0, 'Recursos Humanos', 'Activo', '2024-02-28 10:58:54', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(9, 'Call Center', '1', 21, '', 0, 'Area de Call Center (Puesto 1)', 'Activo', '2024-02-28 11:00:43', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(10, 'Call Center', '1', 23, '', 0, 'Area de Call Center (Puesto 2)', 'Activo', '2024-02-28 11:02:24', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(11, 'Call Center', '1', 24, '', 0, 'Georgette Mardelli', 'Activo', '2024-02-28 11:03:10', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(12, 'Dirección Medica', '2', 1, '', 0, 'Consultorio Medicina Familiar', 'Inactivo', '2024-02-28 11:03:45', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(13, 'Dirección Medica', '2', 2, '', 0, 'Laboratorio', 'Inactivo', '2024-02-28 11:04:03', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(14, 'Call Center', '2', 5, '', 0, 'Area de Call Center (Puesto 4)', 'Inactivo', '2024-02-28 11:04:22', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(15, 'Seguridad', '2', 6, '', 0, 'Seguridad', 'Activo', '2024-02-28 11:04:58', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(16, 'Almacén', '2', 7, '', 0, 'Almacén', 'Activo', '2024-02-28 11:05:19', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(17, 'Farmacia', '2', 10, '', 0, 'Farmacia', 'Activo', '2024-02-28 11:05:36', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(18, 'Dirección Medica', '2', 13, '', 0, 'Consultorio Traumatologia', 'Inactivo', '2024-02-28 11:05:51', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(19, 'Recepción ', '2', 17, '', 0, 'Recepción ', 'Activo', '2024-02-28 11:07:29', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(20, 'Recepción ', '2', 18, '', 0, 'Recepción Teléfono ', 'Activo', '2024-02-28 11:07:46', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(21, 'Call Center', '2', 20, '', 0, 'Area de Call Center (Puesto 3)', 'Activo', '2024-02-28 11:08:11', 'Frank Guiche', '0000-00-00 00:00:00', ''),
(22, 'Administración ', '1', 1, '', 0, 'Administración', 'Activo', '2024-02-28 11:09:56', 'Frank Guiche', '2024-02-29 14:49:46', 'Frank Guiche'),
(23, 'Administración ', '1', 2, '', 0, 'Administración Deinor', 'Activo', '2024-02-28 11:10:24', 'Frank Guiche', '0000-00-00 00:00:00', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `username`, `password`, `rol`) VALUES
(1, 'Frank', 'Guiche', 'FrankG', 'admin', 1),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_fijas`
--
ALTER TABLE `ip_fijas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `puntos_red`
--
ALTER TABLE `puntos_red`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
