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

function getUserInfo($username, $password){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get user innfo";
  }

  $request = array();
  $request['type'] = "getUserInfo";
  //$request['username'] = $username;
  //$request['password'] = $password;
  $request['username'] = $username;
  $request['password'] = $password;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getUserId($username, $password){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
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
}

function getFirstName($userID){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
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
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
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

function getLeagueID($leagueName){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get league ID";
  }

  $request = array();
  $request['type'] = "getLeagueID";
  $request['leagueName'] = $leagueName;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getTeamID($userID, $leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get Team ID";
  }

  $request = array();
  $request['type'] = "getTeamID";
  $request['userID'] = $userID;
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getUserLeagues($userID){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get User Leagues";
  }

  $request = array();
  $request['type'] = "getUserLeagues";
  $request['userID'] = $userID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getTeamName($teamID){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get team name";
  }

  $request = array();
  $request['type'] = "getTeamName";
  $request['teamID'] = $teamID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

/*
function displayTeamPlayersInfo($infoNeeded, $fullName){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display team players info";
  }

  $request = array();
  $request['type'] = "displayTeamPlayersInfo";
  $request['infoNeeded'] = $infoNeeded;
  $request['fullName'] = $fullName;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayTeamPlayersNames($teamID){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display team players names";
  }

  $request = array();
  $request['type'] = "displayTeamPlayersNames";
  $request['teamID'] = $teamID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

*/

?>