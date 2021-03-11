<?php
session_start();

include 'ini.php';
include 'mainfunctions.php';

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

createUserAccount($username, $password, $firstname, $lastname);


$userID = getUserId($username, $password);

$_SESSION["logged"] = true;
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["userID"] = $userID;
$_SESSION["firstname"] = $firstname;
$_SESSION["lastname"] = $lastname;

header("Location: chooseleague.php");
exit();


?>