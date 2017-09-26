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
			function validComment($db_connection)
				{
					$loginCheck = $session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
					// user is logged in, movie is associated with comment, and there is an actual comment submitted
					if(isset($_POST['movieid']) && isset($_POST['comment_text']) && $loginCheck)
					{
						// comment is not empty nor exceeding max length
						if($_POST['comment_text'] != '' && strlen($_POST['comment_text']) <= 1000)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}

			// gets userid based on username and then inserts comment into database
			function addComment($db_connection)
			{
				$userid = getUserID($db_connection);
				$currentDate = date("Y-m-d");
				$query = "INSERT INTO comments(userid, movieid, comment_date, comment_text) VALUES ($userid,{$_POST['movieid']},'$currentDate','{$_POST['comment_text']}')";
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
				if(validComment($db_connection))
				{
					addComment($db_connection);
					$outputStr = "<h2>Comment submitted! Redirecting back to movie page...</h2>";
				}
				else
				{
					$outputStr = "<h2>ERROR: Comment was either empty / too long (more than 255 characters), or no movie is associated with comment.</h2>";
				}

				header("Refresh: 2; URL='{$_SESSION['current_page']}'");
				echo $outputStr . "<br>";
			}
		?>
	</body>
</html>