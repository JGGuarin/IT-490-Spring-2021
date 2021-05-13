<?php

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

function playerAdd ($userID, $username, $leagueID, $teamID, $playerName) {
    global $db, $t;
  
    $s = "UPDATE Player SET TeamID='$teamID' WHERE FullName='$playerName'";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));


    $type = "League member updated their roster";
    $detail = "$username added $playerName to their team";
    $s = "INSERT INTO UserHistory VALUES ('$userID', '$username', '$teamID', '$leagueID', NOW(), '$type', '$detail')";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    echo "<script>alert('Player added!')</script>";
    return true;
}

function playerDrop ($userID, $username, $leagueID, $teamID, $playerName) {
    global $db, $t;

    $s = "UPDATE Player SET TeamID=0 WHERE TeamID='$teamID' AND FullName='$playerName'";

    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    $type = "League member updated their roster";
    $detail = "$username dropped $playerName from their team";
    $s = "INSERT INTO UserHistory VALUES ('$userID', '$username', '$teamID', '$leagueID', NOW(), '$type', '$detail')";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));

    echo "<script>alert('Player dropped!')</script>";
    return true;
}
 
function showTeamScores($teamName, $leagueID){
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

function showLeagueMemberTeamName($Username, $leagueID){
    global $db, $t;

    $s = "select UserID from Users where Username = '$Username'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $userID = $r['UserID'];

    $teamID = obtainTeamID($userID, $leagueID);

    $teamName = getTeamName($teamID);

    return $teamName;
}

function obtainTeamID($userID, $leagueID){
    global $db, $t;

    $s = "select TeamID from Team where UserID='$userID' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamID = $r["TeamID"];

    return $teamID;
}

function obtainTeamName($teamID){
    global $db, $t;

    $s = "select TeamName from Team where TeamID = '$teamID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamName = $r['TeamName'];
    
    return $teamName;

}

function calculatePoints($teamName, $leagueID){
    global $db, $t;

    $s = "select TeamID from Team where TeamName='$teamName' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $teamID = $r['TeamID'];

    $s = "SELECT * FROM Player where TeamID = '$teamID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $fullnames = array();
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
        $fullname = $r["FullName"];
        array_push($fullnames, $fullname);
    }

    $teamPoints = 0;
    foreach($fullnames as $name){
      $s = "SELECT Ppg FROM PlayerImport where FullName = '$name'";
      ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

      $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
      $points = $r['Ppg'];
      $teamPoints += $points;
    }

    return $teamPoints;

}


?>