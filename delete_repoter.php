	<? session_start();
	   
	   $conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	   
	   $id=$_GET["id"];
	   	   
	 $stmt = $conn->prepare("delete from repoters where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();  
	   
	if($num_affected_rows >0)
   {
   		$_SESSION["MSG"]="Repoter deleted";
		header("Location: repoter.php");	
   }
   else
   {
	   $_SESSION["MSG"]="Repoter not deleted, Try Again";
		header("Location: repoter.php");	
   		
   }
	?>