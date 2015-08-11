<?php
	session_start();
	if (isset($_SESSION['person_name'])) {
		if (isset($_SESSION['movie_update'])) {
			unset($_SESSION['movie_update']);
			unset($_SESSION['movie_update_year']);
		}
		
		$personName = $_SESSION['person_name'];
		include('msma-amp_db_utilities.php');			
		$db_connection = connectDB();
		$allWatched = getWatchedList($db_connection, $personName);
		include 'watched.html';
	} else {
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(