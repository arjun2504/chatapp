<?php
	require_once('db.php');
	session_start();
	$u = $_SESSION['username'];
	$with = $_GET['usr'];
	$q = $con->query("SELECT * FROM messages WHERE (fuser = '$u' AND tuser = '$with') OR (fuser = '$with' AND tuser = '$u')");
	while($r = $q->fetch_array(MYSQLI_BOTH)) {
?>

<?php

	if($r['fuser'] == $with) {
		if($r['del2'] == 1) continue;

?>
<div class="fmsg">
	<?php
		$dp = $con->query("SELECT avatar FROM users WHERE username = '$with'");
		$pic = $dp->fetch_array(MYSQLI_BOTH);
		$con->query("UPDATE messages SET receipt = 'read' WHERE fuser = '$with' AND tuser = '$u'");
		if($r['msg'] != "BUZZ!") {
	?>
	<div class="thumb"><img src="dp/<?php echo $pic['avatar']; ?>" title="<?php echo $r['fuser']; ?>"></div>
	<div class="bubble"><?php echo $r['msg']; ?></div>
	<?php
	}
	else {
		?>
		<div class="longwid">
		<center><b><font color="#FF9999"><span class="glyphicon glyphicon-bullhorn"></span> <?php echo $r['fuser']; ?> sent you a BUZZ!</font></b></center>
		</div>
		<?php
	}	?>
</div>
<div style="clear:both"></div>
<?php } ?>

<?php
	if($r['fuser'] == $u) {
		if($r['del1'] == 1) continue;
?>
<div class="umsg">
	<?php
		$dp = $con->query("SELECT avatar FROM users WHERE username = '$u'");
		$pic = $dp->fetch_array(MYSQLI_BOTH);
		if($r['msg'] != "BUZZ!") {
	?>
	<div class="thumb"><img src="dp/<?php echo $pic['avatar']; ?>" title="You"></div>
	<div class="bubble"><?php echo $r['msg']; ?></div>
	<?php
	}
	else {
		?>
		<div class="longwid">
		<center><b><font color="#FF9999"><span class="glyphicon glyphicon-bullhorn"></span> you sent a BUZZ!</font></b></center>
		</div>
		<?php
	}	?>
</div>
<div style="clear:both"></div>
<?php } } ?>