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
					if(isset($_GET['mcid']))
					{
						$getCrewID = mysqli_fetch_assoc(mysqli_query($db_connection,"SELECT crewid FROM moviecrews WHERE mcid={$_GET['mcid']}"));
						$deleteRoles = mysqli_query($db_connection,"DELETE FROM moviecrews WHERE mcid={$_GET['mcid']}");
						echo "Role has successfully been deleted.";
						header("Refresh: 2; URL='manage-roles.php?crewid={$getCrewID['crewid']}");

					}
					else
					{
						echo "No mcid (moviecrews ID) given.";
						header("Refresh: 2; URL='manage-crew.php'");
					}
					
				}	
			}
		?>
	</body>
</html>