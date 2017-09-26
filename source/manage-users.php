<html>
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>	
		<title>Manage Users</title>
		<style>
				table {
			    font-family: arial, sans-serif;
			    border-collapse: collapse;
			    width: 100%;
			    background-color: #34495E;
			}

			th {color: #dd5}

			td, th {
			    border: 1px solid #dddddd;
			    text-align: left;
			    padding: 8px;
			}

		</style>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			// builds a list of all users, their information, and corresponding checkbox 
			// I wrote this function before I found out you can pass an array of checked items into a form - not enough time to change it
			function getUserList($db_connection)
			{
				$query = "SELECT username, firstname, middlename, lastname, date_of_birth, gender, permission_id FROM db_user";
				$result = mysqli_query($db_connection,$query);
				$result_count = mysqli_num_rows($result);
				$countStr = getCountString($result_count,'user');
				$outputStr = $countStr . "<form action = '' method='POST'>
						<table>
							<tr>
								<th>Username</th>
								<th>Full Name</th>
								<th>Date of Birth</th>
								<th>Gender</th>
								<th>Assign As Manager (check to assign)</th>
							</tr>";

				$row_no = 0;
				while($row = mysqli_fetch_assoc($result))
				{
					if(is_null($row['middlename']))
					{
						$fullName = $row['firstname'] . ' ' . $row['lastname'];
					}
					else
					{
						$fullName = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
					}

					$checkbox_var = 'checkbox' . $row_no;

					// if user is already a manager, don't show checkbox - we don't want managers to have the ability to demote other managers
					if($row['permission_id'] == 1)
					{
						$managerToggleString = "Already a Manager<input type='checkbox' class='hidden' name=$checkbox_var value={$row['username']} style='display:none;'>";
					}
					else
					{
						$managerToggleString = "<input type='checkbox' name=$checkbox_var value={$row['username']}>";
					}

					$outputStr = $outputStr . "<tr>
							<td>{$row['username']}</td>
							<td>$fullName</td>
							<td>{$row['date_of_birth']}</td>
							<td>{$row['gender']}</td>
							<td>$managerToggleString</td>
						 </tr>";

					$row_no ++;
				}
				$outputStr = $outputStr . "</table><br><button type='submit' name='submitted'>Submit changes</button></form>";
				return $outputStr;
			}

			// after submitting user form, we loop through the user list looking for a corresponding checkmark by each user; if checked, we promote that user to a manager
			// also keep track of changes made
			function assignManagers($db_connection,&$changesMade)
			{
				$query = "SELECT * FROM db_user";
				$result = mysqli_query($db_connection,$query);
				$row_count = mysqli_num_rows($result);


				for($i = 0; $i < $row_count; $i++)
				{
					if(isset($_POST['checkbox' . $i]))
					{
						$username = $_POST['checkbox'. $i];
						$permissionQuery = "UPDATE db_user SET permission_id=1 WHERE username='$username'";
						$doAssign = mysqli_query($db_connection,$permissionQuery);
						$changesMade++;
					}
				}
			}

			// make sure we're logged in as a manager and connected to the database, then do all the work
			userLinks();
			$session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
			if($session_check)
			{
				if($_SESSION['permission_id'] == 1)
				{
					echo "<h1>Manage Users</h1>";
					$db_connection = connectToDatabase();
					if($db_connection)
					{
						$changesMadeStr = '';
						if(isset($_POST['submitted']))
						{
							$changesMade = 0;
							assignManagers($db_connection,$changesMade);
							echo "$changesMade changes made.<br><br>";
						}
		
						$outputStr = getUserList($db_connection);

						echo $outputStr . "<a href={$_SESSION['current_page']}>Go back to the page you were on</a>";
						mysqli_close($db_connection);
					}
		
				}

			}
			else
			{
				echo "Must be logged in as a manager to see this page.";

			}
		?>
	</body>
</html>