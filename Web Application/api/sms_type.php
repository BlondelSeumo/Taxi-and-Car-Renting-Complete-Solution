<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

		  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"type Get Successfully!!","SMS_TYPE"=>$set['sms_type'],"otp_auth"=>$set['otp_auth']);

echo json_encode($returnArr);
?>