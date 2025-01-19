<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
	$book_id = $data['book_id'];
	
$table = "tbl_book";
                $field = [
                    "book_status" => 'Completed'
                    
                ];
                $where =
                    "where id=" . $book_id . "";
                $h = new Demand($car);
                $check = $h->carupdateData_Api($field, $table, $where);
				
				$checks = $car->query("select uid from tbl_book where id=".$book_id."")->fetch_assoc(); 
				$uid = $checks['uid'];
			$udata = $car->query("select * from tbl_user where id=".$checks['uid']."")->fetch_assoc();
$name = $udata['name'];

	  
	  
	   
$content = array(
       "en" => $name.', Your  Book #'.$book_id.' Has Been Completed.'
   );
$heading = array(
   "en" => "Book Completed!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'data' => array("order_id" =>$book_id),
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
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Complete Successfully!!");
}
echo  json_encode($returnArr);
?>