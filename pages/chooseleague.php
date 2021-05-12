<?php
include('path.inc');
include('get_host_info.inc');
include('rabbitMQLib.inc');
include('logger.php'); // "Importing" logger.php
include('../IT-490-Spring-2021/testRabbitMQClient.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$userID = $_SESSION["userID"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$_SESSION["leagueName"] = "";

if (! $_SESSION["logged"]){
    header("Location: login.html");
    exit();
}


$leagues = getUserLeagues($userID);

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
        <a href="chooseleague.php">Home</a>
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
                <?php
                        echo "<h3>Leagues you are a part of: </h3>";
                        foreach ($leagues as $league){
                            echo "<li>League $league<br>";
                        }
                    ?>

                    <form method="POST" action='chosenLeague.php'> 
                        <div class="custom-select" style="width:200px;">
                            <select id="leagueName" name="leagueName" onchange="this.form.submit()">
                                <option value="0">Select League to View:</option>
                                <?php 
                                    foreach ($leagues as $league){
                                        echo "<option id='chosenLeagueName' name='chosenLeagueName' value='$league'>League $league</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
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
                <div class="col form">
                    <h3>Friends List:</h3>
                        <?php 
                            $friends = getFriends($username); 
                            if ($friends == false){
                                echo "No friends yet<br>";
                            }else{
                                foreach($friends as $friend){
                                    echo "$friend <br>";
                                }
                            }
                        
                        ?>
                    <hr>

                    <h3>Friend requests:</h3>
                        <?php $friendUsername = getReq($username);
                        if ($friendUsername == 0){
                            echo "no friend requests yet";
                        }

                        if ($friendUsername !== 0){
                            echo "<form method='post'> 
                            <input type='submit' name='button1'
                                class='button' value='Accept Request'/> 
                            </form> ";
                            if(array_key_exists('button1', $_POST)) { 
                                acceptReq($friendUsername, $username); 
                            }  
                        }
                        ?> 
                    <hr>

                    <h3>Manage your Friends List</h3>

                    <form id="friendship" method="post" action="addfriend.php">
                        Enter Username: <input type=text name="friendUsername" id="friendusername" required>
                        <input type=submit id = "addFriend" name = "addFriend" value = "Send Friend Request">
                    </form>
                </div>
            </div>


        </div>
    </div>
    </body>
</html>