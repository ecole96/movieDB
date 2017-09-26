<html>
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<title>MovieDB - Search</title>
	</head>
	<body>
	<style>
			.zui-table {
		    border: solid 1px #DDEEEE;
		    border-collapse: collapse;
		    border-spacing: 0;
		    font: normal 16px Arial, sans-serif;}
		    .zui-table thead th {
			    background-color: #DDEFEF;
			    border: solid 1px #DDEEEE;
			    color: #f6f6f6;
			    padding: 10px;
			    text-align: left;
			}
			.zui-table tbody td {
			    border: solid 1px #DDEEEE;
			    color: #f6f6f6;
			    padding: 10px;
			}
			.zui-table-rounded {
			    border: none;
			}
			.zui-table-rounded thead th {
			    background-color: #34495E;
			    border: none;
			    color: #dd5;
			}
			.zui-table-rounded thead th:first-child {
			    border-radius: 10px 0 0 0;
			}
			.zui-table-rounded thead th:last-child {
			    border-radius: 0 10px 0 0;
			}
			.zui-table-rounded tbody td {
			    border: none;
			    border-top: solid 1px #957030;
			    background-color: #34495E;
			}
			.zui-table-rounded tbody tr:last-child td:first-child {
			    border-radius: 0 0 0 10px;
			}
			.zui-table-rounded tbody tr:last-child td:last-child {
			    border-radius: 0 0 10px 0;
			}
	</style>
<?php
	// searches a query and sorts/orders according to user preferences
	function doSearch($db_connection)
	{
		// this query yields results if a film in the database has a title, genre, crew member, or tag matching the query
		$query = "SELECT M.movieid, M.title, M.release_date, M.duration from movie M
			WHERE M.movieid IN (SELECT Ma.movieid FROM movie Ma, genres G, moviegenres MG WHERE Ma.movieid = MG.movieid AND G.genreid = MG.genreid AND G.genre_name LIKE '%{$_GET['search_query']}%') 
			OR M.movieid IN (SELECT Mb.movieid FROM movie Mb, crew C, moviecrews MC WHERE Mb.movieid = MC.movieid AND C.crewid = MC.crewid AND (CONCAT(C.FirstName, ' ', C.LastName) LIKE '%{$_GET['search_query']}%' OR C.LastName LIKE '%{$_GET['search_query']}%')) 
			OR M.movieid IN (SELECT Mc.movieid FROM movie Mc WHERE Mc.title LIKE '%{$_GET['search_query']}%')
			OR M.movieid IN (SELECT Md.movieid FROM movie Md, tags T WHERE Md.movieid = T.movieid AND T.tagdata LIKE '%{$_GET['search_query']}%')";

		// sort results based on criteria (title, release date, duration) and order them from descending ('DESC') or ascending ('ASC') based on user preference
		if($_GET['order'] == 'DESC')
		{
			$query = $query . " ORDER BY M.{$_GET['sort_by']} DESC";
		}
		else
		{
			$query = $query . " ORDER BY M.{$_GET['sort_by']}";
		}
		
		$result = mysqli_query($db_connection,$query);

		$result_count = mysqli_num_rows($result);
		$countStr = getCountString($result_count,'movie');
		echo $countStr . "<br>";

		// build table of search results
		if($result_count != 0)
		{
			echo "<table class='zui-table zui-table-rounded'>
					<thead>
						<tr>
							<th>Title</th>
							<th>Crew</th>
							<th>Genre</th>
							<th>Release Date</th>
							<th>Duration</th>
							<th>Tags</th>
						</tr>
					</thead>
					<tbody>";
			while($row = mysqli_fetch_assoc($result))
			{
				echo "
					<tr>
						<td><a href='movie-page.php?movieid={$row['movieid']}'>{$row['title']}</a></td>";
				$crewQuery = "SELECT C.FirstName,C.LastName from crew C, movie M, moviecrews MC WHERE M.movieid = MC.movieid AND C.crewid = MC.crewid AND M.movieid = {$row['movieid']}";
				$crew = mysqli_query($db_connection,$crewQuery);
				echo "<td>";
				while($crewRow = mysqli_fetch_assoc($crew))
				{
					echo "{$crewRow['FirstName']} {$crewRow['LastName']}<br>";
				}
				echo "</td>";

				$genreQuery = "SELECT G.genre_name FROM movie M, genres G, moviegenres MG WHERE M.movieid = MG.movieid AND G.genreid = MG.genreid AND M.movieid = {$row['movieid']}";
				$genre = mysqli_query($db_connection,$genreQuery);
				echo "<td>";
				while($genreRow = mysqli_fetch_assoc($genre))
				{
					echo "{$genreRow['genre_name']}<br>";
				}
				echo "</td>";

				echo "<td>{$row['release_date']}</td>";
				echo "<td>{$row['duration']} minutes</td>";

				$tagQuery = "SELECT T.tagdata FROM movie M, tags T WHERE M.movieid = T.movieid AND M.movieid = {$row['movieid']}";
				$tags = mysqli_query($db_connection,$tagQuery);
				echo "<td>";
				while($tagRow = mysqli_fetch_assoc($tags))
				{
					echo "{$tagRow['tagdata']}<br>";
				}
				echo "</td>
					</tr>";
			}

			echo "</tbody></table>";

		}

		
	}
		
	include('universalFunctions.php');
	session_start();
	
	userLinks();
	echo "<br>"; 
	
	// remember the page the user is on; the way, if they sign in, we can redirect back to this page after signing in
	if(isset($_GET['search_query']))
	{
		$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']) . "?search_query={$_GET['search_query']}";
	}
	else
	{
		$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']);
	}
	
	// connects to database
	$db_connection = connectToDatabase();
	if($db_connection)
	{
			// draw search box
			echo "
			<div class='searchBar'><form action='search.php' method='GET'>
				Sort by: 
				<input type='radio' name='sort_by' value='title' checked='checked'>Title
				<input type='radio' name='sort_by' value='release_date'>Release Date
				<input type='radio' name='sort_by' value='duration'>Duration<br>
				Order:
				<input type='radio' name='order' value='ASC' checked='checked'>Ascending
				<input type='radio' name='order' value='DESC'>Descending<br>
				<input type='search' name='search_query' placeholder='Type search query here...'>
				<button type='submit'>Search</button>
			</form></div>";
			if(isset($_GET['search_query']))
			{
				$validCriteria = array("title","release_date","duration");
				$validOrder = array("ASC","DESC");
				$filterCheck = isset($_GET['sort_by']) && isset($_GET['order']) && in_array($_GET['sort_by'],$validCriteria) &&  in_array($_GET['order'],$validOrder);
				if(!$filterCheck)
				{
					$_GET['sort_by'] = 'title';
					$_GET['order'] = 'ASC';
				}
				echo "Searching for \"{$_GET['search_query']}\":<br><br>";
				doSearch($db_connection);	
			}	
	}
?>
	</body>
</html>