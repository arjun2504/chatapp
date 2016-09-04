<form action="#" method="post" onsubmit="return regval();">
	
	<div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" class="form-control" id="email" name="e" placeholder="Enter Email" required>
	</div>
	
	<div class="form-group">
	    <label for="username">Username <span id="userstat"></span></label>
	    <input type="text" class="form-control" id="newusername" onKeyUp="checkusr();" name="u" placeholder="Desired Username" pattern=".{4,}">
	</div>
	<div class="form-group">
	    <label for="npwd1">Desired Password</label>
	    <input type="password" class="form-control" id="npwd1" name="p1" placeholder="Enter Password" pattern=".{6,}">
	</div>
	
	<div class="form-group">
	    <label for="npwd2">Retype Password</label>
	    <input type="password" class="form-control" id="npwd2" name="p2" placeholder="Enter Password again" pattern=".{6,}">
	</div>
	
	<div class="form-group">
	    <button type="submit" class="btn btn-primary">Sign up</button>
	</div>
</form>
<script>
function regval() {
	var avail = document.getElementById('userstat').innerHTML;
	var p1 = document.getElementById('npwd1').value;
	var p2 = document.getElementById('npwd2').value;
	var u = document.getElementById('newusername').value;
	if((p1.length < 6) || (p2.length < 6) || (p1 != p2) || (u.length >= 4)) {
		alert("sad");
		alert("Username should be at least 4 characters long or not available.\nPasswords should match and be at least 6 characters long");
		return false;
	}
	else {
		return true;
	}
}
</script>