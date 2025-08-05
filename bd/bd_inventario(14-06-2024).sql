-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2024 a las 20:53:47
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
(6, 46, '192.168.10.1', '192.168.15.179', 'clinica', 'clinicadelostrabajadores', 'admin', 'FasGanZ19', 'Visible', 'No', 'Wifi para todos', 'Cuarto de Datos', '2024-06-04', 2, '2024-06-07', 1, 'Activo'),
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

--
-- Volcado de datos para la tabla `acta_revision`
--

INSERT INTO `acta_revision` (`id_acta`, `fecha_revision`, `unidad_trabajo`, `responsable_uso`, `descripcion_equipo`, `serial`, `codigo_bienes`, `estado_equipo`, `operatividad`, `accesorios_perifericos`, `resultado_revision`, `conclusion_revision`, `user_elaboracion`, `user_revision`) VALUES
(1, '2022-10-19', 'Almacén', 'Lcdo. Erasto Marcano', 'Impresora Hp Deskjet Ink Advantage 1515', 'CN3551HHGW', '20990-0001-558', 'BUENO', 'ENCIENDE', '-No tiene el cable regulador de corriente. - No tiene cable USB. \r\n-No tiene ninguno de los dos cartuchos de tinta. - Falta bandeja de salida de impresión. ', '-El equipo enciende, se conecta al computador por medio del cable usb.\r\n-Funciona correctamente para escanear.\r\n-No pude realizar pruebas de impresión porque no tiene los cartuchos de tinta.', '-Comprar los cartuchos de tinta hp 662 negro y color para poder realizar las pruebas de impresión.\r\n', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(2, '2022-10-19', 'Almacén ', 'Lcdo. Erasto Marcano', 'Regulador de Voltaje Kode', 'NO TIENE', '209990-0001-413', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Se observa que el cable de corriente fue cambiado y se encuentra empatado con uno mas delgado de menor numero, de igual manera el equipo funciona correctamente.', '- Cambiar el cable de corriente que se encuentra empatado por uno de su mismo calibre.\r\n- O colocar un enchufe directamente en el cable original del regular. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(3, '2022-10-19', 'Seguridad y Vigilancia', 'Eusebio Sánchez', 'Impresora Hp Deskjet Ink Advantage 1515', 'CN3AC17MSG', '20990-0001-84', 'BUENO', 'ENCIENDE', '- No tiene el cable regulador de corriente. - No tiene cable USB. \r\n- No tiene ninguno de los dos cartuchos de tinta.', '- El equipo enciende, se conecta al computador por medio del cable USB.\r\n- Funciona correctamente para escanear.\r\n- No pude realizar pruebas de impresión porque no tiene los cartuchos de tinta.', '- Comprar los cartuchos de tinta hp 662 negro y color para poder realizar las pruebas de impresión.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(4, '2022-10-19', 'Seguridad y Vigilancia', 'Eusebio Sánchez', 'Monitor Marca Lg Modelo 20M37A-B', '501NDXQ1W642', '20020-XXXX-488', 'BUENO', 'ENCIENDE', '- No tiene el cable regulador de corriente.', '- El monitor enciende y funciona perfectamente.', '- Comprar cable regulador de voltaje LG Ac Adaptor, Modelo: LCAP36-A 19V 0.84A. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(5, '2022-10-19', 'Auditoria', 'Marisol Flores', 'Regulador de Voltaje Kode', '130129-01014546', '20990-0001-420', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- Se observa que el cable de corriente fue cambiado y se encuentra empatado.\r\n- El transformador se encuentra dañado y es lo que produce un ruido fuerte en el equipo. ', '- Desconectando los cables internos del transformador el equipo se puede utilizar como regleta (sin ningún tipo de protección).\r\n- Sustituir el transformador por otro del mismo modelo de regulador que se encuentre en buen estado.\r\n- Colocar un enchufe directamente en el cable original del regular. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(6, '2022-10-26', 'Auditoria', 'Marisol Flores', 'Impresora/Scanner Hp, Modelo Deskjet Ink Advantage 4615, Color negro y Beige.', 'Impresora/Scanner Hp, Modelo Deskjet Ink Advantage 4615, Color negro y Beige.', '20990-0001-66', 'BUENO', 'ENCIENDE', '- Tiene 4 cartuchos de tinta 670 (Negro, Magenta, Azul y Amarillo).\r\n- No tiene cable usb.', '- Al encender la impresora presenta error por pantalla que dice \"Cartucho Hp protegido instalado. Reemplazar cartucho\". \r\n- Los cartuchos se encuentran protegidos por una aplicación propia de la impresora para evitar el robo o cambio de cartuchos.\r\n- La impresora escanea sin problemas.\r\n- No se pudieron hacer pruebas de impresión por el error que presentan los cartuchos. ', '- Sustituir los cartuchos de tinta, ya que los mismo se encuentran bloqueados para hacer las pruebas de impresión.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(7, '2022-10-26', 'Administración ', 'Deinor Figuera', 'Router Tplink Modelo: TL-WA5210G', '135A9201203', '20020-XXXX-63', 'BUENO', 'ENCIENDE', '- Tiene su cable regulador de corriente.\r\n- Tiene su adaptador poe tplink. ', '- El equipo enciende, se ve físicamente en buen estado y funciona correctamente.\r\n- Se puede configurar como AP o Router comun.\r\n- Se puede administrar entrando en su pagina de configuración. (192.168.1.254) admin admin.', '- El router se encuentra operativo para ser utilizado.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(8, '2022-10-28', 'Dirección Medica ', 'Mariana Martínez ', 'Regulador de voltaje Tonal, modelo RTL-1000 color negro', '13355501414', '20990-0001-60', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- El transformador se encuentra dañado y es lo que produce un ruido fuerte en el equipo. \r\n- Goma protectora del cable se encentra roto en la punta del enchufe.', '- Desconectando los cables internos del transformador el equipo se puede utilizar como regleta (sin ningún tipo de protección).\r\n- Sustituir el transformador por otro del mismo modelo de regulador que se encuentre en buen estado.\r\n', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(9, '2022-11-07', 'Seguridad y Vigilancia', 'Eusebio Sánchez', 'Impresora Hp Deskjet Ink Advantage 2515', 'CN2CU3JNSX', '20990-0001-564', 'BUENO', 'OTRO', '- No tiene cable regulador de corriente.\r\n- No tiene cable USB. -No tiene cartuchos de tinta 662.', '- La impresora se observa en buen estado físico.\r\n- Se ubico prestado un regulador del mismo voltaje para realizar las pruebas.\r\n- Se verifico el escáner y funciona correctamente.\r\n- No se pudo verificar la parte de la impresión por la falta de los cartuchos.', '- Ubicar / comprar un regulador de impresora hp de 33v para poder encenderla y realizar las pruebas de funcionamiento.\r\n- Ubicar / comprar los cartuchos de tinta hp 662 para poder realizar pruebas de impresión. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(10, '2022-11-07', 'Farmacia ', 'Manuel Freites', 'Impresora Hp modelo desk jet ink advantage 1515', 'CN37Q19J9B', '20990-0001-11', 'BUENO', 'ENCIENDE', '- No tiene cable USB. \r\n- No tiene ninguno de los dos cartuchos de tinta 662.', '- El equipo enciende, se conecta al computador por medio del cable usb.\r\n- Funciona correctamente para escanear.\r\n- No pude realizar pruebas de impresión porque no tiene los cartuchos de tinta.', '- Comprar los cartuchos de tinta hp 662 negro y color para poder realizar las pruebas de impresión.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(11, '2022-11-07', 'RRHH', 'Luzmila Narváez', 'Teclado Marca USA - NET, color negro', 'SIN SERIAL', '20020-XXXX-417', 'REGULAR', 'NO ENCIENDE', '- No Aplica.', '- Se observa en buen estado, tiene roto el conector PS2 por tal motivo no se puede conectar a la PC.', '- Desincorporar. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(12, '2022-11-07', 'Ginecología ', '', 'Samsung modelo xpress m 2020 ', '070JB8GF9CU1HKP', '209900001-1', 'REGULAR', 'ENCIENDE', '- No tiene tóner.  - No tiene cable de corriente.\r\n- No tiene cable USB.', '- Se observa que el botón de encendido esta dañado , pero a un así enciende, se le coloco un tóner de prueba y la impresora imprime sin problemas.', '- Es necesario ubicar / comprar cable de corriente y tóner samsung 111 para tener la impresora operativa. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(13, '2022-11-09', 'Informática ', 'Omar Mendoza ', 'Teclado Marca Vit, modelo DOK-K5313 modelo KDB803K12947A', 'SKD803K12947A', '20020-XXXX-433', 'REGULAR', 'ENCIENDE', '- No Aplica. ', '- El teclado se mojo por una filtración en el techo de infraestructura, la parte de los números superiores no funcionan, las demás teclas si funcionan.', '-Se puede utilizar como ultimo recurso temporal para solventar alguna eventualidad.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(14, '2022-11-09', 'Informática ', 'Omar Mendoza ', 'Teclado PS2 USA-NET color negro', 'SIN SERIAL', '20020-XXXX-1231', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- El teclado enciende pero se encuentra dañado.\r\n- No marca ninguna tecla.', '- Desincorporar.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(15, '2022-11-09', 'Infraestructura', '.', 'CPU Marca USA - NET ', 'SIN SERIAL', '20020-0012-1461', 'DETERIORADO', 'NO ENCIENDE', '- No tiene cable de corriente.', '- El CPU pertenece al área de Laboratorio, por fallas eléctricas no enciende fuente de poder, disco duro y tarjeta madre.\r\n- Memoria RAM DDR3 de 2GB si funciona.', '- Desincorporar.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(16, '2022-11-11', 'Infraestructura', '', 'CPU Marca USA - NET ', 'SIN SERIAL', '20020-0012-1462', 'DETERIORADO', 'NO ENCIENDE', '- No tiene cable de corriente.', '- El CPU pertenece al área de recepción, se encuentra quemado por falla eléctrica de la calle, lo cual daño también el toma-corriente. ', '- Desincorporar.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(17, '2022-11-14', 'Infraestructura', '', 'Unidad de lectora dvd para pc', 'R8WS6YDD3008H0', '20990-0001-1469', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Funciona de manera correcta.', '- Puede ser utilizada o asignada para sustituir lectora dañada.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(18, '2022-11-18', 'Infraestructura', '', 'Impresora Multifuncional HP SNPRC-1005-01', 'MY223310J0', '20990-0001-1465', 'BUENO', 'ENCIENDE', '- Tiene sus 4 cartuchos de tintas y sus cables.', '- La impresora presenta fallas con el cabezal de impresión, se le realizo el procedimiento de retirar el cabezal y sacar los cartuchos pero el problema persiste.\r\n- El equipo funciona para escanear con un poco de ruido. ', '- Sustituir el cabezal de impresión.\r\n- Realizarle mantenimiento por el tiempo que la impresora tiene sin uso.\r\n- Comprar / recargar los cartuchos de tintas. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(19, '2022-12-02', 'Infraestructura', '', 'Fuente de Poder para pc MYO-500W P4 1408005112', 'SIN SERIAL', '20020-XXXX-1470', 'DETERIORADO', 'NO ENCIENDE', '- No Aplica.', '- La fuente de poder se encuentra dañada.', '- Desincorporar.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(20, '2022-12-02', 'Infraestructura', '', 'Switch Teralink 24 Puertos SW24213817', 'SW24213817', '20020-XXXX-1472', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- El equipo enciende el led verde de PW pero no hace su función de Switch.', '- Desincorporar. ', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(21, '2022-12-02', 'Infraestructura', '', 'Switch Teralink 24 Puertos SW24215993', 'SW24215993', '20020-XXXX-1473', 'REGULAR', 'NO ENCIENDE', '- No Aplica.', '- El equipo no enciende.', '- Desincorporar.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(22, '2022-12-02', 'Infraestructura', '', 'Switch Encore 8 Puertos ENH908NWY-NA', 'SW24215993', '20020-XXXX-1471', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- El equipo funciona pero tiene problemas en el conector de corriente el cual se puede apagar o desconectar si se mueve. ', '- Puede ser usado como ultimo recurso siempre y cuando el cable de corriente se encuentre fijo.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(23, '2022-12-23', 'Seguridad y Vigilancia', '', 'Hikvion modelo DS-7216HVI-ST/SE', '412295560', '', 'REGULAR', 'NO ENCIENDE', '- No tiene su regulador original. ', '- El equipo grabado no tiene su cable del regulador original.\r\n- El equipo no enciende, no muestra vídeo en pantalla, no pita.\r\n- Ya el disco duro del equipo se había dañado, se le coloco un disco en buen estado y daño.', '- Llevar el equipo a un soporte técnico.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza'),
(24, '2023-05-15', 'Administración ', 'Deinor Figuera', 'Protector AVTEK R8T 601', '05662015013568', '20990-0001-61', 'DETERIORADO', 'NO ENCIENDE', '- No aplica.', '- El equipo no enciende, transformador dañado.', '- Desincorporar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(25, '2024-02-21', 'Cuarto de Datos', 'Omar Mendoza ', 'TP-LINK TL-SG1024D', '2157264004811', '20020-999-39', 'REGULAR', 'ENCIENDE', '- No Aplica.', '- El equipo no funciona de manera correcta.', '- Desmontaje del equipo para revisión profunda.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(26, '2024-02-21', 'Bienes', 'Josué Carrizales', 'MICROCOMPUTADOR MARCA TOSHIBA MODELO SATELITE e557-a5320', '13026497P', '20020-0007-464', 'BUENO', 'ENCIENDE', '- No aplica.', '- La laptop presentaba lentitud en su sistema operativo, lo que afectaba su rendimiento general.\r\n- Experimentaba fallas de apagados repentinos incluso estando conectada a la corriente, causados por problemas de gestión de energía relacionados con la batería.', '- Se procedió a realizar un respaldo de la información almacenada en el disco duro.\r\n- Se procedió a formatear el sistema y reinstalar Windows para abordar la lentitud del sistema operativo.\r\n- Se procedió a desconectar la batería y se operó la laptop directamente con alimentación eléctrica, después de este proceso se eliminaron los apagados repentinos.\r\n- Se sugiere adquirir una batería de remplazo para evitar daños potenciales por operar continuamente con alimentación eléctrica directa.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(27, '2024-04-02', 'Presidencia', 'Jenny Gómez', 'CPU SONEVIEW, PC-1005, COLOR NEGRO', '150716P20260SP0057', '20020-0012-353', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Presentaba lentitud en su sistema operativo, lo que afectaba su rendimiento general.\r\n- Experimentaba fallas de conexión al no reconocer la Impresora.', '- Se procedió a realizar un respaldo de la información almacenada en el disco duro.\r\n- Se procedió a formatear el sistema y reinstalar Windows para abordar la lentitud del sistema operativo y solucionar el problema de conexión con la impresora.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(28, '2024-04-10', 'Seguridad y Vigilancia', 'Eusebio Sánchez', 'LAPTOP LENOVO MODELO G485', 'MB00257341', '02-448', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Presentaba lentitud en su sistema operativo, lo que afectaba su rendimiento general.', '- Se procedió a realizar un respaldo de la información almacenada en el disco duro.\r\n- Se procedió a formatear el sistema y reinstalar Windows para abordar la lentitud del sistema operativo.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(29, '2024-04-10', 'Cuarto de Datos', 'Omar Mendoza ', 'CPU SERVIDOR COLOR NEGRO', 'SIN SERIAL', '', 'BUENO', 'ENCIENDE', '- No aplica.', '- Presentaba problemas para activar la licencia del sistema operativo Windows.', '- Se procedió a realizar un respaldo de la información almacenada en el disco duro.\r\n- Se procedió a formatear el sistema y reinstalar Windows para abordar el problema con la activación del sistema operativo.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(30, '2024-04-24', 'Historias Médicas ', 'Maribel Farias ', 'CPU DELL OPTIPLEX MODELO 7010 #35', 'HP7HB04', '20020-0012-1547', 'BUENO', 'ENCIENDE', '- Incluye mouse, teclado y cable de corriente.', '- Equipo se encontraba nuevo.', '- Se configuro el sistema operativo Windows 11.\r\n- Se instalo el paquete de Office 2016, Intranet y WinRar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(31, '2024-04-24', 'Dirección de Gestión Administrativa ', 'Deinor Figuera', 'CPU DELL OPTIPLEX MODELO 7010 #40', 'CXJP6Z3', '20020-0012-1559', 'BUENO', 'ENCIENDE', '- Incluye mouse, teclado y cable de corriente.', '- Equipo se encontraba nuevo.', '- Se configuro el sistema operativo Windows 11.\r\n- Se instalo el paquete de Office 2016, Intranet y WinRar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(32, '2024-04-24', 'Presidencia', 'Jenny Gómez', 'CPU DELL OPTIPLEX MODELO 7010 #57', 'J4XK6Z3', '20020-0012-1559', 'BUENO', 'ENCIENDE', '- Incluye mouse, teclado y cable de corriente.', '- Equipo se encontraba nuevo.', '- Se configuro el sistema operativo Windows 11.\r\n- Se instalo el paquete de Office 2016, Intranet y WinRar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(33, '2024-04-24', 'Bienes', 'Josué Carrizales', 'CPU DELL OPTIPLEX MODELO 7010 #50', 'HQ7HB04', '20020-0012-1551', 'BUENO', 'ENCIENDE', '- Incluye mouse, teclado y cable de corriente.', '- Equipo se encontraba nuevo.', '- Se configuro el sistema operativo Windows 11.\r\n- Se instalo el paquete de Office 2016, Intranet y WinRar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(34, '2024-04-24', 'Nómina ', 'Jorman Leon', 'CPU DELL OPTIPLEX MODELO 7010 #32', '93KP6Z3', '20020-0012-1543', 'BUENO', 'ENCIENDE', '- Incluye mouse, teclado y cable de corriente.', '- Equipo se encontraba nuevo.', '- Se configuro el sistema operativo Windows 11.\r\n- Se instalo el paquete de Office 2016, Intranet y WinRar.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(35, '2024-05-08', 'Recepción ', '', 'CPU SONEVIEW, PC-1005, COLOR NEGRO', '150716P20260SP0057', '20020-0012-353', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Equipo se encontraba en buen estado.', '- Se realizó mantenimiento preventivo tanto de hardware como de software.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(36, '2024-05-08', 'Bienes', 'Eudalys Rojas', 'CPU SIRAGON PC-1500 COLOR NEGRO', '150819P20276SP0272', '370', 'BUENO', 'ENCIENDE', '- No Aplica.', '- Presentaba lentitud en su sistema operativo, lo que afectaba su rendimiento general.\r\n- El paquete de Office no se puede activar.\r\n- El equipo no cuenta con los requerimientos básicos para los programas de arquitectura y diseño. \r\n- Su procesador es doble núcleo y es de muy poca capacidad para el consumo de estos programas.\r\n- Con cada actualización que realiza el sistema operativo (Windows 10) el equipo queda mas cargado y consumiendo mas recursos.', '- Se realizó mantenimiento tanto de hardware como al software.\r\n- Se recomienda eliminar archivos que no sean necesarios para liberar espacio en el disco.\r\n- Realizar un respaldo para formatear e instalar el sistema operativo nuevamente.\r\n- Instalar los programas de diseño y arquitectura de versiones de años anteriores para que el equipo pueda funcionar de mejor manera.', 'Frank Guiche', 'Ing. Omar Mendoza'),
(37, '2024-06-12', 'Atención al Usuario', '', 'TELÉFONO SIEMENS', 'P30M32200163', '', 'REGULAR', 'ENCIENDE', '', '- El equipo enciende y da tono pero no tiene entrada ni salida de voz por diodos en la placa principal dañados.', '- Sustituir placa principal por otra del mismo modelo.\r\n- Desincorporar teléfono.', 'Ing. Omar Mendoza', 'Ing. Omar Mendoza');

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
(2, 'Administración', 'Activo', '2024-02-07 20:21:58', '1'),
(3, 'Dirección Médica', 'Activo', '2024-02-07 20:22:17', '1'),
(4, 'Recursos Humanos', 'Activo', '2024-02-07 20:23:22', '1'),
(5, 'Presidencia', 'Activo', '2024-02-07 20:26:32', '1'),
(6, 'Auditoria', 'Activo', '2024-02-07 20:27:47', '1'),
(7, 'Historias Medicas ', 'Activo', '2024-02-07 20:28:00', '1'),
(8, 'Laboratorio', 'Activo', '2024-02-07 20:28:18', '1'),
(9, 'Atención al Ciudadano', 'Activo', '2024-02-07 20:28:44', '1'),
(10, 'Bienes ', 'Activo', '2024-02-07 20:29:01', '1'),
(11, 'Almacén', 'Activo', '2024-02-07 20:29:12', '1'),
(12, 'Dirección General', 'Activo', '2024-02-07 20:30:11', '1'),
(13, 'Seguridad Y Vigilancia', 'Activo', '2024-02-07 20:31:17', '1'),
(14, 'Mantenimiento Servicios Generales', 'Activo', '2024-02-07 20:31:38', '1'),
(15, 'Cuarto de Datos', 'Activo', '2024-02-07 20:43:05', '1'),
(16, 'Farmacia', 'Activo', '2024-02-15 20:37:14', '2'),
(17, 'Infraestructura', 'Activo', '2024-02-15 20:42:32', '2'),
(18, 'Call Center', 'Activo', '2024-02-28 16:00:20', '1'),
(19, 'Recepción ', 'Activo', '2024-02-28 16:07:18', '1'),
(20, 'Emergencia', 'Activo', '2024-06-05 21:21:24', '2'),
(21, 'Rayos X', 'Activo', '2024-06-14 17:28:44', '1'),
(22, 'Dirección de Relaciones Interinstitucionales', 'Activo', '2024-06-14 17:29:23', '1'),
(23, 'Consultorio Gobernación', 'Activo', '2024-06-14 17:29:51', '1');

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
(2, 'Atención al Ciudadano', 'Compartida', 'Mouse', 'IMEXX', 'IME-26985', '993015825', '3-1800-1-37-2-20020-999-1126', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-02-07 12:35:28', 1, '2024-06-12 14:55:21', 1, 'Activo', 'Recepción Principal', ''),
(3, 'Informática', 'Omar Mendoza', 'CPU', 'VIT', 'E2220-03', 'A000710371', '3-1800-1-37-2-20020-0012-435', 'Intel I7 3770K 3.40Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'WINDOWS 10 ', '2024-02-07 12:38:19', 1, '2024-06-11 15:27:09', 1, 'Activo', 'Infraestructura', ''),
(10, 'Informática', 'Omar Mendoza', 'Monitor', 'AITEG', 'W90221S5-D', 'W921S5D-D7NZ2B15-01880L', '3-1800-1-37-2-20020-999-397', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-02-07 15:35:12', 1, '2024-06-11 15:36:08', 1, 'Activo', 'Infraestructura', ''),
(11, 'Mantenimiento Servicios Generales', 'Richard Rodríguez', 'CPU', 'SIRAGON', 'PC-1005', '150819P20276SP0272', '3-1800-1-37-2-20020-0012-535', 'Intel G2030 3.00Ghz', 'DDR3', 4, 'HDD / SATA', '1000', 'Windows 10', '2024-02-07 15:43:30', 1, '2024-06-12 11:41:55', 1, 'Activo', 'Infraestructura', ''),
(12, 'Mantenimiento Servicios Generales', 'Richard Rodríguez', 'Mouse', 'LOGITECH', 'M-105', '1230HC00SN18', '3-1800-1-37-2-20020-999-533', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-02-07 15:49:22', 1, '2024-06-12 11:42:04', 1, 'Activo', 'Infraestructura', ''),
(13, 'Administración', 'José Bolívar', 'CPU', 'THERMAL MASTER', '', 'TC101BKKR5001132900580', '3-1800-1-37-2-20020-0012-470', 'Intel Celeron CPU G1610@2.60Ghz', 'DDR3', 2, 'HDD / SATA', '1000', 'Windows 7', '2024-02-07 15:52:27', 1, '2024-06-13 09:56:23', 1, 'Activo', 'Dirección de Gestión Administrativa', ''),
(14, 'Administración', 'Katherine Álvarez', 'Laptop', 'Lenovo', 'G480', 'MB00354255', '3-1800-1-37-2-20020-0007-31', 'Intel Pentium B970 2.30 GHZ', 'DDR3', 4, 'HDD / SATA', '500', 'Windows 7', '2024-02-07 16:11:09', 1, '2024-06-12 11:41:20', 1, 'Activo', 'Dirección de Gestión Administrativa', ''),
(18, 'Farmacia', 'Lirida Almeida', 'Laptop', 'Lenovo', 'G485', 'MB00319591', '3-1800-1-37-2-20020-0007-10', 'AMD C-70', 'DDR3', 4, 'HDD / SATA', '500', 'WINDOWS 7', '2024-04-15 15:25:52', 2, '2024-06-11 15:24:54', 1, 'Activo', 'Farmacia', ''),
(19, 'Informática', 'Omar Mendoza', 'Monitor', 'LG', '20M37A', '501NDDM1W610', '3-1800-1-37-2-20020-999-350', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:20:47', 2, '2024-06-11 15:36:48', 1, 'Activo', 'Infraestructura', ''),
(20, 'Informática', 'Omar Mendoza', 'Teclado', 'HP', 'SK-2880', 'BDAEB0BCP3V7ME', '3-1800-1-37-2-20020-0011-1307', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:24:53', 2, '2024-06-12 10:05:47', 1, 'Activo', 'Infraestructura', ''),
(21, 'Mantenimiento Servicios Generales', 'Richart Rodriguez', 'Teclado', 'GENIUS', 'KL-0210', 'ZCA732900693', '3-1800-1-37-2-20020-0011-527', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 15:37:06', 2, '2024-06-12 11:42:14', 1, 'Activo', 'Infraestructura', ''),
(22, 'Mantenimiento Servicios Generales', 'Richart Rodriguez', 'Impresora', 'HP', 'LASER JET P1102W', 'VND3J74980', '3-1800-1-37-2-20020-0021-530', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 16:08:22', 2, '2024-06-12 11:42:22', 1, 'Activo', 'Infraestructura', ''),
(23, 'Bienes ', 'Eudalys Rojas', 'CPU', 'SIRAGON', 'PC-1500', '150819P20276SP0272', '3-1800-1-37-2-20020-0012-370', 'Intel G2030 3,00Ghz', 'DDR3', 4, 'HDD / SATA', '500', 'WINDOWS 10', '2024-04-16 16:15:49', 2, '2024-06-11 15:21:52', 1, 'Activo', 'Infraestructura', 'Se realizó mantenimiento el dia 08/05/2024'),
(24, 'Bienes ', 'Eudalys Rojas', 'Monitor', 'AOC ', 'Z15LM0041C-00134', 'FMYD5HA008605', '3-1800-1-37-2-20020-999-526', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-16 16:20:48', 2, '2024-06-11 15:33:31', 1, 'Activo', 'Infraestructura', ''),
(25, 'Bienes ', 'Eudalys Rojas', 'Mouse', 'MYO', 'MYO-2550', 'SIN SERIAL', '3-1800-1-37-2-20020-999-384', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 08:44:16', 2, '2024-06-12 10:17:04', 1, 'Activo', 'Infraestructura', ''),
(26, 'Bienes ', 'Eudalys Rojas', 'Teclado', 'SIRAGON', 'SVCPC-1005', 'K15001205008941', '3-1800-1-37-2-20020-0011-368', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 08:47:37', 2, '2024-06-12 10:02:34', 1, 'Activo', 'Infraestructura', ''),
(27, 'Auditoria', 'Manuel Freites', 'Laptop', 'TOSHIBA', 'SATELITE E557-A5320', '13026497P', '3-1800-1-37-2-20020-0007-464', 'Intel I5 4200u 2.3Ghz', 'DDR3', 6, 'HDD / SATA', '500', 'WINDOWS 10', '2024-04-17 08:52:03', 2, '2024-06-14 10:01:49', 1, 'Activo', 'Dirección de Gestión Administrativa', ''),
(28, 'Bienes ', 'Eudalys Rojas', 'Impresora', 'HP', 'OFFICEJET 7500A', 'MY223310J0', '3-1800-1-37-2-20020-0021-1465', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:06:27', 2, '2024-06-12 10:28:34', 1, 'Activo', 'Infraestructura', ''),
(29, 'Informática', 'Omar Mendoza', 'Teclado', 'LENOVO', 'KU-0225', '2366101', '3-1800-1-37-2-20020-0011-1306', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:24:02', 2, '2024-06-12 10:08:49', 1, 'Activo', 'Infraestructura Sr. Carrizales', ''),
(31, 'Bienes ', 'Josue Carrizales', 'Monitor', 'SAMSUNG', 'S22D300NY', '02EYHCLFB03732L', '3-1800-1-37-2-20020-999-367', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 10:48:43', 2, '2024-06-11 15:34:09', 1, 'Activo', 'Infraestructura', ''),
(32, 'Informática', 'Omar Mendoza', 'Regulador de Voltaje', 'AVTEK', 'R8T-601', '5662015013676', '3-1800-1-37-2-20990-0001-354', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-17 11:01:18', 2, '2024-06-12 10:30:08', 1, 'Activo', 'Infraestructura', ''),
(33, 'Informática', 'Frank Guiche', 'CPU', 'HP', 'ML110 G7', 'BRC2120X19', '20020-XXXX-1275', 'Intel Xeon E31220 3.10Ghz', 'DDR3', 4, 'HDD / SATA', '500', 'Windows 10', '2024-04-23 15:13:03', 1, '2024-06-11 15:27:41', 1, 'Activo', 'Infraestructura', 'Cuenta con un Disco Duro Adicional de 500GB HDD.'),
(34, 'Informática', 'Frank Guiche', 'Teclado', 'HP', 'KU-0316', 'BBAVL0KGA1K2OI', '3-1800-1-37-2-20020-0011-1267', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-23 15:20:58', 1, '2024-06-12 10:10:31', 1, 'Activo', 'Infraestructura', ''),
(35, 'Informática', 'Frank Guiche', 'Monitor', 'AOC', 'E943SWNK 185LMOOO12', 'AOPC59A003455', '3-1800-1-37-2-20020-999-1269', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-23 15:23:34', 1, '2024-06-12 10:43:19', 1, 'Activo', 'Infraestructura', ''),
(36, 'Historias Medicas ', 'Maribel Farías ', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-E08B-A08', '3-1800-1-37-2-20020-999-1548', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 15:38:55', 2, '2024-06-11 15:34:56', 1, 'Activo', 'Historias Medicas', ''),
(37, 'Historias Medicas ', 'Maribel Farías ', 'CPU', 'DELL', '7010', 'HP7HB04', '3-1800-1-37-2-20020-0012-1547', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'WINDOWS 11', '2024-04-25 16:28:34', 2, '2024-06-11 15:25:43', 1, 'Activo', 'Registro de Citas', ''),
(38, 'Historias Medicas ', 'Maribel Farías', 'Mouse', 'DELL', 'MS116T1', 'CN-065K5F-L0300-360-0155', '3-1800-1-37-2-20020-999-1549', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:45:32', 2, '2024-06-12 10:18:03', 1, 'Activo', 'Registro de Citas', ''),
(39, 'Historias Medicas ', 'Maribel Farías', 'Teclado', 'DELL', 'KB216t1', 'CN-0081N8-L0300-3A5-A2VH-A04', '3-1800-1-37-2-20020-0011-1550', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:47:09', 2, '2024-06-12 10:05:32', 1, 'Activo', 'Registro de Citas', ''),
(40, 'Recursos Humanos', 'Jorman León ', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-DWYB-A08', '3-1800-1-37-2-20020-999-1545', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-04-25 16:50:33', 2, '2024-06-11 15:38:02', 1, 'Activo', 'Oficina de Recursos Humanos', ''),
(41, 'Recursos Humanos', 'Jorman León ', 'CPU', 'DELL', '7010', '93KP6Z3', '3-1800-1-37-2-20020-0012-1543', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'WINDOWS 11', '2024-04-25 16:54:38', 2, '2024-06-11 15:29:03', 1, 'Activo', 'Oficina de Recursos Humanos', ''),
(42, 'Atención al Ciudadano', 'Compartida', 'Monitor', 'BENQ', 'ET-0024-TA', 'ETWAB05621019', '3-1800-1-37-2-20020-999-432', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-05-14 14:35:31', 1, '2024-06-12 11:42:33', 1, 'Activo', 'Recepción Emergencia', ''),
(43, 'Atención al Ciudadano', 'Compartida', 'CPU', 'HP', 'Compaq dc5800', 'MXJ8350D7Q', '3-1800-1-37-2-20020-0012-83', 'Pentium 4', 'DDR2', 2, 'HDD / SATA', '160', 'Windows 7', '2024-05-14 14:43:35', 1, '2024-06-12 11:42:42', 1, 'Activo', 'Recepción Emergencia', ''),
(44, 'Atención al Ciudadano', 'Compartida', 'Teclado', 'HP', 'sk-2880', 'BC337OFVBW43ZZ', '20020-XXXX-85', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-05-14 14:49:52', 1, '2024-06-12 11:42:50', 1, 'Activo', 'Recepción Emergencia ', ''),
(45, 'Cuarto de Datos', 'Omar Mendoza', 'Router', 'TP-LINK', 'N750', '13972700587', '20020-XXXX-1270', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 10:58:55', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Cuarto de datos', 'Router principal'),
(46, 'Cuarto de Datos', 'Omar Mendoza', 'Router', 'DLINK', 'DIR-601', 'QB1O1A2010454', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 14:23:11', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Cuarto de Datos', 'Equipo pertenece al Ing. Geyker Rodriguez'),
(47, 'Emergencia', 'Dr. Andres Salazar', 'Router', 'MERCUSYS', '', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:21:59', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Encima de techo raso de oficina de médicos en emergencia.', 'Equipo propiedad del Dr. Salazar.'),
(48, 'Administración ', 'Omar Mendoza', 'Router', 'PIXLINK', '', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:24:22', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Administracion sobre escritorio de Lcda. Lirimar.', ''),
(49, 'Infraestructura', 'Omar Mendoza', 'Router', 'PIXLINK2', 'N300', '2021123478M', '20020-XXXX-1002', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:26:40', 2, '2024-06-05 15:30:01', 2, 'Activo', 'Oficina de infraestructura', ''),
(50, 'Administración ', 'Omar Mendoza', 'Router', 'Tp-LINK WA5210G', 'TL-WA5210G', '', '', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-05 15:44:54', 2, '0000-00-00 00:00:00', 0, 'Activo', 'Administración detras del mueble de la impresora Canon. ', ''),
(51, 'Bienes ', 'Josué Carrizales', 'CPU', 'DELL', '7010', 'HQ7HB04', '3-1800-1-37-2-20020-0012-1551', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'Windows 11', '2024-06-12 10:47:50', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(52, 'Presidencia', 'Jenny Gómez', 'CPU', 'DELL', '7010', 'J4XK6Z3', '3-1800-1-37-2-20020-0012-1555', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'Windows 11', '2024-06-12 10:50:55', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(53, 'Administración ', 'Deinor Figuera', 'CPU', 'DELL', '7010', 'CXJP6Z3', '3-1800-1-37-2-20020-0012-1559', 'INTEL CORE I5 13500', 'DDR4', 8, 'SSD', '500', 'Windows 11', '2024-06-12 10:53:36', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Dirección de Gestión Administrativa', ''),
(54, 'Bienes ', 'Josué Carrizales', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-DYLB-A08', '3-1800-1-37-2-20020-999-1552', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 10:58:06', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura ', ''),
(55, 'Presidencia', 'Jenny Gómez', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-DYJB-A08', '3-1800-1-37-2-20020-999-1556', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:00:20', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(56, 'Administración ', 'Deinor Figuera', 'Monitor', 'DELL', 'E1920H', 'CN-0F1XP0-FCC00-32A-EOCB-A08', '3-1800-1-37-2-20020-999-1560', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:01:16', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Dirección de Gestión Administrativa', ''),
(57, 'Bienes ', 'Josué Carrizales', 'Mouse', 'DELL', 'MS116t1', 'CN-065K5F-LO300-36Q-03BS', '3-1800-1-37-2-20020-999-1553', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:02:14', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(58, 'Presidencia', 'Jenny Gómez', 'Mouse', 'DELL', 'MS116t1', 'CN-065K5F-LO300-36Q-02XN', '3-1800-1-37-2-20020-999-1557', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:13:53', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(59, 'Administración ', 'Deinor Figuera', 'Mouse', 'DELL', 'MS116t1', 'CN-065K5F-LO300-3A4-095K', '3-1800-1-37-2-20020-999-1561', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:14:50', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Dirección de Gestión Administrativa', ''),
(60, 'Recursos Humanos', 'Jorman León ', 'Mouse', 'DELL', 'MS116t1', 'CN-065K5F-LO300-36R-0EY8', '3-1800-1-37-2-20020-0012-1544', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:17:23', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Oficina de Recursos Humanos', ''),
(61, 'Recursos Humanos', 'Jorman León ', 'Teclado', 'DELL', 'KB216t3', 'CN-0081N8-LO300-360-00VB-A04', '3-1800-1-37-2-20020-0011-1546', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:18:11', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Oficina de Recursos Humanos', ''),
(62, 'Bienes ', 'Josué Carrizales', 'Teclado', 'DELL', 'KB216t1', 'CN-0081N8-LO300-3A5-A2SQ-A04', '3-1800-1-37-2-20020-0011-1554', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:21:45', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Infraestructura', ''),
(63, 'Presidencia', 'Jenny Gómez', 'Teclado', 'DELL', 'KB216t1', 'CN-0081N8-LO300-36N-0FFC-A04', '3-1800-1-37-2-20020-0011-1558', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:23:15', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(64, 'Administración ', 'Deinor Figuera', 'Teclado', 'DELL', 'KB216t1', 'CN-0081N8-LO300-36N-0QWQ-A04', '3-1800-1-37-2-20020-0011-1562', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-12 11:23:59', 1, '0000-00-00 00:00:00', 0, 'Activo', 'Dirección de Gestión Administrativa', ''),
(65, 'Historias Medicas ', 'Sin Definir', 'CPU', 'SONEVIEW', 'PC-1005', '151001P202945P0146', '3-1800-1-37-2-20020-0012-5', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:05:46', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(66, 'Dirección Médica', 'Sin Definir', 'CPU', 'vIT', 'E2220-03', 'A000710360', '3-1800-1-37-2-20020-0012-76', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:08:18', 1, '2024-06-14 10:23:46', 1, 'Activo', '', ''),
(67, 'Atención al Ciudadano', 'Sin Definir', 'CPU', 'SONEVIEW', 'PC-1005', '150716P20260SP0057', '3-1800-1-37-2-20020-0012-353', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:10:18', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(68, 'Recursos Humanos', 'Sin Definir', 'CPU', 'VIT', 'E2220-03', 'AD00710324', '3-1800-1-37-2-20020-0012-358', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:18:27', 1, '2024-06-14 11:25:20', 1, 'Activo', '', ''),
(69, 'Almacén', 'Sin Definir', 'CPU', 'SONEVIEW', 'PC-1005', '151009P20297SP0030', '3-1800-1-37-2-20020-0012-380', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:19:15', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(70, 'Auditoria', 'Sin Definir', 'CPU', 'VIT', 'E2220-03', 'A000710361', '3-1800-1-37-2-20020-0012-429', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:19:54', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(71, 'Dirección Médica', 'Sin Definir', 'Laptop', 'LENOVO', 'G485', '00257559', '3-1800-1-37-2-20020-0007-7', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:23:52', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(72, 'Presidencia', 'Sin Definir', 'Laptop', 'LENOVO', 'G480', '42135', '3-1800-1-37-2-20020-0007-478', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:26:13', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(73, 'Seguridad Y Vigilancia', 'Eusebio Sánchez', 'Laptop', 'LENOVO', 'G485', 'MB00257341', '3-1800-1-37-2-20020-0007-448', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:29:10', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(74, 'Historias Medicas ', 'Sin Definir', 'Monitor', 'AITEG', 'W921S5D-D7', 'MZ2B278- 02609J', '3-1800-1-37-2-20020-999-4', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:30:44', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(75, 'Laboratorio', 'Sin Definir', 'Monitor', 'AITEG', 'W9021S5-D', 'D7NZ2B013-01481E', '3-1800-1-37-2-20020-999-28', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:32:36', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(76, 'Dirección Médica', 'Sin Definir', 'Monitor', 'SAMSUNG', 'S19B150N', 'Z8H4LC908452E', '3-1800-1-37-2-20020-999-73', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:33:33', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(77, 'Dirección Médica', 'Sin Definir', 'Monitor', 'VIT', 'V215EWD-B', 'C16D8BA000869', '3-1800-1-37-2-20020-999-75', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:34:39', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(78, 'Atención al Ciudadano', 'Sin Definir', 'Monitor', 'HP', 'L1710', 'CNC821NR6T', '3-1800-1-37-2-20020-999-84', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:35:33', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(79, 'Recursos Humanos', 'Sin Definir', 'Monitor', 'VIT', 'V215EWD-B', 'C16D8BA000369', '3-1800-1-37-2-20020-999-355', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:36:14', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(80, 'Seguridad Y Vigilancia', 'Sin Definir', 'Monitor', 'SAMSUNG', 'S22C150', 'ZYSTH4LD700173N', '3-1800-1-37-2-20020-999-364', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:37:15', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(81, 'Almacén', 'Sin Definir', 'Monitor', 'LG', '20M37A-B', '412NDJXCC212', '3-1800-1-37-2-20020-999-377', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:38:00', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(82, 'Auditoria', 'Sin Definir', 'Monitor', 'VIT', 'V215EWD-B', 'C16D8BA000374', '3-1800-1-37-2-20020-999-426', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:39:02', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(83, 'Seguridad Y Vigilancia', 'Sin Definir', 'Monitor', 'VIT', 'V215EW-B', 'C0BB809150000105', '3-1800-1-37-2-20020-999-458', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:39:57', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(84, 'Administración', 'Sin Definir', 'Monitor', 'SAMSUNG', 'LS19B150', 'ZWZ8H4LC910939E', '3-1800-1-37-2-20020-999-467', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:40:48', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(85, 'Seguridad Y Vigilancia', 'Eusebio Sánchez', 'Monitor', 'LG', '20M37A-B', '501NDXQ1W642', '3-1800-1-37-2-20020-999-488', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:41:38', 1, '2024-06-14 10:44:10', 1, 'Inactivo', '', ''),
(86, 'Administración', 'ANALISTA DE PLANIFICACION', 'Laptop', 'LENOVO', 'G485', 'MB00257212', '3-1800-1-37-2-20020-0007-46', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:44:17', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(87, 'Administración', 'ANALISTA DE PRESUPUESTO', 'Laptop', 'HP', 'G600', '5CG3274QWY ', '3-1800-1-37-2-20020-0007-53', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:46:40', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(88, 'Recursos Humanos', 'Nómina', 'Laptop', 'LENOVO', 'G480', 'MB00409151', '3-1800-1-37-2-20020-0007-382', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:47:42', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(89, 'Recursos Humanos', 'SELECCION Y RECLUTAMIENTO', 'Laptop', 'LENOVO', 'G485', 'SIN SERIAL', '3-1800-1-37-2-20020-0007-406', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:48:35', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(90, 'Recursos Humanos', 'ANALISTA DE PERSONAL', 'Laptop', 'LENOVO', 'G480', '408152', '3-1800-1-37-2-20020-0007-424', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:49:31', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(91, 'Recursos Humanos', 'CALIDAD DE VIDA', 'Laptop', 'LENOVO', 'G485', '259865', '3-1800-1-37-2-20020-0007-454', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:50:23', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(92, 'Presidencia', 'CONSULTORIA JURIDICA', 'Laptop', 'LENOVO', 'G485', '59360502', '3-1800-1-37-2-20020-0007-403', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 10:52:01', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(93, 'Rayos X', 'Sin Definir', 'CPU', 'DELL', 'PRECISION T3500', '2XPHCP1 6391748485', '3-1800-1-37-2-20020-0012-19', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:36:55', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(94, 'Administración', 'TESORERIA', 'CPU', 'SONEVIEW', 'PC-1005', '151009P20297SP0484', '3-1800-1-37-2-20020-0012-32', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:37:59', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(95, 'Emergencia', 'EMERGENCIA ADULTOS', 'CPU', 'VIT', 'E2220-03', '000710324', '3-1800-1-37-2-20020-0012-45', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:38:52', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(96, 'Administración', 'JEFATURA DE ADMINISTRACION', 'CPU', 'HP', '', '', '3-1800-1-37-2-20020-0012-48', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:41:09', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(97, 'Administración', 'CONTABILIDAD', 'CPU', 'USA-NET', '', '', '3-1800-1-37-2-20020-0012-56', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:42:26', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(98, 'Consultorio Gobernación', 'CONSULTORIO GOBERNACION', 'CPU', 'HP', 'COMPAQ PRO 4300', '', '3-1800-1-37-2-20020-0012-1198', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:43:39', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(99, 'Rayos X', 'Sin Definir', 'Monitor', 'ELZO', 'FLEXSCAN S2100', '67451120', '3-1800-1-37-2-20020-999-20', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:47:39', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(100, 'Administración', 'TESORERIA', 'Monitor', 'LG', '20M37A-B', '412NDKDCC253', '3-1800-1-37-2-20020-999-35', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:48:29', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(101, 'Emergencia', 'EMERGENCIA ADULTOS', 'Monitor', 'VIT', 'V215EWD-B', '16D8BA000326', '3-1800-1-37-2-20020-999-42', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:49:22', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(102, 'Administración', 'JEFATURA DE ADMINISTRACION', 'Monitor', 'LG', 'FLATRON LED19EN33', '301NDFV7R563', '3-1800-1-37-2-20020-999-47', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:50:05', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(103, 'Administración', 'CONTABILIDAD', 'Monitor', 'AITEG', 'W921S5D', 'D7MZ2B278-02843J', '3-1800-1-37-2-20020-999-57', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:51:03', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(104, 'Dirección de Relaciones Interinstitucionales', 'Sin Definir', 'Monitor', 'VIT', 'V215EWD-B', 'C16D8BA000318 COBB80915000', '3-1800-1-37-2-20020-999-74', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:52:00', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(105, 'Mantenimiento Servicios Generales', 'Richart Rodriguez', 'Monitor', 'SAMSUNG', 'S22D300', '02EYHCLFB03144A', '3-1800-1-37-2-20020-999-531', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:53:03', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(106, 'Consultorio Gobernación', 'CONSULTORIO GOBERNACION', 'Monitor', 'LG', 'FLATRON 19EN33-B', '19EN33LA', '3-1800-1-37-2-20020-999-1199', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:54:23', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(107, 'Historias Medicas ', 'Sin Definir', 'Mouse', 'VIT', '', 'PN: COA4A1000030K000', '3-1800-1-37-2-20020-999-3', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 11:59:46', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(108, 'Administración', 'ANALISTA DE PRESUPUESTO', 'Mouse', 'MICROSOFT', '', 'P/N X822088-001', '3-1800-1-37-2-20020-999-55', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:00:28', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(109, 'Administración', 'CONTABILIDAD', 'Mouse', 'HP', '', 'P/N 590509-001', '3-1800-1-37-2-20020-999-58', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:02:26', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(110, 'Administración', 'TESORERIA', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-70', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:03:06', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(111, 'Administración', 'JEFATURA DE ADMINISTRACION', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-71', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:03:36', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(112, 'Presidencia', 'Sin Definir', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-72', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:04:08', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(113, 'Dirección Médica', 'Sin Definir', 'Mouse', 'IMEXX', 'IME-26300', 'LOT: 993014242', '3-1800-1-37-2-20020-999-78', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:04:38', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(114, 'Atención al Ciudadano', 'Sin Definir', 'Mouse', 'HP', 'MOFXKO', 'FCGLH0D0W3TBGG', '3-1800-1-37-2-20020-999-86', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:05:37', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(115, 'Recursos Humanos', 'Sin Definir', 'Mouse', 'VIT', 'DOK-M696', 'COA4A1000030K000', '3-1800-1-37-2-20020-999-357', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:07:20', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(116, 'Auditoria', 'Sin Definir', 'Mouse', 'SIRAGON', 'KBM-1500', 'M125120508941', '3-1800-1-37-2-20020-999-369', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:08:16', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(117, 'Almacén', 'Sin Definir', 'Mouse', 'SONEVIEW', '', '', '3-1800-1-37-2-20020-999-379', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:09:01', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(118, 'Auditoria', 'Sin Definir', 'Mouse', 'VIT', 'DOX M696', '', '3-1800-1-37-2-20020-999-428', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:09:33', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(119, 'Administración', 'Sin Definir', 'Mouse', 'GENIUS', 'NETSCROLL200', 'GM-070005', '3-1800-1-37-2-20020-999-469', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:10:13', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(120, 'Emergencia', 'EMERGENCIA ADULTOS', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-1058', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:11:05', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(121, 'Rayos X', 'Sin Definir', 'Mouse', 'VIT', 'DOK-M696', 'C0A4A1000030K000', '3-1800-1-37-2-20020-999-1124', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:11:43', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(122, 'Administración', 'ANALISTA DE PLANIFICACION', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-1125', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:12:44', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(123, 'Auditoria', 'Sin Definir', 'Mouse', 'IMEXX', '26985', '', '3-1800-1-37-2-20020-999-1169', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:13:27', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(124, 'Dirección de Relaciones Interinstitucionales', 'Sin Definir', 'Mouse', 'MYO', 'MYO-2550', '', '3-1800-1-37-2-20020-999-1178', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:14:04', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(125, 'Consultorio Gobernación', 'CONSULTORIO GOBERNACION', 'Mouse', 'HP', ' 600553-002', '', '3-1800-1-37-2-20020-999-1201', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:14:38', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(126, 'Bienes ', 'Sin Definir', 'Mouse', 'HP', 'M-SBF96', 'P/N: 537748-001', '3-1800-1-37-2-20020-999-1305', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:16:13', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(127, 'Seguridad Y Vigilancia', 'Eusebio Sánchez', 'Mouse', 'VIT', 'DOK-M696', 'C04A100030K000', '3-1800-1-37-2-20020-999-1381', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:16:55', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(128, 'Seguridad Y Vigilancia', 'Eusebio Sánchez', 'Mouse', 'MAXELL', 'WD ENTRY LEVEL', '02606048AR04506', '3-1800-1-37-2-20020-999-1382', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:22:58', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(129, 'Informática', 'Sin Definir', 'Mouse', '', 'MS111-P', 'CN-011D3V-71561-06M-OPGO', '3-1800-1-37-2-20020-999-1565', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:23:41', 1, '0000-00-00 00:00:00', 0, 'Activo', '', ''),
(130, 'Atención al Ciudadano', 'Sin Definir', 'Mouse', 'GENIUS', 'GM-04003P', '118738005491', '3-1800-1-37-2-20020-999-1566', '', 'Selecciona una Opcion', 0, 'Selecciona una Opcion', '', '', '2024-06-14 12:24:26', 1, '0000-00-00 00:00:00', 0, 'Activo', '', '');

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
(1, 'Dirección Medica', '1', 3, '', 0, 'Consultorio de Eco', 'Inactivo', '2024-02-28 10:48:30', 1, '0000-00-00 00:00:00', 0),
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
(15, 'Seguridad Y Vigilancia', '2', 6, '', 0, 'Seguridad', 'Activo', '2024-02-28 11:04:58', 0, '2024-06-12 14:16:38', 0),
(16, 'Almacén', '2', 7, '', 0, 'Almacén', 'Activo', '2024-02-28 11:05:19', 0, '0000-00-00 00:00:00', 0),
(17, 'Farmacia', '2', 10, '', 0, 'Farmacia', 'Activo', '2024-02-28 11:05:36', 0, '0000-00-00 00:00:00', 0),
(18, 'Dirección Medica', '2', 13, '', 0, 'Consultorio Traumatologia', 'Inactivo', '2024-02-28 11:05:51', 0, '0000-00-00 00:00:00', 0),
(19, 'Recepción ', '2', 17, '', 0, 'Recepción ', 'Activo', '2024-02-28 11:07:29', 0, '0000-00-00 00:00:00', 0),
(20, 'Recepción ', '2', 18, '', 0, 'Recepción Teléfono ', 'Activo', '2024-02-28 11:07:46', 0, '0000-00-00 00:00:00', 0),
(21, 'Call Center', '2', 20, '', 0, 'Area de Call Center (Puesto 3)', 'Activo', '2024-02-28 11:08:11', 0, '0000-00-00 00:00:00', 0),
(22, 'Administración', '1', 1, '', 0, 'Administración', 'Activo', '2024-02-28 11:09:56', 0, '2024-06-12 14:16:04', 0),
(23, 'Administración', '1', 2, '', 0, 'Administración Deinor', 'Activo', '2024-02-28 11:10:24', 0, '2024-06-12 14:16:12', 0),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

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
