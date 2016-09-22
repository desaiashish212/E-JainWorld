<?php session_start();
	include_once('connection.php');
	$oldpass=$_POST["oldpass"];
	$newpass=$_POST["newpass"];
	
	$result = mysqli_query($con,"SELECT login.user_pass FROM login");
	$row = mysqli_fetch_row($result);
	
	$tempOld = $row[0];
	if($tempOld===$oldpass){
		$result = mysqli_query($con,"update login SET user_pass='$newpass'");
		header("Location: login.php");
	}else{
		$_SESSION["ERROR"]="Incorrect password";
		header("Location: change_password.php");
	}
	
 ?>