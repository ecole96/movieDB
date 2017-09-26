<html>
	<head>
		<title>
			Create Crew Member
		</title>
		<link rel='stylesheet' type='text/css' href='style.css'>	
	</head>
	<body>
		<?php
			include('universalFunctions.php');
			session_start();

			userLinks();

			if(isManager())
			{
				if(isset($_POST['submitted']))
				{
			
					if(!empty($_POST['FirstName']) && !empty($_POST['LastName']))
					{
						$db_connection = connectToDatabase();
						if($db_connection)
						{
							$addCrew = mysqli_query($db_connection,"INSERT INTO crew(FirstName, LastName) VALUES ('{$_POST['FirstName']}','{$_POST['LastName']}')");
							echo "<br>New crew member successfully added.<br><br><a href='add-crew.php'>Add another crew</a><br>
						  <a href='manager-page.php'>Go back to manager settings</a><br>";
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
					echo "<h1> Create Crew Member </h1>
							<form action='' method='POST'>
								First Name <input type='text' name='FirstName' required><br><br>
								Last Name <input type='text' name='LastName' required><br><br>
								<button type='submit' name='submitted'>Submit</button>
							</form>";
				}
			}

			

		?>
		
	</body>
</html>