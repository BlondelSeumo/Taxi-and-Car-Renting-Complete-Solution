<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
header('Content-type: text/json');
if($uid == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
	
	$count = $car->query("select * from  payout_setting where uid=".$uid."")->num_rows;
	if($count != 0)
	{
	$cy = $car->query("select * from  payout_setting where uid=".$uid."");
	$p = array();
	$q = array();
	while($adata = $cy->fetch_assoc())
	{
		$p['payout_id'] = $adata['id'];
		$p['amt'] = $adata['amt'];
		$p['status'] = $adata['status'];
		$p['proof'] = $adata['proof'];
		$p['r_date'] = $adata['r_date'];
		$p['r_type'] = $adata['r_type'];
		$p['acc_number'] = $adata['acc_number'];
		$p['bank_name'] = $adata['bank_name'];
		$p['acc_name'] = $adata['acc_name'];
		$p['ifsc_code'] = $adata['ifsc_code'];
		$p['upi_id'] = $adata['upi_id'];
		$p['paypal_id'] = $adata['paypal_id'];
		$q[] = $p;
	}
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Payout List Get Successfully!!!","Payoutlist"=>$q);
	}
	else 
	{
		$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Payout List Not Found!!","Payoutlist"=>[]);
	}
}
echo  json_encode($returnArr);


?>