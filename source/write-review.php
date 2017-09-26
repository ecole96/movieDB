<html>
	<head>
		<title>Write Review</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php

			// returns title of movie with $movieid
			function getTitle($db_connection, $movieid)
			{
				$query = "SELECT title from movie where movieid=$movieid";
				$result = mysqli_query($db_connection,$query);
				$row = mysqli_fetch_assoc($result);
				return $row['title'];
			}

			include('universalFunctions.php');
			session_start();

			// checks for login and valid movieid
			$loginCheck = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
			
			// if logged in, build form
			if($loginCheck && isset($_GET['movieid']) && $_GET['movieid'] != '')
			{
				$db_connection = connectToDatabase();
				if($db_connection)
				{
					// users can only review a movie once.
					if(userHasReviewed($db_connection,$_GET['movieid']))
					{
						echo "Already reviewed movie.";
						header("Refresh: 2; URL='{$_SESSION['current_page']}'");
					}
					else
					{
						// if user has already scored movie, display score dropdown with previous score as default setting
						if(userHasScored($db_connection,$_GET['movieid']))
						{
							$userid = getUserID($db_connection);
							$query = "SELECT score_data FROM score_and_reviews WHERE movieid = {$_GET['movieid']} AND userid=$userid";
							$result = mysqli_query($db_connection,$query);
							$row = mysqli_fetch_assoc($result);
							$defaultRating = $row['score_data'];
						}
						else
						{
							$defaultRating = null;

						}
						$dropdown = generateRatingDropdown($defaultRating);
						$title = getTitle($db_connection,$_GET['movieid']);
						echo 	"<h1>Write Review - $title</h1>
								<form action='submit-review.php' method='POST'>
									<input type='hidden' name='movieid' value={$_GET['movieid']}>
									Score: $dropdown<br><br>
									<textarea rows='50' cols='100' name='review' placeholder='Write review here...(max characters: 65535 characters)'></textarea>
									<button type='submit'>Post</button>
								</form>";
					}
				}
			}
			else
			{
				echo "Not logged in, or no valid movieid given - redirecting to home...";
				header("Refresh: 2; URL='{$_SESSION['current_page']}'");	
			}
		?>
	</body>
</html>