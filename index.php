<?php
  session_start();

  if(isset($_SESSION['canGoToTasks']))
  {
    header("location: tasks.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UDo - Sign In</title>

    <!-- This is link to Google font and Font-Awesome -->
    <link href='//fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- NProgress CSS -->
    <link href="css/nprogress.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="css/customIndex.css" rel="stylesheet">
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

    <div class="container header">
      <img id="UDoLogo" src="images/UDo-Logo.png" alt="UDo Logo">
    </div>

    <div class="backgroundPic">
      <div class="container logincard">
        <div class="card">
          <div id="loginIcon">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-user fa-stack-1x fa-inverse"></i>
            </span>
          </div>
          <div id="loginError"></div>
          <form class="signin" method = "post" action = "">
            <label for="username" class="sr-only">UoM Username</label>
            <input type="text" id="username" name = "username" class="form-control" placeholder="UoM Username" required autofocus value size="25">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" name = "password" class="form-control" placeholder="Password" required value size="25">

            <button id="guestShow" type="button" class="btn btn-default" data-container="body" data-toggle="popover" title="Guest account" data-placement="bottom" data-content="Username: guest@cs.man.ac.uk Password: comp10120">
            Discover via Guest Account</button>


            <input class="btn btn-lg btn-primary btn-block" value="Sign in" name="submit" type="submit">
          </form>
        </div>
      </div>
    </div>

    <div class="uomLogo">
      <img src="images/logo-uom.png" alt="Logo of the University of Manchester" title="Logo of the University of Manchester">
    </div>

    <div class="what bkgnd-grey">
      <div class="container info">
        <h2>What is UDo</h2>
        <hr>
        <p>UDo is an online task manager, which provides students in the School of Computer Science a convenient way to track their coursework progress.</p>
      </div>
    </div>

    <div class="why">
      <div class="container info">
        <h2>Why UDo</h2>
        <hr>
        <div class="row text-grey">
          <div class="col-md-4 feature">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-check-square-o fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Simple</h3>
            <p>UDo captures the most important information about your coursework status in ARCADE, and "translates" them into a simple task list form.</p>

            <p>Also, you can login with your school account and password. Creating a new account is totally unnecessary.</p>
          </div>
          <div class="col-md-4 feature">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-shield fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Secure</h3>
            <p>The connection between the website and server is built on SSL, which means your account and password are encrypted during the transmission bewteen website and server. According to Qualys SSL Labs, udo.timx.me has a more secure connection than cs.manchester.ac.uk!</p>

            <p>We don't store your password or personal information in our database, and we never will. Your user ID will be encrypted by the MD5 algorithm before placing them into our database. Your data is safe.</p>
          </div>
          <div class="col-md-4 feature">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-refresh fa-spin fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Up-to-date</h3>
            <p>Whenever you login, the data in UDo database is merged with the latest coursework statuses in ARCADE.</p>

            <p>The data in UDo is more accurate than ARCADE if the user is keeping track of their Undone and Unsubmitted tasks. Therefore, what you see on UDo is the most up-to-date status of your coursework.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="who bkgnd-grey">
      <div class="container info">
        <h2>Who we are</h2>
        <hr>
        <p>We are group Y9 in first year (2014-2015) of Computer Science undergraduate programme. Our group members are:</p>
        <p>Bhavin Mistry, Oliver Koogle, Oliver Myatt, Tim Xiao.</p>
      </div>
    </div>

    <footer>
      <div class="container">
        <h2>Contact us</h2>
        <p>zhenzhong.xiao@student.manchester.ac.uk</p>
        <p id="rightReserved">© 2014 - 2015 UDo. Group Y9, School of Computer Science, The University of Manchester. All rights reserved.</p>
        <p>Update: March 18, 2015</p>
        <p id="photoSource">Background photo by <a href="https://www.flickr.com/photos/75862793@N06/6812701367/in/photolist-bo1SLp-9yei79-4ppZPt-pWPQmb-9pMj4P-9tv2Tg-q5qKdL-5iD1PD-9FBKjF-9uwnMP-dqdJKi-9yiy9J-djXSBQ-9ykenV-buGa1C-f1jUZf-59rUTU-bo1Rig-4S9f3H-at9con-9yhLfx-6pbTCs-5Txw8t-dWB8rB-aeK6ix-2M6DQw-8kRqZ4-cMRz8E-dd95AX-LteaN-8RnWWK-8weRxv-bo1PXk-dNdNkk-gH5SGT-h127Vs-b5qE9V-dJWaxt-6JxPZU-dK1Z54-dAX485-3tdR17-9ygzxk-N1Xgi-5upyJZ-aKzvE4-9RcF6K-dMSinu-oT7t1E-dHBucZ" target="_blank">abdullah.khan2012</a>
        </p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Refer to NProgress JS -->
    <script src='js/nprogress.js'></script>
    <!-- Custom JS -->
    <script src="js/connectToServer.js"></script>
    <script src="js/customIndex.js"></script>
  </body>
</html>