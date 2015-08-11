<?php

	session_start();
	if(isset($_SESSION['person_name'])) {
		
			$personName = $_SESSION['person_name'];

			include('msma-amp_db_utilities.php');			
			$db_connection = connectDB();
			
			$allInterested = getInterestedInList($db_connection, $personName);
			
			include 'interestedin.html';
			
		}

	else{
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(