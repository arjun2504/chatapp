<?php
	session_start();
	$sid = session_id();
	require_once('db.php');
	$me = $_SESSION['username'];
	$con->query("DELETE FROM chat WHERE usr = '$me'");
	session_destroy();
	header("Location: index.php");
?>