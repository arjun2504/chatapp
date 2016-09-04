<?php
	session_start();
	if(isset($_SESSION['username'])) {
		$meh = $_SESSION['username'];
		$usr = $_GET['usr'];
		require_once('db.php');
		$quer = "SELECT * FROM messages WHERE (fuser = '$meh' AND tuser = '$usr') OR (tuser = '$meh' AND fuser = '$usr')";
		$qw = $con->query($quer);
		while($r1 = $qw->fetch_array(MYSQLI_BOTH)) {
			if($r1['fuser'] == $meh) {
				$con->query("UPDATE messages SET del1 = '1' WHERE fuser = '$meh' AND tuser = '$r1[tuser]'");
			}
			else {
				$con->query("UPDATE messages SET del2 = '1' WHERE tuser = '$meh' AND fuser = '$r1[fuser]'");
			}
			
			if($r1['del1'] == '1' && $r1['del2'] == '1') {
				$con->query("DELETE FROM messages WHERE (fuser = '$meh' AND tuser = '$usr') OR (fuser = '$usr' AND tuser = '$meh')");
			}
		}
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
	else {
		header("Location: index.php");
	}
?>