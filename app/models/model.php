<?php
require_once "database/config.php";
require_once "database/db.php";

    class Model {
        protected $db;

        function __construct() {
            //llamamos a la funcion del DataBaseHelper que crea la base en caso de que no exista
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";" . DB_Charset , DB_USER , DB_PASS);
            $this->deploy();
        }   

        function deploy() {
            // Chequear si hay tablas
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
            if(count($tables)==0) {
                // Si no hay crearlas
                $sql =<<<END
                    CREATE TABLE `categorias` (
                        `id_categoria` int(11) NOT NULL,
                        `categoria` varchar(250) NOT NULL,
                        `fragil` tinyint(1) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
                    
                    --
                    -- Volcado de datos para la tabla `categorias`
                    --
                    
                    INSERT INTO `categorias` (`id_categoria`, `categoria`, `fragil`) VALUES
                    (1, 'Mate', 1),
                    (2, 'Bombilla', 0),
                    (3, 'Matera', 0),
                    (4, 'Termo', 1),
                    (5, 'Yerba', 0);
                    
                    -- --------------------------------------------------------
                    
                    --
                    -- Estructura de tabla para la tabla `productos`
                    --
                    
                    CREATE TABLE `productos` (
                        `id_producto` int(11) NOT NULL,
                        `id_categoria` int(11) NOT NULL,
                        `nombre` varchar(250) NOT NULL,
                        `material` varchar(250) NOT NULL,
                        `color` varchar(250) NOT NULL,
                        `precio` double NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
                    
                    --
                    -- Volcado de datos para la tabla `productos`
                    --
                    
                    INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre`, `material`, `color`, `precio`) VALUES
                    (2, 1, 'Mate imperial', 'Cuero', 'Negro', 25000),
                    (3, 1, 'Mate torpedo', 'Calabaza y cuero', 'marron', 25000),
                    (4, 2, 'Pico de loro', 'Alpaca', 'Plata', 15000),
                    (5, 3, 'Matera Canasta', 'cuero', 'Negro', 8000),
                    (6, 4, 'Stanley 1L', 'Metal', 'Bordo', 45000),
                    (7, 5, 'Canarias Serena', 'Yerba mate', 'Verde', 4500),
                    (8, 1, 'Mate porongo', 'porongo', 'marron', 15000),
                    (10, 2, 'Bombilla Chata-plana', 'Acero inoxidable', 'Metal', 5000),
                    (11, 2, 'Bombilla Resorte', 'Acero inoxidable', 'Metal', 10000),
                    (12, 3, 'Matera Mochila', 'Lona', 'Negro', 18000),
                    (13, 3, 'Matera Bolso', 'Lona', 'Gris', 10000),
                    (14, 5, 'ReiVerde Tradicional', 'Yerba', 'Amarillo', 3500),
                    (15, 5, 'ReiVerde Premium', 'Yerba', 'Negro', 5000),
                    (16, 4, 'Coleman 1.2L', 'Acero inoxidable', 'Negro', 63000),
                    (17, 4, 'Termo Media Manija 1L', 'Acero inoxidable', 'Metal', 17500);
                    
                    -- --------------------------------------------------------
                    
                    --
                    -- Estructura de tabla para la tabla `usuarios`
                    --
                    
                    CREATE TABLE `usuarios` (
                        `id_usuario` int(11) NOT NULL,
                        `nombre` varchar(250) NOT NULL,
                        `password` varchar(250) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
                    
                    --
                    -- Volcado de datos para la tabla `usuarios`
                    --
                    
                    INSERT INTO `usuarios` (`id_usuario`, `nombre`, `password`) VALUES
                    (1, 'webadmin', '$2y$10$11H2PcfPb0oyqTvitl..Su/WHCyT3.8N35UmPsCTahqxk6qUI6a1S');
                    
                    --
                    -- Índices para tablas volcadas
                    --
                    
                    --
                    -- Indices de la tabla `categorias`
                    --
                    ALTER TABLE `categorias`
                        ADD PRIMARY KEY (`id_categoria`);
                    
                    --
                    -- Indices de la tabla `productos`
                    --
                    ALTER TABLE `productos`
                        ADD PRIMARY KEY (`id_producto`),
                        ADD KEY `id_categoria` (`id_categoria`);
                    
                    --
                    -- Indices de la tabla `usuarios`
                    --
                    ALTER TABLE `usuarios`
                        ADD PRIMARY KEY (`id_usuario`);
                    
                    --
                    -- AUTO_INCREMENT de las tablas volcadas
                    --
                    
                    --
                    -- AUTO_INCREMENT de la tabla `categorias`
                    --
                    ALTER TABLE `categorias`
                        MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
                    
                    --
                    -- AUTO_INCREMENT de la tabla `productos`
                    --
                    ALTER TABLE `productos`
                        MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
                    
                    --
                    -- AUTO_INCREMENT de la tabla `usuarios`
                    --
                    ALTER TABLE `usuarios`
                        MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
                    
                    --
                    -- Restricciones para tablas volcadas
                    --
                    
                    --
                    -- Filtros para la tabla `productos`
                    --
                    ALTER TABLE `productos`
                        ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
                    COMMIT;
                   END;
                   $this->db->query($sql);

            }
        }
    }  

