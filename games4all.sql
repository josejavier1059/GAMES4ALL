-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2024 a las 21:13:57
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
-- Estructura de tabla para la tabla `biblioteca`
--

CREATE TABLE `biblioteca` (
  `id_usuario` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `clave` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `biblioteca`
--

INSERT INTO `biblioteca` (`id_usuario`, `id_juego`, `clave`) VALUES
(3, 3, '6252516724621131'),
(3, 4, '3117818804926094'),
(3, 6, '3825230325828610'),
(3, 12, '7136475724048019'),
(3, 19, '1803101452906083');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_usuario` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(6, 3, 6),
(18, 2, 12),
(20, 2, 5),
(22, 1, 4),
(23, 2, 1),
(24, 3, 4),
(25, 2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_juego`
--

CREATE TABLE `info_juego` (
  `id_info` int(11) NOT NULL,
  `titulo_juego` varchar(80) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `imagen` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `info_juego`
--

INSERT INTO `info_juego` (`id_info`, `titulo_juego`, `genero`, `descripcion`, `imagen`) VALUES
(1, 'The Legend of Zelda: Tears of the Kingdom', 'Acción / Aventura', 'Únete a Link en una nueva aventura donde no solo seguirás explorando la basta tierra de Hyrule sino que en esta entrega irás hasta el cielo y más allá. Esta vez Link tendrá que escalar hasta las alturas nunca antes vistas, en esta entrega se da una alta importancia al exploración de forma vertical.', 'totk.png'),
(2, 'Hollow Knight', 'Acción /Aventura / Indie', '¡Forja tu propio camino en Hollow Knight! Una aventura épica a través de un vasto reino de insectos y héroes que se encuentra en ruinas. Explora cavernas tortuosas, combate contra criaturas corrompidas y entabla amistad con extraños insectos, todo en un estilo clásico en 2D dibujado.', 'hollow.ico'),
(4, 'Persona 3 Reload', 'Aventura / Rol /Estrategia', 'Sumérgete en la Hora Oscura y despierta lo más profundo de tu corazón. Persona 3 Reload es la fascinante nueva versión del RPG que definió el género y que ahora renace para la era moderna con gráficos y una jugabilidad de última generación.', 'p3r.png'),
(6, 'Persona 4 Golden', 'Rol', 'Una historia de juventud en la que el protagonista y sus amigos se embarcan en una aventura a raíz de una serie de asesinatos.', 'p4g.png'),
(9, 'Persona 5 Royal', 'Rol', 'Ponte la máscara, acompaña a los Ladrones Fantasma de Corazones en sus asaltos ¡e infíltrate en la mente de los corruptos para hacerles cambiar de opinión!', 'Persona_5_Royal.avif'),
(10, 'Persona 3 Portable', 'Aventura / Rol /Estrategia', 'Si te dijera que existe una hora \"escondida\" entre un día y el siguiente..., ¿me creerías? Domina el poder del corazón, Persona, y descubre la trágica verdad de la Hora Oscura.', 'Persona_3_Portable.png'),
(11, 'Monster Hunter: World', 'Acción', '¡Bienvenidos a un nuevo mundo! En Monster Hunter: World, la última entrega de la serie, podrás disfrutar de la mejor experiencia de juego, usando todos los recursos a tu alcance para acechar monstruos en un nuevo mundo rebosante de emociones y sorpresas.', 'Monster_Hunter_World.jpg'),
(12, 'The Legend of Zelda: Breath of the Wild', 'Acción / Aventura', 'The Legend of Zelda: Breath of the Wild te sumergirá en un mundo de descubrimiento con un impresionante estilo artístico similar a The Wind Waker o Skyward Sword, una cautivadora banda sonora y una intrigante y melancólica historia. Despierta tras un siglo de letargo, adéntrate en el Hyrule más amplio y abierto jamás creado por las tres grandes Diosas y forja tu propio camino con el orden y aventuras que quieras.', 'The_Legend_of_Zelda__Breath_of_the_Wild.png');

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
(1, 'Nintendo Switch', 'The Legend Of Zelda: Tears of the Kingdom', 59.99, 5, 348, 0),
(2, 'Nintendo Switch', 'The Legend Of Zelda: Tears of the Kingdom', 59.90, 5, 212, 1),
(3, 'PC', 'Hollow Knight', 9.99, 0, 665, 1),
(4, 'Nintendo Switch', 'Hollow Knight', 14.99, 0, 554, 1),
(5, 'Xbox One', 'Hollow Knight', 14.99, 5, 444, 1),
(6, 'PlayStation 4', 'Hollow Knight', 14.99, 10, 221, 1),
(11, 'PC', 'Persona 3 Reload', 69.99, 0, 343, 0),
(12, 'PC', 'Persona 3 Reload', 69.99, 40, 675, 1),
(15, 'PC', 'Persona 4 Golden', 19.99, 90, 23231, 0),
(19, 'PC', 'Persona 5 Royal', 59.90, 40, 1110, 1),
(20, 'PlayStation 4', 'Persona 5 Royal', 59.99, 50, 2222, 0),
(21, 'PC', 'Persona 3 Portable', 19.99, 0, 311, 1),
(22, 'PC', 'Monster Hunter: World', 29.99, 0, 2323, 1),
(23, 'Nintendo Switch', 'The Legend of Zelda: Breath of the Wild', 59.99, 0, 3434, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_pedido`
--

CREATE TABLE `juegos_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos_pedido`
--

INSERT INTO `juegos_pedido` (`id_pedido`, `id_juego`, `fecha_entrega`) VALUES
(5, 1, '2024-03-27'),
(5, 12, '2024-03-28'),
(6, 15, '2024-03-30'),
(7, 6, NULL),
(7, 19, NULL),
(8, 1, '2024-03-29'),
(8, 3, NULL),
(9, 4, NULL);

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
(5, 3, 1, 25, 127.75, '2024-03-26'),
(6, 3, 1, 10, 20.00, '2024-03-26'),
(7, 3, 1, 20, 74.90, '2024-03-26'),
(8, 3, 1, 0, 74.78, '2024-03-26'),
(9, 3, 1, 0, 14.79, '2024-03-26');

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
  `nombre` varchar(60) NOT NULL,
  `pais` varchar(20) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `cod_postal` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `rol`, `alias`, `password`, `correo`, `nombre`, `pais`, `ciudad`, `direccion`, `cod_postal`) VALUES
(1, 'administrador', 'admin', 'admin', 'admin.admin@gmail.com', 'Admin Istrator', 'España', 'AdminCity', 'C/ Administracion Nº 66', '11234'),
(2, 'usuario', 'pepe', 'pepito2024', 'pepeperez10@gmail.com', '', 'PepoWorld', 'PepoCity', 'Avenida de los Pepes nº 3', '33102'),
(3, 'usuario', 'Manuhima', 'poipoi', 'manuhima1@gmail.com', 'Manuel Hidalgo', 'España', 'Jerez de la Frontera', 'cerca de mi casa', '11222'),
(5, 'usuario', 'a', 'b', 'c@c', 'x', '', '', '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`id_usuario`,`id_juego`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_juego`),
  ADD KEY `id_juego` (`id_juego`);

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
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `info_juego`
--
ALTER TABLE `info_juego`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id_tarjeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD CONSTRAINT `biblioteca_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `biblioteca_ibfk_2` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

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
