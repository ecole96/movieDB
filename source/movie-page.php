<html>
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>		
		<title>Movie Page</title>
		<style>
			h3 {color: #dd5}
			.poster{float:left;}
			.trailer {float:right;}
			img {padding-right:70px;}
		</style>
	</head>
	<body>
		<?php
			include('universalFunctions.php');

			// if a user is logged in and hasn't added a movie to their watchlist, then 
			function handle_watchlist($db_connection)
			{
				if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
				{
					$userID = getUserID($db_connection);
					if(!inWatchList($db_connection,$userID))
					{
						echo "<form action='add_to_watchlist.php' method='POST'>
								<input type='hidden' name='userid' value=$userID>
								<input type='hidden' name='movieid' value={$_GET['movieid']}>
								<button name='submitted'>Add to Watchlist</button>
								</form>";
					}
					else
					{
						echo "Already in watchlist<br><br>";
					}
				}
			}

			// checks if movie is already in a user's watchlist
			function inWatchList($db_connection,$userID)
			{
				$result = mysqli_query($db_connection,"SELECT * FROM watchlist WHERE userid = $userID AND movieid = {$_GET['movieid']}");
				if(mysqli_num_rows($result) != 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}

			// displays avg score, user's score for a given film
			function scoring($db_connection)
			{
				// display avg rating
				$ScoreQuery = "SELECT score_data FROM score_and_reviews S WHERE S.movieid = {$_GET['movieid']}";
				$score_result = mysqli_query($db_connection,$ScoreQuery);
				// if film has scores, displays the average score
				if(mysqli_num_rows($score_result) == 0)
				{
					echo "No user scores<br>";
				}
				else
				{
					$avgScoreQuery = "SELECT AVG(score_data) FROM score_and_reviews S WHERE S.movieid = {$_GET['movieid']}";
					$avg = mysqli_fetch_assoc(mysqli_query($db_connection,$avgScoreQuery));
					$rounded_avg_score = round($avg['AVG(score_data)'],1);
					echo "Average user rating: $rounded_avg_score/10<br>";
				}

				// if user is logged in, show ratings dropdown
				if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
				{
					echo "<form action='rate-movie.php' method='GET'>
							<input type='hidden' name='movieid' value={$_GET['movieid']}>";
					if(userHasScored($db_connection,$_GET['movieid']))
					{
						$userScoreQuery = "SELECT S.score_data FROM db_user U, score_and_reviews S WHERE U.userid = S.userid AND U.username = '{$_SESSION['username']}' AND S.movieid = {$_GET['movieid']}";
						$result = mysqli_query($db_connection,$userScoreQuery);
						$row = mysqli_fetch_assoc($result);
						$dropdown = generateRatingDropdown($row['score_data']);
						$submit_label = 'Update';

						echo "Your rating: $dropdown<br>";
					}
					else
					{
						$dropdown = generateRatingDropdown(null);
						$submit_label = 'Submit';
						echo "Rate: $dropdown<br>";

					}
					echo "<button type='submit'>$submit_label</button>
						</form>";
					
				}
			}

			// draw film details - title, genre, duration, etc.
			function filmDetails($db_connection)
			{
				$query = "SELECT * FROM movie WHERE movieid='{$_GET['movieid']}'";
				$result = mysqli_query($db_connection,$query);
				$filmDetails = mysqli_fetch_assoc($result);
				$title = $filmDetails['title'];
				$release_year = date('Y', strtotime($filmDetails['release_date']));
				echo "<h2>$title ($release_year)</h2>";
				echo "<div style='float:left'><img src='{$filmDetails['poster']}' alt='poster' width='225' height='340'>";
				if(!is_null($filmDetails['trailer']))
				{
				    $url = "{$filmDetails['trailer']}";
				    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
				    $id = $matches[1];
					echo "<iframe width='580' height='340' src='https://www.youtube.com/embed/$id' frameborder='0' allowfullscreen></iframe>";
				}
				echo "</div>";
				echo "<div style='clear:both; width:100%'><br>";
				handle_watchList($db_connection);
				scoring($db_connection);
				// if logged in, display watchlist message (either in watchlist or button to add to watchlist)
				echo"<div style='width:25%;float:left;background-color:#34495E; margin-right: 40px;border-style: solid;border-color: black;'>";
				echo "<h3>Summary</h3><p>{$filmDetails['summary']}</p>";

				// cast and crew
				echo "<h3>Cast & Crew</h3>";
				$query = "SELECT FirstName, LastName, role from crew NATURAL JOIN moviecrews WHERE movieid='{$_GET['movieid']}'";
				$result = mysqli_query($db_connection,$query);
				echo "<table>";
				while($row = mysqli_fetch_assoc($result))
				{
					echo "
							<tr>
								<td>{$row['FirstName']} {$row['LastName']}</td>
								<td>... {$row['role']}</td>
							</tr>";
				}
				echo "</table>";

				// little details (duration, release_date, etc.)
				echo "<h3>Details</h3>
				Release date: {$filmDetails['release_date']}<br>";

				$genreQuery = "SELECT G.genre_name FROM movie M, genres G, moviegenres MG WHERE M.movieid = MG.movieid AND G.genreid = MG.genreid AND M.movieid = {$_GET['movieid']}";
				$genre = mysqli_query($db_connection,$genreQuery);
				echo "Genre: ";
				$genre_arr = array();
				while($genreRow = mysqli_fetch_assoc($genre))
				{
					array_push($genre_arr,"{$genreRow['genre_name']}");
				}
				echo implode(', ', $genre_arr) . '<br>';
				echo "Language: {$filmDetails['lang']}<br>
				Duration: {$filmDetails['duration']} minutes<br>";
				
			}

			// display tags for a film - if user is logged in, then show "add tag" box
			function displayTags($db_connection)
			{
				echo "<h3>Tags</h3>";
				$query = "SELECT tagdata FROM tags WHERE movieid={$_GET['movieid']}";
				$result = mysqli_query($db_connection,$query);
				$tags = array();
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($tags,$row['tagdata']);
				}
				echo implode(', ',$tags);

				//submit tag
				if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
				{
					echo "
					<form action='add-tag.php' method='POST'>
						<input type='hidden' name='movieid' value={$_GET['movieid']}>
						<input type='text' name='tagdata' placeholder='Add tag...(max 255 characters)'>
						<button type='submit'>Add tag</button> 
					 </form>";
				}

				echo "</div>";

			}

			// displays reviews for a film - if user is logged in, display write review link
			function displayReviews($db_connection)
			{
				echo "
					<div style='width:38%;float:left;background-color:#34495E;margin-right:40px;border-style: solid;border-color: black;'><h3>Reviews</h3>";
				if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
				{
					if(!userHasReviewed($db_connection,$_GET['movieid']))
					{
						echo "<a href=write-review.php?movieid={$_GET['movieid']} style='color:#00FFFF'>Write review</a><br><br>";
					}
				}

				$query = "SELECT username, review, review_date,score_data FROM db_user NATURAL JOIN score_and_reviews WHERE review IS NOT NULL AND movieid = {$_GET['movieid']} ORDER BY review_date DESC";
				$result = mysqli_query($db_connection,$query);
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<div style='text-decoration:underline'>{$row['username']} on {$row['review_date']}</div>Score: {$row['score_data']}/10<br>{$row['review']}<br><br>";
				}

				echo "</div>";

			}

			// display comments - if user is logged in, display comment post box
			function displayComments($db_connection)
			{
				echo "
					<div style='width:30%;float:left;background-color:#34495E;border-style: solid;border-color: black;'><h3>Comments</h3>";
				if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
				{
						echo "Write comment<br>
							<form action='submit-comment.php' method='POST'>
								<input type='hidden' name='movieid' value={$_GET['movieid']}>
								<textarea rows='4' cols='50' name='comment_text' placeholder='Type your comment here...'></textarea>
								<button name='commentSubmitted'>Post</button>
							</form>
							<br>";
				}

				$query = "SELECT username, comment_date, comment_text FROM db_user NATURAL JOIN comments WHERE movieid = {$_GET['movieid']} ORDER BY comment_date DESC";
				$result = mysqli_query($db_connection,$query);
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<div style='text-decoration: underline'>{$row['username']} on {$row['comment_date']}</div>{$row['comment_text']}<br><br>";
				}
				echo "</div>";
			
			}

			session_start();
			userLinks(); 
			echo "<br>";

			// draw search box
			echo "<div class='searchBar'><form action='search.php' method='GET'>
				Sort by: 
				<input type='radio' name='sort_by' value='title' checked='checked'>Title
				<input type='radio' name='sort_by' value='release_date'>Release Date
				<input type='radio' name='sort_by' value='duration'>Duration<br>
				Order:
				<input type='radio' name='order' value='ASC' checked='checked'>Ascending
				<input type='radio' name='order' value='DESC'>Descending<br>
				<input type='search' name='search_query' placeholder='Type search query here...'>
				<button type='submit'>Search</button>
			</form></div>";

			if(!isset($_GET['movieid']) || $_GET['movieid'] == '')
			{
				echo "No movieid queried.<br>";
				$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']);
			}
			else
			{
				$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']) . "?movieid={$_GET['movieid']}";
				$db_connection = connectToDatabase();
				if($db_connection)
				{
					filmDetails($db_connection);
					displayTags($db_connection);
					displayReviews($db_connection);
					displayComments($db_connection);
				}
			}
		?>
	</body>
</html>