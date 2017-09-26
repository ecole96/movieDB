<html>
	<head>
		<title>Manage Roles</title>
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

			function roleList($db_connection)
			{
				$result = mysqli_query($db_connection, "SELECT * FROM moviecrews WHERE crewid = {$_GET['crewid']}");
				echo "<table>
						<tr>
							<th>Movie Name</th>
							<th>Role</th>
							<th>Actions</th>
						</tr>";
				while($row = mysqli_fetch_assoc($result))
				{
					$movieQuery = mysqli_query($db_connection,"SELECT title FROM movie WHERE movieid={$row['movieid']}");
					$movieRow = mysqli_fetch_assoc($movieQuery);
					$query_string = "mcid={$row['mcid']}";
					echo "<tr>
							<td>{$movieRow['title']}</td>
							<td>{$row['role']}</td>
							<td><a href='edit_role.php?$query_string'>Edit Details</a>&nbsp&nbsp&nbsp&nbsp<a href='delete_role.php?$query_string'>Delete</a></td>
						</tr>";
				}
				echo "</table>";
			}


			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(isManager())
				{
					if(isset($_GET['crewid']))
					{
						$crewInfo = mysqli_fetch_assoc(mysqli_query($db_connection,"SELECT * FROM crew WHERE crewid={$_GET['crewid']}"));
						echo "<h1>Manage Roles for {$crewInfo['FirstName']} {$crewInfo['LastName']}</h1>";
						roleList($db_connection);

					}
					else
					{
						echo "There must be a crewid given.";
					}
				}
			}

		?>
	</body>
</html>