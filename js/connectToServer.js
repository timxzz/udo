var loginRequest;
var getJSON;

$(document).ready(function (){
	// When press login
	$(".signin").submit(function (event){

		// Start NProgress bar
		NProgress.start();

		// Abort any pending request
		if(loginRequest)
		{
			loginRequest.abort();
		}

		// Get the local variable
		var $form = $(this);

		// Select  all the input fields
		var $inputs = $form.find("input");

		// Serialize the data in the input
		var serializedData = $form.serialize();

		// Disable the input during the request
		$inputs.prop("disabled", true);

		// Progress 0.1
		NProgress.set(0.1);

		// SFTP to authenticate user and get Arcade PW
		loginRequest = $.ajax({
			url: 'login.php',		// POST data to the login.php
			type: 'post',			// POST type
			data: serializedData,	// POST data from input
			datatype: 'json',
			success: function(response) {

				// Progress 0.3
				NProgress.set(0.3);

				var responseJSON = $.parseJSON(response);	// Parse response to json

				if(responseJSON.success){

					// Progress 0.5
					NProgress.set(0.5);
					// NProgress Speed Config
					NProgress.configure({ trickle: false });
					NProgress.configure({ trickleRate: 0.1, trickleSpeed: 1000 });

					// Reset html element
					$("#loginError").html("");

					// Get tasks JSON
					console.log("loginSuccess");
					$.ajax({
						url: 'getTasks.php',	// PHP that call json
						type: 'get',
						datatype: 'json',		// Data format
						success: function(tasks)
						{
							if(tasks == "Unable to connect.")
							{
								// Post error message
						        $("#loginError").html('<p class="bg-danger signin_error">'
						        	+ 'Bad connection with School of Computer Science, please try again later.' +
						        	'</p>'
						        );
						        // If false then enable to re-enter
			        			$inputs.prop("disabled", false);
						        // Progress bar completes
								NProgress.done(true);
						    } else {
								// Progress bar completes
								NProgress.done(true);
								// console.log(tasks);
								localStorage.clear();			// Clear localStorage
								localStorage.setItem('tasksJSON', tasks);	// Store JSON to localstorage
								localStorage.setItem('tab', 'overall');
								window.location.href = "tasks.php";
							}
						}
					});


			    }else{
		    		// Post error message
			        $("#loginError").html('<p class="bg-danger signin_error">'
			        	+ 'Please check your username and password or try again later.' +
			        	'</p>'
			        );
			        // If false then enable to re-enter
			        $inputs.prop("disabled", false);

			        // Reset progress bar
			        NProgress.done(true);
			    }					
			} // success
		}); // .ajax


    	// Prevent default posting of form
    	event.preventDefault();

	}); // .submit
}); // .ready
