<?php
//function from: http://www.w3schools.com/php/php_form_validation.asp
function cleanData($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
 }
 ?>