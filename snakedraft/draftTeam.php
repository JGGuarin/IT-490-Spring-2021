<?php
include 'ini.php';
include 'functions.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$username = $_SESSION["username"];
$leagueID = $_SESSION['leagueID'];

/*
if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}*/

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

function draftATeam($teamName, $leagueID, $playerArray){
    global $db, $t;

    $s = "select TeamID from Team where LeagueID='$leagueID' and TeamName='$teamName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        echo "<script>alert('That team does not exist!')</script>";
        return false;
    }

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamID = $r["TeamID"];

    foreach($playerArray as $player){
            if(displayAvailability($player) == "Available"){
                $s = "UPDATE Player SET TeamID='$teamID' WHERE FullName='$player'";
                ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
                echo "<script>alert('Team drafted!')</script>";
            }
            else{
                echo "<script>alert('$player is already on a team!')</script>";
            }
        
        
            echo "<script>alert('One of the players does not exist!')</script>";
            return false;
    }

    return $teamID;
}

function setStatusToDrafted($username, $leagueID){
    global $db, $t;

    $s = "UPDATE Draft SET Status='drafted' WHERE Username='$username' and LeagueID='$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
}

setStatusToDrafted($username, $leagueID);



header("Refresh: 0.001, url=snakedraft.php");


?>