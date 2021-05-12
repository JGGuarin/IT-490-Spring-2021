<?php

session_start();
include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('ini.php');
include('functions.php');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

if (! $_SESSION["logged"]){
  header("Location: login.html");
  exit();
}

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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
    <a href="league.php" class="active">League</a>
    <a href="players.php">Players</a>
    <a href="scoreboard.php">Scoreboard</a>
    <a href="logout.php" style="float: right">Log Out</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>

  <br>

  <div class="card">
    <div class="container">
      <div class="row">
        <div class="column left">
            <h2>My Team</h2>
          <img src="jersey%20logo.jpg" height=100px width=100px />
          <h3><?php echo $teamName ?></h3>
          <?php echo $username?><br>
          <a href="myteam.php">View roster</a>

        </div>
        <div class="column right">
          <h2><b><?php echo $leagueName?></b></h2>
          <hr>
          Creator: <?php $creatorUsername = getCreatorUsername($leagueID);  print_r($creatorUsername) ?>
          <h4><b>League Members</b></h4>
          
            <?php 
                $leagueMembers = displayLeagueMembers($leagueID);
                
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
            ?>
        </div>
      </div>
    </div>
  </div>

    <br><br>

  <div class="card">
    <div class="container">

      <h2>Recent Activity </h2>
      <table class="collapsed" width=100%>
        <tr>
          <th>Date</th>
          <th>Type</th>
          <th>Detail</th>
        </tr>
        <?php
          $historyInfo = displayLeagueHistory($leagueID);
          echo "<tr>";
          for ($i=0;$i<count($historyInfo);$i++){
            if ($i%3 == 0){
              echo "</tr></td>";
            } 
            echo "<td>$historyInfo[$i]</td>"; 
  
          }
          echo "</tr>";
        ?>
      </table>
    </div>
  </div>



  
</body>


</html>
