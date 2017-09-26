<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			// checks for valid rating
			function validRating($db_connection)
			{
				$loginCheck = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
				$rating_arr = array(1,2,3,4,5,6,7,8,9,10);
				// user is logged in, there is a movieid and rating, and rating is a value from 1-10
				if(isset($_GET['movieid']) && isset($_GET['rating']) && $loginCheck && in_array($_GET['rating'],$rating_arr))
				{
					return true;
				}
				else
				{
					return false;
				}

			}

			// if user has never scored the film before, inserts score into database
			// if user has scored the film, modifies entry in score_and_reviews table
			function addRating($db_connection)
			{
				$userQuery = "SELECT userid FROM db_user WHERE username = '{$_SESSION['username']}'";
				$get_userid = mysqli_query($db_connection,$userQuery);
				$userid = mysqli_fetch_assoc($get_userid);
				if(userHasScored($db_connection,$_GET['movieid']))
				{
					$query = "UPDATE score_and_reviews SET score_data = {$_GET['rating']} WHERE userid = {$userid['userid']} AND movieid = {$_GET['movieid']}";
					$result = mysqli_query($db_connection,$query);

				}
				else
				{
					$query = "INSERT INTO score_and_reviews(userid, movieid, score_data) VALUES ({$userid['userid']},{$_GET['movieid']}, {$_GET['rating']})";
					$result = mysqli_query($db_connection,$query);
				}
			}

			if(!isset($_SESSION['current_page']))
			{
				$_SESSION['current_page'] = 'home.php';
			}

			// connects to db, adds/updates rating to data unless something goes wrong
			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(validRating($db_connection))
				{
					addRating($db_connection);
					$outputStr = 'Rating submitted!';

				}
				else
				{
					$outputStr = "ERROR: rating was not a valid value, or you don't have permissions to rate movies.";
				}
				header("Refresh: 2; URL='{$_SESSION['current_page']}'");
				echo $outputStr . "<br>";
				
			}
		?>
	</body>
</html>