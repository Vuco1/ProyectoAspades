-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2021 a las 13:28:22
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aspades`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `Id_accion` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`Id_accion`, `Nombre`) VALUES
(1, 'Nada'),
(2, 'Ir hacia subcontexto'),
(3, 'Ir al anterior'),
(4, 'Volver al Inicio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimensiones`
--

CREATE TABLE `dimensiones` (
  `Id_dimension` int(11) NOT NULL,
  `Dimension` varchar(7) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Filas` int(11) NOT NULL,
  `Columnas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dimensiones`
--

INSERT INTO `dimensiones` (`Id_dimension`, `Dimension`, `Nombre`, `Filas`, `Columnas`) VALUES
(1, 'grid-sm', 'Pequeño', 3, 4),
(2, 'grid-md', 'Mediano', 2, 3),
(3, 'grid-lg', 'Grande', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_rol` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_rol`, `Descripcion`) VALUES
(0, 'Usuario'),
(1, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tableros`
--

CREATE TABLE `tableros` (
  `Id_tablero` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Imagen` varchar(200) NOT NULL,
  `Paginas` int(11) NOT NULL,
  `Posicion` int(11) NOT NULL,
  `Puntero` int(100) DEFAULT NULL,
  `Accion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tableros`
--

INSERT INTO `tableros` (`Id_tablero`, `Id_usuario`, `Nombre`, `Imagen`, `Paginas`, `Posicion`, `Puntero`, `Accion`) VALUES
(1, 4, 'Tablero 1', 'images/tabs/1583156628.jpeg', 1, 0, NULL, NULL),
(2, 2, 'Tablero 1', 'images/tabs/1583237401.jpeg', 1, 0, NULL, NULL),
(3, 2, 'Tablero 2', 'images/tabs/1583237416.jpeg', 1, 0, NULL, NULL),
(5, 2, 'Tablero 1.1', 'images/tabs/1583237448.jpeg', 1, 2, 2, 1),
(6, 2, 'Tablero 1.2', 'images/tabs/1583237471.jpeg', 1, 6, 2, 1),
(7, 2, 'Tablero 1.2', 'images/tabs/1583397710.jpeg', 1, 6, 2, 3),
(8, 2, 'Tablero 1.3', 'images/tabs/1583237504.jpeg', 1, 7, 2, 1),
(9, 2, 'Tablero 1.3', 'images/tabs/1583237532.jpeg', 1, 7, 2, 1),
(10, 2, 'Tablero 1.3', 'images/tabs/1583237545.jpeg', 1, 7, 2, 1),
(11, 2, 'Tablero 1.3', 'images/tabs/1583237612.jpeg', 1, 7, 2, 1),
(12, 2, 'Tablero 1.3', 'images/tabs/1583237660.jpeg', 1, 7, 2, 1),
(13, 2, 'Tablero 2.1', 'images/tabs/1583237741.jpeg', 1, 1, 3, 1),
(14, 2, 'Tablero 2.2', 'images/tabs/1583237765.jpeg', 1, 5, 3, 1),
(17, 2, 'Tablero 2.3', 'images/tabs/1583308054.png', 1, 2, 3, 1),
(19, 2, 'Tablero 2.4', 'images/tabs/1583310516.png', 1, 6, 3, 1),
(22, 2, 'Tablero 1.4', 'images/tabs/1583398211.jpeg', 1, 8, 2, 1),
(23, 2, 'Tablero 3', 'images/tabs/1583408181.jpeg', 1, 0, NULL, NULL),
(24, 2, 'Tablero 3', 'images/tabs/1583408313.jpeg', 1, 0, NULL, NULL),
(25, 2, 'Tablero 3', 'images/tabs/1583408429.jpeg', 1, 0, NULL, NULL),
(26, 2, 'Tablero 3', 'images/tabs/1583408554.jpeg', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero_dimension`
--

CREATE TABLE `tablero_dimension` (
  `Id_tabdim` int(11) NOT NULL,
  `Id_tablero` int(11) NOT NULL,
  `Id_dimension` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablero_dimension`
--

INSERT INTO `tablero_dimension` (`Id_tabdim`, `Id_tablero`, `Id_dimension`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(17, 17, 1),
(19, 19, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `Tema` varchar(50) NOT NULL,
  `Logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `Tema`, `Logo`) VALUES
(1, 'default', 'images/icons/logo_default.svg'),
(2, 'blue', 'images/icons/logo_default.svg'),
(3, 'aqua', 'images/icons/logo_default.svg'),
(4, 'green', 'images/icons/logo_default.svg'),
(5, 'yellow', 'images/icons/logo_default.svg'),
(6, 'orange', 'images/icons/logo_default.svg'),
(7, 'red', 'images/icons/logo_default.svg'),
(8, 'red', 'images/icons/logo_default.svg'),
(9, 'pink', 'images/icons/logo_default.svg'),
(10, 'lavender', 'images/icons/logo_default.svg'),
(11, 'purple', 'images/icons/logo_default.svg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_usuario` int(11) NOT NULL,
  `Nick` varchar(50) NOT NULL,
  `Clave` varchar(300) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_usuario`, `Nick`, `Clave`, `Nombre`, `Foto`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'images/users/adminprofile.jpg'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'images/users/userprofile.jpeg'),
(3, 'luis', '1205aa720f00bcd7abafaa0cff0c9f81', 'Luis', 'images/users/luisprofile.jpeg'),
(4, 'prueba', '202cb962ac59075b964b07152d234b70', 'prueba', 'images/users/1583842269.jpeg'),
(7, 'admin2', '202cb962ac59075b964b07152d234b70', 'admin2', 'images/users/1583831911.png'),
(11, 'user2', '202cb962ac59075b964b07152d234b70', 'user2', 'images/users/1583842260.jpeg'),
(14, 'user3', 'd41d8cd98f00b204e9800998ecf8427e', 'user3', 'images/users/1583842446.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `Id_usurol` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`Id_usurol`, `Id_usuario`, `Id_rol`) VALUES
(1, 1, 1),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(7, 7, 1),
(10, 11, 0),
(13, 14, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`Id_accion`);

--
-- Indices de la tabla `dimensiones`
--
ALTER TABLE `dimensiones`
  ADD PRIMARY KEY (`Id_dimension`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_rol`);

--
-- Indices de la tabla `tableros`
--
ALTER TABLE `tableros`
  ADD PRIMARY KEY (`Id_tablero`),
  ADD KEY `Puntero` (`Puntero`),
  ADD KEY `Id_usuario` (`Id_usuario`),
  ADD KEY `tableros_ibfk_3` (`Accion`);

--
-- Indices de la tabla `tablero_dimension`
--
ALTER TABLE `tablero_dimension`
  ADD PRIMARY KEY (`Id_tabdim`),
  ADD KEY `tabdim_fk_dim` (`Id_dimension`),
  ADD KEY `tabdim_fk_tab` (`Id_tablero`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD UNIQUE KEY `Nick` (`Nick`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`Id_usurol`),
  ADD KEY `Idrol` (`Id_rol`),
  ADD KEY `Idusuario` (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `Id_accion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dimensiones`
--
ALTER TABLE `dimensiones`
  MODIFY `Id_dimension` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tableros`
--
ALTER TABLE `tableros`
  MODIFY `Id_tablero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tablero_dimension`
--
ALTER TABLE `tablero_dimension`
  MODIFY `Id_tabdim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `Id_usurol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tableros`
--
ALTER TABLE `tableros`
  ADD CONSTRAINT `tableros_ibfk_1` FOREIGN KEY (`Puntero`) REFERENCES `tableros` (`Id_tablero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tableros_ibfk_2` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tableros_ibfk_3` FOREIGN KEY (`Accion`) REFERENCES `acciones` (`Id_accion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tablero_dimension`
--
ALTER TABLE `tablero_dimension`
  ADD CONSTRAINT `tabdim_fk_dim` FOREIGN KEY (`Id_dimension`) REFERENCES `dimensiones` (`Id_dimension`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabdim_fk_tab` FOREIGN KEY (`Id_tablero`) REFERENCES `tableros` (`Id_tablero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`Id_rol`) REFERENCES `rol` (`Id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
