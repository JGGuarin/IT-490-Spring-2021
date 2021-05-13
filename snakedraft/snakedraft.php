<?php   
session_start();

include('ini.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$leagueID = 47;
$username = "testUser";

$_SESSION['leagueID'] = $leagueID;
$_SESSION['username'] = $username;

function getCreatorUsername($leagueID){
    global $db, $t;

    $s = "select CreatorName from League where LeagueID='$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $creatorUsername = $r["CreatorName"];

    return $creatorUsername;
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

function isDraftActive($leagueID){
    global $db, $t;
    $s = "select * from Draft where (Status = 'drafting' or Status = 'active') and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        return false;
    }else{
        return true;
    }
}

function isDraftDone($leagueID){
    global $db, $t;

    $s = "select * from Draft where Status = 'Done' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        return false;
    }else{
        return true;
    }
}

function getActiveMember($leagueID){
    global $db, $t;

    $s = "select Username from Draft where Status = 'active' and LeagueID = '$leagueID'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $username = $r['Username'];

    return $username;
}

function getDraftingMember($leagueID){
    global $db, $t;

    $s = "select Username from Draft where Status = 'drafting' and LeagueID = '$leagueID'";

    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $username = $r['Username'];

    return $username;
}

function setDraftToDone($leagueID){
    global $db, $t;

    $s = "UPDATE Draft SET Status = 'done' WHERE LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
}

function setActiveMember($username, $leagueID){
    global $db, $t;

    $s = "UPDATE Draft SET Status = 'active' WHERE Username = '$username' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

}

function checkStatus($leagueMember, $leagueID){
    global $db, $t;

    $s = "SELECT Status FROM Draft WHERE Username = '$leagueMember' and LeagueID = '$leagueID'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));

    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    $status = $r['Status'];

    return $status;
}

$creatorUsername = getCreatorUsername($leagueID);  
echo "Creator: "; print_r($creatorUsername); echo "<br>";
$leagueMembers = displayLeagueMembers($leagueID);


if (isDraftActive($leagueID) == false){ //if the draft is not active
    if (isDraftDone($leagueID) == false){ //if the draft is not active & if the draft is not done
        if ($username == $creatorUsername){ //creator has a button to start the draft
            echo "<hr>Start the draft: <br>";
            echo "<form method='post' action = 'creatorDraft.php'> 
                        <input type='submit' name='draftButton'
                        class='button' value='Draft a Team'/> 
                    </form> ";
            //in the draft.php, set the user draft's status to "drafting"
            //once the timer is done, set the user's draft status to "drafted"
            //add everyone in the league with a status of "waiting"
        }else{
            echo "draft has not started yet"; //shows to other users not the creator
        }
    }else{ //if the draft is not active & the draft is done
        echo "draft has ended";
    }
}else{      //if the draft is active
    $activeMember = getActiveMember($leagueID);
    if ($username == $activeMember){
        echo "<hr>Start drafting: <br>";
        echo "<form method='post' action = 'draft.php'> 
                    <input type='submit' name='draftButton'
                    class='button' value='Draft a Team'/> 
                </form> ";
        //display the start button
        //get sent to draft.php
        //set user's draft status to drafting
        //once the timer is done, set the user's status to drafted
    }else{
        $draftingMember = getDraftingMember($leagueID);
        echo "$draftingMember is drafting right now<br>";
        $queue = $leagueMembers;
        foreach($queue as $leagueMember){
            $status = checkStatus($leagueMember, $leagueID);
            if (($status == "drafted") || ($status == "drafting")){
                array_shift($queue);//remove from array
            }else{
                if(count($queue) == 0){ //there are no more players in the queue
                    setDraftToDone($leagueID);
                    echo "draft is done";
                }
            }
        }
        echo "$queue[0] is next";
        if (!isSomeoneDrafting($leagueID)){
            setActiveMember($queue[0], $leagueID);     
        }
    }
}

function isSomeoneDrafting($leagueID){
    global $db, $t;

    $s = "Select * from Draft where Status='drafting'";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $num = mysqli_num_rows($t);

    if ($num == 0){
        return false;
    }else{
        return true;
    }

}

/*

foreach ($leagueMembers as $leagueMember){
    echo "<b>User: </b>" . $leagueMember . " | <b>Team: </b>" . getLeagueMemberTeamName($leagueMember, $leagueID) . "<br>";
}


if ($username == $creatorUsername){
    echo "<hr>Draft a team a team for one of your league members: <br>";
    echo "<form method='post' action = 'draft.php'> 
            <input type='submit' name='draftButton'
                class='button' value='Draft a Team'/> 
        </form> ";
}

*/

?>

