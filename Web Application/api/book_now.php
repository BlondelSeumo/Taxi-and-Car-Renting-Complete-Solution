<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);
if($data['car_id'] == '' or $data['uid'] == '' )
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $car_id = strip_tags(mysqli_real_escape_string($car,$data['car_id']));
    $uid = strip_tags(mysqli_real_escape_string($car,$data['uid']));
    $car_price = strip_tags(mysqli_real_escape_string($car,$data['car_price']));
	$pickup_date = strip_tags(mysqli_real_escape_string($car,$data['pickup_date']));
	$pickup_time = strip_tags(mysqli_real_escape_string($car,$data['pickup_time']));
    $price_type = strip_tags(mysqli_real_escape_string($car,$data['price_type']));
    $return_date = strip_tags(mysqli_real_escape_string($car,$data['return_date']));
	$return_time = strip_tags(mysqli_real_escape_string($car,$data['return_time']));
	$cou_id = strip_tags(mysqli_real_escape_string($car,$data['cou_id']));
	$cou_amt = strip_tags(mysqli_real_escape_string($car,$data['cou_amt']));
	$wall_amt = strip_tags(mysqli_real_escape_string($car,$data['wall_amt']));
	$total_day_or_hr = strip_tags(mysqli_real_escape_string($car,$data['total_day_or_hr']));
	$subtotal = strip_tags(mysqli_real_escape_string($car,$data['subtotal']));
	$tax_per = strip_tags(mysqli_real_escape_string($car,$data['tax_per']));
	$tax_amt = strip_tags(mysqli_real_escape_string($car,$data['tax_amt']));
	$o_total = strip_tags(mysqli_real_escape_string($car,$data['o_total']));
	$p_method_id = strip_tags(mysqli_real_escape_string($car,$data['p_method_id']));
	$transaction_id = strip_tags(mysqli_real_escape_string($car,$data['transaction_id']));
	$type_id = strip_tags(mysqli_real_escape_string($car,$data['type_id']));
	$brand_id = strip_tags(mysqli_real_escape_string($car,$data['brand_id']));
	$book_type = strip_tags(mysqli_real_escape_string($car,$data['book_type']));
	$city_id = strip_tags(mysqli_real_escape_string($car,$data['city_id']));
	$getid = $car->query("select * from tbl_car where id=".$car_id."")->fetch_assoc();
	$post_id = $getid["post_id"];
	$pick_otp = rand(1111,9999);
	$drop_otp = rand(1111,9999);
	$commission = $set['commission_rate'];
	$table="tbl_book";
  $field_values=array("city_id","car_id","uid","car_price","pickup_date","pickup_time","price_type","return_date","return_time","cou_id","cou_amt","wall_amt","total_day_or_hr","subtotal","tax_per","tax_amt","o_total","p_method_id","transaction_id","type_id","brand_id","book_type","post_id","commission","pick_otp","drop_otp");
  $data_values=array("$city_id","$car_id","$uid","$car_price","$pickup_date","$pickup_time","$price_type","$return_date","$return_time","$cou_id","$cou_amt","$wall_amt","$total_day_or_hr","$subtotal","$tax_per","$tax_amt","$o_total","$p_method_id","$transaction_id","$type_id","$brand_id","$book_type","$post_id","$commission","$pick_otp","$drop_otp");
		
   $h = new Demand($car);
	  $bookid = $h->carinsertdata_Api_Id($field_values,$data_values,$table);
	  
	  if($wall_amt != 0)
{
 $vp = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  $mt = intval($vp['wallet'])-intval($wall_amt);
  $table="tbl_user";
  $field = array('wallet'=>"$mt");
  $where = "where id=".$uid."";
$h = new Demand($car);
	  $check = $h->carupdateData_Api($field,$table,$where);
	  $tdate = date("Y-m-d");
	  $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$uid",'Wallet Used in Rent Id#'.$bookid,'Debit',"$wall_amt","$tdate");
   
      $h = new Demand($car);
	  $checks = $h->carinsertdata_Api($field_values,$data_values,$table);
}




	  
	
$udata = $car->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];
$content = array(
       "en" => $name.', Your car Book #'.$bookid.' Has Been Received.'
   );
$heading = array(
   "en" => "Book Received!!"
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


         $title_mains = "Book Received!!";
         $descriptions = $name.', Your car Book #'.$bookid.' Has Been Received.';


$table = "tbl_notification";
         $field_values = ["uid", "datetime", "title", "description"];
         $data_values = ["$post_id", "$timestamp", "$title_mains", "$descriptions"];

         $h = new Demand($car);
         $h->carinsertdata_Api($field_values, $data_values, $table);
	
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Car Done Successfully!");
}
echo json_encode($returnArr);