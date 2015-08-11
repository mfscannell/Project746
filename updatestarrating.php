<?php
	session_start();
	
	if (!isset($_SESSION['movie_update'])) {
		$_SESSION['movie_update'] = htmlspecialchars($_GET["movie"]);
		$_SESSION['movie_update_year'] = htmlspecialchars($_GET["year"]);
	}
			
	$movie = $_SESSION['movie_update'];
	$year = $_SESSION['movie_update_year'];
			
	if (isset($_SESSION['person_name'])) {
		$personName = $_SESSION['person_name'];
			
		if (isset($_POST['submit'])) {
			include 'msma-amp_db_utilities.php';
			$db_connection = connectDB();
		
			if ($_POST['submit'] == "Submit New Rating") {
				$newrating = $_POST["newrating"];
				updateStarRating($db_connection, $movie, $year, $personName, $newrating);
			}
			header('Location:watched.php');
		} else {
			include 'updatestarrating.html';
		}
	} else {
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(