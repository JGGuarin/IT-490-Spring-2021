#!/usr/bin/php
<?php
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


$gameData = [];
$var = 0;
$var2 = 0;

for ($i = 0; $i < count($phpArray['games']); $i++) {
	$gameData[$var] = $phpArray['games'][$var2]['id'];
	$var++;
	$gameData[$var] = $phpArray['games'][$var2]['home']['name'];
	$var++;
	$gameData[$var] = $phpArray['games'][$var2]['away']['name'];
	$var++;
	$var2++;
}

print_r($gameData);

//echo count($phpArray);

$gameID1 = $phpArray['games'][0]['id'];
$homeName1 = $phpArray['games'][0]['home']['name'];
$awayName1 = $phpArray['games'][0]['away']['name'];



?>
