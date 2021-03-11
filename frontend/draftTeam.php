<?php
include 'ini.php';
include 'mainfunctions.php';
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$leagueID = $_SESSION['leagueID'];

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}

$teamName = $_POST["teamName"];

$player1 = $_POST["player1"];
$player2 = $_POST["player2"];
$player3 = $_POST["player3"];
$player4 = $_POST["player4"];
$player5 = $_POST["player5"];
$player6 = $_POST["player6"];
$player7 = $_POST["player7"];
$player8 = $_POST["player8"];
$player9 = $_POST["player9"];
$player10 = $_POST["player10"];

$inputArray = array();
array_push($inputArray, $player1, $player2, $player3, $player4, $player5, $player5, $player6, $player7, $player8, $player9, $player10);

$playerArray = array();

foreach ($inputArray as $input){
    if($input !== ""){
        array_push($playerArray, $input);
    }    
}

$teamID = draftATeam($teamName, $leagueID, $playerArray);


header("Refresh: 0.001, url=league.php");


?>