<?php
session_start();
include 'ini.php';


unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["logged"]);
$_SESSION = array();
session_destroy();

header('Location: login.html');

?>


?>