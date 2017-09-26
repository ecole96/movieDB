<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>		
		<?php
			include('universalFunctions.php');
			session_start();

			// checks for valid comment
			function validReview($db_connection)
				{
					$loginCheck = $session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
					// user is logged in, movie is associated with reivew, and there is an actual review submitted
					if(isset($_POST['movieid']) && isset($_POST['review']) && isset($_POST['rating']) && $loginCheck)
					{
						// review is not empty nor exceeding max length
						if($_POST['review'] != '' && strlen($_POST['review']) <= 65535)
						{
							
							return true;
						}
						else if(userHasReviewed($db_connection,$_POST['movieid']))
						{
							echo "Can't review a film more than once.<br>";
							return false;
						}
						else
						{
							echo "ERROR: Review is either empty or too long (max. 65535 characters).<br>";
							return false;
						}
					}
					else
					{
						echo "ERROR: Either not logged in, or there is no movieid associated with this review.<br>";
						return false;
					}
				}

			// gets userid based on username and then inserts comment into database
			function addReview($db_connection)
			{
				$userid = getUserID($db_connection);
				$currentDate = date("Y-m-d");
				if(userHasScored($db_connection,$_POST['movieid']))
				{
					$query = "UPDATE score_and_reviews SET score_data = {$_POST['rating']}, review = '{$_POST['review']}', review_date = '$currentDate' WHERE userid = $userid";
				}
				else
				{
					$query = "INSERT INTO score_and_reviews(userid, movieid, score_data, review_date, review) VALUES ($userid,{$_POST['movieid']},{$_POST['rating']},'$currentDate','{$_POST['review']}')";

				}
				$result = mysqli_query($db_connection,$query);
			}

			if(!isset($_SESSION['current_page']))
			{
				$_SESSION['current_page'] = 'home.php';
			}

			//  adds comment to database and then redirects back to movie page unless something goes wrong
			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(validReview($db_connection))
				{
					addReview($db_connection);
					echo "<h2>Review submitted! Redirecting back to movie page...</h2><br>";
				}

				header("Refresh: 2; URL='{$_SESSION['current_page']}'");
			}
		?>
	</body>
</html>