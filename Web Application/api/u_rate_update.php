<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' or $data['book_id'] == ''   or $data['total_rate']==''  or $data['rate_text'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	
	$uid = $data['uid'];
	$book_id = $data['book_id'];
	$total_rate = $data['total_rate'];
	$rate_text = $car->real_escape_string($data['rate_text']);
	 $timestamp    = date("Y-m-d");
	 $check_status = $car->query("select * from tbl_book where uid=".$uid." and id=".$book_id." and book_status='Completed'")->num_rows;
	 if($check_status != 0)
	 {
	$table="tbl_book";
  $field = array('total_rate'=>$total_rate,'rate_text'=>$rate_text,'is_rate'=>"1",'review_date'=>$timestamp);
  $where = "where uid=".$uid." and id=".$book_id."";
$h = new Crud($car);
	  $check = $h->carupdateData_Api($field,$table,$where);
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Rate Updated Successfully!!!");
	 }
	 else 
	 {
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Car Not Drop Original Locations!!!"); 
	 }
	  
}
echo json_encode($returnArr);