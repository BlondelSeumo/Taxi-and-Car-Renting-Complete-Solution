<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('IMAGE_PATH', '/images/car_int/');
define('IMAGE_PATHS', '/images/car_ext/');

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

$size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
$sizes = isset($_POST['sizes']) ? (int) $_POST['sizes'] : 0;

if ($_POST['uid'] == '' or $_POST['book_id'] == '') {
    $returnArr = ["ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something Went Wrong!"];
} else {
    $uid = $_POST['uid'];
    $book_id = $_POST['book_id'];
    if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('carint', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }

    if ($sizes > 0) {
        // Process multiple file uploads
        $uploadedFiles = processFileUploads('carext', $sizes, IMAGE_PATHS);
        $multifiles = implode('$;', $uploadedFiles);
    }
    $table = "tbl_book";
    $field = ['exter_photo' => $multifiles, 'inter_photo' => $multifile, 'book_status' => 'Pick_up'];
    $where = "where uid=" . $uid . " and id=" . $book_id . "";

    $h = new Demand($car);
    $check = $h->carupdateData_Api($field, $table, $where);
    $returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Pickup Successfully!!!!!"];
	
	$getid = $car->query("select * from tbl_book where id=".$book_id."")->fetch_assoc();
	$post_id = $getid["post_id"];
	$udata = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];
$content = array(
       "en" => $name.', Your Car Pickup.'
   );
$heading = array(
   "en" => "Car Pickup!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'data' => array("order_id" =>$bookid),
'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => $post_id)),
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

$timestamp = date("Y-m-d H:i:s");


         $title_mains = "Car Pickup!!";
         $descriptions = $name.', Your Car Pickup.';


$table = "tbl_notification";
         $field_values = ["uid", "datetime", "title", "description"];
         $data_values = ["$post_id", "$timestamp", "$title_mains", "$descriptions"];

         $h = new Demand($car);
         $h->carinsertdata_Api($field_values, $data_values, $table);
}
echo json_encode($returnArr);
?>
