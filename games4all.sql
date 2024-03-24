-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-03-2024 a las 14:01:26
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
-- Estructura de tabla para la tabla `descuento`
--

CREATE TABLE `descuento` (
  `id_descuento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descuento`
--

INSERT INTO `descuento` (`id_descuento`, `id_usuario`, `valor`) VALUES
(5, 3, 20),
(6, 3, 6),
(7, 3, 25),
(17, 2, 10),
(18, 2, 12),
(20, 2, 5),
(21, 3, 10),
(22, 1, 4),
(23, 2, 1),
(24, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_juego`
--

CREATE TABLE `info_juego` (
  `id_info` int(11) NOT NULL,
  `titulo_juego` varchar(80) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `descripcion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `info_juego`
--

INSERT INTO `info_juego` (`id_info`, `titulo_juego`, `genero`, `descripcion`) VALUES
(1, 'The Legend of Zelda: Tears of the Kingdom', 'Aventura / Acción', 'Únete a Link en una nueva aventura donde no solo seguirás explorando la basta tierra de Hyrule sino que en esta entrega irás hasta el cielo y más allá. Esta vez Link tendrá que escalar hasta las alturas nunca antes vistas, en esta entrega se da una alta importancia al exploración de forma vertical.'),
(2, 'Hollow Knight', 'Acción /Aventura / Indie', '¡Forja tu propio camino en Hollow Knight! Una aventura épica a través de un vasto reino de insectos y héroes que se encuentra en ruinas. Explora cavernas tortuosas, combate contra criaturas corrompidas y entabla amistad con extraños insectos, todo en un estilo clásico en 2D dibujado'),
(4, 'Persona 3 Reload', 'Aventura / Rol /Estrategia', 'Sumérgete en la Hora Oscura y despierta lo más profundo de tu corazón. Persona 3 Reload es la fascinante nueva versión del RPG que definió el género y que ahora renace para la era moderna con gráficos y una jugabilidad de última generación.'),
(6, 'Persona 4', 'Rol', 'juegazo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `id_juego` int(11) NOT NULL,
  `plataforma` enum('PC','Nintendo Switch','PlayStation 4','PlayStation 5','Xbox One','Xbox Series') NOT NULL,
  `titulo` varchar(80) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `rebaja` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `formato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`id_juego`, `plataforma`, `titulo`, `precio`, `rebaja`, `stock`, `formato`) VALUES
(1, 'Nintendo Switch', 'The Legend Of Zelda: Tears of the Kingdom', 59.99, 5, 350, 0),
(2, 'Nintendo Switch', 'The Legend Of Zelda: Tears of the Kingdom', 59.90, 5, 212, 1),
(3, 'PC', 'Hollow Knight', 14.79, 0, 666, 1),
(4, 'Nintendo Switch', 'Hollow Knight', 14.79, 0, 555, 1),
(5, 'Xbox One', 'Hollow Knight', 15.00, 5, 444, 1),
(6, 'PlayStation 4', 'Hollow Knight', 15.00, 10, 222, 1),
(11, 'PC', 'Persona 3 Reload', 70.00, 0, 343, 0),
(12, 'PC', 'Persona 3 Reload', 67.76, 0, 676, 1),
(15, 'PC', 'Persona 4', 20.00, 90, 23232, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_pedido`
--

CREATE TABLE `juegos_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos_pedido`
--

INSERT INTO `juegos_pedido` (`id_pedido`, `id_juego`) VALUES
(4, 2),
(4, 3),
(4, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tarjeta` int(11) NOT NULL,
  `descuento` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `id_tarjeta`, `descuento`, `subtotal`, `fecha`) VALUES
(4, 3, 2, NULL, 25.76, '2024-03-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id_tarjeta` int(11) NOT NULL,
  `numero` varchar(17) NOT NULL,
  `caducidad` date NOT NULL,
  `titular` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id_tarjeta`, `numero`, `caducidad`, `titular`, `id_usuario`) VALUES
(1, '1234123412341234', '2024-12-01', 'Manuel Antonio Hidalgo Mayén', 3),
(2, '0987098709870987', '2024-10-01', 'Manuel Antonio Hidalgo Mayén', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `rol` varchar(15) NOT NULL DEFAULT 'usuario',
  `alias` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `pais` varchar(20) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `cod_postal` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `rol`, `alias`, `password`, `correo`, `telefono`, `pais`, `ciudad`, `direccion`, `cod_postal`) VALUES
(1, 'administrador', 'admin', 'admin', 'admin.admin@gmail.com', '111222333', 'España', 'AdminCity', 'C/ Administracion Nº 66', '11234'),
(2, 'usuario', 'pepe', 'pepito2024', 'pepeperez10@gmail.com', '999888777', 'PepoWorld', 'PepoCity', 'Avenida de los Pepes nº 3', '33102'),
(3, 'usuario', 'Manuhima', 'poipoi', 'manuhima1@gmail.com', '444555666', 'españa', 'Jeez de la Frontera', 'la calle de al lado', '99000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`id_descuento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `info_juego`
--
ALTER TABLE `info_juego`
  ADD PRIMARY KEY (`id_info`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`id_juego`),
  ADD UNIQUE KEY `plataforma` (`plataforma`,`titulo`,`formato`),
  ADD KEY `titulo` (`titulo`);

--
-- Indices de la tabla `juegos_pedido`
--
ALTER TABLE `juegos_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_juego`),
  ADD KEY `juegos_pedido_ibfk_1` (`id_juego`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `tarjeta` (`id_tarjeta`) USING BTREE;

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id_tarjeta`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `id_usuario` (`id_usuario`);

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
-- AUTO_INCREMENT de la tabla `descuento`
--
ALTER TABLE `descuento`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `info_juego`
--
ALTER TABLE `info_juego`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id_tarjeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD CONSTRAINT `descuento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `juegos_pedido`
--
ALTER TABLE `juegos_pedido`
  ADD CONSTRAINT `juegos_pedido_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE,
  ADD CONSTRAINT `juegos_pedido_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_tarjeta`) REFERENCES `tarjeta` (`id_tarjeta`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
