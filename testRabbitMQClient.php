#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php'); // "Importing" logger.php

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

