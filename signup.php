<?php
	$e = $_POST['e'];
	$u = $_POST['u'];
	$p1 = md5($_POST['p1']);
	$p2 = md5($_POST['p2']);
	require_once('db.php');
	$checku = $con->query("SELECT username FROM users WHERE username = '$u'");
	if(($p1 == $p2) && ($checku->num_rows == 0)) {
		require_once('db.php');
		$con->query("INSERT INTO users (username, password, email, avatar) VALUES ('$u','$p1','$e','default.png')");
		session_start();
		$_SESSION['username'] = $u;
		header("Location: chat.php");
	}
	else {
		header("Location: index.php?err=2");
	}
?>