<?php session_start();

	$conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	
	$uname=$_POST["username"];
	$pass=$_POST["password"];
	
	
	$stmt = $conn->prepare("SELECT login.user_id,login.user_name FROM login WHERE login.user_name = ? AND
login.user_pass = ?");
        $stmt->bind_param("ss", $uname,$pass);
        if ($stmt->execute()) {
            $stmt->bind_result($uid,$username);
            $stmt->fetch();
            $_SESSION["id"]=$uid;
		$_SESSION["user"]=$username;
		header("Location:index.php");
            $stmt->close();
           
        } else {
            $_SESSION["ERROR"]="Incorrect Username Or Password";
		header("Location: login.php");
        }
 ?>