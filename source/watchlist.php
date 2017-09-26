<html>
	<head>
		<title>Watchlist</title>
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
		$db_connection = connectToDatabase();
		if($db_connection)
		{
			$loginCheck = isset($_SESSION['username']) && isset($_SESSION['logged_in']) && isset($_SESSION['permission_id']);
			if($loginCheck)
			{
				if(isset($_POST['submitted']))
				{
					foreach($_POST['checkbox'] as $checkbox)
					{
						$result = mysqli_query($db_connection, "DELETE from watchlist WHERE wlid = $checkbox");
					}
				}
				$userid = getUserID($db_connection);
				$result = mysqli_query($db_connection, "SELECT * FROM watchlist NATURAL JOIN movie where userid=$userid");
				$countStr = getCountString(mysqli_num_rows($result),'movie');
				echo "<br>$countStr<br><br><form action = '' method='POST'>
						<table>
							<tr>
								<th>Poster</th>
								<th>Movie</th>
								<th>Delete</th>
							</tr>";
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<tr>
							<td style='width:1%'><img src={$row['poster']} alt='poster' height='120' width='80' style=''></td></div>
							<td style='width:100%''>{$row['title']}</td>
							<td style ='width:1%; text-align:center'><input type='checkbox' name='checkbox[]' value='{$row['wlid']}'></td>
						  </tr>";
				}

				echo "	</table><br>";
				if(mysqli_num_rows($result) != 0)
				{
					echo "<button name='submitted'>Submit changes</button>";

				}	
				echo "</form>";
			}
			else
			{
				echo "Must be logged in.";
			}
		}



	?>
	</body>
</html>