<? session_start();
   include_once('DbConnect.php');
	
	$db = new DbConnect();
	$conn = $db->connect();
   
   $news_id=$_POST["id"];
   $title=$_POST["title"];
   $news=$_POST["news"];
   $url=$_POST["url"];
   
  // $date = $_POST["date"];

        $stmt = $conn->prepare("UPDATE marathi_news set title= ? ,discription = ? ,url = ? where id = ?");
        $stmt->bind_param("sssi", $title, $news, $url, $news_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        if($num_affected_rows >0){
			$_SESSION["MSG"]="Update Success";
			header("Location: m_news.php");	
		}else{
			$_SESSION["MSG"]="News not updated, Try Again";
			header("Location: m_news.php");
			
		}
   
   
?>