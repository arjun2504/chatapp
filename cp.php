<?php
	session_start();
	if(isset($_SESSION['username'])) {
		$me = $_SESSION['username'];
		require_once('db.php');
		$q = $con->query("SELECT password FROM users WHERE username = '$me'");
		$r = $q->fetch_array(MYSQLI_NUM);
		$op = md5($_POST['op']);
		$np1 = $_POST['np1'];
		$np2 = $_POST['np2'];
		if(($op == $r[0]) && ($np1 == $np2) && !empty($np1) && !empty($np2)) {
			$encpass = md5($np1);
			$con->query("UPDATE users SET password = '$encpass' WHERE username = '$me'");
			header("Location: chat.php");
		}
		else {
			header("Location: index.php?mode=cp&error=1");
		}
	}
	else {
		header("Location: index.php");
	}
?>