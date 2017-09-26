<html>
	<head>
		<title>Watchlist</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();
			userLinks();

			$error_strings = '';
			// this function checks for a valid register form
			function validRegister($username,$firstname,$lastname, $initial_password, $confirm_password, $date_of_birth, $gender,&$error_strings)
			{
				$validRegister = true;

				// housecleaning junk (checks for bad input)
				$var_names = array('username','firstname','lastname','initial_password','confirm_password','date_of_birth','gender');
				// makes sure all required fields are input
				foreach($var_names as $name)
				{
					if(empty($$name))
					{
						$validRegister = false;
						$error_strings = $error_strings ."One or more fields is empty.<br>";
						break;
					}
				}

				// username too long
				if(strlen($username) > 64)
				{
					$validRegister = false;
					$error_strings = $error_strings . "Username is too long (exceeds 64 characters).<br>";
				}

				// Password and Confirm Password aren't identical
				if($initial_password != $confirm_password)
				{
					$validRegister = false;
					$error_strings = $error_strings . "\"Register\" and \"Confirm Password\" fields don't match.<br>";
				}

				// password too long
				if(strlen($initial_password) > 60 || strlen($confirm_password) > 60)
				{
					$validRegister = false;
					$error_strings = $error_strings . "Password is too long (exceeds 60 characters).<br>";
				}

				//now the important stuff - databases!
				$db_connection = mysqli_connect("localhost","root",NULL,"movieDB");
				// database connection fails
				if(!$db_connection)
				{
					$validRegister = false;
					// take out the specific connection error message later - we don't want to give users too much information
					$error_strings = $error_strings . "Server failed to connect to database - " . mysqli_connect_error() . "<br>";
				}
				// check for duplicate username
				$query = "SELECT username FROM db_user WHERE username = '$username'";
				$result = mysqli_query($db_connection,$query);
				$result_count = mysqli_num_rows($result);
				if($result_count != 0)
				{
					$validRegister = false;
					$error_strings = $error_strings . "Username $username already taken.<br>";
				}
				mysqli_close($db_connection);
				return $validRegister;
			}

			// puts name (first or last) in Xxxx format
			function cleanNameInput($name)
			{
				if(!is_null($name))
				{
					if(strlen($name) > 1)
					{
						$name = strtoupper($name[0]) . strtolower(substr($name,1,strlen($name)-1));

					}
					else
					{
						$name = strtoupper($name);
					}
				}
				return $name;
			}

			// inserts user into database; return code 0 is success, 1 is failure
			function createUser($username, $firstname, $middlename, $lastname, $password, $date_of_birth, $gender, &$error_strings)
			{
				$db_connection = mysqli_connect("localhost","root",NULL,"movieDB");
				// database connection fails
				if(!$db_connection)
				{
					// take out the specific connection error message later - we don't want to give users too much information
					$error_strings = $error_strings . "Server failed to connect to database - " . mysqli_connect_error() . "<br>";
					return 1;
				}

				// clean name input into Xxxxxx... format
				$firstname = cleanNameInput($firstname);
				$lastname = cleanNameInput($lastname);
				// do actual insertions
				if(!empty($middlename))
				{
					$middlename = cleanNameInput($middlename);
					$query = "INSERT INTO db_user(username,firstname,middlename,lastname,user_password,date_of_birth, gender, permission_id) VALUES ('$username','$firstname','$middlename','$lastname','$password','$date_of_birth','$gender',0)";

				}
				else
				{
					$query = "INSERT INTO db_user(username,firstname,middlename,lastname,user_password,date_of_birth, gender, permission_id) VALUES ('$username','$firstname',NULL,'$lastname','$password','$date_of_birth','$gender',0)";
				}
				$result = mysqli_query($db_connection,$query);
				if(!$result)
				{
					// take this out later too
					$error_strings = $error_strings . "Server couldn't execute database query - " . mysqli_error($db_connection) . "<br>";
					mysqli_close($db_connection);
					return 1;
				}
				mysqli_close($db_connection);
				return 0;
			}

			// if form has been submitted successfully, enter new user into database and redirect to an automatic login page
			if(isset($_POST['submitted']))
			{
				if(validRegister($_POST['username'],$_POST['firstname'],$_POST['lastname'], $_POST['initial_password'], $_POST['confirm_password'],$_POST['date_of_birth'], $_POST['gender'], $error_strings))
				{
					if(createUser($_POST['username'],$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['initial_password'],$_POST['date_of_birth'], $_POST['gender'],$error_strings) == 0)
					{
						$_SESSION['permission_id'] = 0;
						$_SESSION['logged_in'] = true;
						$_SESSION['username'] = $_POST['username'];
						header("Location: register-success.php");
					}
				}
			}

			// if error string isn't empty, then errors occurred
			if($error_strings != '')
			{
				$error_strings = "Can't register:<br>" . $error_strings . "<br>";
			}

			// we print the register form with any errors that may have occurred
			echo'<h1>Register User</h1>' . $error_strings .' <form action="" method="POST">
				Username: (maximum 64 characters)  
				<input type="text" name="username" required><br><br>
				First Name:
				<input type="text" name="firstname" required><br><br>
				Middle Name (optional)
				<input type="text" name="middlename"><br><br>
				Last Name:
				<input type="text" name="lastname" required><br><br>
				Password (maximum 60 characters):
				<input type="password" name="initial_password" required><br><br>
				Confirm Password:
				<input type="password" name="confirm_password" required><br><br>
				Date of Birth:
				<input type="date" name="date_of_birth" required><br><br>
				Gender:
				<select name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
				</select>
				<br>
				<br>
				<button type="submit" name="submitted">Submit</button>'

		?>
	</body>
</html>