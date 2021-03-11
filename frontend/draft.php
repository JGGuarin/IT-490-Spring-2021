<?php
include 'ini.php';
include 'mainfunctions.php';
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$teamName = $_SESSION["teamName"];
$leagueID = $_SESSION["leagueID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$leagueName = $_SESSION["leagueName"];

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
        <a href="league.php">Back to Leagues</a>
        <a href="logout.php" style="float: right">Log Out</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>


    <div class="card">
        <div class="container">
          <h2><b><?php echo "League " . $leagueName . " Draft"?></b></h2>
          <hr>
          Huddle up with your friends and draft your teams! As the creator of the league, you get to set the initial players for each team. Don't worry, your friends will then have the ability to add and drop players later!
          <hr>
          Creator: <?php $creatorUsername = getCreatorUsername($leagueID); ?>
          <h4><b>League Members</b></h4>
          
            <?php 
                $leagueMembers = displayLeagueMembers($leagueID);
                
                foreach ($leagueMembers as $leagueMember){
                  echo "<b>User: </b>" . $leagueMember . " | <b>Team: </b>" . getLeagueMemberTeamName($leagueMember, $leagueID) . "<br>";
                }

                /*
                if ($username == $creatorUsername){
                  echo "<form method='post' action = 'draft.php'> 
                            <input type='submit' name='draftButton'
                                class='button' value='Set Draft'/> 
                       </form> ";
                }*/
            ?>
        </div>
    </div>
                
    <br>
            
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