<?php

function displayPlayerHistory($leagueID, $playerName){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

	if (isset($argv[1]))
	{
		$msg = $arg[1];
	}
	else
	{
		$msg = "display player history";
	}

	$request = array();
	$request['type'] = "displayPlayerHistory";
	$request['leagueID'] = $leagueID;
	$request['playerName'] = $playerName;
	$request['message'] = $msg;
	$response = $client->send_request($request);

	return $response;
}

function displayLeagueHistory($leagueID){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
        
        if (isset($argv[1]))
        {       
                $msg = $arg[1];
        }       
        else
        {       
                $msg = "display league history";
        }       
        
        $request = array();
        $request['type'] = "displayLeagueHistory";
        $request['leagueID'] = $leagueID;
        $request['message'] = $msg;
        $response = $client->send_request($request);
        
        return $response;
}       

function getFriends($username){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "get friends";
        }

        $request = array();
        $request['type'] = "getFriends";
        $request['username'] = $username;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}

function acceptReq($from, $to){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "accept request";
        }

        $request = array();
        $request['type'] = "acceptReq";
	$request['from'] = $from;
	$request['to'] = $to;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}

function request($from, $to){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "request";
        }

        $request = array();
        $request['type'] = "request";
        $request['from'] = $from;
        $request['to'] = $to;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}


function sanitizeInput($fieldname){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  
        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "sanitize input";
        }

        $request = array();
        $request['type'] = "sanitizeInput";
        $request['fieldname'] = $fieldname;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}

function playerDrop($userID, $username, $leagueID, $teamID, $playerName){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "player drop";
        }

        $request = array();
        $request['type'] = "playerDrop";
        $request['userID'] = $userID;
	$request['username'] = $username;
	$request['leagueID'] = $leagueID;
	$request['teamID'] = $teamID;
	$request['playerName'] = $playerName;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}


function playerAdd($userID, $username, $leagueID, $teamID, $playerName){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "player add";
        }

        $request = array();
        $request['type'] = "playerAdd";
        $request['userID'] = $userID;
        $request['username'] = $username;
        $request['leagueID'] = $leagueID;
        $request['teamID'] = $teamID;
        $request['playerName'] = $playerName;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}

function isPlayerOnTeam($teamID, $playerName){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "is player on team";
        }

        $request = array();
        $request['type'] = "isPlayerOnTeam";
        $request['teamID'] = $teamID;
        $request['playerName'] = $playerName;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}


function draftATeam($teamName, $leagueID, $playerArray){
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

        if (isset($argv[1]))
        {
                $msg = $arg[1];
        }
        else
        {
                $msg = "draft a team";
        }

        $request = array();
        $request['type'] = "draftATeam";
        $request['teamName'] = $teamName;
        $request['leagueID'] = $leagueID;
        $request['playerArray'] = $playerArray;
        $request['message'] = $msg;
        $response = $client->send_request($request);

        return $response;
}


?>


















