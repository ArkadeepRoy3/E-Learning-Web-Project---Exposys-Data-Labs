<?php 
	
	// if direct access to this page
if(preg_match("/config.php/",$_SERVER['SCRIPT_FILENAME'])){
	die("Access denied: Please leave.");
}

	$connection = mysqli_connect('localhost','root','','exceptional') or die("Database Not connected".mysqli_connect_error());
	session_start();
 ?>