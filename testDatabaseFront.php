#!/usr/bin/php

<?php
require_once('testDatabaseClient.php');

echo "Front start".PHP_EOL;
$kink = "being happy and hydrated and breathing";
$output = makeKinkShameRequest($kink);
echo $output.PHP_EOL;

if ($output)
{
    echo "Successful front to back friend".PHP_EOL;
}
echo "Front end".PHP_EOL;
?>