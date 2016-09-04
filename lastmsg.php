<?php
		session_start();
	if(isset($_SESSION['username'])) {
	require_once('db.php');
	$u = $_SESSION['username'];
	$with = $_GET['usr'];
	$q = $con->query("SELECT msg FROM messages WHERE (fuser = '$with' AND tuser = '$u') ORDER BY mid DESC LIMIT 1")->fetch_array(MYSQLI_NUM);
	echo $q[0];
	}
	else {
		header("Location: index.php");
	}
?>