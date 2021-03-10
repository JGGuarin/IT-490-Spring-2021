  
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
$password = 'RagingRabbits21';
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


function writeSchedule($gameID, $homeNames, $awayNames, $phpArray){
    global $db, $t;
    for ($i = 0; $i < count($phpArray['games']); $i++) {
        $s = "INSERT INTO ApiGame (ApiGameId, HomeTeam, AwayTeam) VALUES ($gameID[$i], $homeNames[$i], $awayNames[$i])";
        ($t = mysqli_query($db, $s)) or die (mysqli_error($db));
    }

}

print_r($gameID);
print_r($homeNames);
print_r($awayNames);

?>