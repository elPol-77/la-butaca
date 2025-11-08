-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2025 a las 12:49:22
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
(57, 'Robert De Niro', '1943-08-17', 'Robert Anthony De Niro es un actor estadounidense, ganador de dos Premios Óscar por su actuación en las películas El padrino: Parte II como un joven Vito Corleone y Toro salvaje como Jake LaMotta.', 'robertdeniro.webp'),
(58, 'Scarlett Johansson', '1984-11-22', 'Scarlett Ingrid Johansson es una actriz estadounidense que también se ha desempeñado de manera eventual como cantante, productora, modelo y empresaria. Conocida por su papel de Black Vidow/Viuda Negra en Los Vengadores de Marvel', 'scarlettjohansson.png'),
(59, 'Chris Evans', '1981-06-13', 'Christopher Robert Evans, conocido simplemente como Chris Evans, es un actor, actor de voz, director y productor de cine estadounidense. Criado en el pueblo de Sudbury, mostró interés a temprana edad por la actuación y se mudó a Nueva York para estudiar teatro después de terminar la secundaria. Conocido por su papel de Capitán América en Marvel', 'chrisevans.png'),
(60, 'Chris Hemsworth', '1983-08-11', 'Christopher Hemsworth es un actor, actor de voz y productor australiano. Criado en la comunidad de Bulman, al norte de Australia, mostró interés por la actuación motivado por su hermano mayor e inició su carrera en 2002 con apariciones menores en series de televisión de su país. Conocido por su papel de Thor en Marvel', 'chrishemsworth.png'),
(61, 'Robert Downey Jr.', '1965-04-04', 'Robert John Downey Jr. es un actor, actor de voz, productor y cantante estadounidense. Inició su carrera como actor a temprana edad en varios filmes dirigidos por su padre, Robert Downey Sr., y en su infancia estudió actuación en varias academias de Nueva York. Conocido por su papel de Iron Man en Marvel', 'robertdowneyjr.png'),
(62, 'Mark Ruffalo', '1967-11-22', 'Mark Alan Ruffalo es un actor, actor de voz, productor y director estadounidense. Inició su carrera como actor en los años 1990 apareciendo en varias series de televisión y películas con papeles menores hasta que logró reconocimiento con la película You Can Count On Me. Conocido por su papel como Hulk en Marvel.', 'markruffalo.png'),
(63, 'Jeremy Renner', '1971-01-07', 'Jeremy Lee Renner es un actor, actor de voz, productor y músico estadounidense. Inició su carrera como actor en 1995 con apariciones en varios proyectos de su universidad y posteriormente como protagonista de filmes independientes, entre ellos Dahmer, en el que su actuación recibió buenos comentarios. Conocido por su papel como Ojo de Halcón/Hawkeye en Marvel', 'jeremyrenner.png'),
(64, 'Samuel L. Jackson', '1948-12-21', 'Samuel Leroy Jackson es un actor y productor de cine, televisión y teatro estadounidense. Ha sido candidato al Premio Óscar, a los Globos de Oro y al Premio del Sindicato de Actores, así como ganador de un BAFTA al mejor actor de reparto y en 2022 se le entregó un Óscar honorífico a su trayectoria profesional . Conocido por papeles como Nick Fury de Marvel entre otros.', 'samuelljackson.png'),
(65, 'Tom Hiddleston', '1981-02-09', 'Thomas William Hiddleston es un actor y productor de cine británico. Fue galardonado con el premio Globo de oro por su interpretación en The Night Manager. Conocido por su papel como Loki en Marvel', 'tomhiddleston.png'),
(66, 'Taissa Farmiga', '1994-08-17', 'Taissa Alexandra Farmiga es una actriz estadounidense conocida por interpretar diversos papeles en la serie de televisión American Horror Story.', 'taissafarmiga.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `imagen` varchar(255) NOT NULL
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
(53, 'David Guijarro', '2006-09-23', 'Un tío sexy , elegante y guapo.', 'davidguijarro.png'),
(54, 'Alan Parker', '1944-02-14', 'Actor Fallecido : Alan Parker, fue un director y productor de cine, escritor y actor británico. Trabajó tanto en la industria del cine del Reino Unido como en la de Hollywood y fue uno de los fundadores del Director\'s Guild de Gran Bretaña.', 'alanparker.webp'),
(55, 'Joss Whedon', '1964-06-23', 'Joseph Hill Whedon, conocido como Joss Whedon, es un director, guionista y productor de cine estadounidense.​ Director de Los Vengadores', 'josswhedon.png'),
(56, 'Corin Hardy', '1975-01-06', 'Corin Hardy ​ es un director de cine británico. Debutó como director con la película de terror de 2015 The Hallow, que también coescribió.​​​Dirigió la película de terror de 2018 La Monja, ​ un spin-off de The Conjuring 2 y la quinta película del Universo El Conjuro. ​', 'corinhardy.png');

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
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `anio` int(11) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `plataforma_id` int(11) DEFAULT NULL,
  `LINK` varchar(500) NOT NULL
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
(38, 'El corazón del ángel', 'A Harry Angel (Mickey Rourke), un detective privado que está pasando una mala racha, lo contrata en Nueva York un peculiar y enigmático personaje, Louis Cyphre (Robert De Niro), para que encuentre a un hombre desaparecido.', 1987, 113, 54, 'elcorazndelngel.jpg', '1987-03-06', 7, 'https://www.movistarplus.es/cine/el-corazon-del-angel/ficha?tipo=E&id=540&origen=GGL&referrer=GGL&utm_campaign=product_feed&utm_medium=aggregator&utm_source=google'),
(39, 'Los Vengadores', 'Cuando un enemigo inesperado surge como una gran amenaza para la seguridad mundial, Nick Fury, director de la Agencia SHIELD, decide reclutar a un equipo para salvar al mundo de un desastre casi seguro.', 2012, 143, 55, 'losvengadores.png', '2012-04-27', 3, 'https://www.disneyplus.com/es-es/browse/entity-3a5596d6-5133-4a8e-8d21-00e1531a4e0f'),
(40, 'La Monja', 'Una monja se suicida en una abadía rumana y el Vaticano envía a un sacerdote y una novicia a investigar lo sucedido. Lo que ambos encuentran allí es un secreto perverso que los enfrentará cara a cara con el mal en su esencia más pura.', 2018, 96, 56, 'lamonja.png', '2018-09-07', 7, 'https://www.movistarplus.es/cine/la-monja/ficha?tipo=E&id=1579733&origen=GGL&referrer=GGL&utm_campaign=product_feed&utm_medium=aggregator&utm_source=google');

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
(4, 8),
(5, 53),
(5, 54),
(11, 9),
(11, 10),
(12, 11),
(12, 12),
(13, 13),
(13, 61),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 9),
(19, 18),
(20, 19),
(21, 15),
(22, 32),
(23, 9),
(23, 33),
(24, 35),
(24, 36),
(25, 37),
(27, 19),
(28, 41),
(28, 42),
(29, 13),
(29, 19),
(30, 43),
(32, 22),
(32, 48),
(32, 52),
(34, 50),
(34, 51),
(35, 52),
(37, 53),
(37, 54),
(37, 55),
(37, 56),
(38, 57),
(39, 58),
(39, 59),
(39, 60),
(39, 61),
(39, 62),
(39, 63),
(39, 64),
(39, 65),
(40, 66);

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
(1, 2),
(2, 3),
(2, 6),
(4, 1),
(4, 4),
(4, 7),
(5, 7),
(11, 2),
(11, 4),
(11, 6),
(12, 1),
(12, 3),
(12, 6),
(13, 4),
(13, 9),
(13, 11),
(14, 5),
(14, 8),
(15, 1),
(16, 1),
(16, 6),
(17, 1),
(17, 2),
(18, 5),
(18, 8),
(18, 13),
(19, 1),
(19, 6),
(19, 11),
(20, 4),
(20, 10),
(20, 11),
(21, 1),
(21, 2),
(22, 4),
(22, 5),
(23, 2),
(23, 6),
(23, 11),
(24, 1),
(24, 11),
(25, 1),
(25, 11),
(25, 14),
(27, 4),
(27, 11),
(28, 10),
(28, 11),
(29, 2),
(29, 11),
(30, 1),
(30, 2),
(30, 8),
(32, 13),
(34, 2),
(34, 8),
(35, 4),
(37, 1),
(37, 16),
(38, 7),
(39, 1),
(39, 2),
(39, 6),
(40, 7);

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
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pelicula_id` int(11) NOT NULL,
  `puntuacion_estrellas` int(11) NOT NULL,
  `puntuacion_imdb` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id`, `usuario_id`, `pelicula_id`, `puntuacion_estrellas`, `puntuacion_imdb`, `comentario`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 2, 1, 4, 80, 'No la he visto aún', '2025-11-03 14:42:44', '2025-11-03 14:42:44'),
