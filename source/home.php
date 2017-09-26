<!-- Evan Cole -->
<!DOCTYPE html>
<html>
	<head>
		<style> 
			h1 a:hover{text-decoration:none}
		</style>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<title>MovieDB by Evan Cole, Darin Ellis, and Mauricio Sanchez</title>
	</head>
	<body style="background-image:url('https://newyorksightseeingtours.files.wordpress.com/2014/01/movie-theater.jpg'); background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-position: 50% 0%;">
		<?php
			include('universalFunctions.php');
			session_start();
			
			// c6c6c6 remember the page the user is on; the way, if they sign in, we can redirect back to this page after signing in
			$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']);
			userLinks();
		?>
		<!-- this form will be used to send search information: the page that displays search results will be "search.php" -->
		<div style='text-align:center'>
		<h1 style="font-size:70px;font-family:arial;">MovieDB</h1>
		<div class='searchBar'><form action='search.php' method='GET'>
			Sort by: 
			<input type='radio' name='sort_by' value='title' checked='checked'>Title
			<input type='radio' name='sort_by' value='release_date'>Release Date
			<input type='radio' name='sort_by' value='duration'>Duration<br>
			Order:
			<input type='radio' name='order' value='ASC' checked='checked'>Ascending
			<input type='radio' name='order' value='DESC'>Descending<br>
			<input type='search' size='40' name='search_query' placeholder='Type search query here...'>
			<button type='submit'>Search</button>
		</form></div>
		</div>
		<br>
		<br>
	</body>
</html>