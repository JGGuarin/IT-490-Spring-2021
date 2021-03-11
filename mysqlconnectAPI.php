#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php');

/////////////////
// To Be Executed
/////////////////

$logger = new LoggerServer();
$logger->log("Test log from that database script.");
// Need to add change to logger.php so that it handles errors too

// From testRabbitMQServer.php
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "mysqlconnect BEGIN".PHP_EOL;

$logger->log("mysqlconnect BEGIN".PHP_EOL);

$hostName = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'FantasySports';
$databaseConnection = new mysqli($hostName,$user,$password,$databaseName);  

if ($databaseConnection->errno != 0)
{
	echo "Failed to connect to database: ".$databaseConnection->error.PHP_EOL;
	$logger->log("Failed to connect to database.".PHP_EOL);
	exit(0);
}
else
{
	echo "Successfully connected to database".PHP_EOL;
	$logger->log("Successfully connected to database.".PHP_EOL);
}

// From testRabbitMQServer.php
$server->process_requests('requestProcessor');
echo "mysqlconnect END".PHP_EOL;
exit();

function get($fieldname, &$dataOK){
    //global $databaseConnection, $warnings;
    
    //$v = $_POST[$fieldname];
    //$v = trim($v);
    //$v = mysqli_real_escape_string($databaseConnection, $v);
    /*
    if (($fieldname == "username") && ($v == "")){
        $dataOK = false; $warnings .= "<br>username empty";
    }
    if (($fieldname == "password") && ($v == "")){
        $dataOK = false; $warnings .= "<br>password empty";
    }
    */
    $fieldname =$_POST[$fieldname];
    return $fieldname;
}

function writeStatlineHome ($HomeBigArray){
    global $databaseConnection, $t;
    $lilVar = 0;
    $bigVar = 9;
    for ($i = 0; $i < 17; $i++){ //set i < based on total number of values /9
        $HomeSliced = [];
        $HomeSliced = array_slice($HomeBigArray, $lilVar, $bigVar);

        $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FgPercent`, `TptPercent`, `FtPercent`, `FullName`) VALUES ($HomeSliced[1], $HomeSliced[2], $HomeSliced[3], $HomeSliced[4], $HomeSliced[5], $HomeSliced[6], $HomeSliced[7], $HomeSliced[8], '$HomeSliced[0]')";
        ($t = mysqli_query($databaseConnection, $s)) or die (mysqli_error($databaseConnection));

        $lilVar += 9;
        $bigVar += 9;

    }
    return "Write Succesful";
}

function writeStatlineAway ($AwayBigArray){
    global $databaseConnection, $t;
    $lilVar = 0;
    $bigVar = 9;
    for ($i = 0; $i < 16; $i++){ //set i < based on total number of values /9
        $AwaySliced = [];
        $AwaySliced = array_slice($AwayBigArray, $lilVar, $bigVar);

        $s = "INSERT INTO BBStatLine(`Point`, `Assists`, `Rebounds`, `Steals`, `Blocks`, `FgPercent`, `TptPercent`, `FtPercent`, `FullName`) VALUES ($AwaySliced[1], $AwaySliced[2], $AwaySliced[3], $AwaySliced[4], $AwaySliced[5], $AwaySliced[6], $AwaySliced[7], $AwaySliced[8], '$AwaySliced[0]')";
        ($t = mysqli_query($databaseConnection, $s)) or die (mysqli_error($databaseConnection));

        $lilVar += 9;
        $bigVar += 9;

    }
    return "Write Succesful";
}

function writeSchedule($gameID, $homeNames, $awayNames, $phpArray){
    global $databaseConnection, $t;
    for ($i = 0; $i < count($phpArray['games']); $i++) {
	    $s = "INSERT INTO ApiGame (`ApiGameId`, `HomeTeam`, `AwayTeam`) VALUES ('$gameID[$i]', '$homeNames[$i]', '$awayNames[$i]')";
        ($t = mysqli_query($databaseConnection, $s)) or die (mysqli_error($databaseConnection));
    }

}
  

?>