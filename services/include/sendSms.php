<?php 
include('Config.php');
function sendSms($mobile, $otp) {
    
    $otp_prefix = ':';

    //Your message to send, Add URL encoding here.
    $message = urlencode("Your verification code for Loffer ".$otp_prefix." ".$otp);

    $response_type = 'json';

    //Define route 
    $route = "4";
    
    //Prepare you post parameters
    $postData = array(
        'authkey' => BULKSMS_AUTH_KEY,
        'mobiles' => $mobile,
        'message' => $message,
        'sender' => BULKSMS_SENDER_ID,
        'route' => $route,
        'response' => $response_type
    );

//API URL
    $url = "http://bulksms.makarandmane.com/api/sendhttp.php";

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
    ));


    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    //get response
    $output = curl_exec($ch);

    //Print error if any
    if (curl_errno($ch)) {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);
}

?>