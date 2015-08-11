<?php
	/*
		11/24/13
		Description:
			This function provides a form to the user for login, with option to register as a new user.
			Upon login or new registration, the session variable 'person_name' is set to the username entered in the form.
	*/

	//Include utilities for sanitizing and standardizing data. We will sanitize data for use with SQL and HTML
	include('data_utilities.php');
	
	//Upon post, reset form if required fields are not populated.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$error = 0;
		$person = cleanData($_POST["person"]);
		$password = cleanData($_POST["password"]);
		
		if ($person == "") {
			//print("You did not provide your name. ");
			echo "<script type='text/javascript'>
				alert('Hello');
			</script>";
			$error=1;
		}
		
		if ($password == "") {
			print("You did not provide your password. ");
			$error=1;
		}
		
		if ($error == 1){
			unset($_POST);
		}
	}

	//If post was submitted and complete, connect database and perform selected action (register new user or login existing user).
	//If post is set, show form to collect name and password from user.
	if (isset($_POST['submit'])) {
	
		include 'msma-amp_db_utilities.php';
		$db_connection = connectDB();
		
		if ($_POST['submit'] == "New User") {
			include 'register.php';
			echo(register($db_connection, $person, $password));
		} else if ($_POST['submit'] == "Login") {
			include 'perform_login.php';
			performLogin($db_connection, $person, $password);		
		}
		include 'logonform.html';
		unset($_POST);
	} else {
		include 'logonform.html';
	}
?>
