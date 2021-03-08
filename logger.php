#!/usr/bin/php
<?php
require_once('rabbitMQLib.inc');

// A logger class as defined for midterm specifications
class CentralizedLogger
{
    public $logFile;

    // Automatically called when creating this class object
    function __construct()
    {
        $logFileName = "SystemLog.log";
        echo "LOGGING DATA TO '".$logFileName."'".PHP_EOL;

        $this->logFile = fopen($logFileName, "a");
        fwrite($this->logFile, PHP_EOL);
        fwrite($this->logFile, "LOGGING HAS BEGUN (at ".date(DATE_RFC2822).")".PHP_EOL);
        fwrite($this->logFile, "************************************************************".PHP_EOL);

        //$eeg = new rabbitMQClient("testRabbitMQ.ini", "loggerServer");
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

    // Automatically called when this class object is destructed or
    // the script is stopped or exited
    function __destruct()
    {
        fwrite($this->logFile, "************************************************************".PHP_EOL);
        fwrite($this->logFile, "LOGGING HAS ENDED (at ".date(DATE_RFC2822).")".PHP_EOL);
        fclose($this->logFile);
    }
}

?>