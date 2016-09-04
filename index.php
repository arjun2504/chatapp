<?php
	include_once "db.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>ChatApp</title>
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<link rel="stylesheet" href="css/bootflat.css" type="text/css">
		<link rel="stylesheet" href="css/custom.css" type="text/css">
		<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script>
		$(document).ready(function() {
			<?php
				if(isset($_GET['err'])) {
					echo "changeForm();";
				}
			?>
		});
			function checkusr() {
				var ui = document.getElementById('newusername').value;
				if(ui.length > 3) {
					$.get( "checkusr.php?usr="+ui, function( data ) {
					  $( "#userstat" ).html( data );
					});
				}
				else {
					document.getElementById('userstat').innerHTML = "";
				}
			}
			function regval() {
				var avail = document.getElementById('userstat').innerHTML;
				var p1 = document.getElementById('npwd1').value;
				var e = document.getElementById('em').value;
				var p2 = document.getElementById('npwd2').value;
				var u = document.getElementById('newusername').value;
				if((p1.length < 6) || (p2.length < 6) || (p1 != p2) || (u.length >= 4) || (e != "")) {
					alert("Username should be at least 4 characters long or not available.\nPasswords should match and be at least 6 characters long");
					return false;
				}
				else {
					return true;
				}
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="home">
				<div class="col-lg-6 nu">
					<img src="logo.png" height="45px"><br><br>
					<p>*this app* lets you to chat with your clients privately.</p><br><br>
					<?php
						if(!isset($_GET['mode'])) {
					?>
					<div id="newuser" style="display:block">
						<font size="5px">Don't have an account?</font><br><br>
						<button type="button" class="btn btn-default" onclick="changeForm()">Sign up</button>
					</div>
					
					<div id="existuser" style="display:none">
						<font size="5px">Existing User?</font><br><br>
						<button type="button" class="btn btn-default" onclick="revertForm()">Login</button>
					</div>
					<?php } else if(isset($_GET['mode'])) {
					?>
						<div>
						<font size="5px">Keep your account secure.</font><br><br>
						<!--<button type="button" class="btn btn-default" onclick="revertForm()">Login</button>-->
					</div>
					<?php
					} ?>
				</div>
				<script>
					function changeForm() {
						$('#newuser').css('display','none');
						$('#existuser').css('display','block');
						
						$('#existform').fadeOut("fast").css('display','none');
						$('#newform').fadeIn("fast").css('display','block');
					}
					function revertForm() {
						$('#existuser').css('display','none');
						$('#newuser').css('display','block');
						
						$('#newform').fadeIn("fast").css('display','none');
						$('#existform').fadeOut("fast").css('display','block');
					}
				</script>
				<div class="col-lg-6 eu">
					<?php
						if(!isset($_GET['mode'])) {
					?>
					<div id="existform" style="display:block">
						<h4>Please login</h4>
						<hr>
						<form action="authenticate.php" method="post">
							<div class="form-group">
							    <label for="username">Username</label>
							    <input type="text" class="form-control" id="username" name="u" placeholder="Enter Username" pattern=".{4,}" required>
							</div>
						
							<div class="form-group">
							    <label for="pwd">Password</label>
							    <input type="password" class="form-control" id="pwd" name="p" placeholder="Enter Password" pattern=".{6,}" required>
							</div>
						
							<div class="form-group">
							    <button type="submit" class="btn btn-primary">Sign in</button>
							</div>
							<?php if(isset($_GET['e'])) { ?><font color="red">Incorrect Username/Password. Try Again.</font><?php } ?>
						</form>
					</div>
					
					<div id="newform" style="display:none">
						<h4>Create an account</h4>
						<hr>
						<form action="signup.php" method="post" onsubmit="return regval();">
							
							<div class="form-group">
							    <label for="email">Email</label>
							    <input type="email" class="form-control" id="email" name="e" placeholder="Enter Email" required>
							</div>
							
							<div class="form-group">
							    <label for="username">Username <span id="userstat"></span></label>
							    <input type="text" class="form-control" id="newusername" onKeyUp="checkusr();" name="u" placeholder="Desired Username" pattern=".{4,}" required>
							</div>
							<div class="form-group">
							    <label for="pwd1">Desired Password</label>
							    <input type="password" class="form-control" id="npwd1" name="p1" placeholder="Enter Password" pattern=".{6,}" required>
							</div>
							
							<div class="form-group">
							    <label for="pwd2">Retype Password</label>
							    <input type="password" class="form-control" id="npwd2" name="p2" placeholder="Enter Password again" pattern=".{6,}" required>
							</div>
							
							<div class="form-group">
							    <button type="submit" class="btn btn-primary">Sign up</button>
							</div>
						</form>
						
					</div>
					
					<?php } else {
					if(isset($_SESSION['username']))
					?>
						<div id="newform">
							<form action="cp.php" method="post" onsubmit="return validate()" id="cps">
								<div class="form-group">
									<label for="op">Old Password</label>
									<input type="password" class="form-control" id="op" name="op" placeholder="Old Password" required>
								</div>
								
								<div class="form-group">
									<label for="np1">New Password</label>
									<input type="password" class="form-control" id="np1" name="np1" placeholder="New Password" required>
								</div>
								
								<div class="form-group">
									<label for="np2">Retype New Password</label>
									<input type="password" class="form-control" id="np2" name="np2" placeholder="New Password" required>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> &nbsp; Update & Proceed to App</button>
								</div>
							</form>
							<script>
								function validate() {
									var op = document.getElementById('op').value;
									var np1 = document.getElementById('np1').value;
									var np2 = document.getElementById('np2').value;
									
									if((np1 == np2) && (np1.length >= 6) && (np2.length >= 6)) {
										document.getElementById('cps').submit();
									}
									else {
										alert("Error! Check data!");
										return false;
									}
								}
							</script>
						</div>
						<?php
					}
					?>
					
				</div>
			</div>
		</div>
	</body>
</html>