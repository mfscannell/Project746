<?php
	/*
		11/24/13
		Description:
			When user logs out, destroy the current session and variables.
	*/
	session_start();
	session_unset();
    session_destroy();
    session_write_close();
	header("location:index.php");
?>