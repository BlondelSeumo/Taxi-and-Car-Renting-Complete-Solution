<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('IMAGE_PATH', '/images/car/');
function processFileUploads($prefix, $count, $url) {
    $targetPath = BASE_PATH . $url;
    $uploadedFiles = [];

    for ($i = 0; $i < $count; $i++) {
        $newName = uniqid() . date('YmdHis') . mt_rand() . '.jpg';
        $fileUrl = $url . $newName;

        // Remove leading '/' from each file URL
        $fileUrl = ltrim($fileUrl, '/');

        $uploadedFiles[] = $fileUrl;

        // Move uploaded file and check for errors
        if (!move_uploaded_file($_FILES[$prefix . $i]['tmp_name'], $targetPath . $newName)) {
            // Handle upload error here (e.g., provide feedback to the user)
        }
    }

    return $uploadedFiles;
}
if($_POST["car_number"] == '' or $_POST["car_status"] == '' or $_POST["car_rating"] == ''   or $_POST["total_seat"] == '' or $_POST["car_ac"] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
        $car_number = $_POST["car_number"];
        $car_status = $_POST["car_status"];
        $car_rating = $_POST["car_rating"];
        $total_seat = $_POST["total_seat"];
		$min_hrs = $_POST["min_hrs"];
        $car_ac = $_POST["car_ac"];
        $car_title = $car->real_escape_string($_POST["car_title"]);
        $driver_name = $car->real_escape_string($_POST["driver_name"]);
        $driver_mobile = $car->real_escape_string($_POST["driver_mobile"]);
		$car_gear = $_POST["car_gear"];
		$car_facility = $_POST["car_facility"];
		$car_type = $_POST["car_type"];
		$car_brand = $_POST["car_brand"];
		$car_available = $_POST["car_available"];
		$car_rent_price = $_POST["car_rent_price"];
		$car_rent_price_driver = $_POST["car_rent_price_driver"];
		$engine_hp = $_POST["engine_hp"];
		$price_type = $_POST["price_type"];
		$fuel_type = $_POST["fuel_type"];
		$car_desc = $car->real_escape_string($_POST["car_desc"]);
		$pick_address = $car->real_escape_string($_POST["pick_address"]);
		$pick_lat = $_POST["pick_lat"];
		$pick_lng = $_POST["pick_lng"];
		$total_km = $_POST["total_km"];
		$size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
		$uid = $_POST["uid"];
		$imlist = $_POST['imlist'];
		$record_id = $_POST['record_id'];

if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('carphoto', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }
	
	$imageList = '';
	if (empty($_FILES['carphoto0']['name'][0]) && $imlist != "0") {
    // No new image was uploaded, and there are existing images
    $imageList = $imlist;
    
} else if (empty($_FILES['carphoto0']['name'][0]) && $imlist == "0") {
    // No new image was uploaded, and there are no existing images
    $imageList = $imlist;
    
} else if ($imlist == "0") {
    // New images were uploaded, and there are no existing images
    $imageList = $multifile;
    
} else {
    // New images were uploaded, and there are existing images
    $imageList = $imlist . '$;' . $multifile;
   
}
	
	
	$table = "tbl_car";
                $field = [
                    "car_number" => $car_number,
					"car_img"   =>  $imageList,
                    "car_status" => $car_status,
                    "car_title" => $car_title,
                    "car_rating" => $car_rating,
                    "total_seat" => $total_seat,
                    "car_ac" => $car_ac,
                    "driver_name" => $driver_name,
                    "driver_mobile" => $driver_mobile,
					"car_gear" => $car_gear,
					"car_facility" => $car_facility,
					"car_type" => $car_type,
					"car_brand" => $car_brand,
					"car_available" => $car_available,
					"car_rent_price" => $car_rent_price,
					"car_rent_price_driver" => $car_rent_price_driver,
					"engine_hp" => $engine_hp,
					"price_type" => $price_type,
					"fuel_type" => $fuel_type,
					"car_desc" => $car_desc,
					"pick_address" => $pick_address,
					"pick_lat" => $pick_lat,
					"pick_lng" => $pick_lng,
					"total_km" => $total_km,
					"min_hrs" => $min_hrs
                ];
                $where =
                    "where id=" . $record_id . " and post_id=".$uid."";
                $h = new Demand($car);
                $check = $h->carupdateData_Api($field, $table, $where);
            
			
			$returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Update Successfully!!!!!"];
}

echo json_encode($returnArr);