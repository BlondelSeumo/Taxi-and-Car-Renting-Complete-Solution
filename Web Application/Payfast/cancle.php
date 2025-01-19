<?php 
$returnArr = array("Transaction_id"=>$_GET['payment_id'],"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"payment Failed!!!");
		echo json_encode($returnArr);
?>