<html>
	<head>
		<title>Delete Crew</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(isManager())
				{
					if(isset($_GET['movieid']))
					{
						// delete all columns dependent on the movie
						$dependents = array('moviecrews','comments','tags','moviegenres','score_and_reviews','watchlist');
						foreach($dependents as $dependent)
						{
							$deleteDependents = mysqli_query($db_connection,"DELETE FROM $dependent WHERE movieid={$_GET['movieid']}");
						}
						// then finally kill the movie
						$deleteMovie = mysqli_query($db_connection, "DELETE FROM movie WHERE movieid={$_GET['movieid']}");
						echo "Movie and all dependents have successfully been deleted.";
						header("Refresh: 2; URL='manage-movies.php'");

					}
					else
					{
						echo "No movieid given.";
						header("Refresh: 2; URL='home.php'");
					}
					
				}	
			}
		?>
	</body>
</html>