<html>
	<head>
		<title>Edit Role</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php

			include('universalFunctions.php');
			session_start();

			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(isManager())
				{
					if(isset($_GET['mcid']))
					{
						if(isset($_GET['submitted']))
						{
							if(!empty($_GET['role']))
							{
								$updateRole = mysqli_query($db_connection,"UPDATE moviecrews SET role='{$_GET['role']}' WHERE mcid={$_GET['mcid']}");
								echo "Role successfully updated.";
								header("Refresh: 2; URL='manage-roles.php?crewid={$_GET['crewid']}");
							}
							else
							{
								echo "Role cannot be empty.";
							}
						}
						else
						{
							$getInfo = mysqli_query($db_connection,"SELECT * FROM moviecrews NATURAL JOIN movie NATURAL JOIN crew WHERE mcid = {$_GET['mcid']}");
							$row = mysqli_fetch_assoc($getInfo);
							echo "<h1>Edit Role for {$row['FirstName']} {$row['LastName']}</h1>";
							echo "Crew Member: {$row['FirstName']} {$row['LastName']}<br><br>";
							echo "Movie: {$row['title']}<br><br>";
							echo "<form>
									<input type='hidden' name='mcid' value={$_GET['mcid']}>
									<input type='hidden' name='crewid' value={$row['crewid']}>
									Role: <input type='text' name='role' value='{$row['role']}'>
									<br><br>
									<button name='submitted'>Update Role</button>
								</form>";

						}
					}
					else
					{
						echo "No mcid given.";
					}
				}
			}
			
		?>
	</body>
</html>