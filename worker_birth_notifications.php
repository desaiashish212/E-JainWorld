<?php session_start();
	include_once('connection.php');
	
	$user_id=$_GET["id"];
	$languages=$_GET["lang"];
		
	$pushStatus = '';
	$path='';
	
	  $query = "SELECT gcm_reg_id FROM users WHERE id=$user_id";
    if($query_run = mysqli_query($con,$query)) {

        $gcmRegIds = array();
        while($query_row = mysqli_fetch_assoc($query_run)) {

            array_push($gcmRegIds, $query_row['gcm_reg_id']);

        }

    }
	if($languages==1){
					$pushMessage = "वाढदिवसाच्या हार्दिक शुभेच्छा..!";
					$path='wish/marathi.png';
				}else if($languages==2){
					$pushMessage = "जन्मदिन मुबारक!";
					$path='wish/hindi.png';
				}else{
					$pushMessage = "Happy Birthday!";
					$path='wish/english.png';
				}
				
    if(isset($gcmRegIds) && isset($pushMessage)) {

        $message = array('message' => $pushMessage,'path'=>$path);
        $pushStatus = sendPushNotification($gcmRegIds, $message);

		if($pushStatus>0){
			$sql = "insert into notifications (messages,language) values ('$pushMessage','$languages')";
	//$aff=mysql_affected_rows();
		$result = mysqli_query($con, $sql);
		if($sql)
		{
		

		$_SESSION["MSG"]="Success";
			header("Location: index.php");	
//	}
			
   }
   else
   {

			$_SESSION["MSG"]="Notification sending failed, Try Again";
			header("Location: index.php");
   		
   }
		}
else
   {

			$_SESSION["MSG"]="Notification sending failed, no user present";
			header("Location: index.php");
   		
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
		define("GOOGLE_API_KEY", "AIzaSyDqa_hGc5tMKTVSmrZhwO2lmiGYZCUyNtc"); 		
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
?>