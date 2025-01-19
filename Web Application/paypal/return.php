<?php 
if(isset($_GET['paymentId']))
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Payment Successfull!","paymentId"=>$_GET['paymentId']);
	echo json_encode($returnArr);
}
?>