<?php session_start();
	 $conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	
	$message1=$_POST["message"];
	$languages=$_POST["languages"];
	
	//$res=mysql_query("insert into category (caregory_name,lang_status) values ('$name','$lang')");
	
	$pushStatus = '';
	
	$stmt = $conn->prepare("SELECT user_api_gcm.gcmId FROM users INNER JOIN user_api_gcm ON user_api_gcm.userId = users.id WHERE users.lang =$languages");
       // $stmt->bind_param("i", $user_id);
        
       
    if($stmt->execute()) {
		$stmt->store_result();
        $gcmRegIds = array();
        while($query_row = fetchAssocStatement($stmt)) {

            array_push($gcmRegIds, $query_row['gcmId']);

        }

    }
    $pushMessage = $_POST['message'];
    if(isset($gcmRegIds) && isset($pushMessage)) {

        $message = array('message' => $pushMessage);
        $pushStatus = sendPushNotification($gcmRegIds, $message);
		
		if($pushStatus>0){
			$stmt = $conn->prepare("insert into notifications (messages,language) values ('$message1','$languages')");
						$stmt->bind_param("si", $message1,$languages);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
		
		if($num_affected_rows>0)
		{
		

		$_SESSION["MSG"]="Success";
			header("Location: notifications.php");	
//	}
			
   }
   else
   {

			$_SESSION["MSG"]="Notification sending failed, Try Again";
			header("Location: notifications.php");
   		
   }
		}
else
   {

			$_SESSION["MSG"]="Notification sending failed, no user present";
			header("Location: notifications.php");
   		
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