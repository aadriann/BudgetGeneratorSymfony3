-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-09-2017 a las 21:44:58
-- Versión del servidor: 5.7.19
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `habitissimo-challenge`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `budgets`
--

DROP TABLE IF EXISTS `budgets`;
CREATE TABLE IF NOT EXISTS `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subcategory` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DCAA9548A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `budgets`
--

INSERT INTO `budgets` (`id`, `title`, `description`, `date`, `category`, `subcategory`, `price`, `status`, `created_at`, `user_id`) VALUES
(8, 'Nuevo titulo', 'Nueva construcción en Alaior', 'More than 3 months', 'Construcción', 'Construcción Casas', 'Best Quality', 'ACCEPTED', '2017-09-19 21:36:42', 4),
(9, '', 'Reforma cocina', 'From 1 to 3 months', 'Reforma', 'Reformas Cocinas', 'Value for Money', 'DISCARDED', '2017-09-19 21:38:24', 5),
(10, '', 'Mudanza mañana', 'As soon posible', 'Mudanzas', 'Mudanzas Viviendas', 'The cheapest', 'PENDING', '2017-09-19 21:42:30', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C82E74E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `name`, `last_name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'Adrian Rincon Lopez', '', 'adrianrl9441@gmail.com', '691608131', '', '2017-09-18 19:14:18'),
(2, 'Adrian Rincon Lopez', '', 'pepe@email.es', '789456126', '', '2017-09-18 19:14:50'),
(3, 'Adrian Rincon Lopez', '', 'adrianrl94241@gmail.com', '691608131', '', '2017-09-18 23:49:55'),
(4, 'Adrian Rincon Lopez', '', 'mailfalso@mail.es', '971858585', '', '2017-09-19 21:36:42'),
(5, 'Manolo', '', 'm@gmail.com', '97415263', '', '2017-09-19 21:38:24');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `FK_DCAA9548A76ED395` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
