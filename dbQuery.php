<?php
	// Update the done task
	function updateTask($targetTable, $task)
	{
		$conn = create_connection();

		$sql_updateTask = "UPDATE " . $targetTable . " SET DeadDate = '" . $task->deadDate
								. "', ExteDate = '" . $task->exteDate . "', DeadlineForNow = '"
								. $task->deadlineForNow . "', Extension = '"
								. $task->ext . "', CBD = '" . $task->CBD . "', CBE = '"
								. $task->CBE . "', Done = '" . $task->done 
								. "', Submitted = '" . $task->submitted
								. "', MarkOnArcade = '" . $task->markOnArcade
								. "', DontCare = '" . $task->dontCare
								. "' WHERE CourseCode = '" . $task->courseCode
			                    . "' AND CourseType = '" . $task->courseType
			                    . "' AND ExerciseIndex = '" . $task->exerciseIndex
			                    . "' AND LabSession = '" . $task->labSession . "';";

        $conn->query($sql_updateTask);
        $conn->close();
	} // updateDone

	// Get all Care and Unmarked tasks from arcade and encode to json
	function getJSON($targetTable)
	{
		$conn = create_connection();

		$arrayOfTaskObjects = array();
		$sql_searchAllTasks = "SELECT * FROM " . $targetTable 
								. " WHERE MarkOnArcade = 'n' AND DontCare = 'n'
								ORDER BY DeadlineForNow;";
		$result = $conn->query($sql_searchAllTasks);

		while ($taskObject = $result->fetch_object())
		{
			$arrayOfTaskObjects[] = $taskObject;
		}

		return json_encode($arrayOfTaskObjects);

	} // getJSON


	function checkCreateUser($targetUser)
	{
		$conn = create_connection();
		// MySQL Queries
		$sql_searchUser = "SELECT UID FROM Users WHERE UID = '" . $targetUser . "';";
		$sql_createUser = "INSERT INTO Users VALUES ('" . $targetUser . "');";
		$sql_createUserTaskTable = "CREATE TABLE " . $targetUser . " (
									CourseCode VARCHAR(7) NOT NULL,
									CourseType VARCHAR(1) NOT NULL,
									ExerciseIndex INT(3) NOT NULL,
									LabSession INT(3) NOT NULL,
									DeadDate VARCHAR(10) NOT NULL,
									ExteDate VARCHAR(10) NOT NULL,
									DeadlineForNow VARCHAR(10) NOT NULL,
									Extension VARCHAR(1) NOT NULL,
									CBD VARCHAR(2) NOT NULL,
									CBE VARCHAR(2) NOT NULL,
									Done VARCHAR(1) NOT NULL,
									Submitted VARCHAR(1) NOT NULL,
									MarkOnArcade VARCHAR(1) NOT NULL,
									DontCare VARCHAR(1) NOT NULL,
									PRIMARY KEY (CourseCode, CourseType, 
										ExerciseIndex, LabSession)
									);";

		$userQueryObject = $conn->query($sql_searchUser);
		$userResult = $userQueryObject->fetch_assoc();

		// If the user doesn't exist, then insert its ID and create the table
		if($userResult == null)
		{
			$conn->query($sql_createUser);
			$conn->query($sql_createUserTaskTable);
		}

		// For testing----------------------------------------------
		// if($userResult == null)
		// {
		// 	// Insert new user
		// 	if($conn->query($sql_createUser))
		// 		echo "Inserted new user\n";
		// 	else
		// 		echo "Cannot insert new user\n".$conn->error."\n";
		// 	// Create new table
		// 	if($conn->query($sql_createUserTaskTable))
		// 		echo "Created new table\n";
		// 	else
		// 		echo "Cannot create new table\n".$conn->error."\n";
		// } else {
		// 	echo "User and table existed\n";
		// }
		$conn->close();
	} // checkCreateUser


	// Sync DB data with arcade
	function syncArcadeTasks($targetTable, $arrayOfTasks)
	{
		$conn = create_connection();

		foreach ($arrayOfTasks as $task)
		{
			$sql_searchTask = "SELECT * FROM " . $targetTable 
			                   . " WHERE CourseCode = '" . $task->courseCode
			                   . "' AND CourseType = '" . $task->courseType
			                   . "' AND ExerciseIndex = '" . $task->exerciseIndex 
			                   . "' AND LabSession = '". $task->labSession . "';";
			$sql_insertTask = "INSERT INTO " . $targetTable . " (CourseCode, 
								CourseType, ExerciseIndex, LabSession, DeadDate, ExteDate, DeadlineForNow,
								Extension, CBD, CBE, Done, Submitted, MarkOnArcade, DontCare)
								VALUES ('" . $task->courseCode . "', '" . $task->courseType
								. "', '" . (int)$task->exerciseIndex
								. "', '" . (int)$task->labSession . "', '"
								. $task->deadDate . "', '" . $task->exteDate
								. "', '" . $task->deadlineForNow
								. "', '" . $task->ext . "', '" . $task->CBD 
								. "', '" . $task->CBE . "', '" . $task->done
								. "', '" . $task->submitted
								. "', '" . $task->markOnArcade
								. "', '" . $task->dontCare . "');";
			$sql_updateTaskArcade = "UPDATE " . $targetTable . " SET DeadDate = '" . $task->deadDate
								. "', ExteDate = '" . $task->exteDate . "', DeadlineForNow = '"
								. $task->deadlineForNow . "', Extension = '"
								. $task->ext . "', CBD = '" . $task->CBD . "', CBE = '"
								. $task->CBE . "', MarkOnArcade = '" . $task->markOnArcade
								. "' WHERE CourseCode = '" . $task->courseCode
			                    . "' AND CourseType = '" . $task->courseType
			                    . "' AND ExerciseIndex = '" . $task->exerciseIndex
			                    . "' AND LabSession = '" . $task->labSession . "';";
			$sql_updateDone = "UPDATE " . $targetTable . " SET Done = 'y"
								. "' WHERE CourseCode = '" . $task->courseCode
			                    . "' AND CourseType = '" . $task->courseType
			                    . "' AND ExerciseIndex = '" . $task->exerciseIndex
			                    . "' AND LabSession = '" . $task->labSession . "';";
			$sql_updateSubmitted = "UPDATE " . $targetTable . " SET Done = 'y', Submitted = 'y"
								. "' WHERE CourseCode = '" . $task->courseCode
			                    . "' AND CourseType = '" . $task->courseType
			                    . "' AND ExerciseIndex = '" . $task->exerciseIndex
			                    . "' AND LabSession = '" . $task->labSession . "';";
			// If data doesn't exist, insert it
			$searchResult = $conn->query($sql_searchTask);
			if($searchResult->fetch_assoc() == null)
				$conn->query($sql_insertTask);
			else // Compare and update the data on arcade
			{
				// Update static data from Arcade
				$conn->query($sql_updateTaskArcade);
				// Update the query result
				$searchResult = $conn->query($sql_searchTask);
				$taskFromDB = $searchResult->fetch_assoc();
				// Either Arcade or DB says done = 'y', then update DB Done = 'y' 
				if($task->done == "y" || $taskFromDB["Done"] == "y")
					$conn->query($sql_updateDone);
				// Either Arcade or DB says submitted = 'y', then update DB Submitted = 'y'
				if($task->submitted == "y" || $taskFromDB["Submitted"] == "y")
					$conn->query($sql_updateSubmitted);
			} // else
		}

		// echo "Arcade data synced";
		$conn->close();
	} // syncArcadeTasks


	// Create a new connection and return it to caller
	function create_connection()
	{
		$database_host = "dbhost.cs.man.ac.uk";
		$database_user = "mbax3zx2";
		$database_pass = "19940510";
		$group_dbnames = "2014_comp10120_y9";
		// Create connection
		$timeout = 2;  /* two seconds for timeout */
		$conn = mysqli_init();
		$conn->options( MYSQLI_OPT_CONNECT_TIMEOUT, $timeout );
		$conn->real_connect($database_host, $database_user, 
			  				$database_pass, $group_dbnames);

		// Check connection
		if ($conn -> connect_error)
			die("Unable to connect.");
			// Use for testing!!!!!!!
			// die("Connection failed: " . $conn -> connect_error);

		// Close connection
		return $conn;
	} // create connection


	// Drop all the tables
	function initialization()
	{
		$conn = create_connection();

		// Drop users' task table
		$tables = $conn->query("SELECT UID FROM Users");
		while ($tables != null && $table = $tables->fetch_array(MYSQLI_ASSOC)) 
		{
			$UID = $table['UID'];
			$dropQuery = "DROP TABLE IF EXISTS ". $group_dbnames . " " . $UID . ";";
			$conn->query($dropQuery);
		}

		// Drop users table and create a new one
		$dropQuery = "DROP TABLE Users";
		$createQuery = "CREATE TABLE Users (
						UID VARCHAR(255) NOT NULL UNIQUE,
						PRIMARY KEY (UID)
						);";
		$conn->query($dropQuery);
		$conn->query($createQuery);

		$conn->close();
	} // initialization
?>