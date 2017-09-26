<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php

			include('universalFunctions.php');
			session_start();

			function addMovie($db_connection)
			{
				if(empty($_POST['poster']))
				{
					$_POST['poster'] = "film-poster-placeholder.png";
				}

				if(!empty($_POST['trailer']))
				{
				   $query = "INSERT INTO movie(title, summary, lang, duration, release_date, trailer, poster) VALUES ('{$_POST['title']}','{$_POST['summary']}','{$_POST['lang']}',{$_POST['duration']},'{$_POST['release_date']}','{$_POST['trailer']}','{$_POST['poster']}')";
				}
				else
				{
					$query = "INSERT INTO movie(title, summary, lang, duration, release_date, trailer, poster) VALUES ('{$_POST['title']}','{$_POST['summary']}','{$_POST['lang']}',{$_POST['duration']},'{$_POST['release_date']}',NULL,'{$_POST['poster']}')";
				}
				$result = mysqli_query($db_connection,$query);

				$movieid = mysqli_insert_id($db_connection);
				if(!empty($_POST['genres']))
				{
					addGenres($db_connection,$movieid,'existing');
				}

				if(!empty($_POST['newGenre']))
				{
					addGenres($db_connection,$movieid,'new');
				}
			}

			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(validFilmSubmission($db_connection))
				{
					addMovie($db_connection);
					echo "<h2>Film added to database.</h2>
						  <a href='add-movie.php'>Add another film</a><br>
						  <a href='manager-page.php'>Go back to manager settings</a><br>";
				}
				else
				{
					header("Refresh: 2; URL='add-movie.php'");
				}
			}
		?>
	</body>
</html>