// Load data from localStorage
$(document).ready(function(){
	// Get JSON string from local storage
	tasks = localStorage.getItem('tasksJSON');
	// Parse the string to JSON
	var jsonTasks = $.parseJSON(tasks);

	$.each(jsonTasks, function(key, task){
    
    // Create tabs for each course
    if($("#COMP" + task.CourseCode).length == 0){
      $(".courseTabs").append(
        '<li id="COMP' + task.CourseCode + '"><a href="#COMP' + task.CourseCode + '">'
          + '<i class="fa fa-tasks fa-fw"></i>&nbsp; COMP'
          + task.CourseCode
        + '</a></li>');
    }
    // print the item
    printItem(task);
  }); // .each

  // Remove empty list
  rmEmptyList();
}); // .ready


// Function for printing each task item
function printItem(task){

  var courseType;
  var labSession;
  var deadlineForNow;

  // Parsing some label for each task
  if(task.CourseType == "E")
    courseType = "  Examples Class &nbsp;&nbsp; Exercise ";
  else
    courseType = "  Lab &nbsp;&nbsp; Exercise ";

  if(task.LabSession == "0")
    labSession = "  ";
  else
    labSession = " (Session " + task.LabSession + ")  ";

  taskID = task.CourseCode + task.CourseType + task.ExerciseIndex + task.LabSession;

  deadlineForNow = ' </span><span class="deadLine">Deadline: ' + task.DeadlineForNow 
                  + '</span>';


  // Import all the unmarked task to the page
  if((task.Extension == "y" && task.CBE == "n") 
      || (task.Extension == "n" && task.CBD == "n")){
    $(".missing-list").append(
      '<li class="taskItem">'
            + '<div class="taskItem-body  bg-missed">'
                + '<a id="' + taskID + '" '
                + 'class="taskItem-checkBox"><i class="fa fa-exclamation-triangle checkBox"></i></a>'
                  + '<div class="taskItem-title"><span class="taskLabel">'
                    + task.CourseCode + courseType + task.ExerciseIndex
                    + labSession + deadlineForNow // "</span>" is inside deadlineForNow
                  + '</div>'
                  + '<button type="button" id="' + taskID + 'DontCare" class="dontCare-checkBox dontCare-box close"'
                    + ' data-dismiss="alert" aria-label="Close" data-toggle="tooltip" data-placement="left" title="Never show it again">'
                      + '<span aria-hidden="true">&times;</span>'
                  + '</button>'
              + '</div>'
          + '</li>');
  } else if(task.Done == "n"){
    $(".undone-list").append(
      '<li class="taskItem">'
            + '<div class="taskItem-body  bg-undone">'
                + '<a id="' + taskID + '" '
                + 'class="taskItem-checkBox undone-box" href="javascript: void(0)"><i class="fa fa-square-o checkBox"></i></a>'
                  + '<div class="taskItem-title"><span class="taskLabel">'
                    + task.CourseCode + courseType + task.ExerciseIndex
                    + labSession + deadlineForNow // "</span>" is inside deadlineForNow
                  + '</div>'
              + '</div>'
          + '</li>');
  } else if(task.Submitted == "n"){
    $(".unsubmit-list").append(
      '<li class="taskItem">'
            + '<div class="taskItem-body  bg-unsubmit">'
                + '<a id="' + taskID + '" '
                + ' class="taskItem-checkBox redo-box" href="javascript: void(0)"><i class="fa fa-check-square checkBox"></i></a>'
                  + '<div class="taskItem-title"><span class="taskLabel">'
                    + task.CourseCode + courseType + task.ExerciseIndex
                    + labSession + deadlineForNow // "</span>" is inside deadlineForNow
                  + '</div>'
              + '</div>'
          + '</li>');
  } else if(task.MarkOnArcade == "n"){
    $(".unmark-list").append(
      '<li class="taskItem">'
            + '<div class="taskItem-body  bg-unmark">'
                + '<a id="' + taskID + '" '
                + ' class="unmarked-taskItem-checkBox"><i class="fa fa-check-circle checkBox"></i></a>'
                  + '<div class="taskItem-title"><span class="taskLabel">'
                    + task.CourseCode + courseType + task.ExerciseIndex
                    + labSession // "</span>" is inside deadlineForNow
                  + '</div>'
              + '</div>'
          + '</li>');
	}
} // printItem