<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['car_id'] == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else 
{
$pol = array();
$c = array();
$sel = $car->query("select * from tbl_book where car_id=".$data['car_id']."");
while($row = $sel->fetch_assoc())
{
   
		$pol['pickup_date'] = $row['pickup_date'];
		$pol['return_date'] = $row['return_date'];
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("bookeddate"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Date Not Founded!");
}
else 
{
$returnArr = array("bookeddate"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Date List Founded!");
}
}
echo json_encode($returnArr);
?>