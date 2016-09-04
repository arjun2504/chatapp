<?php
	session_start();
	if(isset($_SESSION['username'])) {
		require_once('db.php');
		$me = $_SESSION['username'];
		$unrq = $con->query("SELECT COUNT( mid ) FROM messages WHERE tuser = '$me' AND receipt = 'unread'");
		$unr = $unrq->fetch_array(MYSQLI_NUM);
		if($unr[0] > 0)
			echo "<span class='badge' style='background-color: #f36750'>$unr[0]</span>";
		else
			echo "<span class='glyphicon glyphicon-time'></span>";
	}
	else {
		header("Location: index.php");
	}
?>