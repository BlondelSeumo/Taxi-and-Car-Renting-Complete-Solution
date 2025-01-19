<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$pol = array();
$c = array();
$sel = $car->query("select * from tbl_facility where status=1");
while($row = $sel->fetch_assoc())
{
   
		$pol['id'] = $row['id'];
		$pol['title'] = $row['title'];
		
		$pol['img'] = $row['img'];
		
		
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("facilitylist"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Facility Not Founded!");
}
else 
{
$returnArr = array("facilitylist"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Facility List Founded!");
}
echo json_encode($returnArr);
?>