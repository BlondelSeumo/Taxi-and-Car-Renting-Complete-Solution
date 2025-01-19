<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require  'src/Twilio/autoload.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');		  
		  $mobile = $data['mobile'];
		  if($mobile == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
$from = $set['twilio_number'];
$to = $mobile; // twilio trial verified number
$otp = rand(111111,999999);

$sid = $set['acc_id'];
$token = $set['auth_token'];
$client = new Twilio\Rest\Client($sid, $token);
try {
    // Use the Client to make requests to the Twilio REST API
    $message = $client->messages->create(
        // The number you'd like to send the message to
        $to,
        [
            // A Twilio phone number you purchased at https://console.twilio.com
            'from' => $set['twilio_number'],
            // The body of the text message you'd like to send
            'body' => "Your OTP is #" . $otp . " to verify and proceed."
        ]
    );
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Balance Get Successfully!!","otp"=>$otp);
} catch (\Twilio\Exceptions\RestException $e) {
    // Handle exceptions such as invalid number, message failures, etc.
  
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>$e->getMessage());
    // Log the error or take other necessary actions
}


}
echo json_encode($returnArr);
?>