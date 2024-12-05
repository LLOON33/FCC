-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2024 a las 00:25:36
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
-- Base de datos: `car_control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallas_reportadas`
--

CREATE TABLE `fallas_reportadas` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_reporte` date DEFAULT NULL,
  `estado_falla` varchar(50) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fallas_reportadas`
--

INSERT INTO `fallas_reportadas` (`id`, `vehiculo_id`, `descripcion`, `fecha_reporte`, `estado_falla`, `usuario_id`) VALUES
(1, 1, 'Frenos ineficaces, requieren revisión urgente', '2024-11-10', 'Resuelta', 1),
(2, 4, 'Falla en el sistema eléctrico, luces intermitentes', '2024-11-09', 'Pendiente', 1),
(3, 3, 'Neumático pinchado, necesita cambio', '2024-11-08', 'Solucionada', 3),
(4, 1, 'Motor sobrecalentado, necesita mantenimiento', '2024-11-07', 'Resuelta', 1),
(5, 4, 'Problemas con el sistema de dirección, revisado por mecánico', '2024-11-06', 'Pendiente', 2),
(8, 4, 'falla en rueda izquierda', '2024-11-12', 'Pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `tipo_mantenimiento` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_mantenimiento` date DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `kilometraje_mantenimiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimientos`
--

INSERT INTO `mantenimientos` (`id`, `vehiculo_id`, `tipo_mantenimiento`, `descripcion`, `fecha_mantenimiento`, `costo`, `kilometraje_mantenimiento`) VALUES
(8, 1, 'Preventiva', 'asdf', '2024-11-14', 50000.00, 12222),
(9, 1, 'Preventiva', 'Cambio de aceite y filtro', '2024-11-16', 50000.00, 10000),
(10, 4, 'Correctiva', 'Reemplazo de frenos traseros', '2024-11-15', 80000.00, 10500),
(11, 3, 'Preventiva', 'Revisión de sistema de refrigeración', '2024-11-14', 35000.00, 11000),
(12, 1, 'Correctiva', 'Ajuste de suspensión delantera', '2024-11-13', 70000.00, 11500),
(13, 4, 'Preventiva', 'Reemplazo de filtro de aire', '2024-10-08', 25000.00, 12000),
(14, 3, 'Correctiva', 'Cambio de batería', '2024-11-11', 60000.00, 12500),
(15, 1, 'Preventiva', 'Revisión de neumáticos', '2024-11-10', 20000.00, 13000),
(16, 4, 'Correctiva', 'Reparación del sistema de dirección', '2024-11-09', 90000.00, 13500),
(17, 3, 'Preventiva', 'Alineación y balanceo de ruedas', '2024-11-08', 30000.00, 14000),
(18, 1, 'Correctiva', 'Cambio de correas de distribución', '2024-11-07', 85000.00, 14500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `creado_en`) VALUES
(1, 'admin', 'Administrador del sistema', '2024-11-08 23:59:20'),
(2, 'bombero', 'Usuario que reporta fallas', '2024-11-08 23:59:20'),
(3, 'mecanico', 'Usuario que realiza mantenimiento', '2024-11-08 23:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `compania` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `contraseña`, `compania`, `fecha_creacion`, `rol`) VALUES
(1, 'test', '1', 'test1@email.com', '$2y$10$yIvKzfx7FSOCLUnJyt1J7.iqknN39e.sakKTiP6CBdWClVBRwVHGu', NULL, NULL, 2),
(2, 'test', 'prueba 2', 'test2@email.com', '$2y$10$F1lLt7I5RTm0dXhAwOosm.6L/iXd9uVeTacbpN2giEKsJcIdMf/FO', NULL, NULL, 3),
(3, 'Admin', '1', 'administrador@gmail.com', '$2y$10$6gj8wSgv4l6UpHIWvlVWYe8fk.yxfzdDlLUQQoe0SlB1RpykoHx7O', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `patente` varchar(10) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `kilometraje_actual` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `patente`, `tipo`, `modelo`, `anno`, `kilometraje_actual`, `estado`, `fecha_ingreso`) VALUES
(1, 'ABC123', 'Camión de Bomberos', 'Ford F750', 2020, 15000, 'Activo', '2024-11-02'),
(3, 'DEF456', 'Autobomba', 'Scania P320', 2022, 12000, 'Activo', '0000-00-00'),
(4, 'ABC1234', 'Camion', 'Ford F-150', 2021, 15000, 'Solicitado', '2024-11-11'),
(18, 'CBR1234', 'Bomberos', 'Camión Bomba', 2020, 35000, 'Inactivo', '2023-11-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_solicitados`
--

CREATE TABLE `vehiculos_solicitados` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `motivo_solicitud` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos_solicitados`
--

INSERT INTO `vehiculos_solicitados` (`id`, `vehiculo_id`, `fecha_solicitud`, `motivo_solicitud`, `usuario_id`, `ubicacion`) VALUES
(2, 4, '2024-11-16', 'asasa', 1, 'Carriel Sur: ubicado en el Sector Carriel Sur.'),
(5, 3, '2024-11-12', 'Incendio forestal', 1, 'Av. Gran Bretaña'),
(6, 1, '2024-11-15', 'Desprendimiento de rocas', 1, 'Plaza Condell'),
(7, 3, '2024-11-14', 'Incendio forestal', 1, 'Avenida Libertador Bernardo O\'Higgins'),
(8, 18, '2024-11-13', 'Fugas de gas', 1, 'Avenida Libertador Bernardo O\'Higgins'),
(9, 3, '2024-11-13', 'Rescate de personas', 1, 'Av. Gran Bretaña');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fallas_reportadas`
--
ALTER TABLE `fallas_reportadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `fk_usuario_falla` (`usuario_id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_roles` (`rol`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patente` (`patente`);

--
-- Indices de la tabla `vehiculos_solicitados`
--
ALTER TABLE `vehiculos_solicitados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fallas_reportadas`
--
ALTER TABLE `fallas_reportadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `vehiculos_solicitados`
--
ALTER TABLE `vehiculos_solicitados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fallas_reportadas`
--
ALTER TABLE `fallas_reportadas`
  ADD CONSTRAINT `fallas_reportadas_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_falla` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `mantenimientos_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `vehiculos_solicitados`
--
ALTER TABLE `vehiculos_solicitados`
  ADD CONSTRAINT `vehiculos_solicitados_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculos_solicitados_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
