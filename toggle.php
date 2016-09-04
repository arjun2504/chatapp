<?php
	session_start();
	$me = $_SESSION['username'];
	require_once('db.php');
	$stat = $_POST['toggle'];
	$con->query("UPDATE chat SET message = '$stat' WHERE usr = '$me'");
?>