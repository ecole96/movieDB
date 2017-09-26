<html>
	<head>
		<title>Add to Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
<?php
	include('universalFunctions.php');
	session_start();

	$db_connection = connectToDatabase();
	if($db_connection)
	{
		$loginCheck = isset($_SESSION['username']) && isset($_SESSION['logged_in']) && isset($_SESSION['permission_id']);
		if($loginCheck)
		{
			if(empty($_POST['userid']) || empty($_POST['movieid']) || !isset($_POST['submitted']))
			{
				echo "Can't add to watchlist - missing vital information (movieid, userid, etc.) for operation";
				header("Refresh: 2; URL='home.php");
			}
			else
			{
				$addToWatchList = mysqli_query($db_connection,"INSERT INTO watchlist(movieid, userid) VALUES ({$_POST['movieid']},{$_POST['userid']})");
				echo "Added to watchlist. Redirecting to movie page...";
				header("Refresh: 2; URL='movie-page.php?movieid={$_POST['movieid']}'");
			}
		}
		else
		{
			echo "Must be logged in.";
		}
	}
	
?>
	</body>
</html>