-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2026 a las 16:54:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `uh_odonto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `matricula` varchar(30) NOT NULL,
  `semestre` int(11) DEFAULT NULL,
  `grupo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `alumno_matricula` varchar(20) NOT NULL,
  `alumno_nombre` varchar(150) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `tipo`, `alumno_matricula`, `alumno_nombre`, `docente_id`, `fecha_asignacion`) VALUES
(4, 'INDIVIDUAL', '23010069  ', 'ADAME DIAZ JESABET GUADALUPE ', 3, '2026-01-09 18:41:33'),
(6, 'INDIVIDUAL', '000551    ', 'ABARCA GUTIERREZ KAREN  ', 5, '2026-01-09 19:32:36'),
(7, 'INDIVIDUAL', '003897', 'MIRANDA PABLO ADIEL', 6, '2026-01-09 23:24:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `usuario_correo` varchar(150) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `modulo` varchar(100) DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `usuario_id`, `usuario_correo`, `rol`, `modulo`, `accion`, `ip`, `created_at`) VALUES
(1, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Cierre de sesión', '::1', '2026-01-12 11:03:52'),
(2, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-12 11:03:54'),
(3, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Cierre de sesión', '::1', '2026-01-12 11:22:24'),
(4, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-12 11:22:25'),
(5, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Cierre de sesión', '::1', '2026-01-12 11:22:46'),
(6, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-14 11:30:43'),
(7, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-15 09:18:40'),
(8, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-17 11:44:14'),
(9, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-01-19 11:56:38'),
(10, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Inicio de sesión', '::1', '2026-02-05 11:23:34'),
(11, NULL, 'SISTEMA', 'SISTEMA', 'Autenticación', 'Cierre de sesión', '::1', '2026-02-05 11:24:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_clinicas`
--

CREATE TABLE `consultas_clinicas` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_consulta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `paciente_nombre` varchar(150) NOT NULL,
  `paciente_edad` int(11) DEFAULT NULL,
  `paciente_sexo` varchar(10) DEFAULT NULL,
  `fecha_apertura` date DEFAULT NULL,
  `estado` varchar(30) DEFAULT 'abierto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica`
--

CREATE TABLE `historia_clinica` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `antecedentes` text DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `padecimientos` text DEFAULT NULL,
  `medicamentos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'ADMIN'),
(2, 'DOCENTE'),
(3, 'ALUMNO'),
(4, 'SUBADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_expediente`
--

CREATE TABLE `solicitudes_expediente` (
  `id` int(11) NOT NULL,
  `alumno_correo` varchar(150) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `estado` enum('PENDIENTE','APROBADA','RECHAZADA') DEFAULT 'PENDIENTE',
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `diagnostico` text DEFAULT NULL,
  `procedimiento` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `validado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol_id`, `activo`, `creado_en`) VALUES
(1, 'MARCELINO', 'admin@uhipocrates.edu.mx', '$2y$10$0v8cIle56JT0NIZaMyNy4u5KmTXiMStVgjTghQeZFi7KVWw3RT58.', 1, 1, '2026-01-06 22:34:05'),
(2, 'Subadministrador', 'subadmin@uhipocrates.edu.mx', '$2y$10$YWXpDdd2pcOiquFard1J5uRTHVxD3j/Om6TX7OcR.yC3x3RfC6iPi', 4, 1, '2026-01-06 22:39:46'),
(3, 'ALEJANDRA PATRICIA FLORES BELLO', 'floresalejandra@uhipocrates.edu.mx', '$2y$10$5jHKGNvmUu776yZWLTQSb.Ng.Mnb76PC9LA9.q4C91Z/B2FJz9A9q', 2, 1, '2026-01-09 18:41:33'),
(4, '', 'argentina_perezgiroud@uhipocrates.edu.mx', '$2y$10$5OM2.1xlR7ZAG/duGm5Lm.v3UK5E8X61T/ywNNXhs63AGnArjXEl6', 2, 1, '2026-01-09 19:31:15'),
(5, '', 'garciairma@uhipocrates.edu.mx', '$2y$10$qYknUIlUoAwlChVAPVntZOHStcHmNf9V6IunLLRknTh2aNweCtgNG', 2, 1, '2026-01-09 19:32:36'),
(6, 'TANIA TERESA FLORES CORRO', 'florestania@uhipocrates.edu.mx', '$2y$10$MmA/zgyR7eJhjcn9OrYaPOcmXao/YxkurhdKJK/NGZpuwzm9Ngikm', 2, 1, '2026-01-09 23:24:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumno_matricula` (`alumno_matricula`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `modulo` (`modulo`),
  ADD KEY `created_at` (`created_at`);

--
-- Indices de la tabla `consultas_clinicas`
--
ALTER TABLE `consultas_clinicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`);

--
-- Indices de la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `expediente_id` (`expediente_id`);

--
-- Indices de la tabla `solicitudes_expediente`
--
ALTER TABLE `solicitudes_expediente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `validado_por` (`validado_por`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `consultas_clinicas`
--
ALTER TABLE `consultas_clinicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_expediente`
--
ALTER TABLE `solicitudes_expediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `consultas_clinicas`
--
ALTER TABLE `consultas_clinicas`
  ADD CONSTRAINT `consultas_clinicas_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`),
  ADD CONSTRAINT `consultas_clinicas_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `evidencias_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`);

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `expedientes_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`);

--
-- Filtros para la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  ADD CONSTRAINT `historia_clinica_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_3` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`);

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`),
  ADD CONSTRAINT `tratamientos_ibfk_2` FOREIGN KEY (`validado_por`) REFERENCES `docentes` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
