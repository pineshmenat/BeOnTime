<?php

//define('DB_SERVER', '192.168.126.136');
//define('DB_PORT', '3306');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', 'aaaaaa');
//define('DB_DATABASE', 'php');

//define('DB_SERVER', 'sql210.byethost16.com');
//define('DB_PORT', '3306');
//define('DB_USERNAME', 'b16_20802573');
//define('DB_PASSWORD', 'beontime');
//define('DB_DATABASE', 'b16_20802573_php');

define('DB_SERVER', 'sql210.byethost16.com');
define('DB_PORT', '3306');
define('DB_USERNAME', 'b16_20802573');
define('DB_PASSWORD', 'beontime');
define('DB_DATABASE', 'b16_20802573_beontime');

$db_connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE, DB_PORT);

?>