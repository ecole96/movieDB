<html>
	<head>
		<title>Manage Movies</title>
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
			
			function movieList($db_connection)
			{
				$result = mysqli_query($db_connection, "SELECT * FROM movie");
				echo "<table>
						<tr>
							<th>Title</th>
							<th>Actions</th>
						</tr>";
				while($row = mysqli_fetch_assoc($result))
				{
					$query_string = "movieid={$row['movieid']}";
					echo "<tr>
							<td>{$row['title']}</td>
							<td><a href='edit_movie.php?$query_string'>Edit Details</a>&nbsp&nbsp&nbsp&nbsp<a href='delete_movie.php?$query_string'>Delete</a></td>
						</tr>";
				}
				echo "</table>";
			}

			$db_connection = connectToDatabase();
			if($db_connection)
			{
				if(isManager())
				{
					echo "<h1>Manage Movies</h1>";
					movieList($db_connection);

				}
					else
					{
						echo "There must be a movieid given.";
					}
			}

		?>
	</body>
</html>