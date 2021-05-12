<?php
session_start();

include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$username = $_POST["username"];
$password = $_POST["password"];

if (authentication($username,$password)){
	$userID = getUserId($username);
	$firstname = getFirstName($userID);
	$lastname = getLastName($userID);

	$_SESSION["logged"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    $_SESSION["userID"] = $userID;
	$_SESSION["firstname"] = $firstname;
	$_SESSION["lastname"] = $lastname;

    header("Location: chooseleague.php");
    exit();

}else{
	$message = "Wrong username or password";
         echo "<script type='text/javascript'>alert('$message');</script>";
        header("refresh: 0.00001, url = 'login.html'");
        exit();
}

?>