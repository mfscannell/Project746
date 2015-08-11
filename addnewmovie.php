<?php
	session_start();
	if(isset($_SESSION['person_name'])) {
	
		$personName = $_SESSION['person_name'];
	
		include 'msma-amp_db_utilities.php';
		$db_connection = connectDB();
		
		if(isset($_POST['formSubmit'])) {
		
			//turn off notices in case of empty select array for actors or directors
			error_reporting (E_ALL ^ E_NOTICE);
		
			//get form data
			$addActors = $_POST['formAddActors'];
			$addDirectors = $_POST['formAddDirectors'];
			$addMovieTitle = $_POST['formAddMovieTitle'];
			$addMovieYear = $_POST['formAddMovieYear'];
			$addGenre = $_POST['formAddGenre'];
			$addTextActors = $_POST['formTextAddActors'];
			$addTextDirectors = $_POST['formTextAddDirectors'];
			$addPremise= $_POST['formAddPremise'];

			$error=0;
			
			if(empty($addActors)) {
				$errActors=1;
				for($i = 0; $i < count($addTextActors); $i++){
					if(!empty($addTextActors[$i])){$errActors=0;}
				}

				if($errActors==1){
					$error=1;
					echo("You didn't select any actors.<br>");
				}
			}
			
			if(empty($addDirectors)) {
				$errDirectors=1;
				for($i = 0; $i < count($addTextDirectors); $i++){
					if(!empty($addTextDirectors[$i])){$errDirectors=0;}
				}

				if($errDirectors==1){
					$error=1;			
					echo("You didn't select any directors.<br>");
				}
			}

			if(empty($addMovieTitle)) {
				echo("You need to enter a movie title.<br>");
				$error=1;
			}

			if(empty($addMovieYear)) {
				echo("You need to specify the movie year.<br>");
				$error=1;
			}
			
			if(empty($addGenre)) {
				echo("You didn't select a genre.<br>");
				$error=1;
			}

			if($error==1){
				$allActors = getAllActors($db_connection);
				$allDirectors = getAllDirectors($db_connection);
				include 'addnewmovie.html';	
			}
			else {
				$sqlerror=0;
				
				//add the movie details
				addNewMovie($db_connection,$addMovieTitle,$addMovieYear,$addGenre,$addPremise);
				
				//add any related actors or directors that are not in the database
				//then add to movie's actor or director list
				
				//TODO: collect this data on form
				$YearsActing = 1;
				$YearsDirecting = 1;
				$addRole = "need to implement adding roles";
				
				//add free text entered actors
				for ($i = 0; $i < count($addTextActors); $i++) {
					if(!empty($addTextActors[$i])){
						addActor($db_connection,$addTextActors[$i],$YearsActing);
						addActorToMovie($db_connection,$addTextActors[$i],$addMovieTitle,$addMovieYear, $addRole);
					}
				}
				
				//add free text entered directors
				for ($i = 0; $i < count($addTextDirectors); $i++) {
					if(!empty($addTextDirectors[$i])){
						addDirector($db_connection,$addTextDirectors[$i],$YearsDirecting);
						addDirectorToMovie($db_connection,$addTextDirectors[$i],$addMovieTitle,$addMovieYear);					
					}
				}
				
				//add select input selected actors
				if(!empty($addActors)){
				echo('select actors');
					$numActors = count($addActors);
					for ($i = 0; $i < $numActors; $i++) {
						addActorToMovie($db_connection,$addActors[$i],$addMovieTitle,$addMovieYear, $addRole);
					}
				}

				//add select input selected directors
				if(!empty($addDirectors)){
				echo('select directors');
					$numDirectors = count($addDirectors);
					for ($i = 0; $i < $numDirectors; $i++) {
						addDirectorToMovie($db_connection,$addDirectors[$i],$addMovieTitle,$addMovieYear);					
					}
				}

				unset($_POST);
				header('Location:addmovieinterestedin.php');
			}
		}
		else{
			$allActors = getAllActors($db_connection);
			$allDirectors = getAllDirectors($db_connection);
			
			include 'addnewmovie.html';
		}
	}
	else{
		header('Location:index.php');
	}

	exit;
?>

Something is wrong with the website :-(
