<?php 
if(isset($_GET['token']))
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Payment Cancelled!!");
	echo json_encode($returnArr);
}
?>