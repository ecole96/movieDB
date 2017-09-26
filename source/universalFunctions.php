<?php

	// universal functions for webpages

	// connects to database checking for failure (not always used - this is implemented in other functions in special cases)
	function connectToDatabase()
	{
		$db_connection = mysqli_connect("localhost","root",NULL,"movieDB");
		// database connection fails
		if(!$db_connection)
		{
			// take out the specific connection error message later - we don't want to give users too much information
			echo "ERROR: Server failed to connect to database - " . mysqli_connect_error() . "<br><br>";
			return NULL;
		}
		else
		{
			return $db_connection;
		}
	}

	// checks if user is signed in and displays the appropriate links 
	// (if signed in -> User Page, Manager Users (if a manager), Logout; if not -> Sign In, Register)
	function userLinks()
	{
		// check if user is signed in; if they are, display name and log out buttons. if not, display sign in and register buttons
		$session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
		echo "<div class='navBar'>";
		echo "<ul>";
		if($session_check)
		{
			echo "<div class='others'><li><a href='user-page.php'>{$_SESSION['username']}</a></li>";
			echo "<li><a href='watchlist.php'>Watchlist</a></li>";
			if($_SESSION['permission_id'] == 1)
			{
				echo "<li><a href=manager-page.php>Manager Settings</a></li>";
			}
			echo "<li><a href=logout.php>Log Out</a></li></div>";
		}
		else
		{
			echo "<div class='others'>
					<li><a href='sign-in.php'>Sign In</a></li>
					<li><a href='register.php'>Register</a></li>
				</div>";
		}
		echo "<div class='home'><li><a href='home.php'>MovieDB</a></li></div></div>";
		echo "</ul></div>";
	}

	// get a string that displays the number of X. Used to display how many reviews/scores/users/etc. there are
	function getCountString($result_count,$type)
		{
			if($result_count == 0)
			{
				$countStr = "No $type". 's';
			}
			else
			{
				if($result_count == 1)
				{
					$countStr = $result_count . ' ' . $type;
				}
				else
				{
					$countStr = $result_count . ' ' . $type . 's';
				}
			}
			return $countStr;
		}

	// builds a dropdown select box for rating a movie from 1-10
	// if user has already rated a movie, then that rating ($defaultRating) will be the pre-selected option in the box
	function generateRatingDropdown($defaultRating)
	{
		$dropdown = "<select name='rating'>";
		for($i = 1; $i <= 10; $i++)
		{
			$dropdown .= "
							<option value=$i";
			if($defaultRating == $i)
			{
				$dropdown .= " selected";
			}
			$dropdown .= ">$i</option>";
		}
		$dropdown .= '
					</select>';
		return $dropdown;
	}

	// checks if user has already scored (but not necessarily reviewed) a movie
	// since a user can score a movie without reviewing it
	function userHasScored($db_connection,$movieid)
	{
		
		$query = "SELECT DISTINCT U.userid FROM db_user U, score_and_reviews S WHERE U.userid = S.userid AND S.movieid = $movieid AND U.username = '{$_SESSION['username']}'";
		$result = mysqli_query($db_connection,$query);
		if(mysqli_num_rows($result) == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}

	// checks if a user has already reviewed a movie
	// since a user can score a movie without reviewing it
	function userHasReviewed($db_connection,$movieid)
	{
		$query = "SELECT DISTINCT U.userid FROM db_user U, score_and_reviews S WHERE U.userid = S.userid AND S.movieid = $movieid AND U.username = '{$_SESSION['username']}' AND S.review IS NOT NULL";
		$result = mysqli_query($db_connection,$query);
		if(mysqli_num_rows($result) == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}

	// returns userid based on username
	function getUserID($db_connection)
	{
		$query = "SELECT userid FROM db_user WHERE username = '{$_SESSION['username']}'";
		$result = mysqli_query($db_connection,$query);
		$row = mysqli_fetch_assoc($result);
		return $row['userid'];

	}

	// helper function for populateGenreBox
	function movie_in_genre($db_connection,$movieid,$genreid)
	{
		$query = "SELECT * FROM moviegenres NATURAL JOIN genres WHERE movieid = $movieid AND genreid = $genreid";
		$result = mysqli_query($db_connection,$query);
		if(mysqli_num_rows($result) == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// for adding/editing films: populates a multi-select box with genres in the database
	function populateGenreBox($db_connection,$mode,$movieid)
	{
		$genreBox = "<select multiple name='genres[]' style='width:200px;height:200px;font-size:14px'>";
		$query = "SELECT genreid, genre_name FROM genres";
		$result = mysqli_query($db_connection,$query);
		while($row = mysqli_fetch_assoc($result))
		{
			$genreBox .= "
							<option value='{$row['genre_name']}'";
			if($mode == 'edit' && movie_in_genre($db_connection,$movieid,$row['genreid']))
			{
				$genreBox .= " selected";
			}
			$genreBox .= ">{$row['genre_name']}</option>";
		}
		$genreBox .= "
					</select>";
		return $genreBox;
	}

	function validFilmSubmission($db_connection)
	{
		$loginCheck = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
		if($loginCheck)
		{
			if($_SESSION['permission_id'] != 1)
			{
				echo "ERROR: Must be a manager to see this page.";
				return false;
			}
			if(empty($_POST['title']) || empty($_POST['summary']) || empty($_POST['release_date']) || empty($_POST['lang']) || empty($_POST['duration']))
			{
				echo "All required fields must be entered.";
				return false;
			}
			if(!empty($_POST['newGenre']))
			{
				$query = "SELECT * FROM genres WHERE genre_name = '{$_POST['newGenre']}'";
				$result = mysqli_query($db_connection,$query);
				if(mysqli_num_rows($result) != 0)
				{
					echo "\"New Genre\" entry must not be the same as any genre in the \"Genres\" box.<br>";
					return false;
				}
			}
			return true;
		}
		else
		{
			echo "ERROR: Must be logged in to see this page.<br>";
			return false;
		}
	}


	function addGenres($db_connection,$movieid,$mode)
	{
		if($mode == 'existing')
		{
			foreach($_POST['genres'] as $genre)
			{
				$genreIDQuery = "SELECT genreid FROM genres WHERE genre_name = '$genre'";
				$IDresult = mysqli_query($db_connection,$genreIDQuery);
				$row = mysqli_fetch_assoc($IDresult);
				$genreid = $row['genreid'];

				$query = "INSERT INTO moviegenres(movieid,genreid) VALUES ($movieid,$genreid)";
				$result = mysqli_query($db_connection,$query);
			}
		}
		else
		{
			$genreQuery = "INSERT INTO genres(genre_name) VALUES ('{$_POST['newGenre']}')";
			$insertGenre = mysqli_query($db_connection,$genreQuery);
			
			$genreid = mysqli_insert_id($db_connection);
			$query = "INSERT INTO moviegenres(movieid, genreid) VALUES($movieid, $genreid)";
			$result = mysqli_query($db_connection,$query);

		}
	}

	function isManager()
			{
				$loginCheck = $session_check = isset($_SESSION['logged_in']) && isset($_SESSION['username']) && isset($_SESSION['permission_id']);
				if($loginCheck)
				{
					if($_SESSION['permission_id'] != 1)
					{
						echo "Must be a manager.<br>";
						return false;
					}
					else
					{
						return true;
					}
				}
				else
				{
					echo "Must be logged in.";
					return false;
				}

			}

?>