<?php 
	function getServerPW($username, $password)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

		include('Net/SSH2.php');
		include('Net/SFTP.php');

		$sftp = new Net_SFTP('kilburn.cs.man.ac.uk');
		if (!$sftp->login($username, $password)) {
			return "F";
			exit();
		}

		// outputs the contents of filename.remote to the screen

		$serverAuthenticationCode = $sftp->get('/home/'.$username.'/.ARCADE/serverAuthentication');

		return $serverAuthenticationCode;
	} // getServerPw

?>