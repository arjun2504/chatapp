<?php
session_start();
if(isset($_SESSION['username'])) {
	require_once('db.php');
	$me = $_SESSION['username'];
	
	$fileName = $me."_".$_FILES["upload_file"]["name"][0];
	$fileTmpLoc = $_FILES["upload_file"]["tmp_name"][0];
	//$fileType = @$_FILES["upload_file"]["image/png||image/jpg"];
	$fileSize = $_FILES["upload_file"]["size"][0];
	$fileErrorMsg = $_FILES["upload_file"]["error"][0];
	$moveResult= move_uploaded_file($fileTmpLoc, "dp/$fileName");
	$con->query("UPDATE users SET avatar = '$fileName' WHERE username = '$me'");
	unlink($fileTmpLoc);
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
else {
	header("Location: index.php");
}
?>