<?php 
header('Content-type: text/json');
if(isset($_GET['status_code']))
{
	if($_GET['status_code'] == 200)
	{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Transaction Completed!!","Transaction_id"=>$_GET['order_id']);
	echo  json_encode($returnArr);
	}
}

?>