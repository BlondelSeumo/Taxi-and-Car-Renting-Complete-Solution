<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
$uid =  strip_tags(mysqli_real_escape_string($car,$data['uid']));
$checkimei = mysqli_num_rows(mysqli_query($car,"select * from tbl_user where  `id`=".$uid.""));

if($checkimei != 0)
    {
		$wallet = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
		
       $sel = $car->query("select message,status,amt from wallet_report where uid=".$uid." order by id desc");
$myarray = array();
$l=0;
$k=0;
$p = array();
while($row = $sel->fetch_assoc())
{
	if($row['status'] == 'Credit')
	{
	$l = $l + $row['amt'];	
	}
	else 
	{
		$k = $k + $row['amt'];
	}
	$p['message'] = $row['message'];
	$p['status'] = $row['status'];
	$p['amt'] = $row['amt'];
	
	$myarray[] = $p;
}
    $returnArr = array("Walletitem"=>$myarray,"wallet"=>$wallet['wallet'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Wallet Report Get Successfully!");
	}
    else
    {
      $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Request To Update Own Device!!!!");  
    }
    
}

echo json_encode($returnArr);