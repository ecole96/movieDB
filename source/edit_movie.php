<html>
	<head>
		<title>Add Film</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();
			userLinks();

			function fillForm($db_connection)
			{
				$query = "SELECT * FROM movie WHERE movieid = {$_GET['movieid']}";
				$result = mysqli_query($db_connection,$query);
				$row = mysqli_fetch_assoc($result);
				$genreBox = populateGenreBox($db_connection,'edit',$_GET['movieid']);
				echo "
					  <form action='submit-edit.php' method='POST'>
					  	<input type='hidden' name='movieid' value={$_GET['movieid']}>
						Title <input type='text' name='title' value='{$row['title']}' required><br><br>
						Summary<br> <textarea rows='10' cols='50' name='summary' required>{$row['summary']}</textarea><br><br>
						Release Date <input type='date' name='release_date' value='{$row['release_date']}' required><br><br>
						Language <input type='text' name='lang' value='{$row['lang']}' required><br><br>
						Duration (in minutes) <input type='number' name='duration' value={$row['duration']} required><br><br>
						Poster link <input type='text' name='poster' value='{$row['poster']}'><br><br>";
				if(is_null($row['poster']))
				{
					echo "Trailer link (must be Youtube) <input type='text' name='trailer'><br><br>";
				}
				else
				{
					echo "Trailer link (must be Youtube) <input type='text' name='trailer' value='{$row['trailer']}'><br><br>";
				}
				echo "Genre: $genreBox<br><br>
					  Add Genre (one not in genre box) <input type='text' name='newGenre'><br><br>
					  <input type='submit' name='submitted'>
				     </form>";

			}

			// checks if user is a manager, logs in, and draws the submit form
			$loginCheck = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
			if($loginCheck && !empty($_GET['movieid']))
			{
				if($_SESSION['permission_id'] == 1)
				{
					$db_connection = connectToDatabase();
					if($db_connection)
					{
						$genreBox = populateGenreBox($db_connection,'edit',$_GET['movieid']);
						echo "<h1>Edit Film</h1>
					  		  <p>All fields except Poster/Trailer/Genre/New Genre required.</p>";
						fillForm($db_connection);
					}
				}	
				else
				{
					echo "Must be a manager in order to see this page.<br>";
				}
			}
			else
			{
				echo "Must be logged in & with a valid movieid to see this page.<br>";
			}
		?>
		</form>
	</body>	
</html>