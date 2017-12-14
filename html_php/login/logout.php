<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<?php
// Because use PDO, there is no method to close connection. Just point to null.
$dbConnection = null;
session_unset();
session_destroy();
// After logout, redirect to index.html
header("Location: ../index.html");
?>