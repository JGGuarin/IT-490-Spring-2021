<?php
session_start();

include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}

$friendUsername = $_POST["friendUsername"];

//echo "friend: $friendUsername";

$msg = request($username, $friendUsername);

if ($msg == 0){
    echo '<script>alert("Friend request sent!")</script>' ; 
}

if ($msg == 1){
    echo '<script>alert("Already has a pending request")</script>' ; 

}

if ($msg == 2){
    echo '<script>alert("Already friends!")</script>' ; 
}

header("Refresh: 0.001, url=chooseleague.php");

?>