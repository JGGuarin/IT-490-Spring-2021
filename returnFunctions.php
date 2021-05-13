#!/usr/bin/php
<?php


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


function getHomeBigArray($phpArray) {
	$HomeBigArray = [];
	$var = 0;
	$var2 = 0;

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

	return $HomeBigArray;
}


function getAwayBigArray($phpArray) {
	$AwayBigArray = [];
	$var3 = 0;
	$var4 = 0;

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

	return $AwayBigArray;
}

getHomeBigArray($phpArray);
getAwayBigArray($phpArray);


?>
