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
	$carlists = $car->query("select * from tbl_car where post_id=".$uid."");
$navs = array();
$cars = array();
while($evs = $carlists->fetch_assoc())
{
	$cars["id"] = $evs["id"];
	$cars["car_title"] = $evs["car_title"];
	$cars["car_img"] = $evs["car_img"];
	$cars["car_rating"] = $evs["car_rating"];
	$cars["car_number"] = $evs["car_number"];
	$cars["total_seat"] = $evs["total_seat"];
	$cars["car_gear"] = $evs["car_gear"];
	$cars["pick_lat"] = $evs["pick_lat"];
	$cars["pick_lng"] = $evs["pick_lng"];
	$cars["engine_hp"] = $evs["engine_hp"];
	$cars["fuel_type"] = $evs["fuel_type"];
	$cars["pick_address"] = $evs["pick_address"];
	$cars["car_status"] = $evs["car_status"];
	$cars["total_seat"] = $evs["total_seat"];
	$cars["car_ac"] = $evs["car_ac"];
	$cars["driver_name"] = $evs["driver_name"];
	$cars["driver_mobile"] = $evs["driver_mobile"];
	$cars["car_facility"] = $evs["car_facility"];
	$cars["car_type"] = $evs["car_type"];
	$cars["car_brand"] = $evs["car_brand"];
	$cars["min_hrs"] = $evs["min_hrs"];
	$cars["car_available"] = $evs["car_available"];
	$cars["car_rent_price"] = $evs["car_rent_price"];
	$cars["car_rent_price_driver"] = $evs["car_rent_price_driver"];
	$cars["price_type"] = $evs["price_type"];
	$cars["car_desc"] = $evs["car_desc"];
	$cars["total_km"] = $evs["total_km"];
	$cars["total_gallery"] = $car->query("SELECT * FROM `tbl_gallery` where car_id=".$evs["id"]."")->num_rows;
	$navs[] = $cars;
	
}
	
	
	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Type wise Car Get Successfully!!!","mycarlist"=>$navs);	
}
echo json_encode($returnArr);