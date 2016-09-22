<? session_start();
   include_once('DbConnect.php');
	
	$db = new DbConnect();
	$conn = $db->connect();
   
					$title=(isset($_POST['title']) ? $_POST['title'] : null);
	                $address=(isset($_POST['address']) ? $_POST['address'] : null);
					$disc=(isset($_POST['disc']) ? $_POST['disc'] : null);
					$start_date=(isset($_POST['start_date']) ? $_POST['start_date'] : null);
					$end_date=(isset($_POST['end_date']) ? $_POST['end_date'] : null);
	                $start_time=(isset($_POST['start_time']) ? $_POST['start_time'] : null);
					$end_time=(isset($_POST['end_time']) ? $_POST['end_time'] : null);
					$spk=(isset($_POST['spk']) ? $_POST['spk'] : null);
					$news_id = $_GET['id'];
   
  // $date = $_POST["date"];

        $stmt = $conn->prepare("UPDATE m_event set title= ? ,startDate = ? ,endDate = ?,startTime = ?,endTime = ?,address = ?,discription = ?,speeker = ? where id = ?");
        $stmt->bind_param("ssssssssi", $title, $start_date, $end_date,$start_time,$end_time,$address,$disc,$spk, $news_id);
        
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        if($num_affected_rows >0){
			$_SESSION["MSG"]="Update Success";
			header("Location: m_event.php");	
		}else{
			$_SESSION["MSG"]="Event not updated, Try Again";
			header("Location: m_event.php");
			
		}
   
   
?>