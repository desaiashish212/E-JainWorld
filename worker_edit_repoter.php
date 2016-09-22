<? session_start();
   include_once('DbConnect.php');
	
	$db = new DbConnect();
	$conn = $db->connect();
   
   $id=$_POST["id"];
   $usernmame=$_POST["username"];
   $password=$_POST["password"];
   $org=$_POST["org"];
   $url=$_POST["url"];
   
        $stmt = $conn->prepare("UPDATE repoters set username= ? ,password = ? ,oragnasation = ?, avatar = ? where id = ?");
        $stmt->bind_param("ssssi", $usernmame, $password, $org,$url, $id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        if($num_affected_rows >0){
			$_SESSION["MSG"]="Update Success";
			header("Location: repoter.php");	
		}else{
			$_SESSION["MSG"]="Repoter not updated, Try Again";
			header("Location: repoter.php");
			
		}
   
   
?>