<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
<?php
	// Evan Cole
	// this page really just lets the user know the register was successful, then redirects them to the page they were on before registering
	session_start();
	if(!isset($_SESSION['current_page']))
	{
		$_SESSION['current_page'] = 'home.php';
	}
	header("Refresh: 2; URL={$_SESSION['current_page']}");
	echo "<h1>User Created - Redirecting...</h1>"
?>
	</body>
</html>