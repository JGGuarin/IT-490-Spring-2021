#!/usr/bin/php
<?php
include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

/*
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "login";
  }

  $request = array();
  $request['type'] = "login";
  //$request['username'] = $username;
  //$request['password'] = $password;

  $username = 'mnunez';
  $password = '1234';

  $request['username'] = $username;
  $request['password'] = $password;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  echo "response: $response";

*/


function authentication($username, $password){

  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "login";
  }

  $request = array();
  $request['type'] = "login";
  //$request['username'] = $username;
  //$request['password'] = $password;
  $request['username'] = $username;
  $request['password'] = $password;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
  exit();

}

function getUserId($username, $password){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get user id";
  }

  $request = array();
  $request['type'] = "getUserID";
  //$request['username'] = $username;
  //$request['password'] = $password;
  $request['username'] = $username;
  $request['password'] = $password;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
  exit();
}

function getFirstName($userID){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get first name";
  }

  $request = array();
  $request['type'] = "getFirstName";
  $request['userID'] = $userID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;

}

function getLastName($userID){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get last name";
  }

  $request = array();
  $request['type'] = "getLasttName";
  $request['userID'] = $userID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;

}

?>
