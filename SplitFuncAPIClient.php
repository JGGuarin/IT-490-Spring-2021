#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('ScheduleGrabClient.php');
require_once('StatlineGrabClient.php');

ApiScheduleGrab();
ApiStatlineGrab();
?>