<?php

//ADD Player
function playerAdd ($name) {
    "UPDATE `Player` "
}

//DROP Player

//Player Averages

//Show the teams for a league

//Insert a statline

//The Following Functions are related to the friend system
 // SEND FRIEND REQUEST
 function request ($from, $to) {
    //CHECK IF ALREADY FRIENDS
    $this->query(
      "SELECT * FROM `relation` WHERE `from`=? AND `to`=? AND `status`='F'",
      [$from, $to]
    );
    $result = $this->stmt->fetch();
    if (is_array($result)) {
      $this->error = "Already added as friends";
      return false;
    }

    //CHECK FOR PENDING REQUESTS
    $this->query(
      "SELECT * FROM `relation` WHERE ".
      "(`status`='P' AND `from`=? AND `to`=?) OR ".
      "(`status`='P' AND `from`=? AND `to`=?)",
      [$from, $to, $to, $from]
    );
    $result = $this->stmt->fetch();
    if (is_array($result)) {
      $this->error = "Already has a pending friend request";
      return false;
    }

    //ADD FRIEND REQUEST
    return $this->query(
      "INSERT INTO `relation` (`from`, `to`, `status`) VALUES (?,?,'P')",
      [$from, $to]
    );
  }

  //ACCEPT FRIEND REQUEST
  function acceptReq ($from, $to) {
    //UPGRADE STATUS TO "F"RIENDS
    $this->query(
      "UPDATE `relation` SET `status`='F' WHERE `status`='P' AND `from`=? AND `to`=?",
      [$from, $to]
    );
    if ($this->stmt->rowCount()==0) {
      $this->error = "Invalid friend request";
      return false;
    }

    //ADD RECIPOCAL RELATIONSHIP
    return $this->query(
      "INSERT INTO `relation` (`from`, `to`, `status`) VALUES (?,?,'F')",
      [$to, $from]
    );
  }

  //CANCEL FRIEND REQUEST
  function cancelReq ($from, $to) {
    return $this->query(
      "DELETE FROM `relation` WHERE `status`='P' AND `from`=? AND `to`=?",
      [$from, $to]
    );
  }

  //UNFRIEND
  function unfriend ($from, $to) {
    return $this->query(
      "DELETE FROM `relation` WHERE ".
      "(`status`='F' AND `from`=? AND `to`=?) OR ".
      "(`status`='F' AND `from`=? AND `to`=?)",
      [$from, $to, $to, $from]
    );
  }

  //BLOCK & UNBLOCK
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

  //GET FRIEND REQUESTS
  function getReq ($uid) {
    //GET OUTGOING FRIEND REQUESTS (FROM USER TO OTHER PEOPLE)
    $req = ["in"=>[], "out"=>[]];
    $this->query(
      "SELECT * FROM `relation` WHERE `status`='P' AND `from`=?",
      [$uid]
    );
    while ($row = $this->stmt->fetch()) { $req['out'][$row['to']] = $row['since']; }

    //GET INCOMING FRIEND REQUESTS (FROM OTHER PEOPLE TO USER)
    $this->query(
      "SELECT * FROM `relation` WHERE `status`='P' AND `to`=?", [$uid]
    );
    while ($row = $this->stmt->fetch()) { $req['in'][$row['from']] = $row['since']; }
    return $req;
  }

  //GET FRIENDS & FOES (BLOCKED)
  function getFriends ($uid) {
    // GET FRIENDS
    $friends = ["f"=>[], "b"=>[]];
    $this->query(
      "SELECT * FROM `relation` WHERE `status`='F' AND `from`=?", [$uid]
    );
    while ($row = $this->stmt->fetch()) { $friends["f"][$row['to']] = $row['since']; }

    // GET FOES
    $this->query(
      "SELECT * FROM `relation` WHERE `status`='B' AND `from`=?", [$uid]
    );
    while ($row = $this->stmt->fetch()) { $friends["b"][$row['to']] = $row['since']; }
    return $friends;
  }

  // GET ALL USERS
  function getUsers () {
    $this->query("SELECT * FROM `users`");
    $users = [];
    while ($row = $this->stmt->fetch()) { $users[$row['user_id']] = $row['user_name']; }
    return $users;
  }
}

?>