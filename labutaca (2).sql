-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-11-2025 a las 12:46:25
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
(1, 'Zoe Saldaña', '1978-06-19', 'Protagonista de Avatar.', 'zoesaldaa.png'),
(2, 'Sam Worthington', '1976-08-02', 'Actor principal en Avatar.', 'samworthington.png'),
(3, 'Jason Momoa', '1979-08-01', 'Protagonista en la película de Minecraft.', 'jasonmomoa.png'),
(4, 'Jack Black', '1969-08-28', 'Actor principal en La película Minecraft.', 'jackblack.png'),
(5, 'Daniel Craig', '1968-03-02', 'Detective Benoit Blanc en Puñales por la espalda. Yes', 'danielcraig.png'),
(6, 'Josh Brolin', '1968-02-12', 'Actor en Puñales por la espalda 3.', 'joshbrolin.png'),
(7, 'Josh Hutcherson', '1992-10-12', 'Actor principal en Five Nights at Freddy\'s.', 'joshhutcherson.png'),
(8, 'Elizabeth Lail', '1992-03-25', 'Actriz principal en Five Nights at Freddy\'s.', 'elizabethlail.png'),
(9, 'Timothée Chalamet', '1995-12-27', 'Protagonista en Dune: Parte Dos y Wonka.', 'timothechalamet.png'),
(10, 'Zendaya', '1996-09-01', 'Protagonista de Dune: Parte Dos.', 'zendaya.png'),
(11, 'Shameik Moore', '1995-05-04', 'Voz de Miles Morales en Spiderman: Cruzando el Multiverso.', 'shameikmoore.png'),
(12, 'Hailee Steinfeld', '1996-12-11', 'Voz de Gwen Stacy en Spiderman: Cruzando el Multiverso.', 'haileesteinfeld.png'),
(13, 'Cillian Murphy', '1976-05-25', 'Actor principal en Oppenheimer.', 'cillianmurphy.png'),
(14, 'Margot Robbie', '1990-07-02', 'Protagonista en Barbie.', 'margotrobbie.png'),
(15, 'Keanu Reeves', '1964-09-02', 'Protagonista en John Wick 4.', 'keanureeves.png'),
(16, 'Tom Cruise', '1962-07-03', 'Actor principal en Misión Imposible: Sentencia Mortal.', 'tomcruise.png'),
(17, 'Brie Larson', '1989-10-01', 'Protagonista en The Marvels.', 'brielarson.png'),
(18, 'Harrison Ford', '1942-07-13', 'Protagonista en Indiana Jones y el Dial del Destino.', 'harrisonford.png'),
(19, 'Leonardo DiCaprio', '1974-11-11', 'Protagonista en Killers of the Flower Moon.', 'leonardodicaprio.png'),
(22, 'Ryan Gosling', '1980-11-12', 'Actor canadiense', 'ryangosling.png'),
(27, 'Ivana Baquero', '1994-06-11', 'Actriz española olé', 'ivanabaquero.png'),
(30, 'Tim Allen', '1953-06-13', 'Actor estadounidense', 'timallen.png'),
(32, 'Tom Hanks', '1956-07-09', 'Actor estadounidense, protagonista de Forrest Gump, Náufrago, Toy Story.', 'tomhanks.png'),
(33, 'Matthew McConaughey', '1969-11-04', 'Actor estadounidense, Interestelar, Dallas Buyers Club.', 'matthewmcconaughey.png'),
(34, 'Felicity Jones', '1983-10-17', 'Actriz británica, La teoría del todo, Rogue One.', 'felicityjones.png'),
(35, 'Ralph Fiennes', '1962-12-22', 'Actor británico, protagonista de El Gran Hotel Budapest.', 'ralphfiennes.png'),
(36, 'Tony Revolori', '1996-04-28', 'Actor estadounidense-guatemalteco, El Gran Hotel Budapest.', 'tonyrevolori.png'),
(37, 'Russell Crowe', '1964-04-07', 'Actor neozelandés-australiano, protagonista de Gladiator.', 'russellcrowe.png'),
(38, 'Audrey Tautou', '1976-08-09', 'Actriz francesa, Amelie, El código Da Vinci.', 'audreytautou.png'),
(39, 'Kate Winslet', '1975-10-05', 'Actriz británica, Titanic, El lector.', 'katewinslet.png'),
(41, 'Marlon Brando', '1924-04-03', 'Actor fallecido estadounidense, protagonista de El Padrino.', 'marlonbrando.png'),
(42, 'Al Pacino', '1940-04-25', 'Actor estadounidense, El Padrino, Scarface.', 'alpacino.png'),
(43, 'Sam Neill', '1947-09-14', 'Actor neozelandés, protagonista de Jurassic Park.', 'samneill.png'),
(44, 'Laura Dern', '1967-02-10', 'Actriz estadounidense, Jurassic Park, Marriage Story.', 'lauradern.png'),
(45, 'Tommy Lee Jones', '1946-09-15', 'Actor estadounidense, El fugitivo, Men in Black.', 'tommyleejones.png'),
(46, 'Billy Crystal', '1948-03-14', 'Actor estadounidense, Monsters, Inc., Cuando Harry conoció a Sally.', 'billycrystal.png'),
(48, 'Emma Stone', '1988-11-06', 'Actriz estadounidense, La La Land, Maniac.', 'emmastone.png'),
(49, 'Dakota Fanning', '1994-02-23', 'Actriz estadounidense, Coraline (voz), Guerra de los Mundos.', 'dakotafanning.png'),
(50, 'Elijah Wood', '1981-01-28', 'Actor estadounidense, Frodo en El Señor de los Anillos.', 'elijahwood.png'),
(51, 'Ian McKellen', '1939-05-25', 'Actor británico, Gandalf en El Señor de los Anillos.', 'ianmckellen.png'),
(52, 'J.K. Simmons', '1955-01-09', 'Actor estadounidense, Whiplash, Spider-Man.', 'jksimmons.png'),
(53, 'Pablo Benlloch Torres', '2006-07-28', 'Actor de 19 años', 'pablobenllochtorres.png'),
(54, 'José Luis Puchades Nova', '2002-07-01', 'Actor y Director de Pesadilla en Navidad', 'josluispuchadesnova.png'),
(55, 'David Guijarro', '2006-09-23', 'Un tío sexy , elegante y guapo', 'davidguijarro.png'),
(56, 'Adrían Huelamo', '2004-11-03', 'El Plex del Solvam', 'adranhuelamo.png'),
(57, 'Robert De Niro', '1943-08-17', 'Robert Anthony De Niro es un actor estadounidense, ganador de dos Premios Óscar por su actuación en las películas El padrino: Parte II como un joven Vito Corleone y Toro salvaje como Jake LaMotta.', 'robertdeniro.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text COLLATE utf8mb4_general_ci,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `fecha_nacimiento`, `biografia`, `imagen`) VALUES
(1, 'James Cameron', '1954-08-16', 'Director canadiense famoso por Titanic y Avatar.', 'jamescameron.webp'),
(2, 'Jared Hess', '1979-07-18', 'Director estadounidense conocido por Napoleon Dynamite.', 'jaredhess.jpg'),
(4, 'Emma Tammi', '1984-03-07', 'Directora estadounidense, Five Nights at Freddy\'s 2.', 'emmatammi.webp'),
(5, 'Denis Villeneuve', '1967-10-03', 'Director canadiense de ciencia ficción y thrillers, conocido por Dune, Blade Runner 2049 y La llegada.', 'denisvilleneuve.webp'),
(6, 'Joaquim Dos Santos', '1977-12-22', 'Director estadounidense de animación, co-director de Spiderman: Cruzando el multiverso.', 'joaquimdossantos.jpg'),
(7, 'Christopher Nolan', '1970-07-30', 'Director británico, famoso por películas como Inception, Interstellar y Oppenheimer.', 'christophernolan.webp'),
(8, 'Greta Gerwig', '1983-08-04', 'Directora y guionista estadounidense, reconocida por Mujercitas y Barbie.', 'gretagerwig.webp'),
(9, 'Chad Stahelski', '1968-09-20', 'Director y doble de acción estadounidense, conocido por la saga John Wick.', 'chadstahelski.jpg'),
(10, 'Christopher McQuarrie', '1968-10-25', 'Director y guionista estadounidense, responsable de Misión Imposible 5, 6 y 7.', 'christophermcquarrie.webp'),
(11, 'Nia DaCosta', '1989-11-08', 'Directora y guionista estadounidense, reconocida por The Marvels y Candyman.', 'niadacosta.jpeg'),
(12, 'Paul King', '1978-07-06', 'Director británico de cine y televisión, conocido por Paddington y Wonka.', 'paulking.jpg'),
(13, 'James Mangold', '1963-12-16', 'Director y guionista estadounidense, conocido por Logan, Ford v Ferrari e Indiana Jones 5.', 'jamesmangold.jpg'),
(14, 'Martin Scorsese', '1942-11-17', 'Legendario director estadounidense, famoso por Taxi Driver, Goodfellas y Killers of the Flower Moon.', 'martinscorsese.jpeg'),
(16, 'Damien Chazelle', '1985-01-19', 'Director estadounidense', 'damienchazelle.png'),
(18, 'Ridley Scott', '1937-11-30', 'Director británico', 'ridleyscott.webp'),
(19, 'Robert Zemeckis', '1951-05-14', 'Director estadounidense', 'robertzemeckis.webp'),
(21, 'Guillermo del Toro', '1964-10-09', 'Director mexicano', 'guillermodeltoro.webp'),
(23, 'Todd Phillips', '1970-12-20', 'Director estadounidense', 'toddphillips.jpg'),
(24, 'Lana Wachowski', '1965-06-21', 'Creadora de Matrix junto a Lilly Wachowski.', 'lanawachowski.jpg'),
(33, 'Steven Spielberg', '1946-12-18', 'Director estadounidense, creador de Jurassic Park, ET, Indiana Jones.', 'stevenspielberg.jpg'),
(41, 'Wes Anderson', '1969-05-01', 'Director y guionista estadounidense, conocido por su estilo único.', 'wesanderson.jpg'),
(45, 'Francis Ford Coppola', '1939-04-07', 'Director estadounidense responsable de El Padrino.', 'francisfordcoppola.jpeg'),
(51, 'Peter Jackson', '1961-10-31', 'Director neozelandés de El Señor de los Anillos.', 'peterjackson.jpg'),
(52, 'Pablo Benlloch Torres', '2006-07-28', 'Director y Actor de Pesadilla en Navidad', 'pablobenllochtorres.png'),
(53, 'David Guijarro', '2006-09-23', 'Un tío sexy , elegante y guapo', 'davidguijarro.png'),
(54, 'Alan Parker', '1944-02-14', 'Actor Fallecido : Alan Parker, fue un director y productor de cine, escritor y actor británico. Trabajó tanto en la industria del cine del Reino Unido como en la de Hollywood y fue uno de los fundadores del Director\'s Guild de Gran Bretaña.', 'alanparker.webp');

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
(16, 'Documental'),
(4, 'Drama'),
(8, 'Fantasia'),
(14, 'Histórico'),
(15, 'Infantil'),
(13, 'Musical'),
(19, 'Noir'),
(18, 'Policiaco'),
(11, 'Suspense'),
(7, 'Terror'),
(17, 'Western');

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
  `plataforma_id` int DEFAULT NULL,
  `LINK` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `descripcion`, `anio`, `duracion`, `director_id`, `imagen`, `fecha_estreno`, `plataforma_id`, `LINK`) VALUES
