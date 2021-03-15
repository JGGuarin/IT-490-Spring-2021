#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php'); // "Importing" logger.php

/*
// Be mindful of which server you're trying to be a client of
$client = new rabbitMQClient("testRabbitMQ.ini","apiServer");

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "Login";
$request['username'] = "steve";
$request['password'] = "password";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

$logger = new LoggerClient(); // LOGGY
set_error_handler(array($logger,'errorLog')); // A static class method call
$logger->log($request); // MORE LOGGY
trigger_error("This is a test", E_USER_ERROR);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;
*/

function ApiScheduleGrab()
{
  $client = new rabbitMQClient("testRabbitMQ.ini","apiServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "ApiScheduleGrab";
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

  $request = array();
  $request['type'] = "ApiScheduleGrab";
  $request['apiArray'] = $phpArray;
  $response = $client->send_request($request);

  if($response)
  {
    echo "Schedule grab successful!".PHP_EOL;
  }
}

function ApiStatlineGrab()
{
  $client = new rabbitMQClient("testRabbitMQ.ini","apiServer");

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

  $request = array();
  $request['type'] = "ApiStatlineGrab";
  $request['apiArray'] = $phpArray;
  $response = $client->send_request($request);

  if($response)
  {
    echo "Statline grab successful!".PHP_EOL;
  }
}

ApiScheduleGrab();
//ApiStatlineGrab();

?>