<?php
  // Includeing session
  session_start();

  if(!isset($_SESSION['canGoToTasks']))
  {
    header("location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My tasks</title>

    <!-- This is link to Google font and Font-Awesome -->
    <link href='//fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- NProgress CSS -->
    <link href="css/nprogress.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="css/customTasks.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel='shortcut icon' type='image/x-icon' href="images/U.ico">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">

      <div id="lists">
        <div id="lists-inside">
          <!-- toolBar -->
          <div id="toolBar">
            <div class="dropdown user">
              <a data-toggle="dropdown" href="#">
                <?php echo '<div id="userIcon" title="' . $_SESSION['name'] . '">' ;?>
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-user fa-stack-1x"></i>
                  </span>
                  <span class="name-label"><?php echo $_SESSION['name'];?><b class="caret"></b></span>
                </div>
              </a>
              <ul class="dropdown-menu user-menu" role="menu">
                <li><a id="sync" href="#">Sync with Arcade</a></li>
                <li role="presentation" class="divider"></li>
                <li><a id="logout" href="#">Logout</a></li>
              </ul>
            </div>
          </div>

          <!-- lists-directory -->
          <div id="lists-directory">
            <ul class="nav nav-lists courseTabs">
              <li class="active" id="overall"><a href="#"><i class="fa fa-database fa-fw"></i>&nbsp; Overall </a></li>
            </ul>
          </div>

          <!-- calendar -->
          <div id="calendar">
          </div>
        </div>
      </div>

      <div id="tasks" class="">
        <div id="tasks-inside">
          <!-- missing -->
          <div class="tasks-list-missed">
            <p class="horizontal-rule"><span>Missed deadline</span></p>
            <ol class="tasks-list missing-list">
            </ol>
          </div>
          <!-- unmark -->
          <div class="tasks-list-unmark">
            <p class="horizontal-rule"><span>Need to get marked</span></p>
            <ol class="tasks-list unmark-list">
            </ol>
          </div>
          <!-- unsubmit -->
          <div class="tasks-list-unsubmit">
            <p class="horizontal-rule"><span>Need to submit</span></p>
            <ol class="tasks-list unsubmit-list">
            </ol>
          </div>
          <!-- undone -->
          <div class="tasks-list-undone">
            <p class="horizontal-rule"><span>Undone &nbsp;&nbsp;&nbsp;</span></p>
            <ol class="tasks-list undone-list">
            </ol>
          </div>
        </div>
      </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Refer to NProgress JS -->
    <script src='js/nprogress.js'></script>
    <!-- Custom JavaScript for this page -->
    <script src="js/customTasks.js"></script>
    <script src="js/getJSONTasks.js"></script>
  </body>
</html>