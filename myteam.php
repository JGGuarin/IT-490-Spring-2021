<?php
session_start();
include 'ini.php';

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
    <a href="myteam.php" class="active">My Team</a>
    <a href="league.php">League</a>
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
          <img src="jersey%20logo.jpg" height=100px width=100px />
        </div>
        <div class="column right">
          <h4><b>Team Name</b></h4>
          <p> <?php echo $leagueName ?> | <?php echo $username ?></p>
        </div>
      </div>
    </div>
  </div>

    <br><br>

  <div class="card">
    <div class="container">

      <h2>TEAM STATS </h2>
      <table class="collapsed team" width=100%>
        <col>
        <colgroup span="2" class="right-border"></colgroup>
        <colgroup span="9"></colgroup>
        <tr>
          <th colspan="2" scope="colgroup">STARTERS</th>
          <th colspan="9" scope="colgroup">STATS</th>
        </tr>
        <tr>
          <th scope="col">Slot</th>
          <th scope="col">Player</th>
          <th scope="col">FGM</th>
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
          <td>postion</td>
          <td>playerName</td>
        </tr>
        <tr>
        </tr>
      </table>
    </div>
  </div>


</body>

</html>
