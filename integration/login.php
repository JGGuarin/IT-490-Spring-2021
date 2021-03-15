<?php

/*
echo "this is login.php";

include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
include('IT-490-Spring-2021/testRabbitMQClient.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo "<br>no problem with imports";



$username = $_POST['username'];
$password = $_POST['password'];

echo "<br>Username: $username";
echo "<br>Password: $password";



$response = authentication($username, $password);


if ($response == false){
	echo "<br>login failed";
}
else{
	echo "<br>login successful";


$userID = getUserId($username, $password);
echo "<br><br>userID: $userID"; 

*/

session_start();

//error reporting code
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);
ini_set('display_startup_errors', 1);


//include files
include('IT-490-Spring-2021/testRabbitMQClient.php');

//use get function to get inputs
$username = $_POST['username'];
$password = $_POST['password'];


if (authentication($username,$password)){
	$loggedIn = true;
	echo "logged in";
}


if ($loggedIn){
	$userID = getUserId($username, $password);
	echo "User ID: $userID";
}else{
	echo "fuck my life";
}

	/*$firstname = getFirstName($userID);
	$lastname = getLastName($userID);

	$_SESSION["logged"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    $_SESSION["userID"] = $userID;
	$_SESSION["firstname"] = $firstname;
	$_SESSION["lastname"] = $lastname;*/


    //header("Location: chooseleague.php");
    //exit();

//}
/*else{
	$message = "Wrong username or password";
         echo "<script type='text/javascript'>alert('$message');</script>";
        header("refresh: 0.00001, url = 'login.html'");
        exit();
}*/


?>
