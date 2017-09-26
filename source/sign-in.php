<!-- Evan Cole -->
<!DOCTYPE html>
<html>
	<head>
		<title>MovieDB - Sign In</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();
			userLinks();
			// error string starts empty - if no error, no error message will be concatenated to the output string
			$error_string = '';

			function validUser($username,$password,&$error_string)
			{
				// one or more fields is empty
				if(empty($username)|| empty($password))
				{
					$error_string = "Unsuccessful login: one or more fields is empty.<br><br>";
					return false;
				}
				else
				{
					$db_connection = mysqli_connect("localhost","root",NULL,"movieDB");
					// database connection fails
					if(!$db_connection)
					{
						// take out the specific connection error message later - we don't want to give users too much information
						$error_string = "ERROR: Server failed to connect to database - " . mysqli_connect_error() . "<br><br>";
						return false;
					}
					// do query magic
					$query = "SELECT username, user_password, permission_id FROM db_user WHERE username = '$username' AND user_password = '$password'";
					$result = mysqli_query($db_connection,$query);
					$result_count = mysqli_num_rows($result);
					// either password or username is wrong - no match found
					if($result_count != 1)
					{
						mysqli_close($db_connection);
						if($result_count == 0)
						{
							$error_string = "No matching user found in database - the name or password you entered is incorrect.<br><br>";
							return false;
						}
						else
						{
							$error_string = "Can't log in - Duplicate users found.<br><br>";
							return false;
						}	
					}
					// success!
					else
					{
						// set login/session variables
						$row = mysqli_fetch_assoc($result);
						if($row['permission_id'] == 1)
						{
							$_SESSION['permission_id'] = 1;
						}
						else
						{
							$_SESSION['permission_id'] = 0;
						}
						$_SESSION['logged_in'] = true;
						$_SESSION['username'] = $row['username'];
						mysqli_close($db_connection);
						return true;
					}
				}
			}

			// if form has been submitted successfully, redirect to the page the user was at before signing in
			if(isset($_POST['submitted']))
			{
				if(validUser($_POST['username'],$_POST['password'],$error_string))
				{
					if(!isset($_SESSION['current_page']))
					{
						$_SESSION['current_page'] = 'home.php';
					}
					header("Location: {$_SESSION['current_page']}");
				}
			}

			// print sign-in form
			$output_str =  "<h1>Sign In</h1>" . $error_string . '<form action="" method="POST">
				Username<br>
				<input type="text" name="username" required><br><br>
				Password<br>
				<input type = "password" name="password" required><br><br>
				<button type="submit" name="submitted">Sign In</button>
			</form>';
			echo $output_str;
		?>
	</body>
</html>