<?php
include 'ini.php';
include 'mainfunctions.php';
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}

$leagueName = $_POST["leagueName"];

$member1 = $_POST["leagueMember1"];
$member2 = $_POST["leagueMember2"];
$member3 = $_POST["leagueMember3"];
$member4 = $_POST["leagueMember4"];
$member5 = $_POST["leagueMember5"];
$member6 = $_POST["leagueMember6"];
$member7 = $_POST["leagueMember7"];
$member8 = $_POST["leagueMember8"];
$member9 = $_POST["leagueMember9"];
$member10 = $_POST["leagueMember10"];

$inputArray = array();
array_push($inputArray, $username, $member1, $member2, $member3, $member4, $member5, $member6, $member7, $member8, $member9, $member10);

$memberArray = array();

foreach ($inputArray as $input){
    if($input !== ""){
        array_push($memberArray, $input);
    }    
}

$leagueID = createALeauge($leagueName, $userID, $username, $memberArray);

$_SESSION["leaugeID"] = $leagueID;
$_SESSION["leaugeName"] = $leagueName;

if (!$leagueID){
    header("Refresh: 0.001, url=chooseleague.php");
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta property="og:title" content="">
        <meta property="og:type" content="">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="main.css">

        <meta name="theme-color" content="#fafafa">
    </head>
    
    <body>
    <!-- Add your site or application content here -->
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="main.js"></script>


    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--menu & css from w3schools: https://www.w3schools.com/howto/howto_js_topnav_responsive.asp-->
    <div class="topnav" id="myTopnav">
        <a href="logout.php" style="float: right">Log Out</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>


    <div class="card">
        <div class="container">
            <h2><?php 
                    echo "Hello, $firstname $lastname";
                    echo "<br>Your username: $username";
                    echo "<hr>";
                ?>
                </h2>
                <h2><b><?php echo $leagueName?></b></h2>
          <hr>
          Creator: <?php $creatorUsername = getCreatorUsername($leagueID); ?>
          <h4><b>League Members</b></h4>
          
            <?php 
                $leagueMembers = displayLeagueMembers($leagueID);
                
                foreach ($leagueMembers as $leagueMember){
                  echo "<b>User: </b>" . $leagueMember . " | <b>Team: </b>" . getLeagueMemberTeamName($leagueMember, $leagueID) . "<br>";
                }

                
                if ($username == $creatorUsername){
                  echo "<form method='post' action = 'draft.php'> 
                            <input type='submit' name='draftButton'
                                class='button' value='Draft a Team'/> 
                       </form> ";
                }
            ?>
        </div>
    </div>
                
    <br>
            
    <div class="card">
        <div class="container">
            <div class="col-container">
                <div class="col">
                    <h3>Create a League!</h3>
                    <form action="createleague.php" id="createLeagueForm" method="post">
                        Give your league a name: <br><input type=text name="leagueName" id="leagueName" required placeholder="Enter league name"><br>
                        
                        <h4 style="margin-bottom: 0px">Add your friends!</h4><p style="margin-top: 0px">*Up to 10 members</p>
                        
                        Member 1: <br><input type=text name="leagueMember1" id = "leagueMember1" required><br>
                        <p></p>
                        Member 2: <br><input type=text name="leagueMember2" id="leagueMember2"><br>
                        <p></p>
                        Member 3: <br><input type=text name="leagueMember3" id="leagueMember3"><br>
                        <p></p>
                        Member 4: <br><input type=text name="leagueMember4" id="leagueMember4"><br>
                        <p></p>
                        Member 5: <br><input type=text name="leagueMember5" id="leagueMember5"><br>
                        <p></p>
                        Member 6: <br><input type=text name="leagueMember6" id="leagueMember6"><br>
                        <p></p>
                        Member 7: <br><input type=text name="leagueMember7" id="leagueMember7"><br>
                        <p></p>
                        Member 8: <br><input type=text name="leagueMember8" id="leagueMember8"><br>
                        <p></p>
                        Member 9: <br><input type=text name="leagueMember9" id="leagueMember9"><br>
                        <p></p>
                        Member 10: <br><input type=text name="leagueMember10" id="leagueMember10"><br>
                        <p></p>

                        <input type=submit id = "createLeague">
                        <input type="reset" value="Cancel">
                    </form>



                </div>
            </div>
        </div>
</body>
</html>