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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="js/plugins.js"></script>
  <script type="text/javascript" src="main.js"></script>

  <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--menu & css from w3schools: https://www.w3schools.com/howto/howto_js_topnav_responsive.asp-->
  <div class="topnav" id="myTopnav">
    <a href="chooseleague.php">Home</a>
    <a href="myteam.php">My Team</a>
    <a href="league.php">League</a>
    <a href="players.php" class="active">Players</a>
    <a href="scoreboard.php">Scoreboard</a>
    <a href="logout.php" style="float: right">Log Out</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>

  <br>

  <div class="card">
    <div class="container">
      <h2 class="in-line">Players</h2>
      <input type="text" id="playerInput" placeholder="Search for names..">

      <aside class="filter-list">
            <br><br>

            <label for="availability">Availability</label>
            <select id="availability" name="availability" class="filter-list">
                <option value="">Select Availability</option>
                <option value="available">Available</option>
                <option value="On Roster">On Roster</option>
            </select>

            <br><br>

            <label for="proTeam">Pro Team</label>
            <select id="proTeam" name="proTeam" class="filter-list">
                <option value="">Select Pro Team</option>

                <?php                 
                  $teams = displayPlayersUniqueTeams();
                  foreach ($teams as $team){
                    echo "<option value='$team'>$team</option>";
                  }

                ?>
            </select>

            <br><br>
            <label for="position">Position</label>
            <select id="position" name="position" class="filter-list">
                <option value="">Select Position</option>
                <option value="F">Forward</option>
                <option value="G">Guard</option>
                <option value="C">Center</option>
            </select>
        </aside>

    </div>
  </div>

    <br><br>

  <div class="card">
    <div class="container">

      <h2>PLAYER STATS </h2>
      <table class="collapsed team" id="playerTable" width=100%>
        <tr class="header">
          <th scope="col">PLAYERS</th>
          <th scope="col">STATUS</th>
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
                $names = displayPlayersNames();
                $positions = displayPlayersPositions();
                $teams = displayPlayersTeams();
                $ft = displayPlayersInfo("Ft");
                $tp = displayPlayersInfo("Tp");
                $fg = displayPlayersInfo("Fg");
                $ppg = displayPlayersInfo("Ppg");
                $rpg = displayPlayersInfo("Rpg");
                $apg = displayPlayersInfo("Apg");
                $spg = displayPlayersInfo("Spg");
                $bpg = displayPlayersInfo("Bpg");

                for ($i=0; $i < count($names); $i++){
                  $availability = displayAvailability($names[$i]);
                  echo "<tr>
                            <td>
                                <a href='player.php?playerName=" . $names[$i] . "'>$names[$i]</a>
                                <p class='position'> $positions[$i] </p>
                                <p class='proTeam'> $teams[$i] </p>";
                  
                  echo "<p>";
                  if ($availability == "Available"){
                    
                    echo "<a href='addPlayers.php?playerName=" . $names[$i] . "'><button type='button' name='addPlayer'>Add Player</button></a>
                              </td>";
                  }elseif (isPlayerOnTeam($teamID, $names[$i])){
                    echo "<a href='dropPlayers.php?playerName=" . $names[$i] . "'><button type='button' name='droplayer'>Drop Player</button></a>
                              </td>";
                  }
                  else{
                    echo "Player not available";
                  }
                  echo "</p>";


          
                  echo "</td>";
                  echo "<td>";
                  echo "<p class='availability'>";
                  echo $availability;
                  echo "</p>";
                  echo "</td>";
                  echo "<td>";
                  echo $fg[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $ft[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $tp[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $rpg[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $apg[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $spg[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $bpg[$i];
                  echo "</td>";
                  echo "<td>";
                  echo $ppg[$i];
                  echo "</td>";
                  echo "</tr>";

                }                
            ?>
      </table>
    </div>
  </div>


</body>

</html>
