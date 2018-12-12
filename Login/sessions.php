<?php
    session_start();

// For added security, regenerate the sesssion id after every 100 page loads.

if (isset($_SESSION['last_regeneration']) && ++$_SESSION['last_regeneration'] >= 100) {
    $_SESSION['last_regeneration'] = 0;
    session_regenerate_id(true);
}

// Check if the login session is active.

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = '0';
    $_SESSION['login'] = '1';
}

if ($_SESSION['login'] != '1') { 
	// The login session is not active so display the login form.
	include 'login/index.php';
	die;
}

// Every time a page loads the session is extended by another 12 hours.
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 4320000)) {
    // last request was more than 6 hours ago (21600) so destroy the session.
	
	 // unset $_SESSION variable for the run-time 
    session_unset();   
	// destroy session data in storage 
    session_destroy();   
	
   // The login session is not active so display the login form.
    include 'login/index.php';
    die;
}

// update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time(); 

?>
