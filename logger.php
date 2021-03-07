#!/usr/bin/php
<?php
require_once('rabbitMQLib.inc');

// Will be used for a centralized logger
class CentralizedLogger
{
    public $logFile;

    // Automatically called when creating an object from a class
    function __construct()
    {
        $logFileName = "SystemLog.log";

        // Creates the log file if it doesn't exist and appends to it
        $this->logFile = fopen($logFileName, "a");
        echo "centralizedLogger BEGIN".PHP_EOL;
        
        fwrite($this->logFile, PHP_EOL);
        fwrite($this->logFile, "centralizedLogger BEGIN (at ".date(DATE_RFC2822).")".PHP_EOL);  
        fwrite($this->logFile, "VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV".PHP_EOL);  
        
        $logServer = new rabbitMQClient("testRabbitMQ.ini","loggerServer");
        // $logServer->process_requests(array($this, 'requestProcessor'));
    }

    function requestProcessor($requestData)
    {
        echo "received request".PHP_EOL;
        print_r($requestData);
        fwrite($this->logFile, $requestData);
    }

    function errorLog($errno, $errstr, $errfile, $errline)
    {
        $errorMsg = "Error Number: ".$errorno.": ".$errfile.": ".$errline.": ".$errstr.PHP_EOL;
        fwrite($this->logFile, $errorMsg);
    }

    function __destruct()
    {
        fwrite($logFile, "^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^".PHP_EOL); 
        write($logFile, "centralizedLogger END (at ".date(DATE_RFC2822).")".PHP_EOL); 
        fclose($logFile);
    }
}

// Will be used for a distributed logger
class LoggerServer
{
    // Automatically called when creating an object from a class
    function __construct()
    {

    }
}

// Will be used for a distributed logger
class LoggerClient
{
    // Automatically called when creating an object from a class
    function __construct()
    {

    }
}
?>