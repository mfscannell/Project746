<?php
	session_start();
	if(isset($_SESSION['person_name'])) {
		include 'msma-amp_db_utilities.php';
		$db_connection = connectDB();

		$allActors = getAllActors($db_connection);
		$allDirectors = getAllDirectors($db_connection);
		
		$searchResults = getAllMovies($db_connection);
		
		if(isset($_POST['formSubmit'])) {
			//get form data
			$selectActor = $_POST['formSelectActor'];
			$selectDirector = $_POST['formSelectDirector'];
			
			if($selectActor==''){
				if($selectDirector==''){
				}
				else{
					$searchResults = getDirectorMovies($db_connection, $selectDirector);
				}
			}
			else{
				if($selectDirector==''){
					$searchResults = getActorMovies($db_connection, $selectActor);
				}
				else{
					$searchResults = getActorDirectorMovies($db_connection, $selectActor, $selectDirector);
				}
			}
			
			include('findrecommended.html');
		}
		else{
			$selectActor = '';
			$selectDirector = '';
			include('findrecommended.html');
		}
	}
	else{
		header('Location:index.php');
	}
	exit;
?>

Something is wrong with the website :-(
