<html>
	<head>
		<title>Add Role</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();
			userLinks();

			function isDuplicateRole($db_connection,$movieid,$crewid,$role)
			{
				$result = mysqli_query($db_connection,"SELECT * FROM moviecrews WHERE movieid=$movieid AND $crewid=$crewid AND role='$role'");
				if(mysqli_num_rows($result) != 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}

			if(isManager())
			{
				$db_connection = connectToDatabase();
				if($db_connection)
				{
					if(isset($_POST['submitted']))
					{
			
						if(!empty($_POST['crewid']) && !empty($_POST['movieid'])  && !empty($_POST['role']))
						{
							if(!isDuplicateRole($db_connection,$_POST['movieid'],$_POST['crewid'],$_POST['role']))
							{
								$result = mysqli_query($db_connection,"INSERT INTO moviecrews(movieid, crewid, role) VALUES ({$_POST['movieid']},{$_POST['crewid']},'{$_POST['role']}')");
								echo "<br>New role successfully added.<br><br><a href='add-role.php'>Add another crew</a><br>
						  <a href='manager-page.php'>Go back to manager settings</a><br>";
							}
							else
							{
								echo "<br>Duplicate role detected - this role is already in the database.";
								header("Refresh:2 url='add-crew.php");
							}
						}
						else
						{
							echo "<br>All fields must be entered.";
							header("Refresh:2 url='add-crew.php");
						}
					}
					else
					{
						echo "<h1>Add New Role</h1>
								<form action='' method='POST'>";
						$crew = mysqli_query($db_connection,"SELECT * FROM CREW");
						echo "Crew Member <select name='crewid'>";
						while($crewRow = mysqli_fetch_assoc($crew))
						{
							echo "<option value='{$crewRow['crewid']}' required>{$crewRow['FirstName']} {$crewRow['LastName']}</option>";
						}
						echo "</select><br><br>
								Movie <select name='movieid'>";
						$movies = mysqli_query($db_connection,"SELECT * FROM movie");
						while($movieRow = mysqli_fetch_assoc($movies))
						{
							echo "<option value='{$movieRow['movieid']}' required>{$movieRow['title']}</option>";
						}
						echo "</select><br><br>
							Role <input type='text' name='role' required><br><br>
							  <button name='submitted'>Submit</button>
							  </form>";
					}
					
				}

			}
		?>
	<body>
</html>
