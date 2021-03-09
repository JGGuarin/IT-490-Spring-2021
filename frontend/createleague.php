<?php
include 'ini.php';
include 'mainfunctions.php';
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}

$leagueName = $_POST["leagueName"];

$member1 = $_POST["leagueMember1"];
$member2 = $_POST["leagueMember2"];
$member3 = $_POST["leagueMember3"];
$member4 = $_POST["leagueMember4"];
$member5 = $_POST["leagueMember5"];
$member6 = $_POST["leagueMember6"];
$member7 = $_POST["leagueMember7"];
$member8 = $_POST["leagueMember8"];
$member9 = $_POST["leagueMember9"];
$member10 = $_POST["leagueMember10"];

$inputArray = array();
array_push($inputArray, $username, $member1, $member2, $member3, $member4, $member5, $member6, $member7, $member8, $member9, $member10);

$memberArray = array();

foreach ($inputArray as $input){
    if($input !== ""){
        array_push($memberArray, $input);
    }    
}

$leagueID = createALeauge($leagueName, $userID, $username, $memberArray);

$_SESSION["leaugeID"] = $leagueID;
$_SESSION["leaugeName"] = $leagueName;

echo "<script>alert('wtf')</script>";

header("Location: chooseleague.php");

?>
