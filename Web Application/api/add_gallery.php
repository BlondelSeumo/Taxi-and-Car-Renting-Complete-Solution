<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('IMAGE_PATH', '/images/gallery/');
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
if($_POST["car_id"] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$uid = $_POST['uid'];
	$car_id = $_POST['car_id'];
	$size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
	
	$check = $car->query("select * from tbl_gallery where uid=".$uid." and car_id=".$car_id."")->num_rows;
	if($check != 0)
	{
		$returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Gallery Alredy Added!!!!!"];
	}
	else 
	{
		if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('cargallery', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }
	$table = "tbl_gallery";
            $field_values = ["img", "car_id","uid"];
            $data_values = ["$multifile", "$car_id","$uid"];

            $h = new Demand($car);
            $check = $h->carinsertdata_Api($field_values, $data_values, $table);
			$returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Gallery Add Successfully!!!!!"];
	}
}
echo json_encode($returnArr);
?>