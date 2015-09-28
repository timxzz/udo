<?php
	// Import the Task class
	include 'taskClass.php';

	// Parse the profile and get the academic year, name and 
    // course contain labs and example classes.
	function parseProfile($profile)
	{
		// String of 5 space to get rid of PHP Notice in $academicYear[4]
		$academicYear = "     "; 

		$name = "";
		$courses = "";
		// Split the profile to array of lines
		$lines = explode("\n", $profile);
		// Check match for each line
		foreach ($lines as $key => $line) 
		{
			if (preg_match("/^(\d\d-\d\d-\d\s)/", $line))
			{
				$tokens=preg_split("/\s/",$line);
				// Get the academic year
				if(ctype_space($academicYear))
					$academicYear = $tokens[0];
				else if((int)$academicYear[4] < (int)$tokens[0][4])
				{
					$academicYear = $tokens[0];
					$courses = "";
				} else if((int)$academicYear[4] > (int)$tokens[0][4])
					break;

				// Get the user name
				$name = $tokens[3];
				// Get the courses
				if (preg_match("/\d\d\d(s\d)?(L|E|P)$/", $tokens[4]))
					$courses .= "$tokens[4] ";
			}
		} // foreach
		$courses = trim($courses);
		
		// return an array of results
		return array($academicYear, $name, $courses);
	} // parseProfile


	// Parse the fullStory to a list of tasks object
	function parseFullStory($fullStorys, $academicYear)
	{
		// Get the two academic year
		$academicYear = preg_split('/-/', $academicYear);
		$sem_one_year = "20" . $academicYear[0];
		$sem_two_year = "20" . $academicYear[1];

		// Declare an array for storing task object
		$tasks = array();
		// Split the fullStorys to array of lines
		$lines = explode("\n", $fullStorys);
		// Check match for each line
		foreach ($lines as $key => $line)
		{
			if (preg_match("/\d\d\d(s\d)?(L|E|P)\s\d+(\.\d+)?D/", $line))
			{
				$tokens=preg_split("/\|/",$line);
				if (!preg_match("/-/", trim($tokens[6])))
				{
					// Dealing with session details
					$session = preg_split("/\s/",$tokens[0]);

					$task = new Task();
					// Session part 1 -> course code
					$task->courseCode = substr($session[0], 0, -1);
					$task->courseType = substr($session[0], -1);
					// Session part 2 -> exercise
					if(preg_match("/\d+D/", trim($session[1])))
						$task->exerciseIndex = substr($session[1], 0, -1);
					if(preg_match("/\d+\.\d+D/", trim($session[1])))
					{
						$labWithSession = preg_split("/\./", $session[1]);
						$task->exerciseIndex = $labWithSession[0];
						$task->labSession = substr($labWithSession[1], 0, -1);
					} // if
					// Session part 3 -> dates
					$dates = preg_split("/\>/", $session[2]);
					foreach ($dates as $key => $date)
					{
						if((strcmp($date, "none") != 0) && preg_match("/\d+\/\d+/", trim($date)))
						{
							$old_date = preg_split('/\//', $date);
							// Add a '0' if it's a single digit
							if(strlen($old_date[0]) == 1)
								$old_date[0] = "0" . $old_date[0];
							if(strlen($old_date[1]) == 1)
								$old_date[1] = "0" . $old_date[1];
							// Choose the year
							if (strcmp($old_date[1], "08") < 0)
								$year = $sem_two_year;
							else
								$year = $sem_one_year;
							// Swap dd/mm to mm-dd
							$new_date = $year . "-" . $old_date[1] . "-" 
										. $old_date[0];
							if ($key == 0)
								$task->deadDate = $new_date;
							else if ($key == 1)
								$task->exteDate = $new_date;
						}
					}

					// Dealing with CBD, ext, CDE and status
					if (preg_match("/\//",trim($tokens[2])))
						$task->CBD = "y";
					else if (preg_match("/x/",trim($tokens[2])))
						$task->CBD = "n";
					if (preg_match("/\//",trim($tokens[3])))
					{
						$task->ext = "y";
						$task->deadlineForNow = $task->exteDate;
					} else {
						$task->deadlineForNow = $task->deadDate;
					}
					if (preg_match("/\//",trim($tokens[4])))
					{
						$task->CBE = "y";
						$task->done = "y";
						$task->submitted = "y";
					}
					else if (preg_match("/x/",trim($tokens[4])))
						$task->CBE = "n";
					if (preg_match("/(d|D)/",trim($tokens[6])))
					{
						$task->done = "y";
						$task->submitted = "y";
					}
					if (preg_match("/\d+/",trim($tokens[6])))
					{
						$task->done = "y";
						$task->submitted = "y";
						$task->markOnArcade = "y";
					}

					array_push($tasks, $task);
				} // if
			} // if
		} // foreach

		return $tasks;
	} // parseFullStory
?>