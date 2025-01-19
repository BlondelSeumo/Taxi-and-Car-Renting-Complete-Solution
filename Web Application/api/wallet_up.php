<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' or $data['wallet'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $wallet = strip_tags(mysqli_real_escape_string($car,$data['wallet']));
$uid =  strip_tags(mysqli_real_escape_string($car,$data['uid']));
$checkimei = mysqli_num_rows(mysqli_query($car,"select * from tbl_user where  `id`=".$uid.""));

if($checkimei != 0)
    {
		
		
      $vp = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  
  $table="tbl_user";
  $field = array('wallet'=>$vp['wallet']+$wallet);
  $where = "where id=".$uid."";
$h = new Demand($car);
	  $check = $h->carupdateData_Api($field,$table,$where);
	  
	   $timestamp = date("Y-m-d H:i:s");
	   $timestamps    = date("Y-m-d");
	   $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$uid",'Wallet Balance Added!!','Credit',"$wallet","$timestamps");
   
      $h = new Demand($car);
	  $checks = $h->carinsertdata_Api($field_values,$data_values,$table);
	  
	  
	   $wallet = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
        $returnArr = array("wallet"=>$wallet['wallet'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Wallet Update successfully!");
        
    
	}
    else
    {
      $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"User Deactivate By Admin!!!!");  
    }
    
}

echo json_encode($returnArr);