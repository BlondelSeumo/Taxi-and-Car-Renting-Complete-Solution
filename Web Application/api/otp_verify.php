<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['uid'] == ''  || $data['status'] == ''  || $data['otp'] == '' || $data['book_id'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
$book_id = $data['book_id'];
$uid = $data['uid'];	
$status = $data['status'];		
$otp = $data['otp'];
if($status == 'Pickup')
{
	$check = $car->query("select * from tbl_book where id=".$book_id." and uid=".$uid." and pick_otp=".$otp."")->num_rows;
	if($check != 0)
	{
		$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Otp Matched!!");
	}
	else 
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Otp Not Matched!!");
	}
}
else 
{
$check = $car->query("select * from tbl_book where id=".$book_id." and uid=".$uid." and drop_otp=".$otp."")->num_rows;
	if($check != 0)
	{
		$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Otp Matched!!");
	}
	else 
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Otp Not Matched!!");
	}	
}
}
echo json_encode($returnArr);
?>