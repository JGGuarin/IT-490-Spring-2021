#!/usr/bin/php
<?php
include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//function authentication($username, $password){

  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "login";
  }

echo "testing";

$username = 'mnunez';
$password = '1234';

$request = array();
$request['type'] = "getUserID";
  //$request['username'] = $username;
  //$request['password'] = $password;
$request['username'] = $username;
$request['password'] = $password;
$request['message'] = $msg;
$response = $client->send_request($request);


echo $response;

$client2 = new rabbitMQClient("testRabbitMQ.ini","testServer");


$request = array();
$request['type'] = "authentication";
  //$request['username'] = $username;
  //$request['password'] = $password;
$request['username'] = $username;
$request['password'] = $password;
$request['message'] = $msg;
$response = $client2->send_request($request);

echo $response;

return $response;

//}
?>

