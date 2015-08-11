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
		$db_connection = new mysqli("localhost","root",null,"msma-amp");
	
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
		
		if (!mysqli_query($db_connection,$sql))
		{
			die('Error: ' . mysqli_error($db_connection));
		}
		else{
			$result=mysqli_query($db_connection,$sql);
			$row=mysqli_fetch_array($result);
			if(is_null($row)){
				$count=0;
			}
			else{
				$count=array_count_values($row);
			}
			return $count;
		}
	}
	
	function isMovieInInterestedTable($db_connection, $movieTitle, $movieYear, $personName) {
		$sql = "SELECT * FROM interestedIn WHERE Title='$movieTitle' AND Year = '$movieYear' AND PersonName = '$personName'";
		
		if (!mysqli_query($db_connection, $sql)) {
			die('Error: ' . mysqli_error($db_connection));
		} else{
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
	
	function getAllMovies($db_connection) {
		$sql = "SELECT * FROM movie";
		$result = mysqli_query($db_connection,$sql);
		//$row = mysqli_fetch_array($result);
		return $result;
	}
?>