<?php
	session_start();
	$me = $_SESSION['username'];
	if(isset($_SESSION['username'])) {
		require_once('db.php');
	$q = $con->query("SELECT * FROM convo WHERE (usr1 = '$me' OR usr2 = '$me') ORDER BY t DESC");
	while($r = $q->fetch_array(MYSQLI_BOTH)) {
			if($r['usr1'] == $me) {
				$u = $r['usr2'];
			}
			else if($r['usr2'] == $me) {
				$u = $r['usr1'];
			}
			
			$getImg = $con->query("SELECT avatar FROM users WHERE username = '$u'");
			$img = $getImg->fetch_array(MYSQLI_NUM);
			
			$getMsg = $con->query("SELECT msg, mid FROM messages WHERE t = '$r[t]' AND cid = $r[cid] LIMIT 1");
			$msg = $getMsg->fetch_array(MYSQLI_BOTH);
			
			$isSent = $con->query("SELECT fuser, receipt FROM messages WHERE mid = $msg[mid]");
			$sent = $isSent->fetch_array(MYSQLI_BOTH);

?>
<a style="color: #434a54" href="chat.php?usr=<?php echo $u; ?>&tab=recent" class="spplthumb" data-user="<?php echo $u; ?>">
<li <?php if(($sent['receipt'] == "unread") && ($sent['fuser'] != $me)) echo "style='background-color: #FFFFCC'"; ?>>
	<?php
		
	?>
	<div class="pplthumb"><img src="dp/<?php echo $img[0]; ?>"></div>
	<div class="pplname"><?php echo $u; ?><br><font color="gray">
		<?php
			echo substr($msg['msg'],0,10)."...";
		?>
	</font></div>
	<div class="chatstart"><span class="glyphicon glyphicon-comment"></span>
		<?php
			if($sent[0] == $me) {
		?>
		<br><span class="glyphicon glyphicon-share-alt" style="margin-top: 5px"></span>
		<?php } ?>
		</div>
</li>
</a>
<?php } } ?>