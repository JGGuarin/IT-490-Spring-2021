<?php
include 'ini.php';
include 'mainfunctions.php';
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$_SESSION["leagueName"] = $_POST["leagueName"];

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}


header("Location: myteam.php");

?>