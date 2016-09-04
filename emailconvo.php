<?php
	session_start();
	if(isset($_SESSION['username'])) {
		require_once('db.php');
		$for = $_GET['usr'];
		$me = $_SESSION['username'];
		$q = $con->query("SELECT * FROM messages WHERE (fuser = '$me' AND tuser = '$for') OR (tuser = '$me' AND fuser = '$for') ORDER BY t");
		$str = "";
		while($r = $q->fetch_array(MYSQLI_BOTH)) {
			if($r['fuser'] == $for) {
				if($r['del2'] == 1) continue;
				$str .= $for.": ".$r['msg']."<br>";
			}
			if($r['fuser'] == $me) {
				if($r['del1'] == 1) continue;
				$str .= $me.": ".$r['msg']."<br>";
			}
		}
		$eq = $con->query("SELECT email FROM users WHERE username = '$me'");
		$email = $eq->fetch_array(MYSQLI_NUM);
		$subject = "Your chat conversation with ".$for;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		mail($email[0], $subject, $str, $headers);
		
		echo "<center>Chat transcript with ".$for." was successfully emailed to ".$email[0]."</center>";
	}
	else {
		header("Location: index.php");
	}
?>