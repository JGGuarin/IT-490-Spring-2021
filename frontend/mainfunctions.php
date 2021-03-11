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

function getTeamScores($teamName, $leagueID){
    global $db, $t;

    $s = "select * from Team where TeamName='$teamName' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $scores = array();
    while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $wins = $r['Wins'];
        $losses = $r['Losses'];
        $ties = $r['Ties'];

        array_push($scores, $wins, $losses, $ties);
    }


    return $scores;
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

function getCreatorUsername($leagueID){
    global $db, $t;

    $s = "select CreatorName from League where LeagueID='$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $creatorUsername = $r["CreatorName"];

    echo $creatorUsername;

    return $creatorUsername;
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

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $teamID = $r['TeamID'];
    }

    if ($teamID == 0){
        return "Available";
    }
    
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

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $info = $r[$infoNeeded];

    /*
    $infoNeededArr = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $info = $r["$infoNeeded"];
        array_push($infoNeededArr, $info);
    }

    // print_r($infoNeededArr);
    */
    return $info;
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

function displayTeamsInLeague($leagueID){
    global $db, $t;

    $s = "SELECT * FROM Team where LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);


    $teams = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $team = $r["UserID"];
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

    
    foreach($memberArray as $member){
        if ($member == $memberArray[0]){
            continue;
        }if (doesUserExist($member)){
            $s = "SELECT * FROM Relation WHERE `from`='$username' AND `to`='$member' AND `status`='F'";
            ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
            $num = mysqli_num_rows($t);

            //if no rows are returned, the users are not friends
            if ($num == 0){
                echo "<script>alert('You must be friends in order to add members to your league!')</script>";
                return false;
            }
        }else{
            echo "<script>alert('One of the member usernames does not exist!')</script>";
            return false;
        }
    }

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
    
    echo "<script>alert('League created!')</script>";

    return $leagueID;
}

function doesPlayerExist($playerName){
    global $db, $t;

    $s = "SELECT * FROM PlayerImport WHERE FullName = '$playerName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        return false;
    }

    return true;
}

function draftATeam($teamName, $leagueID, $playerArray){
    global $db, $t;

    $teamName = sanitizeInput($teamName);
    $s = "select TeamID from Team where LeagueID='$leagueID' and TeamName='$teamName'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        echo "<script>alert('That team does not exist!')</script>";
        return false;
    }

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamID = $r["TeamID"];

    foreach($playerArray as $player){
        $player = sanitizeInput($player);
        if (doesPlayerExist($player)){
            if(displayAvailability($player) == "Available"){
                $s = "UPDATE Player SET TeamID='$teamID' WHERE FullName='$player'";
                ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
                echo "<script>alert('Team drafted!')</script>";
            }
            else{
                echo "<script>alert('$player is already on a team!')</script>";
            }
        }
        else{
            echo "<script>alert('One of the players does not exist!')</script>";
            return false;
        }
    }

    return $teamID;
}

function isPlayerOnTeam($teamID, $playerName){
    global $db, $t;

    $s = "select * from Player where TeamID = '$teamID' and FullName='$playerName'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    //if no rows are returned, the player is not on their team
    if ($num == 0){return false;}

    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $teamID = $r['TeamID'];
    }

    if ($teamID == 0){
        return false;
    }
    
    return true;
}

//ADD Player
//TODO: If loop to check if maximum roster limit will be broken
function playerAdd ($userID, $username, $leagueID, $teamID, $playerName) {
    global $db, $t;
  
    $playerName = sanitizeInput($playerName);
    $s = "UPDATE Player SET TeamID='$teamID' WHERE FullName='$playerName'";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));


    $type = "League member updated their roster";
    $detail = "$username added $playerName to their team";
    $s = "INSERT INTO UserHistory VALUES ('$userID', '$username', '$teamID', '$leagueID', NOW(), '$type', '$detail')";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    echo "<script>alert('Player added!')</script>";
    return true;
}
 

