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
	$logger->log("Successfully connected to database.".PHP_EOL);
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

//////////////////////////////////////////////////////////////////////
// From mainfunctions.php of frontend branch as of 03/09/21 at 7:31 PM
//////////////////////////////////////////////////////////////////////

function get($fieldname, &$dataOK){
    global $db, $warnings;
    
    $v = $_POST[$fieldname];
    $v = trim($v);
    $v = mysqli_real_escape_string($db, $v);
    
    if (($fieldname == "username") && ($v == "")){
        $dataOK = false; $warnings .= "<br>username empty";
    }
    if (($fieldname == "password") && ($v == "")){
        $dataOK = false; $warnings .= "<br>password empty";
    }
    
    return $v;
}

function authenticate($username, $password){
    global $db, $t;

    $s = "select * from Users where Username = '$username' and Password = '$password'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    //if no rows are returned, the authentication failed
    if ($num == 0){return false;}
    
    //access content of row in $t
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    
    return true;
}

function getUserId($username, $password){
    global $db, $t;

    $s = "select UserID from Users where Username='$username' and Password='$password'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $userID = $r["UserID"];

    return $userID;
}

function getTeamID($userID, $leagueID){
    global $db, $t;

    $s = "select TeamID from Team where UserID='$userID' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamID = $r["TeamID"];

    return $teamID;
}

function getTeamName($teamID){
    global $db, $t;

    $s = "select TeamName from Team where TeamID = '$teamID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamName = $r['TeamName'];
    
    return $teamName;

}

function getLeagueMemberTeamName($Username, $leagueID){
    global $db, $t;

    $s = "select UserID from Users where Username = '$Username'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $userID = $r['UserID'];

    $teamID = getTeamID($userID, $leagueID);

    $teamName = getTeamName($teamID);

    return $teamName;

}

function getLeagueID($leagueName){
    global $db, $t;

    $s = "select LeagueID from League where LeagueName='$leagueName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $leagueID = $r["LeagueID"];

    return $leagueID;
}

function getFirstName($userID){
    global $db, $t;

    $s = "select FirstName from Users where UserID='$userID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $firstname = $r["FirstName"];

    return $firstname;
}

function getLastName($userID){
    global $db, $t;

    $s = "select LastName from Users where UserID='$userID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $lastname = $r["LastName"];

    return $lastname;
}

function doesUserExist($username){
    global $db, $t;

    $s = "select * from Users where Username = '$username'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    //if no rows are returned, the user doesnt exist
    if ($num == 0){return false;}
    
    //access content of row in $t
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    
    return true;
}

function createUserAccount($username, $password, $firstname, $lastname){
    global $db, $t;

    $s = "INSERT INTO Users(`Username`, `Password`, `FirstName`, `LastName`) VALUES ('$username', '$password', '$firstname', '$lastname')";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $s = "select UserID from Users where Username='$username'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $userID = $r["UserID"];

    return $userID;
}

function getUserLeagues($userID){
    global $db, $t;

    $s = "SELECT * FROM Team where UserID = '$userID'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $leagueIDs = array();
    $leagueNames = array();

    while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $leagueID = $r["LeagueID"];

        array_push($leagueIDs, $leagueID);
    }


    foreach ($leagueIDs as $leagueID){
        $s = "SELECT LeagueName FROM League where LeagueID = '$leagueID'";
        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

        $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
        $leagueName = $r["LeagueName"];
        
        array_push($leagueNames, $leagueName);

    }

    return $leagueNames;
}

function displayPlayersNames(){
    global $db, $t;

    $s = "SELECT * FROM PlayerImport";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $names = array();

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $name = $r["FullName"];
        array_push($names, $name);
    }

    return $names;
}

function displayPlayersPositions(){
    global $db, $t;

    $s = "SELECT * FROM PlayerImport";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $positions = array();

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $position = $r["Pos"];
        array_push($positions, $position);
    }

    return $positions;
}

function displayPlayersTeams(){
    global $db, $t;

    $s = "SELECT * FROM PlayerImport";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $teams = array();

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $team = $r["Team"];
        array_push($teams, $team);
    }

    return $teams;
}

