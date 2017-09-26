<html>
	<head>
		<title>Edit Crew</title>
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
					if(isset($_GET['submitted']))
					{
				
						if(!empty($_GET['FirstName']) && !empty($_GET['LastName']) && isset($_GET['crewid']))
						{
							$addCrew = mysqli_query($db_connection,"UPDATE crew SET FirstName = '{$_GET['FirstName']}', LastName ='{$_GET['LastName']}' WHERE crewid = {$_GET['crewid']}");
							echo "Crew member successfully edited.";
							header("Refresh:2, url=manage-crew.php");
						}
						else
						{
							echo "All fields must be entered.";
							header("Refresh:2, url=home.php");
						}

					}
					else
					{
						if(isset($_GET['crewid']))
						{
							echo "<h1>Edit Crew Member </h1>
								<form action='' method='GET'>
									<input type='hidden' name='crewid' value={$_GET['crewid']}>";
							$crew = mysqli_query($db_connection,"SELECT * FROM crew WHERE crewid = {$_GET['crewid']}");
							$row = mysqli_fetch_assoc($crew);
							echo "First Name <input type='text' name='FirstName' value='{$row['FirstName']}' required><br><br>
							Last Name <input type='text' name='LastName' value='{$row['LastName']}' required><br><br>
							<button type='submit' name='submitted'>Submit</button>
						</form>";
						}
						else
						{
							echo "No movieid given.";
							header("Refresh:2, url=home.php");
						}
					}
				}
			}
		?>
	</body>
</html>