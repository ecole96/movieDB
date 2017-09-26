<html>
	<head>
		<title>Add Tag</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
<?php
	include('universalFunctions.php');
	session_start();

	// checks if tag has already been entered for a film - if so, then submitted tag is invalid
	function duplicateTag($db_connection)
	{
		$query = "SELECT tagdata from tags WHERE movieid = {$_POST['movieid']} AND tagdata = '{$_POST['tagdata']}'";
		$result = mysqli_query($db_connection,$query);
		if(mysqli_num_rows($result) != 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	// checks for valid tag
	function validTag($db_connection)
	{

		$loginCheck = $session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
		// verifies that user is logged in and that there is a valid movieid associated with the comment + tag text
		if(isset($_POST['movieid']) && isset($_POST['tagdata']) && $loginCheck)
		{
			// checks that tag is not an empty string or exceeding max length, and is not a duplicate
			if($_POST['tagdata'] != '' && strlen($_POST['tagdata']) <= 255 && !duplicateTag($db_connection))
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

	// adds tag to database
	function addTag($db_connection)
	{
		$query = "INSERT INTO tags(movieid, tagdata) VALUES ({$_POST['movieid']}, '{$_POST['tagdata']}')";
		$result = mysqli_query($db_connection,$query);
	}

	if(!isset($_SESSION['current_page']))
	{
		$_SESSION['current_page'] = 'home.php';
	}

	// connect to db, add tag, and then redirect back to movie page unless something is wrong
	$db_connection = connectToDatabase();
	if($db_connection)
	{
		if(validTag($db_connection))
		{
			addTag($db_connection);
			$outputStr = "<h2>Tag submitted! Redirecting back to movie page...</h2>";
		}
		else
		{
			$outputStr = "<h2>ERROR: tag was either empty / too long (more than 255 characters) / duplicate, or no movie is associated with comment.</h2>";
		}

		header("Refresh: 2; URL='{$_SESSION['current_page']}'");
		echo $outputStr . "<br>";
	}
	
?>
	</body>
</html>