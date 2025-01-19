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
    $uid = strip_tags(mysqli_real_escape_string($car,$data['uid']));
    
    
$check = $car->query("select * from tbl_notification where uid=".$uid."");
$op = array();
while($row = $check->fetch_assoc())
{
		$op[] = $row;
}

if(empty($op))
{
	$returnArr = array("NotificationData"=>[],"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Notification Not Found!!");
}
else 
{
$returnArr = array("NotificationData"=>$op,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Notification List Get Successfully!!");
}

}
echo json_encode($returnArr);