<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' || $data['book_id'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid = $data['uid']; 
 $book_id = $data['book_id'];
 $cancle_reason = $data['cancle_reason'];
 $table = "tbl_book";
    $field = ['uid' => $uid, 'book_status' => 'Cancelled', 'cancle_reason'=>$cancle_reason];
    $where = "where uid=" . $uid . " and id=" . $book_id . "";

    $h = new Demand($car);
    $check = $h->carupdateData_Api($field, $table, $where);
	
    $returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Booking Cancelled Successfully!!!!!"];
}
echo  json_encode($returnArr);
?>