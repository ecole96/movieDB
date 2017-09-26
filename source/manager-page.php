<html>
	<head>	
		<link rel='stylesheet' type='text/css' href='style.css'>
		<style>
		</style>
		<title>Manager Settings</title>
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			userLinks();
			if(isManager())
			{
				echo "<h1>Manager Settings</h1>
					<a href='add-movie.php'>Add New Movie</a><br><br>
					<a href='add-crew.php'>Add New Crew Member</a><br><br>
					<a href='add-role.php'>Add New Role</a><br><br>
					<a href='manage-movies.php'>Manage Existing Movies</a><br><br>
					<a href='manage-crew.php'>Manage Existing Crew</a><br><br>
					<a href='manage-users.php'>Manage Users</a>";
			}
		?>
		
	</body>
	
</html>