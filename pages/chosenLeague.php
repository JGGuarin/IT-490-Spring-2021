<?php
include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];

$leagueName = $_POST["leagueName"];
$leagueID = getLeagueID($leagueName);

$teamID = getTeamID($userID, $leagueID);
$teamName = getTeamName($teamID);

$_SESSION["teamID"] = $teamID;
$_SESSION["leagueName"] = $leagueName;
$_SESSION["leagueID"] = $leagueID;
$_SESSION["teamName"] = $teamName;

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}

header("Location: myteam.php");

?>