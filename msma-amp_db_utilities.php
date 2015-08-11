<?php
	/*
		11/24/13
		Description:
			This PHP file contains various functions to connect and manipulate the MSMA-AMP database
	*/
	
	//IMPORTANT: uncomment production database before uploading to production web server.
	//Connects to application database and returns the connection to the application.
	function connectDB(){
	
		//Specify connection string arguments for local application development.
		$db_connection = new mysqli("localhost", "root", null, "msma-amp");
	
		//Specify connection string arguments for 000webhost application web hosting.
		//$db_connection = new mysqli("mysql5.000webhost.com","a7109964_eecs746","nots3cure","a7109964_eecs746");
	
		//Return error if unable to connect.
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
		return $db_connection;
	}
	
	/*
		Checks if person about to be added is already in the database.
		Since person is a key there will be either 0 or 1 row returned.
		0 = no person exists, 1 = person exists
	*/
	function isExistingPerson($db_connection, $person){
		$sql = "SELECT * FROM person WHERE Name='$person'";
		
		if (!mysqli_query($db_connection,$sql)) {
			die('Error: ' . mysqli_error($db_connection));
		} else {
			$result=mysqli_query($db_connection,$sql);
			$row=mysqli_fetch_array($result);
			if (is_null($row)) {
				$count=0;
			} else{
				$count=array_count_values($row);
			}
			return $count;
		}
	}
	
	function isMovieInInterestedTable($db_connection, $movieTitle, $movieYear, $personName) {
		$sql = "SELECT * FROM interestedIn WHERE Title='$movieTitle' AND Year = '$movieYear' AND PersonName = '$personName'";
		
		if (!mysqli_query($db_connection, $sql)) {
			die('Error: ' . mysqli_error($db_connection));
		} else {
			$result = mysqli_query($db_connection,$sql);
			$row = mysqli_fetch_array($result);
			if (is_null($row)) {
				$movieExists = false;
			} else {
				$movieExists = true;
			}
			return $movieExists;
		}
	}

	function getMovieDirectors($db_connection, $movie, $year) {
		$sql = "SELECT DirectorName FROM directs WHERE MovieName='$movie' AND MovieYear='$year'";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}

	function getMovieActors($db_connection, $movie, $year) {
		$sql = "SELECT ActorName, Role FROM actsin WHERE MovieName='$movie' AND MovieYear='$year'";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}

	function getMovie($db_connection, $movie, $year) {
		$sql = "SELECT * FROM movie where Title='$movie' and Year='$year'";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}
	
	function getMovieAvgRating($db_connection, $movie, $year) {
		$sql = "SELECT AVG(StarRating) averageRating FROM watched where MovieName='$movie' and MovieYear='$year'";
		$result = mysqli_query($db_connection,$sql);
		$row = mysqli_fetch_array($result);
		
		if (is_null($row)) {
			$avg='No user ratings';
		}else {
			$avg=$row;
		}
		
		return $avg;
	}
	
	function getAllActors($db_connection) {
		$sql = "SELECT * FROM actor";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}

	function getAllDirectors($db_connection) {
		$sql = "SELECT * FROM director";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}
		
	function getAllMovies($db_connection) {
		$sql = "SELECT * FROM movie";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}
	
	function getAllMoviesNotInInterestedTable($db_connection,$personName) {
		$sql = "SELECT * FROM movie WHERE Title+Year NOT IN (SELECT MovieName+MovieYear FROM interestin WHERE PersonName = '$personName')";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}

	function getAllMoviesNotInWatchedTable($db_connection,$personName) {
		$sql = "SELECT * FROM movie WHERE Title+Year NOT IN (SELECT MovieName+MovieYear FROM watched WHERE PersonName = '$personName')";
		$result = mysqli_query($db_connection,$sql);
		return $result;
	}

	function addNewMovie($db_connection,$addMovieTitle,$addMovieYear,$addGenre,$addPremise) {
		$sql = "INSERT INTO movie (Title, Year, Genre, Premise) VALUES ('$addMovieTitle', '$addMovieYear', '$addGenre', '$addPremise')";
		$result = mysqli_query($db_connection, $sql);
		return $result;
	}

	function addActorToMovie($db_connection,$addActor,$addMovieTitle,$addMovieYear, $addRole) {
		$sql = "INSERT INTO actsin (ActorName, MovieName, MovieYear, Role) VALUES ('$addActor', '$addMovieTitle', '$addMovieYear', '$addRole')";
		$result = mysqli_query($db_connection, $sql);
		return $result;
	}

	function addDirectorToMovie($db_connection,$addDirector,$addMovieTitle,$addMovieYear) {
		$sql = "INSERT INTO directs (DirectorName, MovieName, MovieYear) VALUES ('$addDirector', '$addMovieTitle', '$addMovieYear')";
		$result = mysqli_query($db_connection, $sql);
		return $result;
	}
	
	function addInterestedInMovie($db_connection, $movieTitle, $movieYear, $personName) {
		$sql = "INSERT INTO interestin (MovieName, PersonName, MovieYear) VALUES ('$movieTitle', '$personName', '$movieYear')";
		$result = mysqli_query($db_connection, $sql);
		return $result;
	}

	function addWatchedMovie($db_connection, $movieTitle, $movieYear, $personName, $starRating) {
		$sql = "INSERT INTO watched (MovieName, PersonName, MovieYear, StarRating) VALUES ('$movieTitle', '$personName', '$movieYear', '$starRating')";
		$result = mysqli_query($db_connection, $sql);
		return $result;
	}
	
	function getInterestedInList($db_connection, $personName) {
		$sql = "SELECT movie.Title, movie.Genre, movie.Year
				FROM interestin, movie
				WHERE interestin.PersonName = '$personName'
				AND interestin.MovieName = movie.Title
				AND interestin.MovieYear = movie.Year";
		$result = mysqli_query($db_connection, $sql);
		return $result;		
	}

	function getWatchedList($db_connection, $personName) {
		$sql = "SELECT movie.Title, movie.Genre, movie.Year, watched.StarRating
				FROM watched, movie
				WHERE watched.PersonName = '$personName'
				AND watched.MovieName = movie.Title
				AND watched.MovieYear = movie.Year";
		$result = mysqli_query($db_connection, $sql);
		return $result;		
	}
	
	function updateStarRating($db_connection, $movie, $year, $personName, $newrating) {
		$sql = "UPDATE watched SET StarRating='$newrating' WHERE MovieName='$movie' AND MovieYear='$year' AND PersonName='$personName'";
		$result = mysqli_query($db_connection, $sql);
		return $result;	
	}
	
	function addActor($db_connection, $addActor, $addYearsActing) {
		$sql = "INSERT INTO actor (Name, YearsActing) VALUES ('$addActor', '$addYearsActing')";
		$result = mysqli_query($db_connection, $sql);
		return $result;	
	}

	function addDirector($db_connection, $addDirector, $addYearsDirecting) {
		$sql = "INSERT INTO director (Name, YearsDirecting) VALUES ('$addDirector', '$addYearsDirecting')";
		$result = mysqli_query($db_connection, $sql);
		return $result;	
	}
	
	function getDirectorMovies($db_connection, $selectDirector) {
		$sql = "SELECT MovieName, MovieYear FROM directs WHERE DirectorName='$selectDirector'";
		$result = mysqli_query($db_connection, $sql);
		return $result;		
	}

	function getActorMovies($db_connection, $selectActor) {
		$sql = "SELECT MovieName, MovieYear, Role FROM actsin WHERE ActorName='$selectActor'";
		$result = mysqli_query($db_connection, $sql);
		return $result;		
	}

	function getActorDirectorMovies($db_connection, $selectActor, $selectDirector) {
		$sql = "SELECT actsin.MovieName, actsin.MovieYear FROM actsin, directs WHERE ActorName='$selectActor' AND
				DirectorName='$selectDirector' AND actsin.MovieName=directs.MovieName AND actsin.MovieYear=directs.MovieYear";
		$result = mysqli_query($db_connection, $sql);
		return $result;		
	}
?>