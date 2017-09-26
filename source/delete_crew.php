<html>
	<head>
		<title>Delete Crew</title>
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
					if(isset($_GET['crewid']))
					{
						$deleteRoles = mysqli_query($db_connection,"DELETE FROM moviecrews WHERE crewid={$_GET['crewid']}");
						$deleteMember = mysqli_query($db_connection,"DELETE FROM crew WHERE crewid={$_GET['crewid']}");
						echo "Crew member (and all of their roles) have been deleted.";
						header("Refresh:2, url=manage-crew.php");

					}
					else
					{
						echo "No crewid given.";
						header("Refresh:2, url=home.php");
					}
					
				}
			}
		?>
	</body>
</html>