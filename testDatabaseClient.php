#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('logger.php'); // "Importing" logger.php

//echo "WELCOME".PHP_EOL;

function makeKinkShameRequest($kink)
{
  $client = new rabbitMQClient("testRabbitMQ.ini","apiServer");
  
  /*
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "test message";
  }
  */

  $request = array();
  /*
  $request['type'] = "Login";
  $request['username'] = "steve";
  $request['password'] = "password";
  $request['message'] = $msg;
  */

  $request['type'] = "KinkShame";
  $request['kink'] = $kink;
  $response = $client->send_request($request);
  echo "Your kink: '".$request['kink']."' has been sent for processing".PHP_EOL;
  //$response = $client->publish($request);


  //$logger = new LoggerClient(); // LOGGY
  //$logger->log($request); // MORE LOGGY

  if($response)
  {
    echo "HOLY FUCKING SHIT BATMAN, YOU KILLED A MAN".PHP_EOL;
  }

  echo "client received response: ".PHP_EOL;
  print_r($response);
  echo "\n\n";
  return $response;

  //echo $argv[0]." END".PHP_EOL;
}

