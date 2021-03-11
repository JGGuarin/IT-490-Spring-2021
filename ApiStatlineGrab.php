#!/usr/bin/php
<?php

/////////////////
// To Be Executed
/////////////////

$hostName = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'FantasySports';
$db = new mysqli($hostName,$user,$password,$databaseName);  

if ($db->errno != 0)
{
	echo "Failed to connect to database: ".$db->error.PHP_EOL;
	exit(0);
}
else
{
	echo "Successfully connected to database".PHP_EOL;
}


// create & initialize a curl session
$curl = curl_init();

// set our url with curl_setopt()
curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nba/trial/v7/en/games/08ef9483-b512-4498-8bb0-dc9f846112cd/summary.json?api_key=mkybkfpkm6pyabeyu89x5gft");

// return the transfer as a string, also with setopt()
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// curl_exec() executes the started curl session
// $output contains the output string
$output = curl_exec($curl);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);


$phpArray = json_decode($output, true);
//print_r($phpArray);


$homePlayers	    = [];
$awayPlayers	    = [];

$homePoints	        = [];
$homeAssists	    = [];
$homeRebounds	    = [];
$homeSteals	        = [];
$homeBlocks	        = [];
$homeFgPercent      = [];
$homeTptPercent     = [];
$homeFtPercent      = [];

$awayPoints	        = [];
$awayAssists	    = [];
$awayRebounds	    = [];
$awaySteals	        = [];
$awayBlocks	        = [];
$awayFgPercent      = [];
$awayTptPercent     = [];
$awayFtPercent      = [];

for ($i = 0; $i < count($phpArray['home']['players']); $i++) {
	$homePlayers[$i] = $phpArray['home']['players'][$i]['full_name'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
	$homePoints[$i] = $phpArray['home']['players'][$i]['statistics']['points'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeAssists[$i] = $phpArray['home']['players'][$i]['statistics']['assists'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeRebounds[$i] = $phpArray['home']['players'][$i]['statistics']['rebounds'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeSteals[$i] = $phpArray['home']['players'][$i]['statistics']['steals'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeBlocks[$i] = $phpArray['home']['players'][$i]['statistics']['blocks'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeFgPercent[$i] = $phpArray['home']['players'][$i]['statistics']['field_goals_pct'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeTptPercent[$i] = $phpArray['home']['players'][$i]['statistics']['three_points_pct'];
}

for ($i = 0; $i < count($phpArray['home']['players'][$i]); $i++) {
    $homeFtPercent[$i] = $phpArray['home']['players'][$i]['statistics']['free_throws_pct'];
}



for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
	$awayPlayers[$i] = $phpArray['away']['players'][$i]['full_name'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
	$awayPoints[$i] = $phpArray['away']['players'][$i]['statistics']['points'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayAssists[$i] = $phpArray['away']['players'][$i]['statistics']['assists'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayRebounds[$i] = $phpArray['away']['players'][$i]['statistics']['rebounds'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awaySteals[$i] = $phpArray['away']['players'][$i]['statistics']['steals'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayBlocks[$i] = $phpArray['away']['players'][$i]['statistics']['blocks'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayFgPercent[$i] = $phpArray['away']['players'][$i]['statistics']['field_goals_pct'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayTptPercent[$i] = $phpArray['away']['players'][$i]['statistics']['three_points_pct'];
}

for ($i = 0; $i < count($phpArray['away']['players']); $i++) {
    $awayFtPercent[$i] = $phpArray['away']['players'][$i]['statistics']['free_throws_pct'];
}


function writeStatlineHome($homePlayers, $homePoints, $homeAssists, $homeRebounds, $homeSteals, $homeBlocks, $homeFgPercent, $homeTptPercent, $homeFtPercent, $phpArray){
    global $db, $t;
    for ($i = 0; $i < count($phpArray['home']['players']); $i++) {
	    $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FullName`) VALUES ($homePoints[$i], $homeAssists[$i], $homeRebounds[$i], $homeSteals[$i], $homeBlocks[$i], '$homePlayers[$i]')";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));
    }

}

function writeStatlineAway($awayPlayers, $awayPoints, $awayAssists, $awayRebounds, $awaySteals, $awayBlocks, $awayFgPercent, $awayTptPercent, $awayFtPercent, $phpArray){
    global $db, $t;
    for ($i = 0; $i < count($phpArray['home']['players']); $i++) {
	    $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FullName`) VALUES ($awayPoints[$i], $awayAssists[$i], $awayRebounds[$i], $awaySteals[$i], $awayBlocks[$i], '$awayPlayers[$i]')";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));
    }

}

//writeStatlineHome($homePlayers, $homePoints, $homeAssists, $homeRebounds, $homeSteals, $homeBlocks, $homeFgPercent, $homeTptPercent, $homeFtPercent, $phpArray);
writeStatlineAway($awayPlayers, $awayPoints, $awayAssists, $awayRebounds, $awaySteals, $awayBlocks, $awayFgPercent, $awayTptPercent, $awayFtPercent, $phpArray);

?>
