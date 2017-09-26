<html>
	<head>
		<title>Manage Crew</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
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


			userLinks();

			
			function crewList($db_connection)
			{
				$result = mysqli_query($db_connection, "SELECT * FROM crew");
				echo "<table>
						<tr>
							<th>Name</th>
							<th>Actions</th>
						</tr>";
				while($row = mysqli_fetch_assoc($result))
				{
					$query_string = "crewid={$row['crewid']}";
					echo "<tr>
							<td>{$row['FirstName']} {$row['LastName']}</td>
							<td><a href='edit_crew.php?$query_string'>Edit Details</a>&nbsp&nbsp&nbsp&nbsp <a href='manage-roles.php?$query_string'>Manage Roles</a>&nbsp&nbsp&nbsp&nbsp<a href='delete_crew.php?$query_string'>Delete</a></td>
						</tr>";
				}
				echo "</table>";
			}


			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(isManager())
				{
					echo "<h1>Manage Crew</h1>";
					crewList($db_connection);
				}
			}
		?>
	</body>
</html>