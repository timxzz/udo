$(document).ready(function(){
	// Default load overall tab
	localStorage.setItem('tab', "overall");
	// Logout handling
	$("#logout").click(function(){
		localStorage.clear();
		location.href = "logout.php";

		//Otherwise when you click the link the browser will still attempt
		// to follow the link and you'll lose the javascript action.
		return false;
	}); // click logout

	// Switch between different tabs
	$(".courseTabs").on("click","li", function() { 
		id = this.id
		// change the tabs
	    $(".courseTabs li").removeClass("active");
	    $("#" + id).addClass("active");
	    // store tab id to local storage
	    localStorage.setItem('tab', id);
	    // re-draw tasks pane
		reDraw();
	    // Get JSON string from local storage
		tasks = localStorage.getItem('tasksJSON');
		// Parse the string to JSON
		var jsonTasks = $.parseJSON(tasks);

		$.each(jsonTasks, function(key, task){
			// If the course code match the tab then print
			if(id == "overall")
				// print the item
				printItem(task);
			else if(("COMP" + task.CourseCode) == id)
				// print the item
				printItem(task);
	 	 }); // .each

		// Remove empty list
		rmEmptyList();
	});

	// Check done or undone!!
	$(document).on("click", ".undone-box, .redo-box", function(){
		thisID = this.id;
		// // JQuery effect
		// $("#" + thisID).toggle("drop");
		// Get JSON string from local storage
		tasks = localStorage.getItem('tasksJSON');
		// Parse the string to JSON
		var jsonTasks = $.parseJSON(tasks);

		$.each(jsonTasks, function(key, task){
			// get the task id
			taskID = task.CourseCode + task.CourseType + task.ExerciseIndex + task.LabSession;
			// If the course code match the tab then change JSON and DB
			if(taskID  == thisID)
			{
				// Change Done
				if(task.Done == "n")
					task.Done = "y";
				else
					task.Done = "n";
				// stringify json
				var JString = JSON.stringify(task);
				// Send update request to DB
				$.ajax({
					type: "post",
					url: "updateDB.php",
					data: {updated : JString},
					dataType: "json",
					success: function(tasks){

						// Test if it fail
						if(tasks == "Unable to connect.")
						{
							alert("Bad connection with School of Computer Science, please try again later.");
							return false;
						}

						// Store JSON string to local storage
						localStorage.setItem('tasksJSON', JSON.stringify(tasks));

						// re-draw tasks pane
						reDraw();

						// get tabID
						tabID = localStorage.getItem('tab');
						$.each(tasks, function(key, task){
							// If the course code match the tab then print
							if(tabID == "overall")
								// print the item
								printItem(task);
							else if(("COMP" + task.CourseCode) == tabID)
								// print the item
								printItem(task);
					 	 }); // .each

						// Remove empty list
						rmEmptyList();
						// Break the .each loop
						return false;
					}, // success
					// // Use for debug!!!!
					// error: function(xhr, textStatus, error) {
					//     console.log(xhr.statusText);
					//     console.log(textStatus);
					//     console.log(error);
					// }
				}); // ajax
			} // if
			
	 	 }); // .each
	}); // check done or undone!

	// Check DontCare
	$(document).on("click", ".dontCare-box", function(){
		thisID = this.id;
		// // JQuery effect
		// $("#" + thisID).toggle("drop");
		// Get JSON string from local storage
		tasks = localStorage.getItem('tasksJSON');
		// Parse the string to JSON
		var jsonTasks = $.parseJSON(tasks);

		$.each(jsonTasks, function(key, task){
			// get the task id
			taskID = task.CourseCode + task.CourseType + task.ExerciseIndex 
						+ task.LabSession + "DontCare";
			// If the course code match the tab then change JSON and DB
			if(taskID  == thisID)
			{
				// Change DontCare to 'y'
				task.DontCare = "y";
				// stringify json
				var JString = JSON.stringify(task);
				// Send update request to DB
				$.ajax({
					type: "post",
					url: "updateDB.php",
					data: {updated : JString},
					dataType: "json",
					success: function(tasks){

						// Test if it fail
						if(tasks == "Unable to connect.")
						{
							alert("Bad connection with School of Computer Science, please try again later.");
							return false;
						}

						// Store JSON string to local storage
						localStorage.setItem('tasksJSON', JSON.stringify(tasks));

						// re-draw tasks pane
						reDraw();

						// get tabID
						tabID = localStorage.getItem('tab');
						$.each(tasks, function(key, task){
							// If the course code match the tab then print
							if(tabID == "overall")
								// print the item
								printItem(task);
							else if(("COMP" + task.CourseCode) == tabID)
								// print the item
								printItem(task);
					 	 }); // .each

						// Remove empty list
						rmEmptyList();
						// Break the .each loop
						return false;
					}, // success
					// // Use for debug!!!!
					// error: function(xhr, textStatus, error) {
					//     console.log(xhr.statusText);
					//     console.log(textStatus);
					//     console.log(error);
					// }
				}); // ajax
			} // if
			
	 	 }); // .each
	}); // check submit => redo

	$(document).on("click", "#sync", function(){
		// Start NProgress bar
		NProgress.start();
		// NProgress Speed Config
		NProgress.configure({ trickle: false });
		NProgress.configure({ trickleRate: 0.1, trickleSpeed: 1500 });
		// Sync arcade
		$.ajax({
					url: 'getTasks.php',	// PHP that call json
					type: 'get',
					datatype: 'json',		// Data format
					success: function(tasks)
					{
						// Test if it fail
						if(tasks == "Unable to connect.")
						{
							alert("Bad connection with School of Computer Science, please try again later.");
							// Progress bar completes
							NProgress.done(true);
							return false;
						}
						localStorage.setItem('tasksJSON', tasks);	// Store JSON to localstorage
						// parse to JSON
						var jsonTasks = $.parseJSON(tasks);

						// re-draw tasks pane
						reDraw();

						// get tabID
						tabID = localStorage.getItem('tab');
						$.each(jsonTasks, function(key, task){
							// If the course code match the tab then print
							if(tabID == "overall")
								// print the item
								printItem(task);
							else if(("COMP" + task.CourseCode) == tabID)
								// print the item
								printItem(task);
					 	 }); // .each

						// Remove empty list
						rmEmptyList();
						// Progress bar completes
						NProgress.done(true);
						// Break the .each loop
						return false;

					}
				}); // ajax
	}); // sync

}); // ready


