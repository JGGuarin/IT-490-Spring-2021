<?php
session_start();

//error reporting code
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

//include files
include("mainfunctions.php");
include("ini.php");

$dataOK = true; $state = -2;

//use get function to get inputs
$username = get("username", $dataOK);
$password = get("password", $dataOK);

if (!$dataOK){
    $state == -1;
}else{ $state == -2;}

if (authenticate($username,$password)){
	$userID = getUserId($username, $password);
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
