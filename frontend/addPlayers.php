<?php
session_start();
include 'ini.php';
include 'mainfunctions.php';

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

header("Refresh: 0.001, url=players.php");

?>