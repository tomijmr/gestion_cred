-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2025 a las 08:06:42
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
-- Base de datos: `gestion_creditos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `cliente_nombre` varchar(100) NOT NULL,
  `dni_cliente` varchar(20) NOT NULL,
  `telefono_cliente` varchar(20) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `revisado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `vendedor_id`, `cliente_nombre`, `dni_cliente`, `telefono_cliente`, `creado_en`, `revisado_por`) VALUES
(1, 1, 'Diego Maradona', '11772266', '3873661177', '2025-06-16 04:54:59', 2),
(2, 1, 'Santiago Maratea', '40127118', '3873561928', '2025-06-16 05:31:36', 2),
(3, 3, 'Martin Palermo', '11772266', '3873076160', '2025-06-16 06:05:12', NULL),
(4, 3, 'Roman Riquelme', '11772266', '3873076160', '2025-06-16 06:05:21', NULL),
(5, 3, 'Tiago Almada', '40661772', '3873076160', '2025-06-16 06:05:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_financieras`
--

CREATE TABLE `solicitudes_financieras` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `financiera` varchar(50) NOT NULL,
  `estado` enum('Pendiente','Aprobado','Rechazado') DEFAULT 'Pendiente',
  `monto_aprobado` decimal(12,2) DEFAULT 0.00,
  `observaciones` text DEFAULT NULL,
  `revisado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_financieras`
--

INSERT INTO `solicitudes_financieras` (`id`, `solicitud_id`, `financiera`, `estado`, `monto_aprobado`, `observaciones`, `revisado_por`) VALUES
(1, 1, 'Banco Macro', 'Rechazado', 0.00, '', NULL),
(2, 1, 'Banco Columbia', 'Aprobado', 500000.00, '', NULL),
(3, 1, 'Banco Galicia', 'Aprobado', 300000.00, '', NULL),
(4, 2, 'Banco Macro', 'Aprobado', 900000.00, '', 2),
(5, 2, 'Rapicuotas', 'Rechazado', 0.00, '', 2),
(6, 2, 'Cuota Red', 'Aprobado', 120000.00, '', 2),
(7, 3, 'Banco Macro', 'Pendiente', 0.00, NULL, NULL),
(8, 3, 'Argenpesos', 'Pendiente', 0.00, NULL, NULL),
(9, 3, 'Cuota Red', 'Pendiente', 0.00, NULL, NULL),
(10, 4, 'Banco Macro', 'Pendiente', 0.00, NULL, NULL),
(11, 4, 'Argenpesos', 'Pendiente', 0.00, NULL, NULL),
(12, 4, 'Rapicuotas', 'Pendiente', 0.00, NULL, NULL),
(13, 4, 'Tarjeta Naranja', 'Pendiente', 0.00, NULL, NULL),
(14, 5, 'Banco Macro', 'Pendiente', 0.00, NULL, NULL),
(15, 5, 'Banco Columbia', 'Pendiente', 0.00, NULL, NULL),
(16, 5, 'Banco Galicia', 'Pendiente', 0.00, NULL, NULL),
(17, 5, 'Argenpesos', 'Pendiente', 0.00, NULL, NULL),
(18, 5, 'Banco Santander', 'Pendiente', 0.00, NULL, NULL),
(19, 5, 'Rapicuotas', 'Pendiente', 0.00, NULL, NULL),
(20, 5, 'Cuota Red', 'Pendiente', 0.00, NULL, NULL),
(21, 5, 'Tarjeta Naranja', 'Pendiente', 0.00, NULL, NULL),
(22, 5, 'CuotaYa!', 'Pendiente', 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('vendedor','administrativo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'pchavez', 'Pablo Chavez', 'pchavez@rongahogar.com', '$2y$10$ldVgUGrclJ3MDc4Isl1Ot.R1XaR3OIXqdZBPELv6aMd9NnvfcCKtm', 'vendedor'),
(2, 'idiaz', 'Ivana Diaz', 'idiaz@rongahogar.com', '$2y$10$kLS3fqHhxbHLiJCdwQ4eq.5ruKdmDYU0lrJLr7FwqLNEBqRwt0Kgu', 'administrativo'),
(3, 'tcanavidez', 'Tomás Canavidez', 'info@devjmr.com', '$2y$10$BkKNmF/udEARmXYXqS2XnukCvr.18prgOS8WyuV0Pc1uzXukGnquW', 'vendedor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor_id` (`vendedor_id`),
  ADD KEY `revisado_por` (`revisado_por`);

--
-- Indices de la tabla `solicitudes_financieras`
--
ALTER TABLE `solicitudes_financieras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud_id` (`solicitud_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitudes_financieras`
--
ALTER TABLE `solicitudes_financieras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`revisado_por`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `solicitudes_financieras`
--
ALTER TABLE `solicitudes_financieras`
  ADD CONSTRAINT `solicitudes_financieras_ibfk_1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
