<?php
	require_once('db.php');
	session_start();
	$me = $_SESSION['username'];
	if($_SESSION['username']) {
		$con->query("UPDATE chat SET t = NOW() WHERE usr = '$me'");
		$con->query("DELETE FROM chat WHERE t <= NOW() - INTERVAL 10 MINUTE");
	$activeq = $con->query("SELECT usr, message FROM chat WHERE usr <> '$me' AND message <> 'offline' GROUP BY usr ORDER BY t DESC");
	while($activer = $activeq->fetch_array(MYSQLI_BOTH)) {
?>
<a style="color: #434a54" href="chat.php?usr=<?php echo $activer['usr']; ?>&tab=active" id="<?php echo '_'.$activer['usr']; ?>" onclick="<?php echo '_'.$activer['usr']; ?>()" class="spplthumb" data-user="<?php echo $activer['usr']; ?>">
<li>
	<?php
		$dp = $con->query("SELECT avatar FROM users WHERE username = '$activer[usr]'");
		$pic = $dp->fetch_array(MYSQLI_BOTH);
	?>
	<div class="pplthumb"><img src="dp/<?php echo $pic['avatar']; ?>"></div>
	<div class="pplname"><?php echo $activer['usr']; ?><br><font color="gray"><?php echo $activer['message']; ?></font></div>
	<div class="chatstart"><span class="glyphicon glyphicon-comment"></span><p></p><span style="margin-top:0px"><center><?php if($activer['message'] == 'online') echo "<font color='#5CE62E'>●</font>"; else if($activer['message'] == 'busy')  echo "<font color='red'>●</font>"; ?></center></span></div>
</li>
</a>
<script>
	/*function <?php echo "_".$activer['usr']; ?>() {
		$(this).click(function(e) {
			var ur = $("#<?php echo '_'.$activer['usr']; ?>").attr("href");
			
		    $("body").load(ur);
		    return false;

		});
	}*/
</script>
<?php } } ?>