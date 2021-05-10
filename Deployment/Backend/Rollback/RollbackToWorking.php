<?php

$hostName = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'Deployment';
$db = new mysqli($hostName, $user, $password, $databaseName);

if ($db->errno != 0)
{
    echo "Failed to connect to database: ".$db->error.PHP_EOL;
    exit(0);
}
else
{
    echo "Successfully connected to database".PHP_EOL;
}

$s = "SELECT `FileLocation` FROM VersionList WHERE `Working`='Y' AND `SystemMachine`='Back' ORDER BY `UploadDate` DESC LIMIT 1" ;
$t = $db->query($s);
$r = $t->fetch_assoc();

echo $r["FileLocation"];
echo "\n";

$db->close();

return true;

?>