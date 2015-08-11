<?php
	function performLogin($db_connection, $person, $password) {
		
		//isExistingPerson is a function in msma-amp_db_utilities.php, included in login.php.
		if (isExistingPerson($db_connection, $person)) {
			
			//Find person's salt in order to perform hash with password.
			$sql = "SELECT Salt FROM person WHERE Name='$person'";
			$result = mysqli_query($db_connection,$sql);
			$row = mysqli_fetch_array($result);
			$salt = $row[0];
			
			//Hash given password with salt.
			$hashpassword = hash("sha512", $password.$salt);
			
			//Check hash password is correct for given person.
			$sql = "SELECT * FROM person WHERE Name='$person' AND Password='$hashpassword'";
			$result = mysqli_query($db_connection,$sql);
			$row = mysqli_fetch_array($result);

			if (is_null($row)) {
				//No results in result set means person / hashed password specified does not match database.
				$passwordfailed=1;
			} else {
				//If a result match was found, then password is correct for given user.
				$passwordfailed=0;
			}
			
			if (!mysqli_query($db_connection,$sql)) {
				die('Error: ' . mysqli_error($db_connection));
			}
			
			if ($passwordfailed) {
				echo "Wrong password.  Try again.";
			} else {
				$_SESSION['person_name'] = $person;
				header('Location: index.php');
			}
		} else {
			echo "Account not registered.";
		}
	}
?>