<?php
	// Evan Cole
	// this script unsets all session data pertaining to login information, then redirects to the page the user was at before logging out
	session_start();
	unset($_SESSION['logged_in']);
	unset($_SESSION['username']);
	unset($_SESSION['permission_id']);
	if(!isset($_SESSION['current_page']))
	{
		$_SESSION['current_page'] = 'home.php';
	}
	header("Location: {$_SESSION['current_page']}");
?>