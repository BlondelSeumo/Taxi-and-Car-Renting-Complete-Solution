<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
$uid = $data['uid'];
$car_id = $data['car_id'];
if($uid == '' or $car_id == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
 $check = $car->query("select * from tbl_fav where uid=".$uid." and car_id=".$car_id."")->num_rows;
 if($check != 0)
 {
      
	  
	  $table="tbl_fav";
$where = "where uid=".$uid." and car_id=".$car_id."";
$h = new Crud($car);
	$check = $h->carDeleteData_Api($where,$table);
	
      $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Car Successfully Removed In Favourite List !!");
	  
 }
 else 
 {
     
	 $table="tbl_fav";
  $field_values=array("uid","car_id");
  $data_values=array("$uid","$car_id");
  $h = new Demand($car);
  $check = $h->carinsertdata_Api($field_values,$data_values,$table);
   $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Car Successfully Saved In Favourite List!!!");
   
    
 }
}
echo json_encode($returnArr);
?>