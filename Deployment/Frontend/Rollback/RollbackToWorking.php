<?php

$hostName = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'Deployment';
$db = new mysqli($hostName, $user, $password, $databaseName);

$s = "SELECT `FileLocation` FROM VersionList WHERE `Working`='Y' AND `SystemMachine`='Front' ORDER BY `UploadDate` DESC LIMIT 1" ;
$t = $db->query($s);
$r = $t->fetch_assoc();

echo $r["FileLocation"];

$db->close();

?>
