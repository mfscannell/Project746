<?php

	session_start();
	
	$movie=htmlspecialchars($_GET["movie"]);
	$year=htmlspecialchars($_GET["year"]);

	if(isset($_SESSION['person_name'])) {
	
			//get data to display in HTML layout
			include 'msma-amp_db_utilities.php';
			$db_connection = connectDB();
			
			$allMovieActors = getMovieActors($db_connection, $movie, $year);
			$allMovieDirectors = getMovieDirectors($db_connection, $movie, $year);
			$movieDetail = getMovie($db_connection, $movie, $year);

			$averageRating = getMovieAvgRating($db_connection, $movie, $year);
			
			//display the data
			include('moviedetails.html');
	}

	else{
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(