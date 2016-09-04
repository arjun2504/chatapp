
<?php clearstatcache(); ?>	<?php
		session_start();
		require_once('db.php');
		$with = $_GET['usr'];
		$dq = $con->query("SELECT * FROM users WHERE username = '$with'");
		$data = $dq->fetch_array(MYSQLI_ASSOC);
	?>

	<div class="col-md-6">
		<div class="chatheader">


			<center><span class="chatdp"><img src="dp.jpg" align="center"></span></center>
			<div class="chatname">
				<?php echo $data['username']; ?>
				<br>
				<font color="#afafaf"></font>
				</div>
				
		</div>
		<script>
		$(document).ready(function() {
				$("#chatcontain").animate({ scrollTop: $('#chatcontain')[0].scrollHeight}, 1000);
		});
		</script>
		<div class="chatcont">

			<div id="chatcontain">
				<!--- FOR PRE-LOAD-->
				<?php

					$u = $_SESSION['username'];
					$with = $_GET['usr'];
					$q = $con->query("SELECT * FROM messages WHERE (fuser = '$u' AND tuser = '$with') OR (fuser = '$with' AND tuser = '$u')");
					while($r = $q->fetch_array(MYSQLI_BOTH)) {
				?>

				<?php

					if($r['fuser'] == $with) {

				?>
				<div class="fmsg">
					<?php
						$dp = $con->query("SELECT avatar FROM users WHERE username = '$with'");
						$pic = $dp->fetch_array(MYSQLI_BOTH);
					?>
					<div class="thumb"><img src="dp/<?php echo $pic['avatar']; ?>" title="<?php echo $r['fuser']; ?>"></div>
					<div class="bubble"><?php echo $r['msg']; ?></div>
				</div>
				<div style="clear:both"></div>
				<?php } ?>

				<?php
					if($r['fuser'] == $u) {
				?>
				<?php
					$dp = $con->query("SELECT avatar FROM users WHERE username = '$u'");
					$pic = $dp->fetch_array(MYSQLI_BOTH);
				?>
				<div class="umsg">
					<div class="thumb"><img src="dp/<?php echo $pic['avatar']; ?>" title="You"></div>
					<div class="bubble"><?php echo $r['msg']; ?></div>
				</div>
				<div style="clear:both"></div>
				<?php } } ?>


				<!-- FOR PRE-LOAD ENDS-->
			</div>
			
			
			<div class="replybox">
				<form action="reply.php" id="reply" method="post">
					<input type="hidden" name="to" value="<?php echo $with; ?>">
					<textarea placeholder="Write a reply..." id="replytxt" name="message"></textarea>
					<button type="submit"><span class="glyphicon glyphicon-send"></span></button>
				</form>
				<script>
				/*$(document).ready(function(){
					$('textarea').keypress(
					    function(e){

					        if (e.keyCode == 13) {
					            var msg = $(this).val();
								$(this).val('');
								if(msg!='')
									$('#chatcont').scrollTop($('#chatcont')[0].scrollHeight);
					        }
					    });
				});*/



					$("#reply").submit(function() {

							    var url = "reply.php";
							    $.ajax({
							           type: "POST",
							           url: url,
							           data: $("#reply").serialize(),
							           success: function(data)
							           {
										document.getElementById('replytxt').value ="";
										$(".chatcont").animate({ scrollTop: $(".chatcont")[0].scrollHeight}, 1000);
							           }
							     });

							    return false;
							});
				</script>
			</div>
		</div>
		<script>
		$(document).ready(function(){
					function callAjax() {
						var wth = "<?php echo $with; ?>";
					    $.ajax({
					   		method:'get',
							cache:false,
							url: 'chatarea.php?usr=' + wth,
							success:function(data){
					        	$('#chatcontain').html(data);
					      	}
					    });
					  }
					var s = setInterval(function() { callAjax(); },800);
		});
		</script>

		
	</div>

	<div class="col-md-2">
		<div class="rightbar">

		</div>
	</div>
</div>