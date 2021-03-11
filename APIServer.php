#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php');

$logger = new LoggerServer();
$logger->log("Test log.");

$server = new rabbitMQServer("testRabbitMQ.ini","apiServer");

echo "APIServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "APIServer END".PHP_EOL;
exit();

///////////////////////
// FUNCTION DEFINITIONS
///////////////////////

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    return true;
    //return false if not valid
}

function requestProcessor($request)
{
  echo "Received API request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    trigger_error("Unsupported message type", E_USER_ERROR);
    return "ERROR: Unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

/*
// From soccerData.php, a sample API request as weitten by DJ
<?php
$results = shell_exec('GET http://api.football-data.org/alpha/soccerseasons/354');
$arrayCode = json_decode($results);
var_dump($arrayCode);
?>
**/
?>