(1, 'Avatar: Fire and Ash', 'Tercera entrega de la saga Avatar, en Pandora.', 2025, 170, 1, 'avatar3.jpg', '2025-12-19', 4, 'https://youtu.be/lhLsr9S3bgQ?si=RvmERvpl_PLYGhZB'),
(2, 'Una película de Minecraft', 'Adaptación del popular juego Minecraft.', 2025, 125, 2, 'minecraft.jpg', '2025-04-04', 4, 'https://www.hbomax.com/es/es/movies/una-pelicula-de-minecraft/05eee581-3112-4515-b17f-219ff6265ef8?utm_source=universal_search'),
(4, 'Five Nights at Freddy\'s', 'Secuela de terror basada en el videojuego.', 2025, 110, 4, 'fnaf.jpg', '2025-12-05', 7, 'https://www.movistarplus.es/cine/five-nights-at-freddy-s/ficha?tipo=E&id=3263458&origen=GGL&referrer=GGL&utm_campaign=product_feed&utm_medium=aggregator&utm_source=google'),
(5, 'Pesadilla en Navidad', 'Pesadilla de Guillermo', 2023, 20, 52, 'pesadilla.png', '2023-12-25', 8, 'https://youtu.be/--dGfVyuTks?si=D4Tn-JjIzW7k5PQS'),
(11, 'Dune: Parte Dos', 'Secuela de Dune con nuevas aventuras en Arrakis.', 2024, 155, 5, 'dune2.jpg', '2024-03-01', 4, 'https://www.hbomax.com/es/es/movies/dune-parte-dos/f0a4f239-0b57-47e2-a39a-54fb96925e61?utm_source=universal_search'),
(12, 'Spiderman: Cruzando el Multiverso', 'Nueva entrega animada de Spiderman.', 2023, 140, 6, 'spiderverse2.jpg', '2023-06-16', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.08bf002f-a5e6-4c0d-9288-6e83a129e2d4?autoplay=0&ref_=atv_cf_strg_wb'),
(13, 'Oppenheimer', 'Drama biográfico dirigido por Christopher Nolan.', 2023, 180, 7, 'oppenheimer.jpg', '2023-07-21', 2, 'https://www.youtube.com/watch?v=MVvGSBKV504'),
(14, 'Barbie', 'Comedia y fantasía protagonizada por Margot Robbie.', 2023, 125, 8, 'barbie.jpg', '2023-08-05', 4, 'https://www.hbomax.com/es/es/movies/barbie/80bc4915-c826-499f-9961-b422b17559b6?utm_source=universal_search'),
(15, 'John Wick 4', 'Cuarta entrega del implacable asesino John Wick.', 2023, 169, 9, 'johnwick4.jpg', '2023-03-24', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.a183463a-b642-40fe-9457-99d9ea5e0be1?autoplay=0&ref_=atv_cf_strg_wb'),
(16, 'Misión Imposible: Sentencia Mortal', 'Nueva misión de Ethan Hunt.', 2023, 163, 10, 'mi7.jpg', '2023-07-14', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.11311722-0576-4b19-b2fd-01561f3a3e4d?autoplay=0&ref_=atv_cf_strg_wb'),
(17, 'The Marvels', 'Marvel presenta nueva aventura espacial.', 2023, 105, 11, 'themarvels.jpg', '2023-11-10', 3, 'https://www.disneyplus.com/es-es/browse/entity-75c90eca-8969-4edb-ac1a-7165cff2671c?distributionPartner=google'),
(18, 'Wonka', 'Historia de origen de Willy Wonka.', 2023, 112, 12, 'wonka.jpg', '2023-12-15', 4, 'https://www.hbomax.com/es/es/movies/wonka/c34d4c23-39eb-4eb8-95dd-209fa0cb3fb4?utm_source=universal_search'),
(19, 'Indiana Jones y el Dial del Destino', 'Nueva aventura de Indiana Jones.', 2023, 142, 13, 'indianajones5.jpg', '2023-06-30', 3, 'https://www.disneyplus.com/play/f4bbe891-e949-4a15-9df1-6c2e87cca2bc?distributionPartner=google'),
(20, 'Killers of the Flower Moon', 'Drama criminal dirigido por Scorsese.', 2023, 206, 14, 'killersoftheflowermoon.jpg', '2023-10-20', 5, 'https://tv.apple.com/es/movie/los-asesinos-de-la-luna/umc.cmc.5x1fg9vferlfeutzpq6rra1zf?action=play'),
(21, 'Matrix', 'Un hacker descubre la verdad sobre su realidad.', 1999, 136, 24, 'matrix.png', '1999-03-31', 1, 'https://www.netflix.com/title/20557937'),
(22, 'Forrest Gump', 'Un hombre con un gran corazón vive increíbles aventuras.', 1994, 142, 19, 'forrestgump.jpg', '1994-07-06', 2, 'https://www.primevideo.com/forrestgump'),
(23, 'Interestelar', 'Un equipo de exploradores viaja a través de un agujero de gusano.', 2014, 169, 9, 'interestelar.png', '2014-11-07', 2, 'https://www.primevideo.com/dp/amzn1.dv.gti.b4a9f7c6-5def-7e63-9aa7-df38a479333e?autoplay=0&ref_=atv_cf_strg_wb'),
(24, 'El Gran Hotel Budapest', 'Las peripecias del conserje de un hotel europeo entre guerras.', 2014, 99, 16, 'elgranhotelbudapest.png', '2014-03-28', 3, 'https://www.disneyplus.com/es-es/browse/entity-6a6e4a89-b567-47af-9943-1b5230a2d6cd?distributionPartner=google'),
(25, 'Gladiator', 'Un general romano lucha por vengar la muerte de su familia.', 2000, 155, 18, 'gladiator.png', '2000-05-05', 3, 'https://www.disneyplus.com/es-es/browse/entity-2379bace-e85c-4ca5-9621-63b77ed5f176?distributionPartner=google'),
(27, 'Titanic', 'Romance en el famoso transatlántico.', 1997, 195, 1, 'titanic.png', '1997-12-19', 4, 'https://www.disneyplus.com/es-es/browse/entity-ed94de01-f394-4d37-9888-1186bd143ec8?distributionPartner=google'),
(28, 'El Padrino', 'La vida de la familia Corleone.', 1972, 175, 21, 'elpadrino.png', '1972-03-15', 6, 'https://www.primevideo.com/dp/amzn1.dv.gti.64a9f786-efb1-28d3-bf27-6038d12cc53a?autoplay=0&ref_=atv_cf_strg_wb'),
(29, 'Inception', 'Un ladrón roba secretos a través de los sueños.', 2010, 148, 7, 'inception.png', '2010-07-16', 1, 'https://www.netflix.com/inception'),
(30, 'Jurassic Park', 'Dinosaurios reviven en una isla.', 1993, 127, 33, 'jurassicpark.png', '1993-06-11', 2, 'https://www.primevideo.com/jurassicpark'),
(32, 'La La Land', 'Un pianista y una actriz persiguen sus sueños en Los Ángeles.', 2016, 128, 16, 'lalaland.png', '2016-12-09', 10, 'https://www.hbomax.com/lalaland'),
(34, 'El Señor de los Anillos: La Comunidad del Anillo', 'Un hobbit inicia la misión de destruir un anillo mágico.', 2001, 178, 51, 'elseordelosanilloslacomunidaddelanillo.png', '2001-12-19', 1, 'https://www.netflix.com/es/title/60004480?source=35&fromWatch=true'),
(35, 'Whiplash', 'Un joven baterista y su exigente profesor.', 2014, 106, 16, 'whiplash.png', '2014-10-10', 1, 'https://www.filmin.es/whiplash'),
(37, 'El Ascenso del Zeta FC', 'El Documental que nos cuenta desde la creación hasta la llegada a la cima del Zeta FC', 2026, 90, 52, 'httpswwwyoutubecomwatchvlpq3jyr9jiq.png', '2026-03-25', 8, 'https://youtu.be/LpQ3jyR9jIQ?si=CveR1ALQB1UBE3Sw'),
(38, 'El corazón del ángel', 'A Harry Angel (Mickey Rourke), un detective privado que está pasando una mala racha, lo contrata en Nueva York un peculiar y enigmático personaje, Louis Cyphre (Robert De Niro), para que encuentre a un hombre desaparecido.', 1987, 113, 54, 'elcorazndelngel.jpg', '1987-03-06', 7, 'https://www.movistarplus.es/cine/el-corazon-del-angel/ficha?tipo=E&id=540&origen=GGL&referrer=GGL&utm_campaign=product_feed&utm_medium=aggregator&utm_source=google');

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
(23, 9),
(11, 10),
(12, 11),
(12, 12),
(13, 13),
(29, 13),
(14, 14),
(15, 15),
(21, 15),
(16, 16),
(17, 17),
(19, 18),
(20, 19),
(27, 19),
(29, 19),
(32, 22),
(22, 32),
(23, 33),
(24, 35),
(24, 36),
(25, 37),
(28, 41),
(28, 42),
(30, 43),
(32, 48),
(34, 50),
(34, 51),
(32, 52),
(35, 52),
(5, 53),
(37, 53),
(5, 54),
(37, 54),
(37, 55),
(37, 56),
(38, 57);

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
(21, 1),
(24, 1),
(25, 1),
(30, 1),
(37, 1),
(1, 2),
(11, 2),
(17, 2),
(21, 2),
(23, 2),
(29, 2),
(30, 2),
(34, 2),
(2, 3),
(12, 3),
(4, 4),
(11, 4),
(13, 4),
(20, 4),
(22, 4),
(27, 4),
(35, 4),
(14, 5),
(18, 5),
(22, 5),
(2, 6),
(11, 6),
(12, 6),
(16, 6),
(19, 6),
(23, 6),
(4, 7),
(5, 7),
(38, 7),
(14, 8),
(18, 8),
(30, 8),
(34, 8),
(13, 9),
(20, 10),
(28, 10),
(13, 11),
(19, 11),
(20, 11),
(23, 11),
(24, 11),
(25, 11),
(27, 11),
(28, 11),
(29, 11),
(18, 13),
(32, 13),
(25, 14),
(37, 16);

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
(8, 'Youtube', 'Plataforma de Vídeos ', 'https://www.youtube.com/'),
(9, 'Aún en Cine', 'Aún disponible en Cine', NULL),
(10, 'Sin Plataforma', 'No está en ninguna plataforma ', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `pelicula_id` int NOT NULL,
  `puntuacion_estrellas` int NOT NULL,
  `puntuacion_imdb` int NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id`, `usuario_id`, `pelicula_id`, `puntuacion_estrellas`, `puntuacion_imdb`, `comentario`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 2, 1, 4, 80, 'No la he visto aún', '2025-11-03 14:42:44', '2025-11-03 14:42:44'),
(2, 5, 1, 1, 100, 'Basura', '2025-11-03 14:43:34', '2025-11-03 14:44:15'),
(3, 6, 1, 5, 100, 'En efecto , es cine', '2025-11-03 14:45:10', '2025-11-03 14:50:33');

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
(2, 'elPol', 'pablo.benlloch7@gmail.com', '$2y$10$7kv7cqJwnzRRjOWwWI2V6.T35tPayrvIljC9eK3h27.OogOUcUGSy', 'usuario', '2025-10-27 15:47:29'),
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
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unica_resena_usuario` (`usuario_id`,`pelicula_id`),
  ADD KEY `pelicula_id` (`pelicula_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `resenas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resenas_ibfk_2` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE;

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
