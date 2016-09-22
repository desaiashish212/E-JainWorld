	<? session_start();
	   $conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	   
	   $cat_id=$_GET["id"];
	  
	  $stmt = $conn->prepare("delete from advertise where id= ?");
						$stmt->bind_param("i", $cat_id);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
	   
	if($num_affected_rows<=0)
   {
   		$_SESSION["MSG"]="Advertise not deleted, Try Again";
		header("Location: advertise.php?");	
   }
   else
   {
   		$_SESSION["MSG"]="Advertise deleted";
		header("Location: advertise.php");	
   }
	?>