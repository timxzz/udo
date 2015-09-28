<?php
	// Import ssh page
	include 'ssh_arcade.php';

	session_start();

	$response = array();

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	if(($username == "guest@cs.man.ac.uk" || $username =="guest@manchester.ac.uk")
		&& ($password == "comp10120"))
	{
		$response['success'] = true;
		$_SESSION['login_user'] = "guest";
	}
	else
	{
		$serverAuthentication = getServerPW($username, $password);

		if($serverAuthentication == "F")
		{
			$response['success'] = false;
		}else{
			$_SESSION['login_user'] = $username;
			$_SESSION['arcade_AC'] = $serverAuthentication;
			$response['success'] = true;
			// header("location: tasks.php");
		}
	}
	// Reponse to the login request
	echo json_encode($response);
?>