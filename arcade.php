<?php
	// function for setting up connection with arcade
	function setUpConnection($serverAuthentication, $serverUser)
	{
		$serverHost = '130.88.196.144';
		$serverPort = 4000;
		$helloToken = "LKJHGFDSA\n";


	    // Create socket
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		// Timeout
		socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
		socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 1, 'usec' => 0));
		// Create connection
		socket_connect($sock , $serverHost , $serverPort) 
		or die("Unable to connect.");
		// Concate the setting needed for connection (user id and Arcade key)
		$connectionSetting = "";
		$connectionSetting = $helloToken;
		$connectionSetting .= $serverUser;
		$connectionSetting .= $serverAuthentication;
		// Sending the setting to arcade server --> Authentification
		socket_write($sock, $connectionSetting, strlen($connectionSetting));
		// Pass the socket to caller function
		return $sock;
	} // setUpConnection

	// function for sending query to arcade
	function runQuery($command, $databases, $groups, $students, 
		              $courses, $serverAuthentication, $serverUser)
	{
		// Calling setUpConnection() to create a new connection
		$sock = setUpConnection($serverAuthentication, $serverUser);

		// Concate the query with five variable given
		$query = "";
		$query = "$command\n";
		$query .= "$databases\n";
		$query .= "$groups\n";
		$query .= "$students\n";
		$query .= "$courses\n";

		// Sending the query to arcade
		$line = "";
		$result = "";
		socket_write($sock, $query, strlen($query));
		while ($line = socket_read($sock, 2048)) 
		{
		    if (strcmp($line, "++WORKING\n") != 0)
	      	{ 
	      		$result .= $line;
	      	}
		}
		socket_close($sock);
		return $result;
	} // runQuery

	// function for getting the profile
	function getProfile($serverAuthentication, $serverUser)
	{
		return runQuery("profile", "", "", "", "", $serverAuthentication, $serverUser);
	} // getProfile

?>