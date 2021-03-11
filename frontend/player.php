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
$teamName = $_SESSION["teamName"];

$playerName = $_GET['playerName'];
$playerName = sanitizeInput($playerName);

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
    <a href="players.php">Return to Players</a>

    <a href="logout.php" style="float: right">Log Out</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>

  <br>

  <div class="card">
    <div class="container">
        <h4><b><?php echo $playerName ?></b></h4>
        <p> <?php 
                echo "Pro Team: " . displayTeamPlayersInfo('Team',$playerName) . 
                "<br> Eligible Positions: " . displayTeamPlayersInfo('Pos',$playerName) . "<br>Status: " .

                $availability = displayAvailability($playerName);

                if ($availability == "Available"){
                    
                    echo "<a href='addPlayers.php?playerName=" . $playerName . "'><br><br><button type='button' name='addPlayer'>Add Player</button></a>
                              </td>";
                  }elseif (isPlayerOnTeam($teamID, $playerName)){
                    echo "<a href='dropPlayers.php?playerName=" . $playerName . "'><br><br><button type='button' name='droplayer'>Drop Player</button></a>
                              </td>";
                  }
                  else{
                    echo "Player is already part of a team. They not available to be drafted at this time.";
                  }

            ?></p>
    </div>
  </div>

    <br>

  <div class="card">
    <div class="container">

      <h2>PLAYER STATS </h2>
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
          <th scope="col">FG%</th>
          <th scope="col">FT%</th>
          <th scope="col">3PM</th>
          <th scope="col">RB</th>
          <th scope="col">AST</th>
          <th scope="col">STL</th>
          <th scope="col">BLK</th>
          <th scope="col">PTS</th>
        </tr>
          <?php 
              $positions = displayTeamPlayersInfo('Pos', $playerName);
              $teams = displayTeamPlayersInfo('Team',$playerName);
              $ft = displayTeamPlayersInfo('Ft',$playerName);
              $tp = displayTeamPlayersInfo('Tp',$playerName);
              $fg = displayTeamPlayersInfo('Fg',$playerName);
              $ppg = displayTeamPlayersInfo('Ppg',$playerName);
              $rpg = displayTeamPlayersInfo('Rpg',$playerName);
              $apg = displayTeamPlayersInfo('Apg',$playerName);
              $spg = displayTeamPlayersInfo('Spg',$playerName);
              $bpg = displayTeamPlayersInfo('Bpg',$playerName);

              echo "<tr>";
              echo "<td>";
              echo $positions;
              echo "</td>";
              echo "<td>";
              echo $playerName;
              echo "<p class='proTeam'>";
              echo $teams;
              echo "</p>";
              echo "</td>";
              echo "<td>";
              echo $fg;
              echo "</td>";
              echo "<td>";
              echo $ft;
              echo "</td>";
              echo "<td>";
              echo $tp;
              echo "</td>";
              echo "<td>";
              echo $rpg;
              echo "</td>";
              echo "<td>";
              echo $apg;
              echo "</td>";
              echo "<td>";
              echo $spg;
              echo "</td>";
              echo "<td>";
              echo $bpg;
              echo "</td>";
              echo "<td>";
              echo $ppg;
              echo "</td>";
              echo "</tr>";                
          ?>     
      </table>
    </div>
  </div>

    <br>

  <div class="card">
    <div class="container">

      <h2>GAME LOGS </h2>
      <table class="collapsed team" id="playerTable" width=100%>
        <tr class="header">
          <th scope="col">DATE</th>
          <th scope="col">OPP</th>
          <th scope="col">PTS</th>
          <th scope="col">REB</th>
          <th scope="col">AST</th>
          <th scope="col">STL</th>
          <th scope="col">BLK</th>
        </tr>
                    
      </table>
    </div>
  </div>

  <br>

  <div class="card">
    <div class="container">

      <h2>TRANSACTIONS </h2>
      <table class="collapsed" width=100%>
        <tr>
          <th>Date</th>
          <th>Type</th>
          <th>Detail</th>
        </tr>
        <?php
          $historyInfo = displayPlayerHistory($leagueID, $playerName);
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
