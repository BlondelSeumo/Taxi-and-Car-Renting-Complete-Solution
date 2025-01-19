<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' || $data['book_id'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid = $data['uid']; 
 $book_id = $data['book_id'];
 $table = "tbl_book";
    $field = ['uid' => $uid, 'book_status' => 'Drop'];
    $where = "where uid=" . $uid . " and id=" . $book_id . "";

    $h = new Demand($car);
    $check = $h->carupdateData_Api($field, $table, $where);
	
    $returnArr = ["ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Car Drop Successfully!!!!!"];
	
	$getid = $car->query("select * from tbl_book where id=".$book_id."")->fetch_assoc();
	$post_id = $getid["post_id"];
	$udata = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];
$content = array(
       "en" => $name.', Your Car Drop.'
   );
$heading = array(
   "en" => "Car Drop!!"
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


         $title_mains = "Car Drop!!";
         $descriptions = $name.', Your Car Drop.';


$table = "tbl_notification";
         $field_values = ["uid", "datetime", "title", "description"];
         $data_values = ["$post_id", "$timestamp", "$title_mains", "$descriptions"];

         $h = new Demand($car);
         $h->carinsertdata_Api($field_values, $data_values, $table);
}
echo  json_encode($returnArr);
?>