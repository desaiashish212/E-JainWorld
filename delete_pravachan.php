	<? session_start();

	   $conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();

	   $news_id=$_GET["id"];

	 $stmt = $conn->prepare("delete from m_pravachan where id = ?");
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();

	if($num_affected_rows >0)
   {
   		$_SESSION["MSG"]="Pravachan deleted";
		header("Location: m_pravachan.php");
   }
   else
   {
	   $_SESSION["MSG"]="Pravachan not deleted, Try Again";
		header("Location: m_pravachan.php");

   }
	?>
