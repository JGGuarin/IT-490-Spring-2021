#!/usr/bin/php
<?php

/////////////////
// To Be Executed
/////////////////


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


$bigArray = [];
$var = 0;
$var2 = 0;

for ($i = 0; $i < count($phpArray['home']['players']); $i++) {
	
	$bigArray[$var] = $phpArray['home']['players'][$var2]['full_name'];
	$var++;


	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['points'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['assists'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['rebounds'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['steals'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['blocks'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['field_goals_pct'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['three_points_pct'];
	$var++;

	$bigArray[$var] = $phpArray['home']['players'][$var2]['statistics']['free_throws_pct'];
	$var++;
	$var2++;

}

print_r($bigArray);
