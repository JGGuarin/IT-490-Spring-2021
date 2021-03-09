<?php
include 'ini.php';
include 'mainfunctions.php';
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
