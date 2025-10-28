-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2025 a las 19:54:09
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
-- Base de datos: `labutaca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actores`
--

CREATE TABLE `actores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actores`
--

INSERT INTO `actores` (`id`, `nombre`, `fecha_nacimiento`, `biografia`, `imagen`) VALUES
(1, 'Zoe Saldaña', '1978-06-19', 'Protagonista de Avatar.', NULL),
(2, 'Sam Worthington', '1976-08-02', 'Actor principal en Avatar.', NULL),
(3, 'Jason Momoa', '1979-08-01', 'Protagonista en la película de Minecraft.', NULL),
(4, 'Jack Black', '1969-08-28', 'Actor principal en La película Minecraft.', NULL),
(5, 'Daniel Craig', '1968-03-02', 'Detective Benoit Blanc en Puñales por la espalda. Yes', ''),
(6, 'Josh Brolin', '1968-02-12', 'Actor en Puñales por la espalda 3.', NULL),
(7, 'Josh Hutcherson', '1992-10-12', 'Actor principal en Five Nights at Freddy\'s.', NULL),
(8, 'Elizabeth Lail', '1992-03-25', 'Actriz principal en Five Nights at Freddy\'s.', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `fecha_nacimiento`, `biografia`) VALUES
(1, 'James Cameron', '1954-08-16', 'Director canadiense famoso por Titanic y Avatar.'),
(2, 'Jared Hess', '1979-07-18', 'Director estadounidense conocido por Napoleon Dynamite.'),
(3, 'Rian Johnson', '1973-12-17', 'Director de Puñales por la espalda y Looper.'),
(4, 'Emma Tammi', '1984-03-07', 'Directora estadounidense, Five Nights at Freddy\'s 2.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'Acción'),
(3, 'Animación'),
(6, 'Aventura'),
(2, 'Ciencia Ficción'),
(5, 'Comedia'),
(4, 'Drama'),
(7, 'Terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `anio` int(11) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `plataforma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `descripcion`, `anio`, `duracion`, `director_id`, `imagen`, `fecha_estreno`, `created_at`, `plataforma_id`) VALUES
(1, 'Avatar: Fire and Ash', 'Tercera entrega de la saga Avatar, en Pandora.', 2025, 170, 1, 'avatar3.jpg', '2025-12-19', '2025-10-27 12:57:30', 4),
(2, 'Una película de Minecraft', 'Adaptación del popular juego Minecraft.', 2025, 125, 2, '', '2025-04-04', '2025-10-27 12:57:30', NULL),
(4, 'Five Nights at Freddy\'s', 'Secuela de terror basada en el videojuego.', 2025, 110, 4, 'fnaf.jpg', '2025-12-05', '2025-10-27 12:57:30', 1),
(5, 'Pesadilla en Navidad', 'Pesadilla de Guillermo ', 2023, 20, 4, '', '2023-12-25', '2025-10-27 19:44:50', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_actor`
--

CREATE TABLE `pelicula_actor` (
  `pelicula_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_actor`
--

INSERT INTO `pelicula_actor` (`pelicula_id`, `actor_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(4, 7),
(4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_genero`
--

CREATE TABLE `pelicula_genero` (
  `pelicula_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_genero`
--

INSERT INTO `pelicula_genero` (`pelicula_id`, `genero_id`) VALUES
(1, 7),
(2, 3),
(2, 6),
(4, 1),
(4, 4),
(4, 7),
(5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

CREATE TABLE `plataformas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`id`, `nombre`, `descripcion`, `url`) VALUES
(1, 'Netflix', 'Plataforma global de streaming de películas y series.', 'https://www.netflix.com'),
(2, 'Amazon Prime Video', 'Servicio de streaming de Amazon con películas, series y contenido original.', 'https://www.primevideo.com'),
(3, 'Disney+', 'Plataforma con contenido de Disney, Pixar, Marvel, Star Wars y National Geographic.', 'https://www.disneyplus.com'),
(4, 'HBO Max', 'Servicio de streaming de Warner Bros., HBO y más.', 'https://www.hbomax.com'),
(5, 'Apple TV+', 'Plataforma de Apple con contenido original exclusivo.', 'https://tv.apple.com'),
(6, 'Filmin', 'Plataforma española especializada en cine independiente y de autor.', 'https://www.filmin.es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `fecha_registro` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'admin', 'admin@admin.es', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'admin', '2025-10-27 12:58:11'),
(2, 'elPol', 'pablo.benlloch00@gmail.com', '$2y$10$nKr2lpyHeTNxii9b3ttpX.ezTJp8VqvpM6La6S4HW5iceYa3mKS4e', 'usuario', '2025-10-27 15:47:29'),
(5, 'paula25', 'paula@prueba.es', '$2y$10$TEJH.WC7YA4EqkAycJqfpe6tMxy.89a/ipuOt.YxuNRxxIy4xHayW', 'usuario', '2025-10-27 16:23:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `pelicula_id` int(11) DEFAULT NULL,
  `puntuacion` tinyint(4) DEFAULT NULL CHECK (`puntuacion` between 1 and 10),
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actores`
--
ALTER TABLE `actores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagen_id` (`imagen`);

--
-- Indices de la tabla `directores`
--
ALTER TABLE `directores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `director_id` (`director_id`),
  ADD KEY `plataforma_id` (`plataforma_id`);

--
-- Indices de la tabla `pelicula_actor`
--
ALTER TABLE `pelicula_actor`
  ADD PRIMARY KEY (`pelicula_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indices de la tabla `pelicula_genero`
--
ALTER TABLE `pelicula_genero`
  ADD PRIMARY KEY (`pelicula_id`,`genero_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pelicula_id` (`pelicula_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actores`
--
ALTER TABLE `actores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `peliculas_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `directores` (`id`),
  ADD CONSTRAINT `peliculas_ibfk_2` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`);

--
-- Filtros para la tabla `pelicula_actor`
--
ALTER TABLE `pelicula_actor`
  ADD CONSTRAINT `pelicula_actor_ibfk_1` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelicula_actor_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pelicula_genero`
--
ALTER TABLE `pelicula_genero`
  ADD CONSTRAINT `pelicula_genero_ibfk_1` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelicula_genero_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
