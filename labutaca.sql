-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-11-2025 a las 08:59:08
-- Versión del servidor: 8.0.43-0ubuntu0.24.04.1
-- Versión de PHP: 8.4.12

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
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text COLLATE utf8mb4_general_ci,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
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
(8, 'Elizabeth Lail', '1992-03-25', 'Actriz principal en Five Nights at Freddy\'s.', NULL),
(9, 'Timothée Chalamet', '1995-12-27', 'Protagonista en Dune: Parte Dos y Wonka.', NULL),
(10, 'Zendaya', '1996-09-01', 'Protagonista de Dune: Parte Dos.', NULL),
(11, 'Shameik Moore', '1995-05-04', 'Voz de Miles Morales en Spiderman: Cruzando el Multiverso.', NULL),
(12, 'Hailee Steinfeld', '1996-12-11', 'Voz de Gwen Stacy en Spiderman: Cruzando el Multiverso.', NULL),
(13, 'Cillian Murphy', '1976-05-25', 'Actor principal en Oppenheimer.', NULL),
(14, 'Margot Robbie', '1990-07-02', 'Protagonista en Barbie.', NULL),
(15, 'Keanu Reeves', '1964-09-02', 'Protagonista en John Wick 4.', NULL),
(16, 'Tom Cruise', '1962-07-03', 'Actor principal en Misión Imposible: Sentencia Mortal.', NULL),
(17, 'Brie Larson', '1989-10-01', 'Protagonista en The Marvels.', NULL),
(18, 'Harrison Ford', '1942-07-13', 'Protagonista en Indiana Jones y el Dial del Destino.', NULL),
(19, 'Leonardo DiCaprio', '1974-11-11', 'Protagonista en Killers of the Flower Moon.', NULL),
(20, 'Paul King', '1978-07-06', 'Director y voz secundaria en Wonka.', NULL),
(21, 'Ethan Hawke', '1970-11-06', 'Ethan Green Hawke es un actor, escritor y director estadounidense.', 'ethan_hawke.jpg'),
(22, 'Mason Thames', '2007-07-10', 'Mason Thames es un joven actor estadounidense conocido por su papel en The Black Phone.', 'mason_thames.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `fecha_nacimiento`, `biografia`) VALUES
(1, 'James Cameron', '1954-08-16', 'Director canadiense famoso por Titanic y Avatar.'),
(2, 'Jared Hess', '1979-07-18', 'Director estadounidense conocido por Napoleon Dynamite.'),
(3, 'Rian Johnson', '1973-12-17', 'Director de Puñales por la espalda y Looper.'),
(4, 'Emma Tammi', '1984-03-07', 'Directora estadounidense, Five Nights at Freddy\'s 2.'),
(5, 'Denis Villeneuve', '1967-10-03', 'Director canadiense de ciencia ficción y thrillers, conocido por Dune, Blade Runner 2049 y La llegada.'),
(6, 'Joaquim Dos Santos', '1977-12-22', 'Director estadounidense de animación, co-director de Spiderman: Cruzando el multiverso.'),
(7, 'Christopher Nolan', '1970-07-30', 'Director británico, famoso por películas como Inception, Interstellar y Oppenheimer.'),
(8, 'Greta Gerwig', '1983-08-04', 'Directora y guionista estadounidense, reconocida por Mujercitas y Barbie.'),
(9, 'Chad Stahelski', '1968-09-20', 'Director y doble de acción estadounidense, conocido por la saga John Wick.'),
(10, 'Christopher McQuarrie', '1968-10-25', 'Director y guionista estadounidense, responsable de Misión Imposible 5, 6 y 7.'),
(11, 'Nia DaCosta', '1989-11-08', 'Directora y guionista estadounidense, reconocida por The Marvels y Candyman.'),
(12, 'Paul King', '1978-07-06', 'Director británico de cine y televisión, conocido por Paddington y Wonka.'),
(13, 'James Mangold', '1963-12-16', 'Director y guionista estadounidense, conocido por Logan, Ford v Ferrari e Indiana Jones 5.'),
(14, 'Martin Scorsese', '1942-11-17', 'Legendario director estadounidense, famoso por Taxi Driver, Goodfellas y Killers of the Flower Moon.'),
(15, 'Scott Derrickson', '1966-07-16', 'Director de Miedo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'Acción'),
(3, 'Animación'),
(6, 'Aventura'),
(9, 'Biografía'),
(2, 'Ciencia Ficción'),
(5, 'Comedia'),
(10, 'Crimen'),
(4, 'Drama'),
(8, 'Fantasia'),
(14, 'Histórico'),
(13, 'Musical'),
(12, 'Romance'),
(11, 'Suspense'),
(7, 'Terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `anio` int DEFAULT NULL,
  `duracion` int DEFAULT NULL,
  `director_id` int DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `plataforma_id` int DEFAULT NULL,
  `LINK` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `descripcion`, `anio`, `duracion`, `director_id`, `imagen`, `fecha_estreno`, `created_at`, `plataforma_id`, `LINK`) VALUES
(1, 'Avatar: Fire and Ash', 'Tercera entrega de la saga Avatar, en Pandora.', 2025, 170, 1, 'avatar3.jpg', '2025-12-19', '2025-10-27 12:57:30', 4, 'https://youtu.be/lhLsr9S3bgQ?si=RvmERvpl_PLYGhZB'),
(2, 'Una película de Minecraft', 'Adaptación del popular juego Minecraft.', 2025, 125, 2, 'minecraft.jpg', '2025-04-04', '2025-10-27 12:57:30', 4, 'https://www.hbomax.com/es/es/movies/una-pelicula-de-minecraft/05eee581-3112-4515-b17f-219ff6265ef8?utm_source=universal_search'),
(4, 'Five Nights at Freddy\'s', 'Secuela de terror basada en el videojuego.', 2025, 110, 4, 'fnaf.jpg', '2025-12-05', '2025-10-27 12:57:30', 7, 'https://www.movistarplus.es/cine/five-nights-at-freddy-s/ficha?tipo=E&id=3263458&origen=GGL&referrer=GGL&utm_campaign=product_feed&utm_medium=aggregator&utm_source=google'),
(5, 'Pesadilla en Navidad', 'Pesadilla de Guillermo ', 2023, 20, 4, 'pesadilla.png', '2023-12-25', '2025-10-27 19:44:50', 8, 'https://youtu.be/--dGfVyuTks?si=D4Tn-JjIzW7k5PQS'),
(11, 'Dune: Parte Dos', 'Secuela de Dune con nuevas aventuras en Arrakis.', 2024, 155, 5, 'dune2.jpg', '2024-03-01', '2025-10-30 14:22:00', 4, 'https://www.hbomax.com/es/es/movies/dune-parte-dos/f0a4f239-0b57-47e2-a39a-54fb96925e61?utm_source=universal_search'),
(12, 'Spiderman: Cruzando el Multiverso', 'Nueva entrega animada de Spiderman.', 2023, 140, 6, 'spiderverse2.jpg', '2023-06-16', '2025-10-30 14:22:00', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.08bf002f-a5e6-4c0d-9288-6e83a129e2d4?autoplay=0&ref_=atv_cf_strg_wb'),
(13, 'Oppenheimer', 'Drama biográfico dirigido por Christopher Nolan.', 2023, 180, 7, 'oppenheimer.jpg', '2023-07-21', '2025-10-30 14:22:00', 2, 'https://www.youtube.com/watch?v=MVvGSBKV504'),
(14, 'Barbie', 'Comedia y fantasía protagonizada por Margot Robbie.', 2023, 125, 8, 'barbie.jpg', '2023-08-05', '2025-10-30 14:22:00', 4, 'https://www.hbomax.com/es/es/movies/barbie/80bc4915-c826-499f-9961-b422b17559b6?utm_source=universal_search'),
(15, 'John Wick 4', 'Cuarta entrega del implacable asesino John Wick.', 2023, 169, 9, 'johnwick4.jpg', '2023-03-24', '2025-10-30 14:22:00', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.a183463a-b642-40fe-9457-99d9ea5e0be1?autoplay=0&ref_=atv_cf_strg_wb'),
(16, 'Misión Imposible: Sentencia Mortal', 'Nueva misión de Ethan Hunt.', 2023, 163, 10, 'mi7.jpg', '2023-07-14', '2025-10-30 14:22:00', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.11311722-0576-4b19-b2fd-01561f3a3e4d?autoplay=0&ref_=atv_cf_strg_wb'),
(17, 'The Marvels', 'Marvel presenta nueva aventura espacial.', 2023, 105, 11, 'themarvels.jpg', '2023-11-10', '2025-10-30 14:22:00', 3, 'https://www.disneyplus.com/es-es/browse/entity-75c90eca-8969-4edb-ac1a-7165cff2671c?distributionPartner=google'),
(18, 'Wonka', 'Historia de origen de Willy Wonka.', 2023, 112, 12, 'wonka.jpg', '2023-12-15', '2025-10-30 14:22:00', 4, 'https://www.hbomax.com/es/es/movies/wonka/c34d4c23-39eb-4eb8-95dd-209fa0cb3fb4?utm_source=universal_search'),
(19, 'Indiana Jones y el Dial del Destino', 'Nueva aventura de Indiana Jones.', 2023, 142, 13, 'indianajones5.jpg', '2023-06-30', '2025-10-30 14:22:00', 3, 'https://www.disneyplus.com/play/f4bbe891-e949-4a15-9df1-6c2e87cca2bc?distributionPartner=google'),
(20, 'Killers of the Flower Moon', 'Drama criminal dirigido por Scorsese.', 2023, 206, 14, 'killersoftheflowermoon.jpg', '2023-10-20', '2025-10-30 14:22:00', 5, 'https://tv.apple.com/es/movie/los-asesinos-de-la-luna/umc.cmc.5x1fg9vferlfeutzpq6rra1zf?action=play'),
(21, 'Black Phone 2', 'Black Phone 2 es una película estadounidense de terror sobrenatural de 2025 dirigida por Scott Derrickson a partir de un guion que coescribió la película con C. Robert Cargill y producida por Jason Blum. Es la secuela de The Black Phone', 2025, 114, 15, 'blackphonedos.jpg', '2025-11-24', '2025-11-03 08:38:15', 2, 'https://www.youtube.com/watch?reload=9&v=szKBR8NLPAk');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_actor`
--

CREATE TABLE `pelicula_actor` (
  `pelicula_id` int NOT NULL,
  `actor_id` int NOT NULL
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
(4, 8),
(11, 9),
(18, 9),
(11, 10),
(12, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(19, 18),
(20, 20),
(21, 21),
(21, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_genero`
--

CREATE TABLE `pelicula_genero` (
  `pelicula_id` int NOT NULL,
  `genero_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_genero`
--

INSERT INTO `pelicula_genero` (`pelicula_id`, `genero_id`) VALUES
(4, 1),
(12, 1),
(15, 1),
(16, 1),
(17, 1),
(19, 1),
(1, 2),
(11, 2),
(17, 2),
(2, 3),
(12, 3),
(4, 4),
(11, 4),
(13, 4),
(20, 4),
(14, 5),
(18, 5),
(2, 6),
(11, 6),
(12, 6),
(16, 6),
(19, 6),
(4, 7),
(5, 7),
(21, 7),
(14, 8),
(18, 8),
(13, 9),
(20, 10),
(13, 11),
(15, 11),
(19, 11),
(20, 11),
(20, 12),
(18, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

CREATE TABLE `plataformas` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
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
(6, 'Filmin', 'Plataforma española especializada en cine independiente y de autor.', 'https://www.filmin.es'),
(7, 'Movistar +', 'Plataforma de Movistar', 'https://www.movistarplus.es/'),
(8, 'Youtube', 'Plataforma de Vídeos ', 'https://www.youtube.com/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('admin','usuario') COLLATE utf8mb4_general_ci DEFAULT 'usuario',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'admin', 'admin@admin.es', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'admin', '2025-10-27 12:58:11'),
(2, 'elPol', 'pablo.benlloch00@gmail.com', '$2y$10$nKr2lpyHeTNxii9b3ttpX.ezTJp8VqvpM6La6S4HW5iceYa3mKS4e', 'usuario', '2025-10-27 15:47:29'),
(5, 'paula25', 'paula@prueba.es', '$2y$10$TEJH.WC7YA4EqkAycJqfpe6tMxy.89a/ipuOt.YxuNRxxIy4xHayW', 'usuario', '2025-10-27 16:23:55'),
(6, 'elPol2', 'pablo.benlloch01@gmail.com', '$2y$10$wwBPk5OA5bjVBiuGEe4d1.eBTQoPXEp726V.LwepYrvB.ilE.EFlm', 'usuario', '2025-10-30 14:43:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `pelicula_id` int DEFAULT NULL,
  `puntuacion` tinyint DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
