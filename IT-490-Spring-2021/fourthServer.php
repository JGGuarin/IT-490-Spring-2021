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
    $result = $mysqli -> query("SELECT * FROM Users WHERE Username='$username' and Password='$password'");
    
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

function getUserInfo($username, $password){
    $host = '127.0.0.1';
    $user = 'root';
    $dbpass = 'root';
    $db = 'newsql';
    $mysqli = new MySQLi($host, $user, $dbpass, $db);

    $userInfo = array();

    $username = $mysqli->escape_string($username);
    $result = $mysqli -> query("SELECT * FROM Users WHERE Username='$username' and Password='$password'");
    
    $user = $result -> fetch_assoc();

    $userInfo['userID'] = $user['UserID'];
    $userInfo['firstName'] = $user['FirstName'];
    $userInfo['lastName'] = $user['LastName'];
    $userInfo['username'] = $username;


    // get leagues the user is part of

    $userID = $userInfo['userID'];

    $result = $mysqli -> query("SELECT * FROM Team WHERE UserID='$userID'");

    $leagueIDs = array();
    $leagueNames = array();

    while ($leagues = $result -> fetch_assoc()){
      $leagueID = $leagues["LeagueID"];

      array_push($leagueIDs, $leagueID);
    }

    foreach ($leagueIDs as $leagueID){
      $result = $mysqli -> query("SELECT LeagueName FROM League where LeagueID = '$leagueID'");

      $r = $result -> fetch_assoc();
      $leagueName = $r["LeagueName"];
      
      array_push($leagueNames, $leagueName);
    }

    $userInfo['leagueIDs'] = $leagueIDs;
    $userInfo['leagueNames'] = $leagueNames;

    $username = $userInfo['username'];

    /* get friends
    $result = $mysqli -> query("SELECT * FROM `Relation` WHERE `status`='F' AND (`from`='$username' OR `to`='$username'");
    if ($result -> num_rows == 0){
      echo "No friends yet";
    }else{
    $toUsernames = array();
    $fromUsernames = array();
    
    while ($result -> fetch_assoc()){
        $toUsername = $r["to"];
        $fromUsername = $r["from"];
        array_push($toUsernames, $toUsername);
        array_push($fromUsernames, $fromUsername);
    }
    $userInfo['friendsToUsername'] = $toUsernames;
    $userInfo['friendsForUsername'] = $fromUsernames;
      for ($i=0; $i < count($toUsernames) ; $i++){
          if ($toUsernames[$i]== $username){
              echo $fromUsernames[$i] . "<br>";
          }
      }
    }*/

    return $userInfo;

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

    $result = $mysqli ->query("select FirstName from Users where UserID='$userID'");

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

  $result = $mysqli ->query("select LastName from Users where UserID='$userID'");

  $user = $result -> fetch_assoc();

  $lastName = $user['LastName'];

  $mysqli -> close();

  return $lastName;

}

function getLeagueID($leagueName){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT LeagueID from League where LeagueName='$leagueName'");

  $result = $result -> fetch_assoc();

  $leagueID = $result['LeagueID'];

  $mysqli -> close();

  return $leagueID;
}

function getTeamID($userID, $leagueID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("select TeamID from Team where UserID='$userID' and LeagueID = '$leagueID'");

  $result = $result -> fetch_assoc();

  $teamID = $result['TeamID'];

  $mysqli -> close();

  return $teamID;
}

function getUserLeagues($userID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT * FROM Team where UserID = '$userID'");

  $leagueIDs = array();
  $leagueNames = array();

  while ($r = $result -> fetch_assoc()){
      $leagueID = $r["LeagueID"];

      array_push($leagueIDs, $leagueID);
  }


  foreach ($leagueIDs as $leagueID){
    $result = $mysqli ->query("SELECT LeagueName FROM League where LeagueID = '$leagueID'");

      $r = $result -> fetch_assoc();
      $leagueName = $r["LeagueName"];
      
      array_push($leagueNames, $leagueName);

  }

  $mysqli -> close();

  return $leagueNames;
}

