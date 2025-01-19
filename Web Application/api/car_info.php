<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$car_id = $data['car_id'];
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

if($uid == '' or $car_id == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $carlists = $car->query("select tcar.*,(
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
    ) AS car_rate  from tbl_car AS tcar where tcar.id=".$car_id."")->fetch_assoc();
	
		$facilityResult = $car->query("SELECT GROUP_CONCAT(title) as facility,GROUP_CONCAT(img) as facility_img
        FROM tbl_facility 
        WHERE FIND_IN_SET(tbl_facility.id, '" . $carlists["car_facility"] . "') > 0")->fetch_assoc();
		
		$t = $car->query("select img,title from car_type where id=".$carlists["car_type"]."")->fetch_assoc();
		$b = $car->query("select img,title from car_brand where id=".$carlists["car_brand"]."")->fetch_assoc();
    $cars = array();
    $cars["id"] = $carlists["id"];
	$cars["type_id"] = $carlists["car_type"];
	$cars["city_id"] = $carlists["car_available"];
	$cars["brand_id"] = $carlists["car_brand"];
	$cars["min_hrs"] = $carlists["min_hrs"];
	$cars["car_title"] = $carlists["car_title"];
	$cars["car_img"] = explode('$;',$carlists["car_img"]);
	$cars["car_rating"] = $carlists["car_rate"];
	$cars["car_number"] = $carlists["car_number"];
	$cars["total_seat"] = $carlists["total_seat"];
	$cars["car_gear"] = $carlists["car_gear"];
	$cars["total_km"] = $carlists["total_km"];
	$cars["pick_lat"] = $carlists["pick_lat"];
	$cars["pick_lng"] = $carlists["pick_lng"];
	$cars["pick_address"] = $carlists["pick_address"];
	$cars["car_desc"] = $carlists["car_desc"];
	$cars["fuel_type"] = $carlists["fuel_type"];
	$cars["price_type"] = $carlists["price_type"];
	$cars["engine_hp"] = $carlists["engine_hp"];
	$cars["car_facility"] = $facilityResult["facility"];
	$cars["facility_img"] = $facilityResult["facility_img"];
	$cars['car_type_title'] = $t["title"];
	$cars['car_type_img'] = $t["img"];
	$cars['car_brand_title'] = $b["title"];
	$cars['car_brand_img'] = $b["img"];
	$cars["car_rent_price"] = $carlists["car_rent_price"];
	$cars["car_rent_price_driver"] = $carlists["car_rent_price_driver"];
	$cars["car_ac"] = $carlists["car_ac"];
	$cars['IS_FAVOURITE'] = $car->query("select * from tbl_fav where uid=".$uid." and car_id=".$carlists['id']."")->num_rows;
	$gal = array();
	$gallery = $car->query("select img from tbl_gallery where car_id=".$car_id."");
		while($rk = $gallery->fetch_assoc())
		{
			$gal = explode('$;',$rk['img']);
		}
		
		
	$returnArr = array("carinfo"=>$cars,"Gallery_images"=>$gal,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Car info get successfully!");
}
echo json_encode($returnArr);
?>