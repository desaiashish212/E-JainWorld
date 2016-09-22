<?php session_start();
	$conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	
	$username=$_POST["username"];
   $password=$_POST["password"];
	
	
	$stmt = $conn->prepare("insert into repoters (username,password) values (?,?)");
						$stmt->bind_param("ss", $username, $password);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
	
	if($num_affected_rows > 0)
   {
	   
			$_SESSION["MSG"]="Success";
			header("Location: repoter.php");
	   
   }
   else
   {
	   
			$_SESSION["MSG"]="Repoter is not added, Try Again";
			header("Location: repoter.php");
	   
   		
   }
?>