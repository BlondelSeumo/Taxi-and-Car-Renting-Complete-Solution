<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' or $data['amt'] == '' or $data['r_type'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$uid = $data['uid'];
	$amt = $data['amt'];
	$r_type = $data['r_type'];
	$acc_number = $data['acc_number'];
	$bank_name = $data['bank_name'];
	$acc_name = $data['acc_name'];
	$ifsc_code = $data['ifsc_code'];
	$upi_id = $data['upi_id'];
	$paypal_id = $data['paypal_id'];
	
	$sales  = $car->query("select sum((subtotal-cou_amt) - ((subtotal-cou_amt) * commission/100)) as full_total from tbl_book where book_status='Completed'  and  post_id=".$uid."")->fetch_assoc();
	
	$without_cod = empty($sales['full_total']) ? 0 : $sales['full_total'];

	
	
	
	
	
	
            $payout =   $car->query("select sum(amt) as full_payout from payout_setting where uid=".$uid."")->fetch_assoc();
			$finalpayout = empty($payout['full_payout']) ? 0 : $payout['full_payout'];
                 $bs = 0;
				
				
				 if($sales['full_total'] == ''){}else {$bs = number_format((float)($without_cod)- $finalpayout, 2, '.', ''); }
				 
				 
				 if(floatval($amt) <= floatval($set['wlimit']))
				 {
					$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Minimum Withdraw Amount is a ".$set['wlimit'].$set['currency']); 
				 }
				 else if(floatval($amt) > floatval($bs))
				 {
					 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"You can't Withdraw Above Your Earning!"); 
				 }
				 else 
				 {
					 $timestamp = date("Y-m-d H:i:s");
					 $table="payout_setting";
  $field_values=array("uid","amt","status","r_date","r_type","acc_number","bank_name","acc_name","ifsc_code","upi_id","paypal_id");
  $data_values=array("$uid","$amt","pending","$timestamp","$r_type","$acc_number","$bank_name","$acc_name","$ifsc_code","$upi_id","$paypal_id");
  
      $h = new Demand($car);
	  $check = $h->carinsertdata_Api($field_values,$data_values,$table);
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Payout Request Submit Successfully!!");
				 }
}
echo json_encode($returnArr);
?>