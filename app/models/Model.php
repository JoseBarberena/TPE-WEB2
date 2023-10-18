<?php

require_once 'config.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    function deploy() {
        // Chequear si hay tablas
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
        if(count($tables)==0) {
            // Si no hay crearlas
            $sql =<<<END

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
(1, 'webadmin@gmail.com', '$2y$10$VxWRxpQwkc8t6X7YHljO..RlviqYI42dF6OEW1LNHyMtn1jafaspW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id_Vendedor` int(11) NOT NULL,
  `Vendedor` varchar(100) NOT NULL,
  `Zona` varchar(100) NOT NULL,
  `Comision` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id_Vendedor`, `Vendedor`, `Zona`, `Comision`) VALUES
(1, 'Jose Ignacio', 'Tandil', 0.23),
(2, 'Noelia Camila', 'CABA', 0.18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `Cliente` varchar(100) NOT NULL,
  `Factura` varchar(20) NOT NULL,
  `Fecha` date NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `Producto` varchar(100) NOT NULL,
  `Cantidad` int(15) NOT NULL,
  `P_Unitario` double NOT NULL,
  `Total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `Cliente`, `Factura`, `Fecha`, `id_vendedor`, `Producto`, `Cantidad`, `P_Unitario`, `Total`) VALUES
(22, 'Maitia R', 'A000535', '2023-10-24', 1, 'SUPLEMENTO', 4, 10, 10),
(23, 'MSGP', 'A000050036', '2023-06-05', 1, 'Calcio bloque', 9, 100, 9),
(24, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE CALCIO', 9, 3, 27),
(25, 'CONSUMIDOR FINAL', 'A00-005327', '2023-05-10', 1, 'BLOQUE MAGNESIO', 3, 15, 3),
(26, 'CEPEDA HORARIO', 'A00-005333', '2023-04-25', 2, 'BLOQUE CALCIO', 20, 3, 60),
(27, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE MAGNESIO', 1, 15, 15),
(28, 'CERRO CHATO', 'A00-005333', '2023-05-23', 1, '17/15', 10, 500, 5000),
(29, 'FERREIRO CLAUDIO', 'A00-005338', '2023-06-26', 2, 'POSTE QUEBRACHO', 9, 100, 900),
(30, 'SANCHEZ OFELIA', 'A00-005345', '2023-06-25', 1, 'CLAVOS TECHO', 100, 3, 300),
(31, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE CALCIO', 9, 3, 27),
(32, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE CALCIO', 9, 3, 27),
(33, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE CALCIO', 9, 3, 27),
(34, 'MSGP', 'A00-005326', '0000-00-00', 2, 'BLOQUE CALCIO', 9, 3, 27);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id_Vendedor`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `id_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedores` (`id_Vendedor`);
COMMIT;

END;
                $this->db->query($sql);
            }
            
        }
    }
