<?php
session_start();

include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('ini.php');
include('functions.php');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$email = $_POST["email"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$username = $_POST["username"];

if (doesUserExist($username)){
    $message = "Username already exists";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh: 0.00001, url = 'login.html'");
    exit();
}

$userID = createUserAccount($username, $password, $firstname, $lastname);

$_SESSION["logged"] = true;
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["userID"] = $userID;
$_SESSION["firstname"] = $firstname;
$_SESSION["lastname"] = $lastname;

header("Location: chooseleague.php");
exit();


?>