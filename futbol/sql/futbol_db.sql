-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2026 a las 02:53:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `futbol_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `torneo_id` int(11) NOT NULL,
  `zona` char(1) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `jugados` int(11) NOT NULL DEFAULT 0,
  `ganados` int(11) NOT NULL DEFAULT 0,
  `empatados` int(11) NOT NULL DEFAULT 0,
  `perdidos` int(11) NOT NULL DEFAULT 0,
  `diferencia_gol` int(11) NOT NULL DEFAULT 0,
  `puntos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `torneo_id`, `zona`, `nombre`, `logo`, `jugados`, `ganados`, `empatados`, `perdidos`, `diferencia_gol`, `puntos`) VALUES
(1, 1, 'A', 'Los Primos', NULL, 4, 3, 0, 1, 18, 9),
(2, 1, 'A', 'Union FC', NULL, 4, 3, 0, 1, 13, 9),
(3, 1, 'A', 'La Banda de Coco', NULL, 4, 3, 0, 1, 4, 9),
(4, 1, 'A', 'Colon FC', NULL, 4, 2, 1, 1, 9, 7),
(5, 1, 'A', 'Dtoke F.C.', NULL, 4, 2, 1, 1, 5, 7),
(6, 1, 'A', 'Jagger FC', NULL, 4, 2, 1, 1, -2, 7),
(7, 1, 'A', 'Chicago Bulls', NULL, 4, 2, 0, 2, -1, 6),
(8, 1, 'A', 'La Taberna', NULL, 4, 1, 1, 2, -4, 4),
(9, 1, 'A', 'Telepase', NULL, 4, 1, 0, 3, -8, 3),
(10, 1, 'A', 'Leyenda MG', NULL, 4, 1, 0, 3, -12, 3),
(11, 1, 'A', 'LP del Tambo', NULL, 4, 0, 2, 2, -10, 2),
(12, 1, 'A', 'La Funda FC', NULL, 4, 0, 2, 2, -12, 2),
(13, 1, 'B', 'Casa Beta', NULL, 4, 4, 0, 0, 13, 12),
(14, 1, 'B', 'El Vajo', NULL, 4, 4, 0, 0, 10, 12),
(15, 1, 'B', 'Garfield FC', NULL, 4, 3, 0, 1, 6, 9),
(16, 1, 'B', 'El Puente', NULL, 4, 2, 1, 1, 5, 7),
(17, 1, 'B', 'Los Causas', NULL, 4, 2, 1, 1, 3, 7),
(18, 1, 'B', 'La Caldera', NULL, 4, 2, 0, 2, -1, 6),
(19, 1, 'B', 'Miller FC', NULL, 4, 1, 2, 1, -2, 5),
(20, 1, 'B', 'El Depor', NULL, 4, 1, 1, 2, -4, 4),
(21, 1, 'B', 'El Toke FC', NULL, 4, 1, 0, 3, -7, 3),
(22, 1, 'B', 'Legarreta FC', NULL, 4, 1, 0, 3, -9, 3),
(23, 1, 'B', 'La Banda del Abuelo', NULL, 4, 0, 2, 2, -8, 2),
(24, 1, 'B', 'Union Sur', NULL, 4, 0, 1, 3, -11, 1),
(25, 3, 'A', 'lo pomperito', NULL, 1, 1, 1, 1, 1, 15),
(26, 3, 'A', 'lo porreros', NULL, 2, 2, 2, 2, 0, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `goles` int(11) NOT NULL DEFAULT 0,
  `amarillas` int(11) NOT NULL DEFAULT 0,
  `rojas` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `equipo_id`, `nombre`, `goles`, `amarillas`, `rojas`) VALUES
(1, 1, 'Mateo Lopez', 9, 1, 0),
(2, 13, 'Lucas Fernandez', 8, 2, 1),
(3, 14, 'Joaquin Morales', 7, 4, 0),
(4, 2, 'Santiago Ruiz', 7, 1, 0),
(5, 15, 'Franco Diaz', 7, 5, 1),
(6, 16, 'Nicolas Gomez', 6, 2, 0),
(7, 3, 'Matias Torres', 6, 3, 1),
(8, 5, 'Agustin Perez', 5, 4, 1),
(9, 4, 'Facundo Ramirez', 5, 4, 0),
(10, 6, 'Tomas Herrera', 5, 2, 0),
(11, 13, 'Pablo Castro', 4, 3, 1),
(12, 14, 'Diego Morales', 4, 1, 0),
(13, 8, 'Andres Silva', 4, 2, 0),
(14, 7, 'Martin Rojas', 4, 0, 1),
(15, 15, 'Lucas Vazquez', 3, 3, 0),
(16, 25, 'el cholo', 2, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `mensaje` text NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int(11) NOT NULL,
  `torneo_id` int(11) NOT NULL,
  `fecha_numero` int(11) NOT NULL,
  `fecha_partido` date NOT NULL,
  `equipo_local_id` int(11) NOT NULL,
  `equipo_visitante_id` int(11) NOT NULL,
  `goles_local` int(11) DEFAULT NULL,
  `goles_visitante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `torneo_id`, `fecha_numero`, `fecha_partido`, `equipo_local_id`, `equipo_visitante_id`, `goles_local`, `goles_visitante`) VALUES
(1, 1, 5, '2026-04-20', 5, 2, 3, 1),
(2, 1, 5, '2026-04-20', 13, 14, NULL, NULL),
(3, 1, 5, '2026-04-20', 15, 3, 4, 2),
(4, 1, 4, '2026-04-13', 1, 4, 2, 2),
(5, 1, 4, '2026-04-13', 6, 7, 1, 3),
(6, 1, 3, '2026-04-06', 8, 5, 0, 5),
(7, 3, 1, '2026-05-27', 25, 26, 5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `modalidad` varchar(20) NOT NULL,
  `temporada` varchar(80) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `barrio` varchar(120) NOT NULL DEFAULT '',
  `descripcion` text DEFAULT NULL,
  `creador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`id`, `nombre`, `modalidad`, `temporada`, `activo`, `barrio`, `descripcion`, `creador_id`) VALUES
(1, 'La Esquina Cup', 'F7', 'Apertura 2026', 1, 'Barrio Norte', 'Torneo local para equipos del barrio y alrededores.', NULL),
(2, 'Potrero de los Sabados', 'F6', 'Apertura 2026', 1, 'Villa del Parque', 'Partidos de barrio con inscripcion comunitaria.', NULL),
(3, 'copa lo pibe', 'f6', 'invierno 2026', 1, 'barrio federal', 'este es un torneito rapido pa ver quien de lo pibe es mejor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `telefono`, `password_hash`, `creado_en`) VALUES
(1, 'ariel aranda', 'ariaranda07@gmail.com', '1123456789', '$2y$10$HFDODo/k1L5UuottgO273O2MtvjG2ethBYz7DYt8MSckYc.7RTLOe', '2026-05-27 00:19:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torneo_id` (`torneo_id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_id` (`equipo_id`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torneo_id` (`torneo_id`),
  ADD KEY `equipo_local_id` (`equipo_local_id`),
  ADD KEY `equipo_visitante_id` (`equipo_visitante_id`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `jugadores_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `partidos_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidos_ibfk_2` FOREIGN KEY (`equipo_local_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidos_ibfk_3` FOREIGN KEY (`equipo_visitante_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
