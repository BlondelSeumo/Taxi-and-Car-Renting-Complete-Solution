<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid  = $data['uid'];
$cid  = $data['cid'];
if($uid == '' or $cid == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else 
{
	$getcinfo = $car->query("select * from tbl_coupon where id=".$cid."");
	$cinfo = $getcinfo->num_rows;
	
		if($cinfo !=0)
		{
			$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Coupon Applied Successfully!!");
		}
		else 
		{
			$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Coupon Not Exist!!");
		}
	
}

echo json_encode($returnArr);