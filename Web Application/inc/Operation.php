<?php
include 'Connection.php';
include 'Demand.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST["type"])) {
   
    if ($_POST['type'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $h = new Demand($car);

        $count = $h->carlogin($username, $password, 'admin');
        if($count == - 1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($count == 1) {
            $_SESSION['carname'] = $username;

            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Login Successfully!", "message" => "welcome admin!!", "action" => "dashboard.php"];
        } else {
            $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Please Use Valid Data!!", "message" => "welcome admin!!", "action" => "index.php"];
        }
        }
    }  
	elseif ($_POST["type"] == "add_coupon") {
        $expire_date = $_POST["expire_date"];
        $status = $_POST["status"];
        $coupon_code = $_POST["coupon_code"];
        $min_amt = $_POST["min_amt"];
        $coupon_val = $_POST["coupon_val"];
        $description = $car->real_escape_string($_POST["description"]);
        $title = $car->real_escape_string($_POST["title"]);
        $subtitle = $car->real_escape_string($_POST["subtitle"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/coupon/";
        $url = "images/coupon/";
        $temp = explode(".", $_FILES["coupon_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["coupon_img"]["tmp_name"], $target_file);
            $table = "tbl_coupon";
            $field_values = [
                "expire_date",
                "status",
                "title",
                "coupon_code",
                "min_amt",
                "coupon_val",
                "description",
                "subtitle",
                "coupon_img",
            ];
            $data_values = [
                "$expire_date",
                "$status",
                "$title",
                "$coupon_code",
                "$min_amt",
                "$coupon_val",
                "$description",
                "$subtitle",
                "$url",
            ];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
            if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Coupon Add Successfully!!",
                    "message" => "Coupon section!",
                    "action" => "list_coupon.php",
                ];
            } 
        }
        
    }elseif ($_POST["type"] == "add_gal") {
        
		$car_id = $_POST['car_id'];
		$imageList = '';
$url = 'images/gallery/';
 $v = array();
   foreach ($_FILES['cat_img']['name'] as $key => $filename) {
    $tempLocation = $_FILES['cat_img']['tmp_name'][$key];
    $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
    $target_path = dirname(dirname(__FILE__)) . '/images/gallery/';
    $v[] = $url . $newname;
    move_uploaded_file($tempLocation, $target_path . $newname);

    $temp = explode(".", $filename);
    // Check if the file extension is not allowed
    
}

$imageList = implode('$;', $v);

        
            
            $table = "tbl_gallery";
            $field_values = ["img", "car_id","uid"];
            $data_values = ["$imageList", "$car_id",'0'];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Gallery Add Successfully!!",
                    "message" => "Gallery section!",
                    "action" => "list_gal.php",
                ];
            } 
        }
        
    }elseif ($_POST["type"] == "edit_gal") {
        
        
		$car_id = $_POST['car_id'];
		$id = $_POST['id'];
		$imlist = $_POST['imlist'];
		
		$imageList = '';
$url = 'images/car/';
if (!empty($_FILES['cat_img']['name'][0])) {
 $v = array();
   foreach ($_FILES['cat_img']['name'] as $key => $filename) {
    $tempLocation = $_FILES['cat_img']['tmp_name'][$key];
    $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
    $target_path = dirname(dirname(__FILE__)) . '/images/car/';
    $v[] = $url . $newname;
   

    $temp = explode(".", $filename);
    // Check if the file extension is not allowed
    
	 move_uploaded_file($tempLocation, $target_path . $newname);	
	
}
}

		if (empty($_FILES['cat_img']['name'][0]) && $imlist != "0") {
    // No new image was uploaded, and there are existing images
    $imageList = $imlist;
    
} else if (empty($_FILES['cat_img']['name'][0]) && $imlist == "0") {
    // No new image was uploaded, and there are no existing images
    $imageList = $imlist;
    
} else if ($imlist == "0") {
    // New images were uploaded, and there are no existing images
    $imageList = implode('$;', $v);
    
} else {
    // New images were uploaded, and there are existing images
    $imageList = $imlist . '$;' . implode('$;', $v);
   
}

        
                $table = "tbl_gallery";
                $field = [ "img" => $imageList,"car_id"=>$car_id,"uid"=>'0'];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
                
                 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Gallery Update Successfully!!",
                        "message" => "Gallery section!",
                        "action" => "list_gal.php",
                    ];
                } 
        }
        
    }
	elseif($_POST["type"] == "make_decision")
	{
		$c_reason = $_POST["c_reason"];
		$decision_id = $_POST["decision_id"];
		$id = $_POST["id"];
		 $table = "tbl_car";
                $field = [ "reject_comment" => $c_reason,"is_approve"=>$decision_id];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Decision Update Successfully!!",
                        "message" => "Decision section!",
                        "action" => "list_car.php",
                    ];
                } 
        }
				
	}
	elseif($_POST["type"] == "add_car")
	{
		$car_number = $_POST["car_number"];
		$min_hrs = $_POST["min_hrs"];
        $car_status = $_POST["car_status"];
        $car_rating = $_POST["car_rating"];
        $total_seat = $_POST["total_seat"];
        $car_ac = $_POST["car_ac"];
        $car_title = $car->real_escape_string($_POST["car_title"]);
        $driver_name = $car->real_escape_string($_POST["driver_name"]);
        $driver_mobile = $car->real_escape_string($_POST["driver_mobile"]);
        
		
		$car_gear = $_POST["car_gear"];
		$car_facility = implode(',',$_POST["car_facility"]);
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
		
		$imageList = '';
$url = 'images/car/';
 $v = array();
   foreach ($_FILES['car_img']['name'] as $key => $filename) {
    $tempLocation = $_FILES['car_img']['tmp_name'][$key];
    $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
    $target_path = dirname(dirname(__FILE__)) . '/images/car/';
    $v[] = $url . $newname;
    move_uploaded_file($tempLocation, $target_path . $newname);

    $temp = explode(".", $filename);
    // Check if the file extension is not allowed
    
}

$imageList = implode('$;', $v);
            
			$table = "tbl_car";
            $field_values = [
                "car_number",
                "car_status",
                "car_title",
                "car_rating",
                "total_seat",
                "car_ac",
                "driver_name",
                "driver_mobile",
                "car_img",
				"car_gear",
				"car_facility",
				"car_type",
				"car_brand",
				"car_available",
				"car_rent_price",
				"car_rent_price_driver",
				"engine_hp",
				"price_type",
				"fuel_type",
				"car_desc",
				"pick_address",
				"pick_lat",
				"pick_lng",
				"total_km",
				"min_hrs",
				"post_id",
				"is_approve"
            ];
            $data_values = [
                "$car_number",
                "$car_status",
                "$car_title",
                "$car_rating",
                "$total_seat",
                "$car_ac",
                "$driver_name",
                "$driver_mobile",
                "$imageList",
				"$car_gear",
				"$car_facility",
				"$car_type",
				"$car_brand",
				"$car_available",
				"$car_rent_price",
				"$car_rent_price_driver",
				"$engine_hp",
				"$price_type",
				"$fuel_type",
				"$car_desc",
				"$pick_address",
				"$pick_lat",
				"$pick_lng",
				"$total_km",
				"$min_hrs",
				'0',
				'1'
            ];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Add Successfully!!",
                    "message" => "Car section!",
                    "action" => "list_car.php",
                ];
            } 
        }
		
	}elseif($_POST["type"] == "edit_car")
	{
		$car_number = $_POST["car_number"];
		$id = $_POST["id"];
		$min_hrs = $_POST["min_hrs"];
        $car_status = $_POST["car_status"];
        $car_rating = $_POST["car_rating"];
        $total_seat = $_POST["total_seat"];
        $car_ac = $_POST["car_ac"];
        $car_title = $car->real_escape_string($_POST["car_title"]);
        $driver_name = $car->real_escape_string($_POST["driver_name"]);
        $driver_mobile = $car->real_escape_string($_POST["driver_mobile"]);
		$car_gear = $_POST["car_gear"];
		$car_facility = implode(',',$_POST["car_facility"]);
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
		$imlist = $_POST['imlist'];
		
		$imageList = '';
$url = 'images/car/';
if (!empty($_FILES['car_img']['name'][0])) {
 $v = array();
   foreach ($_FILES['car_img']['name'] as $key => $filename) {
    $tempLocation = $_FILES['car_img']['tmp_name'][$key];
    $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
    $target_path = dirname(dirname(__FILE__)) . '/images/car/';
    $v[] = $url . $newname;
   

    $temp = explode(".", $filename);
    // Check if the file extension is not allowed
   
	 move_uploaded_file($tempLocation, $target_path . $newname);	
	
}
}

		if (empty($_FILES['car_img']['name'][0]) && $imlist != "0") {
    // No new image was uploaded, and there are existing images
    $imageList = $imlist;
    
} else if (empty($_FILES['car_img']['name'][0]) && $imlist == "0") {
    // No new image was uploaded, and there are no existing images
    $imageList = $imlist;
    
} else if ($imlist == "0") {
    // New images were uploaded, and there are no existing images
    $imageList = implode('$;', $v);
    
} else {
    // New images were uploaded, and there are existing images
    $imageList = $imlist . '$;' . implode('$;', $v);
   
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
					"min_hrs"=> $min_hrs
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
                 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Update Successfully!!",
                    "message" => "Car section!",
                    "action" => "list_car.php",
                ];
            } 
        }
	}	elseif ($_POST["type"] == "edit_coupon") {
        $expire_date = $_POST["expire_date"];
        
        $id = $_POST["id"];
        $status = $_POST["status"];
        $coupon_code = $_POST["coupon_code"];
        $min_amt = $_POST["min_amt"];
        $coupon_val = $_POST["coupon_val"];
        $description = $car->real_escape_string($_POST["description"]);
        $title = $car->real_escape_string($_POST["title"]);
        $subtitle = $car->real_escape_string($_POST["subtitle"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/coupon/";
        $url = "images/coupon/";
        $temp = explode(".", $_FILES["coupon_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["coupon_img"]["name"] != "") {
                move_uploaded_file(
                    $_FILES["coupon_img"]["tmp_name"],
                    $target_file
                );
                $table = "tbl_coupon";
                $field = [
                    "status" => $status,
                    "coupon_img" => $url,
                    "title" => $title,
                    "coupon_code" => $coupon_code,
                    "min_amt" => $min_amt,
                    "coupon_val" => $coupon_val,
                    "description" => $description,
                    "subtitle" => $subtitle,
                    "expire_date" => $expire_date,
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
                  if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Coupon Update Successfully!!",
                        "message" => "Coupon section!",
                        "action" => "list_coupon.php",
                    ];
                } 
        }
	}  
         else {
            $table = "tbl_coupon";
            $field = [
                "status" => $status,
                "title" => $title,
                "coupon_code" => $coupon_code,
                "min_amt" => $min_amt,
                "coupon_val" => $coupon_val,
                "description" => $description,
                "subtitle" => $subtitle,
                "expire_date" => $expire_date,
            ];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Coupon Update Successfully!!",
                    "message" => "Coupon section!",
                    "action" => "list_coupon.php",
                ];
            } 
        }
        }
	}
    elseif ($_POST["type"] == "add_facility") {
        $okey = $_POST["status"];
        $title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/facility/";
        $url = "images/facility/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_facility";
            $field_values = ["img", "status", "title"];
            $data_values = ["$url", "$okey", "$title"];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Facility Add Successfully!!",
                    "message" => "Facility section!",
                    "action" => "list_facility.php",
                ];
            } 
        }
        
    }elseif ($_POST["type"] == "edit_facility") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/facility/";
        $url = "images/facility/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
         
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_facility";
                $field = ["status" => $okey, "img" => $url, "title" => $title];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Facility Update Successfully!!",
                        "message" => "Facility section!",
                        "action" => "list_facility.php",
                    ];
                } 
            }
            
        } else {
            $table = "tbl_facility";
            $field = ["status" => $okey, "title" => $title];
            $where = "where id=" . $id . "";
            $h = new Demand($bus);
            $check = $h->busupdateData($field, $table, $where);
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Facility Update Successfully!!",
                    "message" => "Facility section!",
                    "action" => "list_facility.php",
                ];
            } 
        }
        }
    }
      elseif ($_POST['type'] == 'add_page') {
        $ctitle = $car->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $car->real_escape_string($_POST['cdesc']);
        $table = "tbl_page";

        $field_values = ["description", "status", "title"];
        $data_values = ["$cdesc", "$cstatus", "$ctitle"];

        $h = new Demand($car);
        $check = trim($h->carinsertdata($field_values, $data_values, $table));
         if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Add Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
        }
    } elseif ($_POST['type'] == 'edit_page') {
        $id = $_POST['id'];
        $ctitle = $car->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $car->real_escape_string($_POST['cdesc']);

        $table = "tbl_page";
        $field = ['description' => $cdesc, 'status' => $cstatus, 'title' => $ctitle];
        $where = "where id=" . $id . "";
        $h = new Demand($car);
        $check = trim($h->carupdateData($field, $table, $where));
         if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Update Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
        }
    } elseif ($_POST['type'] == 'edit_payment') {
        $attributes = mysqli_real_escape_string($car, $_POST['p_attr']);
        $ptitle = mysqli_real_escape_string($car, $_POST['ptitle']);
        $okey = $_POST['status'];
        $id = $_POST['id'];
        $p_show = $_POST['p_show'];
        $target_dir = dirname(dirname(__FILE__)) . "/images/payment/";
        $url = "images/payment/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != '') {
           
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_payment_list";
                $field = ['status' => $okey, 'img' => $url, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
                } 
            }
            
        } else {
            $table = "tbl_payment_list";
            $field = ['status' => $okey, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
            } 
        }
        }
    } elseif ($_POST['type'] == 'add_faq') {
        $question = mysqli_real_escape_string($car, $_POST['question']);
        $answer = mysqli_real_escape_string($car, $_POST['answer']);
        $okey = $_POST['status'];

        $table = "tbl_faq";
        $field_values = ["question", "answer", "status"];
        $data_values = ["$question", "$answer", "$okey"];

        $h = new Demand($car);
        $check = trim($h->carinsertdata($field_values, $data_values, $table));
         if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Add Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        } 
        }
    } elseif ($_POST['type'] == 'edit_faq') {
        $question = mysqli_real_escape_string($car, $_POST['question']);
        $answer = mysqli_real_escape_string($car, $_POST['answer']);
        $okey = $_POST['status'];
        $id = $_POST['id'];

        $table = "tbl_faq";
        $field = ['question' => $question, 'status' => $okey, 'answer' => $answer];
        $where = "where id=" . $id . "";
        $h = new Demand($car);
        $check = trim($h->carupdateData($field, $table, $where));
         if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Update Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        } 
        }
    }  elseif ($_POST['type'] == 'edit_profile') {
        
            $dname = $_POST['username'];
            $dsname = $_POST['password'];
			$mobile = $_POST['mobile'];
            $id = $_POST['id'];
            $table = "admin";
            $field = ['username' => $dname, 'password' => $dsname , 'mobile'=>$mobile];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Profile Update Successfully!!", "message" => "Profile  section!", "action" => "profile.php"];
            } 
        }
        
    }  elseif ($_POST['type'] == 'edit_setting') {
        $webname = mysqli_real_escape_string($car, $_POST['webname']);
        $timezone = $_POST['timezone'];
        $currency = $_POST['currency'];
        $id = $_POST['id'];
        $tax = $_POST['tax'];
        $contact_no = $_POST['contact_no'];
        $one_key = $_POST['one_key'];
        $one_hash = $_POST['one_hash'];
        $commission_rate = $_POST['commission_rate'];
        $scredit = $_POST['scredit'];
		$wlimit = $_POST['wlimit'];
        $rcredit = $_POST['rcredit'];
		$sms_type = $_POST['sms_type'];
		$auth_key = $_POST['auth_key'];
		$otp_id = $_POST['otp_id'];
		$acc_id = $_POST['acc_id'];
		$auth_token = $_POST['auth_token'];
		$twilio_number = $_POST['twilio_number'];
		$otp_auth = $_POST['otp_auth'];

        $target_dir = dirname(dirname(__FILE__)) . "/images/website/";
        $url = "images/website/";
        $temp = explode(".", $_FILES["weblogo"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["weblogo"]["name"] != '') {
            
                move_uploaded_file($_FILES["weblogo"]["tmp_name"], $target_file);
                $table = "tbl_setting";
                $field = ['timezone' => $timezone, 'weblogo' => $url, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash, 'scredit' => $scredit, 'rcredit' => $rcredit,'tax'=>$tax,'contact_no'=>$contact_no,'commission_rate'=>$commission_rate,'wlimit'=>$wlimit,'otp_auth'=>$otp_auth,
					'twilio_number'=>$twilio_number,
					'auth_token'=>$auth_token,
					'acc_id'=>$acc_id,
					'otp_id'=>$otp_id,
					'auth_key'=>$auth_key,
					'sms_type'=>$sms_type];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Setting section!", "action" => "setting.php"];
                } 
            }
            
        } else {
            $table = "tbl_setting";
            $field = ['timezone' => $timezone, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash, 'scredit' => $scredit, 'rcredit' => $rcredit,'tax'=>$tax,'contact_no'=>$contact_no,'commission_rate'=>$commission_rate,'wlimit'=>$wlimit,'otp_auth'=>$otp_auth,
					'twilio_number'=>$twilio_number,
					'auth_token'=>$auth_token,
					'acc_id'=>$acc_id,
					'otp_id'=>$otp_id,
					'auth_key'=>$auth_key,
					'sms_type'=>$sms_type];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Offer section!", "action" => "setting.php"];
            } 
        }
        }
    } elseif ($_POST["type"] == "add_city") {
        $okey = $_POST["status"];
        $title = $car->real_escape_string($_POST["title"]);
        
        
            
            $table = "tbl_city";
            $field_values = [ "status", "title"];
            $data_values = [ "$okey", "$title"];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "City Add Successfully!!",
                    "message" => "City section!",
                    "action" => "list_city.php",
                ];
            } 
        }
        
    } elseif ($_POST["type"] == "add_banner") {
        $okey = $_POST["status"];

        $target_dir = dirname(dirname(__FILE__)) . "/images/banner/";
        $url = "images/banner/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_banner";
            $field_values = ["img", "status"];
            $data_values = ["$url", "$okey"];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
            
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Banner Add Successfully!!",
                    "message" => "Banner section!",
                    "action" => "list_banner.php",
                ];
            } 
        }
        
    } elseif ($_POST["type"] == "add_car_type") {
        $okey = $_POST["status"];
        $title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/cartype/";
        $url = "images/cartype/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "car_type";
            $field_values = ["img", "status","title"];
            $data_values = ["$url", "$okey","$title"];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Type Add Successfully!!",
                    "message" => "Car Type section!",
                    "action" => "list_car_type.php",
                ];
            } 
        }
        
    } elseif ($_POST["type"] == "add_car_brand") {
        $okey = $_POST["status"];
        $title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/carbrand/";
        $url = "images/carbrand/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "car_brand";
            $field_values = ["img", "status","title"];
            $data_values = ["$url", "$okey","$title"];

            $h = new Demand($car);
            $check = trim($h->carinsertdata($field_values, $data_values, $table));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Brand Add Successfully!!",
                    "message" => "Car Brand section!",
                    "action" => "list_car_brand.php",
                ];
            } 
        }
        
    }  elseif ($_POST["type"] == "edit_city") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $title = $car->real_escape_string($_POST["title"]);
        
            $table = "tbl_city";
            $field = ["status" => $okey, "title" => $title];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "City Update Successfully!!",
                    "message" => "City section!",
                    "action" => "list_city.php",
                ];
            } 
        }
    } elseif ($_POST["type"] == "edit_banner") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $target_dir = dirname(dirname(__FILE__)) . "/images/banner/";
        $url = "images/banner/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
           
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_banner";
                $field = ["status" => $okey, "img" => $url];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Banner Update Successfully!!",
                        "message" => "Banner section!",
                        "action" => "list_banner.php",
                    ];
                } 
            }
            
        } else {
            $table = "tbl_banner";
            $field = ["status" => $okey];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Banner Update Successfully!!",
                    "message" => "Banner section!",
                    "action" => "list_banner.php",
                ];
            } 
        }
        }
    } elseif ($_POST["type"] == "edit_car_type") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/cartype/";
        $url = "images/cartype/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "car_type";
                $field = ["status" => $okey, "img" => $url,"title"=>$title];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Car Type Update Successfully!!",
                        "message" => "Car Type section!",
                        "action" => "list_car_type.php",
                    ];
                } 
            }
            
        } else {
            $table = "car_type";
            $field = ["status" => $okey,"title"=>$title];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Type Update Successfully!!",
                    "message" => "Car Type section!",
                    "action" => "list_car_type.php",
                ];
            } 
        }
        }
    } elseif ($_POST["type"] == "edit_car_brand") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $car->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/carbrand/";
        $url = "images/carbrand/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "car_brand";
                $field = ["status" => $okey, "img" => $url,"title"=>$title];
                $where = "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
 if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Car Brand Update Successfully!!",
                        "message" => "Car Brand section!",
                        "action" => "list_car_brand.php",
                    ];
                } 
            }
            
        } else {
            $table = "car_brand";
            $field = ["status" => $okey,"title"=>$title];
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Car Brand Update Successfully!!",
                    "message" => "Car Brand section!",
                    "action" => "list_car_brand.php",
                ];
            } 
        }
        }
    } 	elseif ($_POST["type"] == "update_status") {
        $id = $_POST["id"];
        $status = $_POST["status"];
        $coll_type = $_POST["coll_type"];
        $page_name = $_POST["page_name"];
         if ($coll_type == "userstatus") {
            $table = "tbl_user";
            $field = "status=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData_single($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "User Status Change Successfully!!",
                    "message" => "User section!",
                    "action" => "userlist.php",
                ];
            } 
        }
        }  elseif ($coll_type == "dark_mode") {
		
            $table = "tbl_setting";
            $field = "show_dark=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Demand($car);
            $check = trim($h->carupdateData_single($field, $table, $where));
             if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Dark Mode Status Change Successfully!!",
                    "message" => "Dark Mode section!",
                    "action" => $page_name,
                ];
            } 
        }
        }
		elseif ($coll_type == "bookcomplete") {
            
			$table = "tbl_book";
                $field = [
                    "book_status" => $status
                    
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Demand($car);
                $check = trim($h->carupdateData($field, $table, $where));
				
				$checks = $car->query("select uid from tbl_book where id=".$id."")->fetch_assoc(); 
				$uid = $checks['uid'];
			$udata = $car->query("select * from tbl_user where id=".$checks['uid']."")->fetch_assoc();
$name = $udata['name'];

	  
	  
	   
$content = array(
       "en" => $name.', Your  Book #'.$id.' Has Been Completed.'
   );
$heading = array(
   "en" => "Book Completed!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'data' => array("order_id" =>$id),
'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => $checks['uid'])),
'contents' => $content,
'headings' => $heading
);

$fields = json_encode($fields);

 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, 
array('Content-Type: application/json; charset=utf-8',
'Authorization: Basic '.$set['one_hash']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
$response = curl_exec($ch);
curl_close($ch);


	    if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Book Completed Successfully!!",
                    "message" => "Book section!",
                    "action" => "Completed.php",
                ];
            } 
        }
		}

		else {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "false",
                "title" => "Option Not There!!",
                "message" => "Error!!",
                "action" => "dashboard.php",
            ];
        }
    } else {
        $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
    }


}else {
    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
}
echo json_encode($returnArr);
?>
