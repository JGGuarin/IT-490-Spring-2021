<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

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






?>