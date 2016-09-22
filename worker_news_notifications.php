<?php session_start();
	include_once('DbConnect.php');
						$db = new DbConnect();
						$conn = $db->connect();
	
	$id=$_GET["id"];
	$title=$_GET["title"];
	
	//$res=mysql_query("insert into category (caregory_name,lang_status) values ('$name','$lang')");
	
	$pushStatus = '';

	$gcmRegIds = array();
	$stmt = $conn->prepare("SELECT user_api_gcm.gcmId FROM user_api_gcm");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($adds=  fetchAssocStatement($stmt)) {
                
                array_push($gcmRegIds, $adds["gcmId"]);
            }
        $stmt->close();
	
	
	
    $pushMessage = $_GET['title'];
    if(isset($gcmRegIds) && isset($pushMessage)) {

        $message = array('message' => $pushMessage,'id'=>$id,'activity'=>'event');
        $pushStatus = sendPushNotification($gcmRegIds, $message);
	
		if($pushStatus>0){
			
			
	//$aff=mysql_affected_rows();
	
	$stmt = $conn->prepare("insert into notifications (messages,category) values (?,'news')");
        $stmt->bind_param("s", $pushMessage);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
		
		$stmt = $conn->prepare("update marathi_news set notif_status=1 where id=$id");
      //  $stmt->bind_param("s", $pushMessage);
        $res = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
		
		if($result==$res)
		{
		

		$_SESSION["MSG"]="Notification sent successfully";
			
							header("Location: m_news.php");	
			
//	}
			
   }
   else
   {

			$_SESSION["MSG"]="Table update failed failed, Try Again";
			
							header("Location: m_news.php");	
				
   }
		}
else
   {

			$_SESSION["MSG"]="Notification sending failed, no user present";
			
							header("Location: m_news.php");	
				
   		
   }		
    
  }
   
   function sendPushNotification($registatoin_ids, $message) {
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
		// Update your Google Cloud Messaging API Key
		define("GOOGLE_API_KEY", "AIzaSyD7xO91_HRb2O80jRByaNiUvP7xC7mBblU"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       echo  $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
		$pretty = json_decode($result);
        return $pretty->success;
    }
	
	function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }

    return null;
}
?>