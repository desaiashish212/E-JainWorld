	<? session_start();

	   $conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();

	   $news_id=$_GET["id"];

	 $stmt = $conn->prepare("delete from ringtone where id = ?");
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();

	if($num_affected_rows >0)
   {
   		$_SESSION["MSG"]="Ringtone deleted";
		header("Location: ringtone.php");
   }
   else
   {
	   $_SESSION["MSG"]="Ringtone not deleted, Try Again";
		header("Location: ringtone.php");

   }
	?>
