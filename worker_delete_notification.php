 	<? session_start();
	   include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	   
	   $id=$_GET["id"];
	  $stmt = $conn->prepare("delete from notifications where id= ?");
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
	   
	 
	if($num_affected_rows<=0)
   {
   		$_SESSION["MSG"]="Try Again";
		header("Location: notifications.php");	
   }
   else
   {
   		$_SESSION["MSG"]="Notification deleted";
		header("Location: notifications.php");	
   }
	?>