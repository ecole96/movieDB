<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<style>h3{color:#dd3;}</style>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			// Evan Cole
			session_start();

			userLinks();

			// display all of the user's comments
			function displayUserComments($db_connection)
			{
				$query = "SELECT title, comment_date, comment_text FROM (movie NATURAL JOIN comments NATURAL JOIN db_user) WHERE username = '{$_SESSION['username']}'";
				$result = mysqli_query($db_connection,$query);
				$result_count = mysqli_num_rows($result);
				$countStr = getCountString($result_count,'comment');
				$commentStr = '';
				while($row = mysqli_fetch_assoc($result))
				{
					$title = $row['title'];
					$comment_date = $row['comment_date'];
					$comment_text = $row['comment_text'];

					$commentStr = $commentStr . "Title: $title<br>Comment Date: $comment_date<br>$comment_text<br><br>";
				}
				$commentStr = "<h3>Comments</h3>$countStr<br><br>" . $commentStr;
				echo $commentStr;
			}

			// display all of the user's reviews/scores
			function displayUserReviews($db_connection)
			{
				$query = "SELECT title, score_data, review, review_date FROM (movie NATURAL JOIN score_and_reviews NATURAL JOIN db_user) WHERE username = '{$_SESSION['username']}'";
				$result = mysqli_query($db_connection,$query);
				$result_count = mysqli_num_rows($result);
				$countStr = getCountString($result_count,'review');
				$scoreStr = '';
				while($row = mysqli_fetch_assoc($result))
				{
					$title = $row['title'];
					$score = $row['score_data'];
					if(!is_null($row['review']) && !is_null($row['review_date']))
					{
						$review_dateStr = 'Review Date: ' . $row['review_date'] . '<br>';
						$review_textStr = $row['review'];
						
					}
					else
					{
						$review_dateStr = '';
						$review_textStr = '';
					}
					$scoreStr = $scoreStr . "Title: $title<br>Score: $score<br>" . $review_dateStr . $review_textStr . '<br><br>';
				}

				$scoreStr = "<h3>Scores and Reviews</h3>$countStr<br><br>" . $scoreStr . '<br>';
				echo $scoreStr;
			}

			// display user details
			function displayUser($db_connection)
			{
				$query = "SELECT firstname, middlename, lastname, date_of_birth, gender FROM db_user WHERE username = '{$_SESSION['username']}'";
				$result = mysqli_query($db_connection,$query);
				$result_count = mysqli_num_rows($result);
		
				$row = mysqli_fetch_assoc($result);
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				if(!is_null($row['middlename']))
				{
					$middlename = $row['middlename'];
					$fullNameStr = $firstname . ' ' . $middlename . ' ' . $lastname;
				}
				else
				{
					$fullNameStr = $firstname . ' ' . $lastname;
				}
				
				$date_of_birth = $row['date_of_birth'];

				$gender = $row['gender'];

				if($_SESSION['permission_id'] == 1)
				{
					$userType = 'Manager';
				}
				else
				{
					$userType = 'Basic';
				}
				
				$userString = "<h1>User page - {$_SESSION['username']}</h1><h3>Details</h3>Full Name: $fullNameStr<br> Date of Birth: $date_of_birth<br>Gender: $gender<br>User Type: $userType<br>";
				echo $userString;
			}

			if(isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']))
			{
				$db_connection = connectToDatabase();
				if($db_connection)
				{
					displayUser($db_connection);
					displayUserComments($db_connection);
					displayUserReviews($db_connection);
					echo "<a href={$_SESSION['current_page']} style='color:#00FFFF'>Go back to the page you were on</a>";
					mysqli_close($db_connection);
				}
			}
			else
			{
				echo "Error: must be logged in to see this page.";
			}
		?>
	</body>
</html>