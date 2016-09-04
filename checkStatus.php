<?php
	$usr = $_GET['usr'];
	session_start();
	if(isset($_SESSION['username'])) {
		require_once('db.php');
		$sq = $con->query("SELECT message FROM chat WHERE usr = '$usr'");
		$sa = $sq->fetch_array(MYSQLI_BOTH);
		if($sq->num_rows == 0 || $sa['message'] == 'offline')
			echo "offline";
		else if($sa['message'] == 'online')
			echo "<font color='#5CE62E'>●</font> ".$sa[0];
		else if($sa['message'] == 'busy')
			echo "<font color='red'>●</font> ".$sa[0];
		else
			echo "offline";
	}
?>