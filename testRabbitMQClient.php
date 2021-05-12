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

function getUserId($username){
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
  $request['type'] = "getLastName";
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

function getCreatorUsername($leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get creator username";
  }

  $request = array();
  $request['type'] = "getCreatorUsername";
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;

}

function displayLeagueMembers($leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display league members";
  }

  $request = array();
  $request['type'] = "displayLeagueMembers";
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getLeagueMemberTeamName($leagueMember, $leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get league member team name";
  }

  $request = array();
  $request['type'] = "getLeagueMemberTeamName";
  $request['leagueMember'] = $leagueMember;
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayLeagueHistory($leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display league history";
  }

  $request = array();
  $request['type'] = "displayLeagueHistory";
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayPlayersUniqueTeams(){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display players unique teams";
  }

  $request = array();
  $request['type'] = "displayPlayersUniqueTeams";
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayPlayersPositions(){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display players positions";
  }

  $request = array();
  $request['type'] = "displayPlayersPositions";
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;

}

function displayPlayersTeams(){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display players teams";
  }

  $request = array();
  $request['type'] = "displayPlayersTeams";
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayPlayersNames(){
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display players names";
  }

  $request = array();
  $request['type'] = "displayPlayersNames";
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function displayGameLog($playerName){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "display game log";
  }

  $request = array();
  $request['type'] = "displayGameLog";
  $request['playerName'] = $playerName;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function dropPlayer($userID, $username, $leagueID, $teamID, $playerName){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "drop player";
  }

  $request = array();
  $request['type'] = "dropPlayer";
  $request['userID'] = $userID;
  $request['username'] = $username;
  $request['leagueID'] = $leagueID;
  $request['teamID'] = $teamID;
  $request['playerName'] = $playerName;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function addPlayer($userID, $username, $leagueID, $teamID, $playerName){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "add player";
  }

  $request = array();
  $request['type'] = "addPlayer";
  $request['userID'] = $userID;
  $request['username'] = $username;
  $request['leagueID'] = $leagueID;
  $request['teamID'] = $teamID;
  $request['playerName'] = $playerName;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getFriends($username){
  $client = new rabbitMQClient("testRabbitMQ.ini","secondServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get friends list";
  }

  $request = array();
  $request['type'] = "getFriends";
  $request['username'] = $username;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function getReq($username){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "get friend requests";
  }

  $request = array();
  $request['type'] = "getReq";
  $request['username'] = $username;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function acceptReq($friendUsername, $username){
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "accept friend request";
  }

  $request = array();
  $request['type'] = "acceptReq";
  $request['friendUsername'] = $friendUsername;
  $request['username'] = $username;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function request($username, $friendUsername){
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "send friend request";
  }

  $request = array();
  $request['type'] = "request";
  $request['friendUsername'] = $friendUsername;
  $request['username'] = $username;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function doesUserExist($username){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "does user exist";
  }

  $request = array();
  $request['type'] = "doesUserExist";
  $request['username'] = $username;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

function createUserAccount($username, $password, $firstname, $lastname){
  $client = new rabbitMQClient("testRabbitMQ.ini","thirdServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "create user account";
  }

  $request = array();
  $request['type'] = "createUserAccount";
  $request['username'] = $username;
  $request['password'] = $password;
  $request['firstname'] = $firstname;
  $request['lastname'] = $lastname;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}

/*function calculatePoints($teamName, $leagueID){
  $client = new rabbitMQClient("testRabbitMQ.ini","fourthServer");
  
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "calculate points";
  }

  $request = array();
  $request['type'] = "calculatePoints";
  $request['teamName'] = $teamName;
  $request['leagueID'] = $leagueID;
  $request['message'] = $msg;
  $response = $client->send_request($request);

  return $response;
}*/


?>