function displayPlayersInfo($stat){
    global $db, $t;

    $s = "SELECT $stat FROM PlayerImport";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $stats = array();

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $stat1 = $r["$stat"];
       
        array_push($stats, $stat1);

    }
    return $stats;
}

function displayAvailability($playerName){
    global $db, $t;

    $s = "select * from Player where FullName = '$playerName'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    //if no rows are returned, the user doesnt exist
    if ($num == 0){
        return "Available";
    }
    
    //access content of row in $t
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    
    return "On Roster";
}

function displayTeamPlayersNames($teamID){
    global $db, $t;

    $s = "SELECT * FROM Player where TeamID = '$teamID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $fullnames = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $fullname = $r["FullName"];
        array_push($fullnames, $fullname);
    }


    return $fullnames;
}

function displayTeamPlayersInfo($infoNeeded, $fullName){
    global $db, $t;

    $s = "SELECT $infoNeeded FROM PlayerImport where FullName = '$fullName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    $infoNeededArr = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $info = $r["$infoNeeded"];
        array_push($infoNeededArr, $info);
    }


    return $infoNeededArr;
}

function displayLeagueMembers($leagueID){
    global $db, $t;

    $s = "SELECT * FROM Team where LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);


    $userIDs = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $userID = $r["UserID"];
        array_push($userIDs, $userID);
    }

    $usernames = array();
    foreach ($userIDs as $userID){
        $s = "SELECT Username FROM Users where UserID = '$userID'";
        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
        $num = mysqli_num_rows($t);


        while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
            $username = $r["Username"];
            array_push($usernames, $username);
        }
    }

    return $usernames;

}

function createALeauge($leagueName, $userID, $username, $memberArray){
    global $db, $t;

    $s = "INSERT INTO League(`LeagueName`, `CreatorID`, `CreatorName`) VALUES ('$leagueName', '$userID', '$username')";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

   //dont know why $leagueID = getLeagueID($leagueName) is not working :/
   $s = "select LeagueID from League where LeagueName='$leagueName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $leagueID = $r["LeagueID"];


    foreach($memberArray as $member){
        $s = "SELECT * from Users where Username = '$member'";
        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

        $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
        $memberUserID = $r["UserID"];

        echo "userID: $memberUserID";

        $s = "INSERT INTO Team(`LeagueID`, `UserID`, `TeamName`) VALUES ('$leagueID', '$memberUserID', 'Team $member')";
        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    
    }

    return $leagueID;
}

///////////////////////////////////////////////////////////////////////////////
// From SqlFnctions.php of SQLRelatedFunctions branch as of 03/09/21 at 7:26 PM
///////////////////////////////////////////////////////////////////////////////

//ADD Player
//TODO: If loop to check if maximum roster limit will be broken
function playerAdd ($teamID, $playername) {
	global $db, $t;
  
	$s = "UPDATE Player SET TeamID='$teamID' WHERE FullName='$playername'";
  
	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
}
  
//DROP Player
//TODO: If loop to check if minimum roster limit will be broken
//TODO: Update the team names
function playerDrop ($teamID, $names) {
	
	$s = "UPDATE Player SET TeamID=0 WHERE TeamID='$teamID' AND FullName='$names'";

	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
}
  
//TODO Player Averages
  
//Insert a statline
function addStatline ($PlayerID, $Points, $Assists, $Rebounds, $Steals, $Blocks, $FgPercent, $TptPercent, $FtPercent) {
	global $db, $t;

	$s = "INSERT INTO BBStatLine(PlayerID, Point, Assists, Rebounds, Steals, Blocks, FgPercent, TptPercent, FtPercent) VALUES ($PlayerID, $Points, $Assists, $Rebounds, $Steals, $Blocks, $FgPercent, $TptPercent)";

	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
}
  
//TODO: Write the return from the schedule call
function scheduleWrite($ApiGameId, $HomeTeam, $AwayTeam) {
	
}
?>
