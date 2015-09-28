<?php
	// Includeing session
	session_start();
	// Import dbQuery for DB quest
	include 'dbQuery.php';
	// Import task class
	include 'taskClass.php';

	if(isset($_POST['updated'])){
		$doneTask = json_decode($_POST['updated'], true);
	}
	$task = new Task();
	$task->courseCode = $doneTask['CourseCode'];
	$task->courseType = $doneTask['CourseType'];
	$task->exerciseIndex = $doneTask['ExerciseIndex'];
	$task->labSession = $doneTask['LabSession'];
	$task->deadDate = $doneTask['DeadDate'];
	$task->exteDate = $doneTask['ExteDate'];
	$task->deadlineForNow = $doneTask['DeadlineForNow'];
	$task->ext = $doneTask['Extension'];
	$task->CBD = $doneTask['CBD'];
	$task->CBE = $doneTask['CBE'];
	$task->done = $doneTask['Done'];
	$task->submitted = $doneTask['Submitted'];
	$task->markOnArcade = $doneTask['MarkOnArcade'];
	$task->dontCare = $doneTask['DontCare'];

	$userID = $_SESSION['login_user'];
	if($userID == "guest") // For guest
	{
		// Update task on DB
		updateTask($userID, $task);
		// Get json from DB
		$json_tasks = getJSON($userID);
	} else { // For other users
		// Update task on DB
		updateTask(md5($userID), $task);
		// Get json from DB
		$json_tasks = getJSON(md5($userID));
	}
	echo $json_tasks;
?>