#!/usr/bin/php
<?php
require_once('rabbitMQLib.inc');

class LoggerClient
{
    public $logFile;

    // Automatically called when creating this class object
    function __construct()
    {
        $logFileName = "SystemLog.log";
        echo "LOGGING DATA TO '".$logFileName."'".PHP_EOL;

        $this->logFile = fopen($logFileName, "a");
        fwrite($this->logFile, PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        fwrite($this->logFile, "CLIENT LOGGING HAS BEGUN (at ".date(DATE_RFC2822).")".PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);

        $loggerClient = new rabbitMQClient("testRabbitMQ.ini","loggerServer");
        echo "loggerClient BEGIN".PHP_EOL;
    }

    function log($data)
    {
        // Referencing the first and only array entry of an array
        $backTrace = debug_backtrace()[0];

        $filePath = $backTrace['file'];
        $lineNumber = $backTrace['line'];

        //json_encode($data) can handle arrays
        $log = $filePath." on line ".$lineNumber.": ".json_encode($data).PHP_EOL; 
        fwrite($this->logFile, $log);
    }

    // An error handler
    function errorLog($errno, $errstr, $errfile, $errline)
    {
        $errorLog = $errfile. " on line ".$errline.": ".$errstr.". (errno: ".$errno.")".PHP_EOL;
        fwrite($this->logFile, $errorLog);
    }

    // Automatically called when this class object is destructed or
    // the script is stopped or exited
    function __destruct()
    {
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        fwrite($this->logFile, "CLIENT LOGGING HAS ENDED (at ".date(DATE_RFC2822).")".PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        fclose($this->logFile);

        echo "loggerClient END".PHP_EOL;
    }
}

class LoggerServer
{
    public $logFile;

    // Automatically called when creating this class object
    function __construct()
    {
        $logFileName = "SystemLog.log";
        echo "LOGGING DATA TO '".$logFileName."'".PHP_EOL;

        $this->logFile = fopen($logFileName, "a");
        fwrite($this->logFile, PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        fwrite($this->logFile, "SERVER LOGGING HAS BEGUN (at ".date(DATE_RFC2822).")".PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        
        $loggerServer = new rabbitMQServer("testRabbitMQ.ini","loggerServer");
        echo "loggerServer BEGIN".PHP_EOL;
        $loggerServer->process_requests(array($this,'requestProcessor'));
    }

    function log($data)
    {
        // Referencing the first and only array entry of an array
        $backTrace = debug_backtrace()[0];

        $filePath = $backTrace['file'];
        $lineNumber = $backTrace['line'];

        //json_encode($data) can handle arrays
        $log = $filePath." on line ".$lineNumber.": ".json_encode($data).PHP_EOL; 
        fwrite($this->logFile, $log.PHP_EOL);
    }

    function requestProcessor($data)
    {
        echo "REQUEST RECEIVED: ".PHP_EOL;
        print_r($data);
        $log = $filePath." on line ".$lineNumber.": ".json_decode($data).PHP_EOL; 
        fwrite($this->logFile, $data);
    }

    // The server shouldn't really have a stopping point so it shouldn't need a destructor
}

?>