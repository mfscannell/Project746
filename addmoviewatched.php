<?php
	session_start();
	if(isset($_SESSION['person_name'])) {
	
		$personName = $_SESSION['person_name'];
	
		include 'msma-amp_db_utilities.php';
		$db_connection = connectDB();
		
		if(isset($_POST['formSubmit'])) {
			$addWatched = $_POST['formAddWatched'];
			if(empty($addWatched)) {
				echo("You didn't select any movies.");
			} else {
				$N = count($addWatched);
				echo("You selected ".$N." movie(s):<br>");
				$addedMovies = 0;
				
				for ($i = 0; $i < $N; $i++) {
					$movie = explode('|||',$addWatched[$i]);					
					$movieTitle = $movie[0];
					$movieYear = $movie[1];
					$starRating = $_POST['newstarrating'.$i];
					
					echo("Adding " . $movie[0] . " (" . $movie[1] . ")");
					
					$result = addWatchedMovie($db_connection, $movieTitle, $movieYear, $personName, $starRating);
					if ($result) {
						$addedMovies++;
						echo(" ... Success!<br>");
					} else {
						echo(" ... Failed!<br>");
					}
				}
				echo('Successfully added '.$addedMovies.' movies to your list.<br>');
				unset($_POST);
				$allMovies = getAllMoviesNotInWatchedTable($db_connection, $personName);
				include 'addmoviewatched.html';
			}
		} else {
			$allMovies = getAllMoviesNotInWatchedTable($db_connection, $personName);
			include 'addmoviewatched.html';
		}
	} else {
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(
