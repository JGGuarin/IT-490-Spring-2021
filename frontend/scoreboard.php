<?php
session_start();
include 'ini.php';
include 'mainfunctions.php';

if (! $_SESSION["logged"]){
  header("Location: login.html");
  exit();
}

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$teamID = $_SESSION["teamID"];
$leagueID = $_SESSION["leagueID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$leagueName = $_SESSION["leagueName"];

?>

<!doctype html>
<html class="no-js" lang="">

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
  <script src="main.js"></script>

  <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--menu & css from w3schools: https://www.w3schools.com/howto/howto_js_topnav_responsive.asp-->
  <div class="topnav" id="myTopnav">
    <a href="chooseleague.php">Home</a>
    <a href="myteam.php">My Team</a>
    <a href="league.php">League</a>
    <a href="players.php">Players</a>
    <a href="scoreboard.php" class="active">Scoreboard</a>
    <a href="logout.php" style="float: right">Log Out</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>

  <br>

  <h2><b>Scoreboard</b> - <?php echo $leagueName?></h2>

  <div class="card">
    <div class="container">
      <h2>Team Scores</h2>
      <table class='no-border' width=50%>   
          <th>Team</th> 
          <th>Scores</th>      
          <?php 
            $leagueMembers = displayLeagueMembers($leagueID);
            
            foreach ($leagueMembers as $leagueMember){
              $teamName = getLeagueMemberTeamName($leagueMember, $leagueID);
              $teamScores = getTeamScores($teamName, $leagueID);
              echo "<tr><td></b>" . $teamName . "</td><td> $teamScores[0] - $teamScores[1] - $teamScores[2]" ."<br></td></tr>";
            }
          ?>
      </table>
    </div>
  </div>

  <!--
  <div class="card">
    <div class="container">
      <h2>Team Stats</h2>
      <table class="no-border" width=100%>
      <tr>
            <th scope="col"></th>
            <th scope="col">FG%</th>
            <th scope="col">FT%</th>
            <th scope="col">3PM</th>
            <th scope="col">RB</th>
            <th scope="col">AST</th>
            <th scope="col">STL</th>
            <th scope="col">BLK</th>
            <th scope="col">PTS</th>
        </tr>
        <tr>
            <th scope="col">Team 1</th>
            <th scope="col">number</th>
            <th scope="col">number</th>
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>        
        </tr>
        <tr>
            <th scope="col">Team 2</th>
            <th scope="col">number</th>
            <th scope="col">number</th>
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>        
        </tr>
        <tr>
            <th scope="col">Team 3</th>
            <th scope="col">number</th>
            <th scope="col">number</th>
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>            
            <th scope="col">number</th>        
        </tr>
      </table>
    </div>
  </div>
          -->


  
</body>

</html>