// Function to re draw the task list pane
function reDraw()
{
    // Replace the old tasks pane
    $("div#tasks").replaceWith(
    	'<div id="tasks" class="">'
         + '<div id="tasks-inside">'
          + '<!-- missing -->'
          + '<div class="tasks-list-missed">'
            + '<p class="horizontal-rule"><span>Missed deadline</span></p>'
            + '<ol class="tasks-list missing-list">'
            + '</ol>'
          + '</div>'
          + '<!-- unmark -->'
          + '<div class="tasks-list-unmark">'
            + '<p class="horizontal-rule"><span>Need to get marked</span></p>'
            + '<ol class="tasks-list unmark-list">'
            + '</ol>'
          + '</div>'
          + '<!-- unsubmit -->'
          + '<div class="tasks-list-unsubmit">'
            + '<p class="horizontal-rule"><span>Need to submit</span></p>'
            + '<ol class="tasks-list unsubmit-list">'
            + '</ol>'
          + '</div>'
          + '<!-- undone -->'
          + '<div class="tasks-list-undone">'
            + '<p class="horizontal-rule"><span>Undone &nbsp;&nbsp;&nbsp;</span></p>'
            + '<ol class="tasks-list undone-list">'
            + '</ol>'
          + '</div>'
        + '</div>'
      + '</div>'
    ); // .replaseWith
} // reDraw

// Remove the list which is empty
function rmEmptyList()
{
	// If not missed, then remove the list
	if($(".tasks-list-missed ol").has("li").length == 0)
		$(".tasks-list-missed").remove();
	// If not unmark, then remove the list
	if($(".tasks-list-unmark ol").has("li").length == 0)
		$(".tasks-list-unmark").remove();
	// If not unsubmit, then remove the list
	if($(".tasks-list-unsubmit ol").has("li").length == 0)
		$(".tasks-list-unsubmit").remove();
	// If not undone, then remove the list
	if($(".tasks-list-undone ol").has("li").length == 0)
		$(".tasks-list-undone").remove();

} // rmEmptyList