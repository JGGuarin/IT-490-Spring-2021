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

if (! $_SESSION["logged"]){
  header("Location: login.html");
  exit();
}

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$teamID = $_SESSION["teamID"];
$leagueID = $_SESSION["leagueID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$leagueName = $_SESSION["leagueName"];

$playerName = $_GET['playerName'];

echo $playerName . "<br>";

playerAdd($userID, $username, $leagueID, $teamID, $playerName);
addPlayer($userID, $username, $leagueID, $teamID, $playerName);

header("Refresh: 0.001, url=players.php");

?>