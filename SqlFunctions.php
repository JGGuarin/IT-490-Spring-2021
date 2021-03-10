<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

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
function scheduleWrite($ApiGameId, $HomeTeam, $AwayTeam){

}

//The Following Functions are related to the friend system
//TODO: Fix the format
 // SEND FRIEND REQUEST
 function request ($from, $to) {
    //CHECK IF ALREADY FRIENDS
    global $db, $t
    $s = "SELECT * FROM `relation` WHERE `from`=$from AND `to`=$to AND `status`='F'" ;

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        //RUN THE NEXT PART
        $s =  "SELECT * FROM `relation` WHERE (`status`='P' AND `from`=$from AND `to`=$to) OR (`status`='P' AND `from`=$to AND `to`=$from)";

        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
        $num = mysqli_num_rows($t);

        if ($num == 0){
          $s = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES ($from,$to,'P')";
          ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
          return "Friend Request Sent";
        }

        return "Already has a pending friend request";
    }
    
    return "Already Friends";

  }

  //ACCEPT FRIEND REQUEST
  function acceptReq ($from, $to) {
    global $db, $t
    //UPGRADE STATUS TO "F"RIENDS
    $s = "UPDATE `relation` SET `status`='F' WHERE `status`='P' AND `from`=$from AND `to`=$to";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);
    
    //check to see if valid friend request
    if ($num == 0){
      return "Invalid Friend Request";
    }

    //ADD RECIPOCAL RELATIONSHIP
    $s = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES ($to,$from,'F')";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    return "Friend Request Accepted";
    
  }

  //NEEDS WORK: GET FRIEND REQUESTS
  //TODO: Display the results
  function getReq ($userID) {
    global $db, $t
    //GET OUTGOING FRIEND REQUESTS (FROM USER TO OTHER PEOPLE)
    $s = "SELECT * FROM `relation` WHERE `status`='P' AND `from`=$userID";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    //GET INCOMING FRIEND REQUESTS (FROM OTHER PEOPLE TO USER)
    $s = "SELECT * FROM `relation` WHERE `status`='P' AND `to`=$userID";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    
  }

  //NEEDS WORK: GET FRIENDS
  //TODO: Display the results
  function getFriends ($userID') {
    global $db, $t
    // GET FRIENDS
    $s = "SELECT * FROM `relation` WHERE `status`='F' AND `from`=$userID";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
  }


  //STRETCH GOAL: CANCEL FRIEND REQUEST
  function cancelReq ($from, $to) {
    return $this->query(
      "DELETE FROM `relation` WHERE `status`='P' AND `from`=? AND `to`=?",
      [$from, $to]
    );
  }


  //STRETCH GOAL: UNFRIEND
  function unfriend ($from, $to) {
    return $this->query(
      "DELETE FROM `relation` WHERE ".
      "(`status`='F' AND `from`=? AND `to`=?) OR ".
      "(`status`='F' AND `from`=? AND `to`=?)",
      [$from, $to, $to, $from]
    );
  }
  //STRETCH GOAL: BLOCK & UNBLOCK
function block ($from, $to, $blocked=true) {
  //BLOCK
  if ($blocked) { return $this->query(
    "INSERT INTO `relation` (`from`, `to`, `status`) VALUES (?,?,'B')",
    [$from, $to]
  ); }

  //UNBLOCK
  else { return $this->query(
    "DELETE FROM `relation` WHERE `from`=? AND `to`=? AND `status`='B'",
    [$from, $to]
  ); }
}

?>