//DROP Player
//TODO: If loop to check if minimum roster limit will be broken
//TODO: Update the team names
function playerDrop ($userID, $username, $leagueID, $teamID, $playerName) {
    global $db, $t;

    $playerName = sanitizeInput($playerName);
    $s = "UPDATE Player SET TeamID=0 WHERE TeamID='$teamID' AND FullName='$playerName'";

    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    $type = "League member updated their roster";
    $detail = "$username dropped $playerName from their team";
    $s = "INSERT INTO UserHistory VALUES ('$userID', '$username', '$teamID', '$leagueID', NOW(), '$type', '$detail')";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    echo "<script>alert('Player dropped!')</script>";
    return true;
}

function sanitizeInput($fieldname){
    global $db, $warnings;

    $v = trim($fieldname);
    $v = mysqli_real_escape_string($db, $v);

    return $v;
}

// SEND FRIEND REQUEST
function request ($from, $to) {
    //CHECK IF ALREADY FRIENDS
    global $db, $t;

    $from = sanitizeInput($from);
    $to = sanitizeInput($to);

    $s = "SELECT * FROM Relation WHERE `from`='$from' AND `to`='$to' AND `status`='F'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        //RUN THE NEXT PART
        $s =  "SELECT * FROM `relation` WHERE (`status`='P' AND `from`='$from' AND `to`='$to') OR (`status`='P' AND `from`='$to' AND `to`='$from')";

        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
        $num = mysqli_num_rows($t);

        if ($num == 0){
          $s = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES ('$from','$to','P')";
          ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
          return "Friend Request Sent";
        }

        return "Already has a pending friend request";
    }
    
    return "Already Friends";

}

//ACCEPT FRIEND REQUEST
function acceptReq ($from, $to) {
    global $db, $t;
    //UPGRADE STATUS TO "F"RIENDS
    $s = "UPDATE `relation` SET `status`='F' WHERE `status`='P' AND `from`='$from' AND `to`='$to'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
 

    //ADD RECIPOCAL RELATIONSHIP
    $s = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES ('$to','$from','F')";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    return "Friend Request Accepted";
    
}

  //NEEDS WORK: GET FRIEND REQUESTS
  //TODO: Display the results
  function getReq ($username) {
    global $db, $t;

    /*
    //GET OUTGOING FRIEND REQUESTS (FROM USER TO OTHER PEOPLE)
    $s = "SELECT * FROM `relation` WHERE `status`='P' AND `from`='$username'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    */

    //GET INCOMING FRIEND REQUESTS (FROM OTHER PEOPLE TO USER)
    $s = "SELECT * FROM `relation` WHERE `status`='P' AND `to`='$username'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $num = mysqli_num_rows($t);
    
    //check to see if the user has any friends
    if ($num == 0){
      echo "No incoming friend requests yet";
      return 0;
    }else{
    
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    echo "Incoming friend request from: <b>" . $r["from"] . "</b>";  
    
    return $r["from"];
    }
}

  //NEEDS WORK: GET FRIENDS
  //TODO: Display the results
  function getFriends ($username) {
    global $db, $t;
    // GET FRIENDS
    $s = "SELECT * FROM `relation` WHERE `status`='F' AND (`from`='$username' OR `to`='$username')";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $num = mysqli_num_rows($t);
    
    //check to see if the user has any friends
    if ($num == 0){
      echo "No friends yet";
    }else{

    $toUsernames = array();
    $fromUsernames = array();
    
    while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $toUsername = $r["to"];
        $fromUsername = $r["from"];

        array_push($toUsernames, $toUsername);
        array_push($fromUsernames, $fromUsername);

    }

    for ($i=0; $i < count($toUsernames) ; $i++){
        if ($toUsernames[$i]== $username){
            echo $fromUsernames[$i] . "<br>";
        }
    }
    }
}




function displayLeagueHistory($leagueID){
    global $db, $t;

    $s = "SELECT * FROM UserHistory WHERE LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    $historyArray = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $date = $r['Date'];
        $type = $r['Type'];
        $detail = $r['Detail'];

        array_push($historyArray, $date, $type, $detail);
    }

    return $historyArray;
}

function displayPlayerHistory($leagueID, $playerName){
    global $db, $t;

    $s = "SELECT * FROM UserHistory WHERE LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    $historyArray = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $date = $r['Date'];
        $type = $r['Type'];
        $detail = $r['Detail'];

        
        if (strpos($detail, $playerName)){
            array_push($historyArray, $date, $type, $detail);
        }
    }

    return $historyArray;
}

?>
