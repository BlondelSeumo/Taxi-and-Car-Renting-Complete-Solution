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
	$imlist = $_POST['imlist'];
	$uid = $_POST['uid'];
	$car_id = $_POST['car_id'];
	$record_id = $_POST['record_id'];
	$size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
	if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('cargallery', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }
	
	$imageList = '';
	if (empty($_FILES['cargallery0']['name'][0]) && $imlist != "0") {
    // No new image was uploaded, and there are existing images
    $imageList = $imlist;
    
} else if (empty($_FILES['cargallery0']['name'][0]) && $imlist == "0") {
    // No new image was uploaded, and there are no existing images
    $imageList = $imlist;
    
} else if ($imlist == "0") {
    // New images were uploaded, and there are no existing images
    $imageList = $multifile;
    
} else {
    // New images were uploaded, and there are existing images
    $imageList = $imlist . '$;' . $multifile;
   
}

$table = "tbl_gallery";
                $field = [
                    "img" => $imageList,
					"car_id" => $car_id
                ];
                $where =
                    "where id=" . $record_id . " and car_id=".$car_id." and uid=".$uid."";
                $h = new Demand($car);
                $check = $h->carupdateData_Api($field, $table, $where);
            
			
			$returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Gallery Update Successfully!!!!!"];
			
	
}
echo json_encode($returnArr);
?>