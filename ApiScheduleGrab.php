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
curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nba/trial/v7/en/games/2021/03/04/schedule.json?api_key=zj6an2w9yyafk9speye2espw");

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


$gameID	= [];
$homeNames = [];
$awayNames = [];
$combo = [];

for ($i = 0; $i < count($phpArray['games']); $i++) {
	$gameID[$i] = $phpArray['games'][$i]['id'];
}

for ($i = 0; $i < count($phpArray['games']); $i++) {
        $homeNames[$i] = $phpArray['games'][$i]['home']['name'];
}

for ($i = 0; $i < count($phpArray['games']); $i++) {
        $awayNames[$i] = $phpArray['games'][$i]['away']['name'];
}


function writeSchedule($gameID, $homeNames, $awayNames, $phpArray){
    global $db, $t;
    for ($i = 0; $i < count($phpArray['games']); $i++) {
	    $s = "INSERT INTO ApiGame (`ApiGameId`, `HomeTeam`, `AwayTeam`) VALUES ('$gameID[$i]', '$homeNames[$i]', '$awayNames[$i]')";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));
    }

}

writeSchedule($gameID, $homeNames, $awayNames, $phpArray)

?>
