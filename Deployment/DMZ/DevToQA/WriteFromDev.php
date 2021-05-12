<?php

$hostName = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'Deployment';
$db = new mysqli($hostName, $user, $password, $databaseName);

$date = date("Y-m-d");

if ($db->errno != 0)
{
    echo "Failed to connect to database: ".$db->error.PHP_EOL;
    exit(0);
}
else
{
    echo "Successfully connected to database".PHP_EOL;
}

//TODO: Pass Command Line Arguments for  FileLocation
//TODO: Fix AUTO_INCREMENT
$s = "INSERT INTO VersionList(`SystemType`, `SystemMachine`, `UploadDate`, `Working`, `FileLocation`) VALUES ('Development', 'DMZ', '$date', 'N', '$argv[1]')" ;
$t = $db->query($s);

$db->close();

return true;

?>
