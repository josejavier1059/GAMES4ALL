-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2024 a las 00:09:31
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
-- Base de datos: `games4all`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_juego`
--

CREATE TABLE `info_juego` (
  `id_info_juego` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `genero` varchar(25) NOT NULL,
  `descripcion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id_juego` int(11) NOT NULL,
  `plataforma` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `rebaja` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id_juego`, `plataforma`, `titulo`, `precio`, `rebaja`, `stock`, `tipo`) VALUES
(2, 'PC', 'Juego PC 1', 19.99, 0.00, 100, 1),
(4, 'PlayStation', 'Juego PS 1', 49.99, 0.00, 75, 3),
(6, 'PC', 'Baldurs Gate', 50.08, 0.00, 32, 3),
(7, 'Switch', 'Baldurs Gate', 50.00, 0.00, 32, 3),
(9, 'p', 'Baldurs Gate', 0.02, 2.00, 551, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `genero` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `titulo`, `genero`, `descripcion`) VALUES
(1, 'Aventura Gráfica', 'Aventura|Gráfica', 'Juegos que se centran en la resolución de puzzles y exploración con una fuerte narrativa.'),
(2, 'Counter Strike', 'Acción|Shooter', 'Juegos de disparos en primera persona donde los reflejos y la estrategia son clave para la supervivencia.'),
(3, 'Baldurs Gate', 'Rol|Multijugador|Online', 'Juegos de rol multijugador masivos en línea, donde puedes explorar vastos mundos y interactuar con miles de jugadores.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `alias`, `password`, `correo`, `rol`) VALUES
(1, 'adminUser', 'password123', 'admin@correo.com', 'Administrador'),
(2, 'normalUser', '1234', 'usuario@correo.com', 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `info_juego`
--
ALTER TABLE `info_juego`
  ADD PRIMARY KEY (`id_info_juego`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id_juego`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
