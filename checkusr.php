<?php
	require_once('db.php');
	$u = $_GET['usr'];
	$getu = $con->query("SELECT username FROM users WHERE username = '$u'");
	if($getu->num_rows > 0) {
		echo "<font color='red'>Not available</font>";
	}
	else {
		echo "<font color='green'>Available</font>";
	}
?>