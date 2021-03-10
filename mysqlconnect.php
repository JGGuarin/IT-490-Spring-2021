#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php');

$logger = new LoggerServer();
$logger->log("Test log from that database script.");
// Need to add change to logger.php so that it handles errors too

// From testRabbitMQServer.php
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "mysqlconnect BEGIN".PHP_EOL;

$logger->log("mysqlconnect BEGIN".PHP_EOL);

$hostName = 'localhost';
$user = '';
$password = '';
$databaseName = '';
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
	$logger->log("Successfully connect to database.".PHP_EOL);
}

// From testRabbitMQServer.php
$server->process_requests('requestProcessor');
echo "mysqlconnect END".PHP_EOL;
exit();

/*
$query = "select * from students;";

$response = $mydb->query($query);
if ($mydb->errno != 0)
{
	echo "failed to execute query:".PHP_EOL;
	echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
	exit(0);
}
**/

// From testRAbbitMQServer.php, but y'know redefined
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
		return doLogin($request['username'],$request['password']);
    case "validate_session":
		return doValidate($request['sessionId']);
	// Add and remove some cases
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

function doLogin($username, $password)
{

}

function doValidate($sessionId)
{
	
}
?>
