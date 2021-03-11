<?php

$hostname = "localhost"; 	
$username = "root" ;
$project  = "newsql" ;
$password = "root" ;

//connect to the database
$db = mysqli_connect($hostname, $username, $password, $project);
if (mysqli_connect_errno())
  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }
mysqli_select_db( $db, $project ); 

?>
