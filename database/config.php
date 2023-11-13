<?php
//El config se encarga de tener los datos de conexion a la db
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "db_tpe");
define("DB_Charset", "utf8mb4");
define("JWT_KEY", "matedatos123"); //el secreto
define("JWT_EXP",  3600); //el tiempo de vida del token