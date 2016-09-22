	<? session_start();
	   include_once('DbConnect.php');
						$db = new DbConnect();
						$conn = $db->connect();
	
	   
	   $news_id=$_GET["id"];	//get feed id
	   
	   
	$stmt = $conn->prepare("delete from feedback where id = ?");
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();

	if($num_affected_rows >0)
    {
		$_SESSION["MSG"]="Feedack deleted";
		header("Location: feedback.php");	
   			
    }
    else
    {
   		$_SESSION["MSG"]="Feedback not deleted, Try Again";
		header("Location: feedback.php");
    }
	?>