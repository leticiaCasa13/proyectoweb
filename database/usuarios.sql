-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-05-2025 a las 09:20:26
-- Versión del servidor: 8.0.41-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(4, 'ÁRBOLES'),
(3, 'ARBUSTOS'),
(5, 'DE INTERIOR'),
(1, 'PLANTAS ANUALES'),
(2, 'PLANTAS PERENNES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int NOT NULL,
  `planta_id` int NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `planta_id`, `imagen_url`) VALUES
(342, 342, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav001_b.jpg'),
(343, 343, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav004-01.jpg'),
(344, 344, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav004-02.jpg'),
(345, 345, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV004.jpg'),
(346, 346, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav642.jpg'),
(347, 347, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav640.jpg'),
(348, 348, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav641.jpg'),
(349, 349, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav598.jpg'),
(350, 350, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0853-b.jpg'),
(351, 351, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV014.jpg'),
(352, 352, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV015.jpg'),
(353, 353, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav625.jpg'),
(354, 354, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav016_2.jpg'),
(355, 355, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7228.jpg'),
(356, 356, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7229.jpg'),
(357, 357, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav016-01.jpg'),
(358, 358, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav350.jpg'),
(359, 359, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7208.jpg'),
(360, 360, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7210.jpg'),
(361, 361, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7262.jpg'),
(362, 362, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav449.jpg'),
(363, 363, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav017.jpg'),
(364, 364, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav609.jpg'),
(365, 365, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV070.jpg'),
(366, 366, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV069.jpg'),
(367, 367, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav376-b.jpg'),
(368, 368, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav295.jpg'),
(369, 369, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav072_1.jpg'),
(370, 370, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav073.jpg'),
(371, 371, 'https://www.lavender.com.uy/imagenes/img_presentacion/noimg-productos-lista.jpg'),
(372, 372, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav643.jpg'),
(373, 373, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav073-01_b.jpg'),
(374, 374, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav622.jpg'),
(375, 375, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV075.jpg'),
(376, 376, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV078.jpg'),
(377, 377, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV081.jpg'),
(378, 378, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav435.jpg'),
(379, 379, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV082.jpg'),
(380, 380, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV086.jpg'),
(381, 381, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0856-b.jpg'),
(382, 382, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV156.jpg'),
(383, 383, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV149.jpg'),
(384, 384, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV151.jpg'),
(385, 385, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV249.jpg'),
(386, 386, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV158.jpg'),
(387, 387, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav628.jpg'),
(388, 388, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV166.jpg'),
(389, 389, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV164.jpg'),
(390, 390, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav163.jpg'),
(391, 391, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV242.jpg'),
(392, 392, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav449.jpg'),
(393, 393, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV171.jpg'),
(394, 394, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV179.jpg'),
(395, 395, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV178.jpg'),
(396, 396, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/areca-mini-b.jpg'),
(397, 397, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav655.jpg'),
(398, 398, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV173.jpg'),
(399, 399, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav335.jpg'),
(400, 400, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV241.jpg'),
(401, 401, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0786-b.jpg'),
(402, 402, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV130.jpg'),
(403, 403, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV131.jpg'),
(404, 404, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV168.jpg'),
(405, 405, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV041.jpg'),
(406, 406, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV182.jpg'),
(407, 407, 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV180.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantas`
--

CREATE TABLE `plantas` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `imagen_url` varchar(500) DEFAULT NULL,
  `categoria_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `plantas`
--

INSERT INTO `plantas` (`id`, `nombre`, `descripcion`, `precio`, `imagen_url`, `categoria_id`) VALUES
(342, 'Alisum blanco', ' Mucho Sol y poca agua', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav001_b.jpg', 1),
(343, 'Clavelinas blancas', 'Muy aromáticas.Requieren luz natural.', '70.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav004-01.jpg', 1),
(344, 'Clavelinas fucsias', 'Sol y riego', '70.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav004-02.jpg', 1),
(345, 'Clavelinas rosadas', 'Sol y sombra', '100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV004.jpg', 1),
(346, 'Flor de azucar blanca', 'Sombra parcial.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav642.jpg', 1),
(347, 'Flor de azucar roja', 'Sol y sombra parcial.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav640.jpg', 1),
(348, 'Flor de azucar rosada', 'Sol y sombra parcial.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav641.jpg', 1),
(349, 'Achilea amarilla', 'Pleno Sol. Resistente a la sequia.', '240.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav598.jpg', 2),
(350, 'Achilea roja', 'Abundante sol. Riego, moderado.', '260.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0853-b.jpg', 2),
(351, 'Agapanto AZUL', 'Proteger de las heladas; suelos bien drenados.', '240.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV014.jpg', 2),
(352, 'Agapanto blanco', 'Proteger de las heladas.', '240.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV015.jpg', 2),
(353, 'Agave atenuata', 'Pleno sol. Riego, escaco.', '1100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav625.jpg', 2),
(354, 'Alegría Nueva Guínea blanca', 'Mucho sol. Mucha alegría.', '100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav016_2.jpg', 2),
(355, 'Alegría Nueva Guinea fucsia', 'Mucho sol y riego.', '100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7228.jpg', 2),
(356, 'Alegría Nueva Guinea roja', 'Sol, suelo rico y bien drenado.', '100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7229.jpg', 2),
(357, 'Alegría Nueva Guínea rosada', 'Sol y sombra moderada.', '100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav016-01.jpg', 2),
(358, 'Alegrías blancas', 'Mucho sol.Suelos elquilibrados.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav350.jpg', 2),
(359, 'Alegrías fucsias', 'Sol, mucha luz. Poco riego.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7208.jpg', 2),
(360, 'Alegrías rojas', 'Pleno sol o semisombra.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7210.jpg', 2),
(361, 'Alegrías rosadas', 'Luz y riegos, moderados.', '44.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_7262.jpg', 2),
(362, 'Alocasia', 'Resistente a las sequías.', '2390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav449.jpg', 2),
(363, 'Anémonas Japónica rosada', 'Pleno sol. Riego moderado.', '270.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav017.jpg', 2),
(364, 'Aspidistra (hoja de lata)', 'Resistente al solo. Poco riego.', '380.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav609.jpg', 2),
(365, 'Alegría japonesa', 'Mucho sol, o semisombra.', '480.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV070.jpg', 3),
(366, 'Abelia grandiflora', 'Muy luminosa. Riego abundante.', '390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV069.jpg', 3),
(367, 'Albertine (trepadora)', 'Poco riego.Sombra.', '598.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav376-b.jpg', 3),
(368, 'Aster ', 'Semisombra. Espacios de luz.', '240.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav295.jpg', 3),
(369, 'Azalea solferino ', 'Mucha luz. Resistente al frío.', '720.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav072_1.jpg', 3),
(370, 'Azaleas doble (enana) blanca', 'Luz natural. Riego escaso.', '390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav073.jpg', 3),
(371, 'Azaleas doble (enana) fucsia', 'Luz, riego escaso, semisombra.', '390.00', 'https://www.lavender.com.uy/imagenes/img_presentacion/noimg-productos-lista.jpg', 3),
(372, 'Azaleas doble (enana) roja', 'Sol, y semisombra.', '390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav643.jpg', 3),
(373, 'Azaleas doble (enana) rosada', 'Sol y poco riego. Resistente.', '390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav073-01_b.jpg', 3),
(374, 'Boj cono', 'Muy resistente. Poca luz.', '1390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav622.jpg', 3),
(375, 'Buxus  (boj) sempervirens topiado', 'Muy resistente. Poca luz.', '1100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV075.jpg', 3),
(376, 'Camelia Japónica blanca', 'Luz y riego abundante.', '1750.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV078.jpg', 3),
(377, 'Cufea (blanca)', 'Luz abundante. Riego moderado.', '240.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV081.jpg', 3),
(378, 'Dama de la noche ', 'Abundante riego. Resistente al frío.', '350.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav435.jpg', 3),
(379, 'Duranta azul', 'Luz moderada. Poco riego.', '460.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV082.jpg', 3),
(380, 'Eugenia mirtifolia ', 'Sol y agua.', '560.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV086.jpg', 3),
(381, 'Acers Palmatum', 'Resistente al frío.', '8500.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0856-b.jpg', 4),
(382, 'Limoneros', 'Mucho cuidado, protección contra agentes.', '760.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV156.jpg', 4),
(383, 'Liquidambar Stiraciflua Chico', 'Sol moderado. Semisombra.', '1290.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV149.jpg', 4),
(384, 'Liquidambar Stiraciflua Grande', 'Sol, muy resistente al frío.', '3990.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV151.jpg', 4),
(385, 'Mandarino', 'Resistente. Sol abundante.', '498.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV249.jpg', 4),
(386, 'Naranjos', 'Resistente y abundante luz.', '498.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV158.jpg', 4),
(387, 'Olivo topiado', 'Mucho sol. Resistente.', '9900.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav628.jpg', 4),
(388, 'Phoenix  grande', 'Mucha luz y riego.', '3590.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV166.jpg', 4),
(389, 'Phoenix chica', 'Mucha luz y riego.', '1190.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV164.jpg', 4),
(390, 'Pindó grande', 'Agua abundante y sol.', '2100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav163.jpg', 4),
(391, 'Pomelo', 'Mucha luz y amor.', '498.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV242.jpg', 4),
(392, 'Alocasia', 'Resistente al sol y a las sequías.', '2390.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav449.jpg', 5),
(393, 'Anturio schererianum', 'Sombra y poca agua.', '810.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV171.jpg', 5),
(394, 'Areca palm ', 'Mucho sol. Resiste épocas de sequía.', '1250.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV179.jpg', 5),
(395, 'Areca palm grande', 'Muy resistente, sol moderado.', '2100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV178.jpg', 5),
(396, 'Areca palm mini', 'Poco riego, y bastante luz.', '250.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/areca-mini-b.jpg', 5),
(397, 'Asplenium', 'Sol y agua, abundante.', '680.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav655.jpg', 5),
(398, 'Chamaedorea  elegans', 'Poco riego. Lugares sombríos.', '260.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV173.jpg', 5),
(399, 'Dracena tricolor', 'Mucha luz y riego.', '998.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/lav335.jpg', 5),
(400, 'Ficus benjamina (Limonado)', 'Muy resistente.Sol abundante.', '1100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV241.jpg', 5),
(401, 'Ficus benjamina variegado', 'Luz y sombra. Poco riego.', '1100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/img_0786-b.jpg', 5),
(402, 'Ficus benjamina verde', 'Poco riego. Luz suave.', '1100.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV130.jpg', 5),
(403, 'Ficus lyrata chico', 'Luz moderada. Poco riego.', '810.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV131.jpg', 5),
(404, 'Ficus lyrata grande ', 'Poca luz, lugares sombríos.', '3990.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV168.jpg', 5),
(405, 'Helecho colgante', 'Riego abundante y mucha luz, indirecta.', '810.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV041.jpg', 5),
(406, 'Kentia ', 'Palmera. Poca agua. Luz.', '2990.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV182.jpg', 5),
(407, 'Monstera (Esqueleto de Caballo)', 'Muy resistente.', '798.00', 'https://www.lavender.com.uy/imagenes/img_contenido/productos/b/LAV180.jpg', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`id`, `email`, `created_at`, `username`, `password`, `role`) VALUES
(1, 'juancarlos11@gmail.com', '2025-01-27 12:38:19', 'JuanCarlos', '$2y$10$io8mPYUp/PhSzKnhp9SN/uFiDYy1Yx3F7R1wVe.AsyBwVliTrg2.2', 'user'),
(2, 'annagomez@gmail.com', '2025-01-31 20:36:28', 'Annita', '$2y$10$AvtPn8cehQoo1El9mZDmoebUwpkpKQDovzCxDKXGoGiCuudFUwewm', 'user'),
(3, 'prueba123@example.com', '2025-02-10 22:52:11', 'prueba123', '$2y$10$qZom52ZLBTUEn5akpRW8V.W8IDSsa9uYnK5ysI3eh/dszgZHgmtdS', 'user'),
(4, 'nuevocorreo@example.com', '2025-02-10 23:39:10', 'nuevo_usuario', '$2y$10$p/tqGMNMdzRAtaJug2i3KehBxaWf52ttuUcsmrQXJF/sjlnVDBOje', 'user'),
(5, 'carlos1313@gmail.com', '2025-02-10 23:52:24', 'Carlos', '$2y$10$SsrvOVQJ/GYzDKcY9kuOP.L6jDgk2y0PWqgm/UnKDcm3DAgIzgK9G', 'user'),
(6, 'leticiacasaravilla@gmail.com', '2025-02-11 21:52:25', 'Leticia', '$2y$10$tf2FmUlwjMneIYiH.wfnE./iPYvw/TGymTyTsDHeVJ06fjdQypRrS', 'admin'),
(7, 'sandra@example.com', '2025-02-13 23:53:21', 'Sandra', '$2y$10$eImG4N24PqKAsVHXGDeWPOFiIuU.QcZpA0WfI8.sQvDQz1t.B3w/u', 'user'),
(8, 'federico@gmail.com', '2025-02-14 00:26:14', 'Federico', '$2y$10$beNkjGQ69hYdX7QcXdGh9.Vg9dJwynrVUr3BUQqudNH/caiYN2gf.', 'user'),
(9, 'mariaferres@gmail.com', '2025-02-14 10:53:02', 'Maria', '$2y$10$W6SB2uS26Ev7LzX.wtxy2u.Kh8Gc2ZljTTfEe5JhH0ap2G9FCQ4BG', 'user'),
(10, 'soniarodriguez@gmail.com', '2025-02-14 11:55:05', 'Sonia', '$2y$10$.UBPlrTz15HwfY1MjyvSEOUe/e9BfYVNU0Be1kq3jIRSy0Bop6sXm', 'user'),
(11, 'elisapacheco@gmail.com', '2025-02-15 20:32:59', 'Eli', '$2y$10$JLmeHy2TkPhYqCPX8M81QeWh33.cWvZlEeBF028fZ0jeM.V9vmoLi', 'user'),
(12, 'vaneferrer@gmail.com', '2025-02-15 23:49:15', 'Vane', '$2y$10$oOwwwZlx52ByPkLxM5tS5ukUuEN28fram.03GO96pGdYu9Ol9wX0i', 'user'),
(13, 'prueba@example.com', '2025-02-22 14:35:49', 'prueba', '$2y$10$IUmQOpXO9UfmiJ8yc14qF.HjkUCVxQPtiINIhXhdnFT1UCVsQSrDK', 'user'),
(14, 'laurigonzalez@gmail.com', '2025-02-22 14:48:57', 'Lauri', '$2y$10$IBN8EKuAaIMWsLjNuJVdReAIgIgfXz/2/B59IDP1UEk8Ehb6DzuiK', 'user'),
(15, 'floren@gmail.com', '2025-04-14 14:16:31', 'Florencia', '$2y$10$qFPvrBFA13WLxp3ZJpjFAuG5LJ7CpEsR7UAzTHJAKvQ8fKpActdFS', 'user'),
(16, 'andrea1234@gmail.com', '2025-04-20 20:20:57', 'Andrea', '$2y$10$xZVCL2LUlklaH3p.nqS3B.EW30H.Y6ENQyt31bnOV5gPpC/n/pKue', 'user'),
(17, 'isabel123@gmail.com', '2025-05-11 16:10:45', 'Isabel', '$2y$10$ejPWe/jlTsxfr5sjwiciH.nzMmwrBI3y46clBkKBzMAc0b7QSH4iG', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planta_id` (`planta_id`);

--
-- Indices de la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=408;

--
-- AUTO_INCREMENT de la tabla `plantas`
--
ALTER TABLE `plantas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=415;

--
-- AUTO_INCREMENT de la tabla `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`planta_id`) REFERENCES `plantas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD CONSTRAINT `plantas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
