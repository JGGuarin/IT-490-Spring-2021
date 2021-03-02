<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

	function sendError($data){
		$client = new rabbitMQClient("testRabbitMQ.ini", "log");
		$response = $client->send_request($data);
		return $response;
	}
?>
