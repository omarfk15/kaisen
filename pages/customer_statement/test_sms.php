<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";


function sendSMS($mobile, $message, $type = 'text')
{
    $apiKey   = "f9ff7ffeb72941f39886f4d052917561";
$senderId = "KAIZEN KMI"; 
    // Base API URL
    $url = "https://sms.maestro.com.bd/api/smsapi";

    // Prepare parameters
    $params = [
        'api_key'  => $apiKey,
        'type'     => $type,        // text | unicode
        'contacts' => $mobile,      // 01XXXXXXXXX or 8801XXXXXXXXX
        'senderid' => $senderId,    // Your approved Sender ID
        'msg'      => $message
    ];

    // Build query string
    $queryString = http_build_query($params);

    // Full URL
    $requestUrl = $url . '?' . $queryString;

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // Execute request
    $response = curl_exec($ch);

    // Error handling
    if (curl_errno($ch)) {
        return [
            'status' => false,
            'error'  => curl_error($ch)
        ];
    }

    curl_close($ch);

    // Decode JSON response
    return json_decode($response, true);
}


 


$mobile   = "01915639645";
$message  = "This is new sms3.";

$response = sendSMS($mobile, $message);

 



 ?>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>