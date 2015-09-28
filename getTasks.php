<?php
	// Includeing session
	session_start();

	// Import arcade.php for accessing arcade
	include 'arcade.php';
	// Import queryParsing.php for parsing the query result
	include 'queryParsing.php';
	// Import dbQuery for DB quest
	include 'dbQuery.php';

	$userID = $_SESSION['login_user'];

	// For guest
	if($userID == "guest")
	{
		$_SESSION['name'] = "Guest";
		$json_tasks = getJSON($userID);
	}
	else // For other users
	{
		// get the profile of the user
		$serverAuthentication = $_SESSION['arcade_AC'];
		$serverUser = "$userID\n";
		$profile = getProfile($serverAuthentication, $serverUser);

		// if(strcmp($profile, "") == 0)
		// 	echo "Timeout\n";
		// parse the profile to $academicYear,$name,$courses, and get them as list
		list($academicYear, $name, $courses) = parseProfile($profile);
		$_SESSION['name'] = $name;
		// run query to get the deadlines
		$fullStorys = runQuery("full-story: chronological", $academicYear, "", 
			                   "", $courses, $serverAuthentication, $serverUser);
		// if(strcmp($fullStorys, "") == 0)
		// 	echo "Timeout\n";
		// parse the fullStory and get a list of tasks object
		$listOfTasks = parseFullStory($fullStorys, $academicYear);
		// if(empty($listOfTasks))
		// 	echo "No data from fullStorys\n";

		checkCreateUser(md5($userID));
		syncArcadeTasks(md5($userID), $listOfTasks);
		// Get json from DB
		$json_tasks = getJSON(md5($userID));
	}
	// Set canGoToTasks if successful
	if($json_tasks != "Unable to connect.")
	{
		$_SESSION['canGoToTasks'] = "true";
	}

	echo $json_tasks;
?>