function getTeamName($teamID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("select TeamName from Team where TeamID = '$teamID'");

  $r = $result -> fetch_assoc();

  $teamName = $r['TeamName'];

  $mysqli -> close();
  
  return $teamName;

}

function displayTeamPlayersNames($teamID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT * FROM Player where TeamID = '$teamID'");

  $fullnames = array();
  while($r = $result -> fetch_assoc()){
      $fullname = $r["FullName"];
      array_push($fullnames, $fullname);
  }

  $mysqli -> close();

  return $fullnames;
}

function displayTeamPlayersInfo($infoNeeded, $fullName){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT $infoNeeded FROM PlayerImport where FullName = '$fullName'");

  $r = $result -> fetch_assoc();
  $info = $r[$infoNeeded];

  /*
  $infoNeededArr = array();
  while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
      $info = $r["$infoNeeded"];
      array_push($infoNeededArr, $info);
  }
  // print_r($infoNeededArr);
  */

  $mysqli -> close();

  return $info;
}

function getCreatorUsername($leagueID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("select CreatorName from League where LeagueID='$leagueID'");

  $r = $result -> fetch_assoc();

  $creatorUsername = $r["CreatorName"];

  echo $creatorUsername;

  $mysqli -> close();

  return $creatorUsername;
}

function displayLeagueMembers($leagueID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT * FROM Team where LeagueID = '$leagueID'");
  

  $userIDs = array();
  while($r = $result -> fetch_assoc()){
      $userID = $r["UserID"];
      array_push($userIDs, $userID);
  }

  $usernames = array();
  foreach ($userIDs as $userID){
    $result = $mysqli ->query("SELECT Username FROM Users where UserID = '$userID'");

    while($r = $result -> fetch_assoc()){
        $username = $r["Username"];
        array_push($usernames, $username);
    }
  }

  $mysqli -> close();


  return $usernames;

}

function getLeagueMemberTeamName($username, $leagueID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("select UserID from Users where Username = '$username'");

  $r = $result -> fetch_assoc();

  $userID = $r['UserID'];

  $teamID = getTeamID($userID, $leagueID);

  $teamName = getTeamName($teamID);

  $mysqli -> close();

  return $teamName;
}

function displayLeagueHistory($leagueID){
  $host = '127.0.0.1';
  $user = 'root';
  $dbpass = 'root';
  $db = 'newsql';
  $mysqli = new MySQLi($host, $user, $dbpass, $db);

  $result = $mysqli ->query("SELECT * FROM UserHistory WHERE LeagueID = '$leagueID'");

  $historyArray = array();
  while($r = $result -> fetch_assoc()){
      $date = $r['Date'];
      $type = $r['Type'];
      $detail = $r['Detail'];

      array_push($historyArray, $date, $type, $detail);
  }

  $mysqli -> close();

  return $historyArray;
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
    case "getUserInfo":
        return getUserInfo($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "getUserID":
      return getUserID($request['username'], $request['password']);
    case "getFirstName":
      return getFirstName($request['userID']);
    case "getLastName":
      return getLastName($request['userID']);
    case "getLeagueID":
      return getLeagueID($request['leagueName']);
    case "getTeamID":
      return getTeamID($request['userID'], $request['leagueID']);
    case "getUserLeagues":
      return getUserLeagues($request['userID']);
    case "getTeamName":
      return getTeamName($request['teamID']);
    case "displayTeamPlayersNames":
      return displayTeamPlayersNames($request['teamID']);
    case "displayTeamPlayersInfo":
      return displayTeamPlayersInfo($request['infoNeeded'], $request['fullName']);
    case "getCreatorUsername":
      return getCreatorUsername($request['leagueID']);
    case "displayLeagueMembers":
      return displayLeagueMembers($request['leagueID']);
    case "getLeagueMemberTeamName":
      return getLeagueMemberTeamName($request['leagueMember'], $request['leagueID']);
    case "displayLeagueHistory":
      return displayLeagueHistory($request['leagueID']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","fourthServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
