#!/usr/bin/php
<?php

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
curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nba/trial/v7/en/games/ed238559-8f25-40fd-96e0-07450e995186/summary.json?api_key=mkybkfpkm6pyabeyu89x5gft"); //change based on game id found through schedule call

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


$HomeBigArray = [];
$var = 0;
$var2 = 0;
$var3 = 0;
$var4 = 0;

for ($i = 0; $i < count($phpArray['home']['players']); $i++) {
	
	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['full_name'];
	$var++;


	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['points'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['assists'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['rebounds'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['steals'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['blocks'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['field_goals_pct'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['three_points_pct'];
	$var++;

	$HomeBigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['free_throws_pct'];
	$var++;
	$var2++;

}


for ($i = 0; $i < count($phpArray['away']['players']); $i++) {

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['full_name'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['points'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['assists'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['rebounds'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['steals'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['blocks'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['field_goals_pct'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['three_points_pct'];
	$var3++;

	$AwayBigArray[$var3] = $phpArray['away']['players'][$var4]['statistics']['free_throws_pct'];
	$var3++;
	$var4++;
}



//print_r($HomeBigArray);
//print_r($AwayBigArray);
function writeStatlineHome ($HomeBigArray){
    global $db, $t;
    $lilVar = 0;
    $bigVar = 9;
    for ($i = 0; $i < 17; $i++){ //set i < based on total number of values /9
        $HomeSliced = [];
        $HomeSliced = array_slice($HomeBigArray, $lilVar, $bigVar);

        $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FgPercent`, `TptPercent`, `FtPercent`, `FullName`) VALUES ($HomeSliced[1], $HomeSliced[2], $HomeSliced[3], $HomeSliced[4], $HomeSliced[5], $HomeSliced[6], $HomeSliced[7], $HomeSliced[8], '$HomeSliced[0]')";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

        $lilVar += 9;
        $bigVar += 9;

    }
}

function writeStatlineAway ($AwayBigArray){
    global $db, $t;
    $lilVar = 0;
    $bigVar = 9;
    for ($i = 0; $i < 16; $i++){ //set i < based on total number of values /9
        $AwaySliced = [];
        $AwaySliced = array_slice($AwayBigArray, $lilVar, $bigVar);

        $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FgPercent`, `TptPercent`, `FtPercent`, `FullName`) VALUES ($AwaySliced[1], $AwaySliced[2], $AwaySliced[3], $AwaySliced[4], $AwaySliced[5], $AwaySliced[6], $AwaySliced[7], $AwaySliced[8], '$AwaySliced[0]')";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

        $lilVar += 9;
        $bigVar += 9;

    }
}

writeStatlineHome($HomeBigArray);
writeStatlineAway ($AwayBigArray);
?>