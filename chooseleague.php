<?php
include 'ini.php';
include 'mainfunctions.php';
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


echo "Hello, $firstname $lastname";
echo "<br>Username: $username";

echo "<hr>";

$leagues = getUserLeagues($userID);

foreach ($leagues as $league){
    echo "<li>League $league<br>";
}
//create a league option



//join a league


?>

<!doctype html>
<html>
    <body>
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
    </body>
</html>