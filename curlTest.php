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


$gameID	= [];
$homeNames = [];
$awayNames = [];
$combo = [];

$var = 0;
$var2 = 0;
$var3 = 0;
$var4 = 0;
$var5 = 0;
$var6 = 0;
$var7 = 0;

for ($i = 0; $i < count($phpArray['games']); $i++) {
	$gameID[$var] = $phpArray['games'][$var2]['id'];
	$var++;
	$var2++;
}

for ($i = 0; $i < count($phpArray['games']); $i++) {
        $homeNames[$var3] = $phpArray['games'][$var4]['home']['name'];
        $var3++;
        $var4++;
}

for ($i = 0; $i < count($phpArray['games']); $i++) {
        $awayNames[$var5] = $phpArray['games'][$var6]['away']['name'];
        $var5++;
        $var6++;
}


print_r($gameID);
print_r($homeNames);
print_r($awayNames);

//echo count($phpArray);

$gameID1 = $phpArray['games'][0]['id'];
$homeName1 = $phpArray['games'][0]['home']['name'];
$awayName1 = $phpArray['games'][0]['away']['name'];



?>
