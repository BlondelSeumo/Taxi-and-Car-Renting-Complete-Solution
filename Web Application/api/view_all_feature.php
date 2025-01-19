<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$lats = $data['lats'];
$longs = $data['longs'];
$cityid = $data['cityid'];
function calculateDistance($originLat, $originLng, $destLat, $destLng, $apiKey) {
    $unit = "K";
    $theta = (float)$originLng - (float)$destLng;
    $dist = sin(deg2rad((float)$originLat)) * sin(deg2rad((float)$destLat)) + cos(deg2rad((float)$originLat)) * cos(deg2rad((float)$destLat)) * cos(deg2rad((float)$theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        $distanceInKilometers = $miles * 1.609344;
        return round($distanceInKilometers, 2); // Rounded to 2 decimal places
    } else if ($unit == "N") {
        $distanceInNauticalMiles = $miles * 0.8684;
        return round($distanceInNauticalMiles, 2); // Rounded to 2 decimal places
    } else {
        return round($miles, 2); // Rounded to 2 decimal places
    }
}

if($data['uid'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$check_user_verify = $car->query("select * from tbl_user where id=".$data['uid']."")->fetch_assoc();
	$is_block = empty($check_user_verify["status"]) ? "1" : ($check_user_verify["status"] == 1 ? "0" : "1");
$uid = $data["uid"];
 if($cityid == 0)
 {
	$carlists = $car->query("SELECT 
	 (((acos(sin((".$lats."*pi()/180)) * sin((`pick_lat`*pi()/180))+cos((".$lats."*pi()/180)) * cos((`pick_lat`*pi()/180)) * cos(((".$longs."-`pick_lng`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance,
	tcar.id,
    tcar.car_title,
    tcar.car_img,
    tcar.car_rating,
    tcar.car_number,
    tcar.total_seat,
    tcar.car_gear,
    tcar.pick_lat,
    tcar.pick_lng,
    tcar.car_rent_price,
    tcar.price_type,
    tcar.engine_hp,
    tcar.fuel_type,
    tcar.car_type,
    (
        SELECT 
            CASE 
                WHEN COUNT(*) != 0 THEN 
                    FORMAT(SUM(total_rate) / COUNT(*), IF(SUM(total_rate) % COUNT(*) > 0, 2, 0))
                ELSE 
                    tcar.car_rating 
            END 
        FROM tbl_book 
        WHERE car_id = tcar.id 
            AND book_status = 'Completed' 
            AND is_rate = 1
    ) AS car_rate 
FROM 
    tbl_car AS tcar  
	where tcar.car_status=1  and tcar.post_id !=".$uid."  and tcar.is_approve=1
	order by distance");
 }
 else 
 {
	 $carlists = $car->query("SELECT 
	 (((acos(sin((".$lats."*pi()/180)) * sin((`pick_lat`*pi()/180))+cos((".$lats."*pi()/180)) * cos((`pick_lat`*pi()/180)) * cos(((".$longs."-`pick_lng`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance,
	tcar.id,
    tcar.car_title,
    tcar.car_img,
    tcar.car_rating,
    tcar.car_number,
    tcar.total_seat,
    tcar.car_gear,
    tcar.pick_lat,
    tcar.pick_lng,
    tcar.car_rent_price,
    tcar.price_type,
    tcar.engine_hp,
    tcar.fuel_type,
    tcar.car_type,
    (
        SELECT 
            CASE 
                WHEN COUNT(*) != 0 THEN 
                    FORMAT(SUM(total_rate) / COUNT(*), IF(SUM(total_rate) % COUNT(*) > 0, 2, 0))
                ELSE 
                    tcar.car_rating 
            END 
        FROM tbl_book 
        WHERE car_id = tcar.id 
            AND book_status = 'Completed' 
            AND is_rate = 1
    ) AS car_rate 
FROM 
    tbl_car AS tcar  
	where tcar.car_status=1 and tcar.car_available=".$cityid." and tcar.post_id !=".$uid."  and tcar.is_approve=1
	order by distance");
 }
$navs = array();
$cars = array();
while($evs = $carlists->fetch_assoc())
{
	
	$t = $car->query("select title from car_type where id=".$evs["car_type"]."")->fetch_assoc();
	$cars["id"] = $evs["id"];
	$cars["car_title"] = $evs["car_title"];
	$im = explode('$;',$evs['car_img']);
	$cars["car_img"] = $im[0];
	$cars["car_rating"] = $evs["car_rate"];
	$cars["car_number"] = $evs["car_number"];
	$cars["total_seat"] = $evs["total_seat"];
	$cars["car_gear"] = $evs["car_gear"];
	$cars["car_rent_price"] = $evs["car_rent_price"];
	$cars["price_type"] = $evs["price_type"];
	$cars["engine_hp"] = $evs["engine_hp"];
	$cars["fuel_type"] = $evs["fuel_type"];
	$cars['car_type_title'] = $t["title"];
	$distance = calculateDistance($lats, $longs,$evs['pick_lat'], $evs['pick_lng'], $apiKey);
	$cars["car_distance"] = $distance.' KM';
	$navs[] = $cars;
	
}
	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Home Data Get Successfully!!!",'is_block'=>$is_block,"tax"=>$set['tax'],"currency"=>$set['currency'],"FeatureCar"=>$navs);	
}
echo json_encode($returnArr);