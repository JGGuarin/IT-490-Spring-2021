<?php

session_start();

include('ini.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$leagueID = $_SESSION['leagueID'];
$username = $_SESSION['username'];

echo "LeagueID: $leagueID and Username: $username <br>";

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

function initiateTeamDraft($leagueID){
    global $db, $t;

    $leagueMembers = displayLeagueMembers($leagueID);

    foreach($leagueMembers as $leagueMember){
        $s = "INSERT INTO Draft VALUES('$leagueID', '$leagueMember', 'waiting')";
        ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    }

}

function setStatusToDrafting($username, $leagueID){
    global $db, $t;

    $s = "UPDATE Draft SET Status='drafting' WHERE Username='$username' and LeagueID='$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
}

initiateTeamDraft($leagueID);
setStatusToDrafting($username, $leagueID);

?>
<!DOCTYPE html>
<div class="card">
        <div class="container">
            <div class="col-container">
                <div class="col" style="width:100%">

                <form method='post' action = 'draftTeam.php'>
                Choose Team to Draft: <input type="text" name="teamName" placeholder = "Ex: Team Username" required><br>   
                        <br>                            
                        Player 1: <input type=text name="player1" id = "player1" required>
                        <p></p>
                        Player 2: <input type=text name="player2" id="player2">
                        <p></p>
                        Player 3: <input type=text name="player3" id="player3">
                        <p></p>
                        Player 4: <input type=text name="player4" id="player4">
                        <p></p>
                        Player 5: <input type=text name="player5" id="player5">
                        <p></p>
                        Player 6: <input type=text name="player6" id="player6">
                        <p></p>
                        Player 7: <input type=text name="player7" id="player7">
                        <p></p>
                        Player 8: <input type=text name="player8" id="player8">
                        <p></p>
                        Player 9: <input type=text name="player9" id="player9">
                        <p></p>
                        Player 10: <input type=text name="player10" id="player10">
                        <p></p>

                        <input type=submit id = "draftTeam">
                        <input type="reset" value="Reset">
                    </form> <br><br>

          

                </div>
            </div>
        </div>
</body>
</html>

