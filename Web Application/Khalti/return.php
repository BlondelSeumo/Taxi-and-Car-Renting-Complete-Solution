<?php 
header('Content-type: text/json');
if(isset($_GET['txnId']))
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Transaction Completed!!","Transaction_id"=>$_GET['txnId']);
	echo  json_encode($returnArr);
}

?>