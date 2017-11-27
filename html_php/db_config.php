<!--------------->
<!--By Zhongjie-->
<!--------------->
<?php

const DB_HOST = "192.168.126.140";
const DB_PORT = "3306";
const DB_NAME = "b16_20802573_beontime";
const DB_USERNAME = "root";
const DB_PASSWORD = "aaaaaa";

//const DB_HOST = "sql210.byethost16.com";
//const DB_PORT = "3306";
//const DB_NAME = "b16_20802573_beontime";
//const DB_USERNAME = "b16_20802573";
//const DB_PASSWORD = "beontime";

try {
    $dataSourceName = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT;
    $dbConnection = new PDO($dataSourceName, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    $dbErrorMessage = $e->getMessage();
    include('database_error.php');
    exit();
}

?>