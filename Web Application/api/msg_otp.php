<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');		  
		  $mobile = $data['mobile'];
		  if($mobile == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
// Initialize cURL session
$ch = curl_init();

// Define the URL
$url = 'https://control.msg91.com/api/v5/otp?template_id='.$set['otp_id'].'&mobile='.$mobile.'&authkey='.$set['auth_key'].'';

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/JSON'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$otp = rand(111111,999999);
// Define the data to send
$data = json_encode(array(
    "otp" => $otp
));

// Attach the JSON data to the request
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Execute the request and store the response
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Balance Get Successfully!!","otp"=>$otp);
}
echo json_encode($returnArr);
?>