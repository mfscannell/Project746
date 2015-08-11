<?php
	function register($db_connection, $person, $password){
		
		//isExistingPerson is a function in msma-amp_db_utilities.php, included in login.php.
		if(isExistingPerson($db_connection, $person)){
			return ("Account ".$person." is already registered.");
		}
		else{

			$email = getEmail();

			$ch=curl_init("http://www.random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new");	
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response=curl_exec($ch);
			curl_close($ch);
		
			$salt=$response;		
			
			$hashpassword = hash("sha512",$password.$salt);
			
			$sql = "INSERT INTO person (Name, Email, Password, Salt) VALUES ('$person','$email','$hashpassword','$salt')";
		
			if (!mysqli_query($db_connection,$sql))
			{
				die('Error: ' . mysqli_error($db_connection));
			}
			else{
				echo "You have been successfully registered.";
				$_SESSION['person_name']=$person;
				header('Location: index.php');
			}
		}
	}
	
	function getEmail(){
		$email = "test";
		return $email;
	}
?>