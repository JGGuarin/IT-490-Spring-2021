#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function authentication($username,$password)
{
    /*$host = '10.192.233.107';
    $user = 'root';
    $dbpass = '';
    $db = 'FantasySports';*/

    $host = '127.0.0.1';
    $user = 'root';
    $dbpass = 'root';
    $db = 'newsql';
    $mysqli = new MySQLi($host, $user, $dbpass, $db);

    $userInfo = array();

    $username = $mysqli->escape_string($username);
    $result = $mysqli ->query("SELECT * FROM Users WHERE Username='$username' and Password='$password'");
    
    $user = $result -> fetch_assoc();

    if ($result -> num_rows == 0){
      echo "Incorrect credentials";

      $mysqli -> close();
      return false;
    }else{
          $pass = $user['Password'];
          print_r($user);
          echo "pass: $pass";

          $mysqli -> close();

          return true;
      }
      /*$userInfo['username'] = $user['Username'];
      $userInfo['userID'] = $user['UserID'];
      print_r($userInfo);
      return true;*/
    
    return "i dont know what im doing";

    //return false if not valid
}


function getUserID($username,$password)
{
    $host = '127.0.0.1';
    $user = 'root';
    $dbpass = 'root';
    $db = 'newsql';
    $mysqli = new MySQLi($host, $user, $dbpass, $db);

    $result = $mysqli ->query("select UserID from Users where Username='$username' and Password='$password'");

    $user = $result -> fetch_assoc();

    $userID = $user["UserID"];

    $mysqli -> close();

    echo "UserID: $userID";

    return $userID;
}

function getFirstName($userID){
    $host = '127.0.0.1';
    $user = 'root';
    $dbpass = 'root';
    $db = 'newsql';
    $mysqli = new MySQLi($host, $user, $dbpass, $db);

    $result = $mysqli ->query($s = "select FirstName from Users where UserID='$userID'");

    $user = $result -> fetch_assoc();

    $firstName = $user['FirstName'];

    $mysqli -> close();

    return $firstName;

}

function getLastName($userID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query($s = "select LastName from Users where UserID='$userID'");

  $user = $result -> fetch_assoc();

  $lastName = $user['LastName'];

  $mysqli -> close();

  return $lastName;

}



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
      return authentication($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "getUserID":
      return getUserID($request['username'], $request['password']);
    case "getFirstName":
      return getFirstName($request['userID']);
    case "getLastName":
      return getLastName($request['userID']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
