<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$lats = $data['lats'];
$longs = $data['longs'];
$uid = $data['uid'];
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
	$uid = $data['uid'];
$getfavlist = $car->query("select * from tbl_fav where uid=".$uid."");
$navs = array();
$cars = array();
while($row = $getfavlist->fetch_assoc())
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
	where tcar.car_status=1 and  tcar.id=".$row["car_id"]." and tcar.post_id !=".$uid."
	order by distance")->fetch_assoc();

	$cars["id"] = $carlists["id"];
	$cars["car_title"] = $carlists["car_title"];
	$cars["car_img"] = $carlists["car_img"];
	$cars["car_rating"] = $carlists["car_rate"];
	$cars["car_number"] = $carlists["car_number"];
	$cars["total_seat"] = $carlists["total_seat"];
	$cars["car_gear"] = $carlists["car_gear"];
	$cars["price_type"] = $carlists["price_type"];
	$cars["engine_hp"] = $carlists["engine_hp"];
	$cars["fuel_type"] = $carlists["fuel_type"];
	$distance = calculateDistance($lats, $longs,$carlists['pick_lat'], $carlists['pick_lng'], $apiKey);
	$cars["car_distance"] = $distance.' KM';
	$navs[] = $cars;
}
	
	
	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Favourite Car Get Successfully!!!","FeatureCar"=>$navs);	
}
echo json_encode($returnArr);