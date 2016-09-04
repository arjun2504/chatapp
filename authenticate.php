<?php
	require_once('db.php');
	$u = $_POST['u'];
	$p = md5($_POST['p']);
	
	$q = $con->query("SELECT * FROM users WHERE username = '$u' AND password = '$p'");
	if($q->num_rows == 1) {
		session_start();
		$data = $q->fetch_array(MYSQLI_BOTH);
		$_SESSION['username'] = $data['username'];
		
		$sid = session_id();
		$con->query("INSERT INTO chat VALUES ('$sid','$data[username]', NOW(), 'online')");
		header("Location: chat.php");
	}
	else {
		header("Location: index.php?e=1");
	}
?>