(2, 5, 1, 1, 100, 'Basura', '2025-11-03 14:43:34', '2025-11-03 14:44:15'),
(3, 6, 1, 5, 100, 'En efecto , es cine', '2025-11-03 14:45:10', '2025-11-03 14:50:33'),
(4, 2, 14, 4, 80, '', '2025-11-05 14:36:47', '2025-11-05 14:38:08'),
(5, 2, 11, 1, 20, '', '2025-11-05 14:38:34', '2025-11-05 14:38:34'),
(6, 2, 4, 4, 80, 'Espero la segunda parte', '2025-11-05 19:14:14', '2025-11-05 19:14:14'),
(7, 8, 4, 2, 40, '', '2025-11-05 19:15:21', '2025-11-05 19:15:21'),
(8, 9, 37, 5, 100, 'Pendejos no duran nada', '2025-11-06 09:30:04', '2025-11-06 09:30:04');

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
(2, 'elPol', 'pablo.benlloch7@gmail.com', '$2y$10$7kv7cqJwnzRRjOWwWI2V6.T35tPayrvIljC9eK3h27.OogOUcUGSy', 'usuario', '2025-10-27 15:47:29'),
(5, 'paula25', 'paula@prueba.es', '$2y$10$TEJH.WC7YA4EqkAycJqfpe6tMxy.89a/ipuOt.YxuNRxxIy4xHayW', 'usuario', '2025-10-27 16:23:55'),
(6, 'elPol2', 'pablo.benlloch01@gmail.com', '$2y$10$wwBPk5OA5bjVBiuGEe4d1.eBTQoPXEp726V.LwepYrvB.ilE.EFlm', 'usuario', '2025-10-30 14:43:24'),
(8, 'elPol4', 'pablo.benlloch0@gmail.com', '$2y$10$b4EbZZbVmc./CdifCPrhXOzm.colOWwBZ3iXdgMHc0QcG3lF9QRx2', 'usuario', '2025-11-05 19:14:55'),
(9, 'elmejorenelmundo', 'adrian@solvam.es', '$2y$10$yaVlSlo.tPxBC9yAZ1g9Z.ddV0s8NNr3iXmzbI64PxZR6dve6/FZi', 'usuario', '2025-11-06 09:28:45'),
(10, 'mariluz', 'mariluz@solvam.es', '$2y$10$WrVYUd/0tOopcRb9IWr.5ufBBmPJzo9d6lkQubmOz8SpqpeB5mVdW', 'admin', '2025-11-07 08:57:42'),
(12, 'kaleru', 'joselu@correo.com', '$2y$10$TCieWtiGndOjh8IHF.QDseppQfQkKvhHEhHm0P5lu6mmnF9dDudPS', 'usuario', '2025-11-07 17:06:54');

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actores`
--
ALTER TABLE `actores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
