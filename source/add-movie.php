<html>
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<title>Add Film</title>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			userLinks();

			// checks if user is a manager, logs in, and draws the submit form
			$loginCheck = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
			if($loginCheck)
			{
				if($_SESSION['permission_id'] == 1)
				{
					$db_connection = connectToDatabase();
					if($db_connection)
					{
						$genreBox = populateGenreBox($db_connection,'add',null);
						echo "<h1>Add Film</h1>
							  <p>All fields except Poster/Trailer/Genre/New Genre required.</p>
							  <form action='submit-film.php' method='POST'>
								Title <input type='text' name='title' required><br><br>
								Summary<br> <textarea rows='10' cols='50' name='summary' required></textarea><br><br>
								Release Date <input type='date' name='release_date' required><br><br>
								Language <input type='text' name='lang' required><br><br>
								Duration (in minutes) <input type='number' name='duration' required><br><br>
								Poster link <input type='text' name='poster'><br><br>
								Trailer link (must be Youtube) <input type='text' name='trailer'><br><br>
								Genres $genreBox<br><br>
								Add Genre (one not in genre box) <input type='text' name='newGenre'><br><br>
								<input type='submit' name='submitted'>
							  </form>";
					}
				}	
				else
				{
					echo "Must be a manager in order to see this page.<br>";
				}

			}
			else
			{
				echo "Must be logged in to see this page.<br>";
			}
		?>
		</form>
	</body>	
</html>