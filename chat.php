<?php
	require_once('db.php');
	session_start();
	if(isset($_SESSION['username'])) {
?>
<html>
	<head>
		<title>ChatApp</title>
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<link rel="stylesheet" href="css/bootflat.css" type="text/css">
		<link rel="stylesheet" href="css/custom.css" type="text/css">
		<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script>
		$(document).ready(function(){
			<?php
				if($_GET['tab'] == 'active') {
					echo "active();";
				}
				else if($_GET['tab'] == 'recent') {
					echo "recent();";
				}
				else if($_GET['tab'] == 'all') {
					echo "allppl();";
				}
				else {
					echo "active();";
				}
			?>
			
			function scrolTop() {
				$('html').on ('mousewheel', function (e) {
				    var delta = e.originalEvent.wheelDelta;
					if (delta > 0) {
					    clearInterval(s);
						k;
					}
				});
				$("#chatcontain").animate({ scrollTop: $("#chatcontain")[0].scrollHeight}, 1000);
			}
			var s = setInterval(function() { scrolTop(); },2000);
			
			function scrolcontinue() {
				$('#chatcontain').bind('scroll', function() {
				        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
							clearInterval(k);
				            s;
				        }
				    });
			}
			var k = setInterval(function () { scrolcontinue(); },2100);
		});
		</script>
	</head>
	<body>
		<div class="ccontainer">
			<div class="row no-gutter">
			<div class="col-md-4" style="position:fixed; width: 300px; height: 100%">
				<div class="lefttop">
					
					<?php
						$me = $_SESSION['username'];
						$dp = $con->query("SELECT avatar FROM users WHERE username = '$me'");
						$pic = $dp->fetch_array(MYSQLI_BOTH);
					?>
					<div class="dp">
						<img src="dp/<?php echo $pic[0]; ?>">
					</div>
					
					<div class="dpname">
						<?php
							echo $_SESSION['username'];
						?><br>
						<span class="status">
							<form action="toggle.php" id="cs" method="post" onsubmit="changeStatus()">
								<?php
									$me = $_SESSION['username'];
									$myStatus = $con->query("SELECT message FROM chat WHERE usr = '$me' LIMIT 1");
									$myStat = $myStatus->fetch_array(MYSQLI_NUM);
								?>
								<select class="statuschange" onchange="changeStatus()" name="toggle">
									<option <?php if($myStat[0] == 'online') echo 'selected'; ?>>online</option>
									<option <?php if($myStat[0] == 'busy') echo 'selected'; ?>>busy</option>
									<option <?php if($myStat[0] == 'offline') echo 'selected'; ?>>invisible</option>
								</select>
							</form>
							<script>
							function changeStatus() {
								$.ajax({
									method: 'POST',
									url: 'toggle.php',
									data: $("#cs").serialize(),
							        success: function(data)
							        {
										
							         }
								});
								return false;
							}
							</script>
						</span>
					</div>

				</div>
				
				<div class="tabarea">
					<div class="tabs" id="activetab" onclick="active()">
						<center><span class="glyphicon glyphicon-record"></span> Active</center>
					</div>
					<div class="tabs" id="recenttab" onclick="recent()">
						<center><span id="unreadmsgc"><span class="glyphicon glyphicon-time"></span></span> Recent</center>
						<script>
						$(document).ready(function() {
							var check = function() {
								$.ajax({
									method: 'GET',
									url: 'getUnread.php',
									success: function(data) {
										$('#unreadmsgc').html(data);
									}
								});
							}
							
							setInterval(check,3100);
						});
						</script>
					</div>
					<div class="tabs lasttab" id="peopletab" onclick="allppl()">
						<center><span class="glyphicon glyphicon-user"></span> People</center>
					</div>
				</div>
				<script>
					function active() {
						$('#activetab').attr("class","tabs activetabs");
						$('#recenttab').attr("class","tabs");
						$('#peopletab').attr("class","tabs lasttab");
						
						$('#recentppl').css("display","none");
						$('#allppl').css("display","none");
						$('#activeppl').fadeIn("medium").css("display","block");
						$('#activetab').css("cursor", "pointer");
					}
					function recent() {
						$('#recenttab').attr("class","tabs activetabs");
						$('#peopletab').attr("class","tabs lasttab");
						$('#activetab').attr("class","tabs");
						
						$('#activeppl').css("display","none");
						$('#allppl').css("display","none");
						$('#recentppl').fadeIn("medium").css("display","block");
						$('#recenttab').css("cursor", "pointer");
					}
					function allppl() {
						$('#peopletab').attr("class","tabs lasttab activetabs");
						$('#activetab').attr("class","tabs");
						$('#recenttab').attr("class","tabs");
						
						$('#activeppl').css("display","none");
						$('#recentppl').css("display","none");
						$('#allppl').fadeIn("medium").css("display","block");
						$('#peopletab').css("cursor", "pointer");
					}
				</script>
				
				<div class="mainsidebar" style="height: 100%">
					
					<ul class="ppllist" id="activeppl">
						
						
					</ul>
					
					<script>
					
					$(document).ready(function() {
						function callActive() {
							$.ajax({
								method: 'GET',
								url: 'active.php',
								success: function(data) {
									$('#activeppl').html(data);
								}
								
							});
						}
						
						var s = setInterval(function() { callActive(); }, 1000);
					});
					
					</script>
					
					<ul class="ppllist" id="recentppl" style="display: none">
						<div id="rp"></div>
					</ul>
					<script>
						$(document).ready(function() {
							var rec = function() {
								$.ajax({
									method: 'GET',
									url: 'recent.php',
									success: function(data) {
										$('#rp').html(data);
									}
								});
							}
							
							setInterval(rec,1000);
						});
					</script>
					<ul class="ppllist" id="allppl" style="display:none">
						
						<?php
							$me = $_SESSION['username'];
							$activeq = $con->query("SELECT username, avatar FROM users WHERE username <> '$me' ORDER BY username ASC");
							while($activer = $activeq->fetch_array(MYSQLI_BOTH)) {
						?>
						<a style="color: #434a54" href="chat.php?usr=<?php echo $activer['username']; ?>&tab=all" class="spplthumb" data-user="<?php echo $activer['usr']; ?>">
						<li>
							<div class="pplthumb"><img src="dp/<?php echo $activer['avatar']; ?>"></div>
							<div class="pplname"><?php echo $activer['username']; ?><br></div>
							<div class="chatstart"><span class="glyphicon glyphicon-comment"></span></div>
						</li>
						</a>
						<?php } ?>
					</ul>
					
					
					<!--<script>
						$(".spplthumb").click(function(){
							var user = $(this).attr("data-user");
							$.ajax({
							        type: 'GET',
							        url: 'chatwindow.php?usr='+user,
							        data: {},
							        success: function(data) {
							        	$("#chatwindow").html(data);
							        }
							    });
						});
					</script>-->
				</div>
				
				<!--<div class="sidefooter">
			
				</div>-->
				
			</div>
			
			<div id="chatwindow">
				
				
					<?php
						if(isset($_GET['usr'])) {
						$with = @$_GET['usr'];
						$dq = $con->query("SELECT * FROM users WHERE username = '$with'");
						$data = $dq->fetch_array(MYSQLI_ASSOC);
					?>

					<div class="col-md-6" style="position:fixed; width: 550px; margin-left: 300px; height: 100%">
						<div class="chatheader">

							<?php
								$dp = $con->query("SELECT avatar FROM users WHERE username = '$with'");
								$pic = $dp->fetch_array(MYSQLI_BOTH);
							?>
							<center><span class="chatdp"><img src="dp/<?php echo $pic['avatar']; ?>" align="center"></span></center>
							<div class="chatname">
								<center><?php echo $data['username']; ?></center>
								<font color="#aeaeae"><span id="updstatus"></span></font>
								</div>
								
								
								<script>

								$(document).ready(function() {
									function updateStat() {
										$.ajax({
											method: 'GET',
											url: 'checkStatus.php' + '<?php echo "?usr=".$with; ?>',
											success: function(data) {
												$('#updstatus').html(data);
											}

										});
									}

									var s = setInterval(function() { updateStat(); }, 2000);
								});

								</script>
						</div>

						<div class="chatcont" id="chatcontain">



						</div>
						<script>
						$(document).ready(function(){

									<?php
										$u = $_SESSION['username'];
										$with = $_GET['usr'];
										$q = $con->query("SELECT msg FROM messages WHERE (fuser = '$with' AND tuser = '$u') ORDER BY mid DESC LIMIT 1")->fetch_array(MYSQLI_NUM);
									?>
									var lastMsg = '<?php echo $q[0]; ?>';
									//$(window).scrollTop($(document).height());
									function callAjax() {
										var wth = "<?php echo $with; ?>";
									    $.ajax({
									      type:'get',
										 cache:false,
									      url: 'chatarea.php?usr=' + wth,
									      success:function(data){
									        $('#chatcontain').html(data);
											$(".chatcont").animate({ scrollTop: $(".chatcont").scrollHeight}, 1);
											$.ajax({
												type: 'GET',
												url: 'lastmsg.php' + '?usr=' + wth,
												success: function(data) {
													var nowMsg = data;
													if(lastMsg != nowMsg) {
														if(nowMsg != "BUZZ!") {
															playSound('receive');
														}
														else if(nowMsg == 'BUZZ!'){
															playSound('buzz');
														}
														lastMsg = nowMsg;
													}
												}
											});
									      }
									    });
									  }
									  //setInterval(callAjax,100);
										var s = setInterval(function() { callAjax(); },1500);
								});
						</script>

						<div class="replybox">
							<form action="reply.php" id="reply" method="post">
								<input type="hidden" name="to" value="<?php echo $with; ?>">
								<textarea placeholder="Write a reply..." id="replytxt" onKeyUp="isEnterKey()" name="message"></textarea>
								<button type="submit" title="Send"><span class="glyphicon glyphicon-send"></span></button>
								<button type="button" id="buzzb" onclick="sendBuzz('buzz')" title="Buzz"><span class="glyphicon glyphicon-bullhorn"></span></button>
							</form>
							<script>
								
								$(document).ready(function() {
									$('#replytxt').keydown(function() {
									    if (event.keyCode == 13 && !event.shiftKey) {
											fs();
									        return false;
									     }
									});
								});
								
								function playSound(kind) {
									var audioElement = document.createElement('audio');
									audioElement.setAttribute('src', 'sounds/' + kind + '.mp3');
							        audioElement.setAttribute('autoplay', 'autoplay');
							        //audioElement.load()

							        $.get();

							        audioElement.addEventListener("load", function() {
							            audioElement.play();
							        }, true);

							        $('.play').click(function() {
							            audioElement.play();
							        });

							        $('.pause').click(function() {
							            audioElement.pause();
							        });
								}
								function sendBuzz(kind) {
									$.ajax({
										type: "POST",
										url: "sendbuzz.php",
										data: $('#reply').serialize(),
										success: function(data) {
												playSound(kind);
										}
									});
								}
								function fs() {

											    var url = "reply.php";
											    $.ajax({
											           type: "POST",
											           url: url,
											           data: $("#reply").serialize(),
											           success: function(data)
											           {
														if(document.getElementById('replytxt').value != "") {
															playSound('send');
														}
														document.getElementById('replytxt').value ="";
														$(".chatcont").animate({ scrollTop: $(".chatcont")[0].scrollHeight}, 1000);
											           }
											     });

											    return false;
											
											
								}
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
					<?php } else if(!isset($_GET['usr'])) {
						?>
							<div class="col-md-6" style="position:fixed; width: 600px; margin-left: 300px; height: 100%">
								<div class="whome">
									<center><span class="glyphicon glyphicon-comment" style="font-size: 200px; margin-top: 20%"></span></center>
									<br>
									<center><font color="#8d8d8d">Click on a username and start chatting</font></center>
								</div>
							</div>
						<?php
					}
					 ?>
					<div class="col-md-2" style="position:fixed; width: 200px; margin-left: 850px; height: 100%">
						<div class="rightbar">
								<br><br><br><br><br><br>
								
								<div style="padding: 10px">
									<?php
										if(isset($_GET['usr'])) {
									?>
									<a href="delconvo.php?usr=<?php echo $_GET['usr']; ?>" onclick="return confirm('Are your sure that you want to delete this conversation with <?php echo $with; ?>? You cannot undo this action')"><span class="glyphicon glyphicon-trash"></span> Delete conversation</a>
									<?php } else if(!isset($_GET['usr'])) {
										?>
										<span style="text-decoration: line-through; pointer-events: none"><span class="glyphicon glyphicon-trash"></span> Delete conversation</a></span>
										<?php
									} ?>
								</div>
								
								
								<div style="padding: 10px">
									<?php
										if(isset($_GET['usr'])) {
									?>
									<a href="emailconvo.php?usr=<?php echo $_GET['usr']; ?>" target="_blank"><span class="glyphicon glyphicon-envelope"></span> Email this convo</a>
									<?php } else if(!isset($_GET['usr'])) {
										?>
										<span style="text-decoration: line-through; pointer-events: none"><span class="glyphicon glyphicon-envelope"></span> Email this convo</a></span>
										<?php
									} ?>
									</div>
									<hr style="border-color: #fcfcfc">
								<div style="padding: 10px"><span class="glyphicon glyphicon-user"></span>
									<form action="updatedp.php" style="display:none" method="post" enctype="multipart/form-data">
										<input type="file" name="upload_file[]" id="selFile" onchange="this.form.submit()">
									</form>
									<a href="#" onclick="document.getElementById('selFile').click()"> Change avatar</a></div>
								<div style="padding: 10px"><a href="index.php?mode=cp"><span class="glyphicon glyphicon-lock"></span> Change password</a></div>
								<div style="padding: 10px"><a href="signout.php"><span class="glyphicon glyphicon-off"></span> Log out</a></div>

						</div>
					</div>
				</div>
			
			</div>
		</div>
	</body>
</html>
<?php
} else {
	header("Location: index.php");
}
?>