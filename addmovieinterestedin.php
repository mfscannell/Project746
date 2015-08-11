<?php
	session_start();
	if (isset($_SESSION['person_name'])) {
		$personName = $_SESSION['person_name'];
	
		include 'msma-amp_db_utilities.php';
		$db_connection = connectDB();
		
		if (isset($_POST['formSubmit'])) {
			$addInterested = $_POST['formAddInterested'];
			if (empty($addInterested)) {
				echo("You didn't select any movies.");
			} else {
				$N = count($addInterested);
				echo("You selected ".$N." movie(s):<br>");
				$addedMovies = 0;
				
				for ($i = 0; $i < $N; $i++) {
					$movie = explode('|||', $addInterested[$i]);					
					$movieTitle = $movie[0];
					$movieYear = $movie[1];
					echo("Adding " . $movie[0] . " (" . $movie[1] . ")");
					
					$result = addInterestedInMovie($db_connection, $movieTitle, $movieYear, $personName);
					if ($result) {
						$addedMovies++;echo(" ... Success!<br>");
					} else {
						echo(" ... Failed!<br>");
					}
				}
				echo('Successfully added '.$addedMovies.' movies to your list.<br>');
				unset($_POST);
				$allMovies = getAllMoviesNotInInterestedTable($db_connection, $personName);
				include 'addmovieinterestedin.html';
			}
		} else {
			$allMovies = getAllMoviesNotInInterestedTable($db_connection, $personName);
			include 'addmovieinterestedin.html';
		}
	} else {
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(
