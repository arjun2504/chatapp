<?php
	session_start();
	if(isset($_SESSION['username'])) {
		require_once('db.php');
		$from = $_SESSION['username'];
		$to = $_POST['to'];

		$msg = "BUZZ!";
		
		
		$ccheck = $con->query("SELECT * FROM convo WHERE (usr1 = '$from' AND usr2 = '$to') OR (usr1 = '$to' AND usr2 = '$from')");
		if($ccheck->num_rows == 0) {
			$con->query("INSERT INTO convo (usr1, usr2) VALUES ('$from','$to')");
		}
		
		$getcid = $con->query("SELECT cid FROM convo WHERE (usr1 = '$from' AND usr2 = '$to') OR (usr1 = '$to' AND usr2 = '$from') LIMIT 1");
		$cid = $getcid->fetch_array(MYSQLI_NUM);
		$con->query("INSERT INTO messages (fuser, tuser, msg, cid, t) VALUES ('$from', '$to', '$msg',$cid[0], NOW())");
		
		$getTime = $con->query("SELECT t FROM messages WHERE fuser = '$from' AND tuser = '$to' AND cid = '$cid[0]' ORDER BY mid DESC LIMIT 1");
		$time = $getTime->fetch_array(MYSQLI_NUM);
		
		$con->query("UPDATE convo SET t = '$time[0]' WHERE (usr1 = '$from' AND usr2 = '$to') OR (usr1 = '$to' AND usr2 = '$from')");
	}
	else {
		header("Location: index.php");
	}
?>