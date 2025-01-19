<?php 
$returnArr = array("Transaction_id"=>$_GET['payment_id'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"payment Successfull!!");
		echo json_encode($returnArr);
?>