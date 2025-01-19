<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$uid = $data["uid"];
	$car_id = $data["car_id"];
	$carlists = $car->query("select * from tbl_gallery where uid=".$uid." and car_id=".$car_id."");
$navs = array();
$cars = array();
while($evs = $carlists->fetch_assoc())
{
	$cardata = $car->query("select * from tbl_car where id=".$evs['car_id']."")->fetch_assoc();
	$cars["id"] = $evs["id"];
	$cars["img"] = $evs["img"];
	
	$cars["car_title"] = $cardata["car_title"];
	$navs[] = $cars;
	
}
	
	
	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Car Gallery Get Successfully!!!","gallerylist"=>$navs);	
}
echo json_encode($returnArr);