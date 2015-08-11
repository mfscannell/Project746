<?php
//	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
//		$uri = 'https://';
//	} else {
//		$uri = 'http://';
//	}
//	$uri .= $_SERVER['HTTP_HOST'];
//	header('Location: '.$uri.'/navigation.html');
	session_start();
	if (isset($_SESSION['person_name'])){
		include 'navigation.html';
	} else {
		include 'login.php';
	}
	exit;
?>
Something is wrong with the website :-(
