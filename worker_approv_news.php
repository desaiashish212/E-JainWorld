<? session_start();
   include_once('DbConnect.php');
	
	$db = new DbConnect();
	$conn = $db->connect();
   
 $news_id=$_GET["id"];

   
  // $date = $_POST["date"];

        $stmt = $conn->prepare("UPDATE marathi_news set status= 1 where id = ? ");
        $stmt->bind_param("i",$news_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        if($num_affected_rows >0){
			$_SESSION["MSG"]="News approved";
			header("Location: m_news.php");	
		}else{
			$_SESSION["MSG"]="Try Again";
			header("Location: m_news.php");
			
		}
   
   
?>