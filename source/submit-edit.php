<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php

			include('universalFunctions.php');
			session_start();

			// removes any genres that have been deselected
			function handleExistingGenres($db_connection)
			{
				$allGenres = mysqli_query($db_connection,"SELECT * FROM genres");

				$mgQuery = "SELECT * from moviegenres NATURAL JOIN genres WHERE movieid = {$_POST['movieid']}";
				$mg_result = mysqli_query($db_connection,$mgQuery);
				$mg_genres = array();
				while($mg_row = mysqli_fetch_assoc($mg_result))
				{
					array_push($mg_genres,$mg_row['genreid']);

				}

				while($row = mysqli_fetch_assoc($allGenres))
				{
					// if genre is selected but there is no entry in moviegenres, then insert a moviegenres entry for that movie & genre
					if(in_array($row['genre_name'],$_POST['genres']) && !in_array($row['genreid'],$mg_genres))
					{
						$query = "INSERT INTO moviegenres(movieid,genreid) VALUES ({$_POST['movieid']},{$row['genreid']})";
						$result = mysqli_query($db_connection,$query);
					}
					// if genre is not selected but there is an entry for it in moviegenres (in other words, the genre has been deselected), then delete that moviegenres record
					else if(!in_array($row['genre_name'],$_POST['genres']) && in_array($row['genreid'],$mg_genres))
					{
						$query = "DELETE FROM moviegenres WHERE movieid = {$_POST['movieid']} AND genreid = {$row['genreid']}";
						$result = mysqli_query($db_connection,$query);
					}	
				}
			}

			
			function editMovie($db_connection)
			{
				if(empty($_POST['poster']))
				{
					$_POST['poster'] = "film-poster-placeholder.png";
				}

				if(empty($_POST['trailer']))
				{
					$query = "UPDATE movie SET title = '{$_POST['title']}', summary='{$_POST['summary']}', lang='{$_POST['lang']}',duration={$_POST['duration']},release_date='{$_POST['release_date']}',trailer=NULL,poster='{$_POST['poster']}' WHERE movieid={$_POST['movieid']}";
				}
				else
				{
					$query = "UPDATE movie SET title = '{$_POST['title']}', summary='{$_POST['summary']}', lang='{$_POST['lang']}',duration={$_POST['duration']},release_date='{$_POST['release_date']}',trailer='{$_POST['trailer']}',poster='{$_POST['poster']}' WHERE movieid={$_POST['movieid']}";

				}

				$result = mysqli_query($db_connection,$query);

				if(isset($_POST['genres']))
				{
					handleExistingGenres($db_connection);
				}
				else
				{
					$query = "DELETE FROM moviegenres WHERE movieid = {$_POST['movieid']}";
					$deleteAll = mysqli_query($db_connection,$query);
				}

				if(!empty($_POST['newGenre']))
				{
					addGenres($db_connection,$_POST['movieid'],$_POST['movieid'],'new');
				}

			}

			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(validFilmSubmission($db_connection))
				{
					editMovie($db_connection);
					echo "<h2>Film successfully edited.</h2>";
					$link = "movie-page.php?movieid={$_POST['movieid']}";

				}
				else
				{
					$link = "edit_movie.php?movieid={$_POST['movieid']}";
					
				}
				header("Refresh: 2; URL='$link'");
			}
		?>
	</body>
</html>