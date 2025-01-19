<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['uid'] == ''  || $data['book_id'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
$pol = array();
$c = array();
$uid = $data['uid'];
$book_id = $data['book_id'];

$sel = $car->query("select * from tbl_book where uid=".$uid." and id=".$book_id."")->fetch_assoc();



   $carinfo = $car->query("select tcar.car_title,tcar.car_number,tcar.car_img,tcar.id,tcar.pick_lat,tcar.pick_lng,tcar.pick_address,tcar.engine_hp,
   tcar.fuel_type,tcar.total_seat,tcar.car_gear,(
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
    ) AS car_rate  from tbl_car AS tcar where tcar.id=".$sel['car_id']."")->fetch_assoc();
   $cityinfo = $car->query("select * from tbl_city where id=".$sel['city_id']."")->fetch_assoc();
   $paymentinfo = $car->query("select * from tbl_payment_list where id=".$sel['p_method_id']."")->fetch_assoc();
		
		$pol['book_id'] = $sel['id'];
		$pol['car_id'] = $sel['car_id'];
		$pol['car_title'] = $carinfo['car_title'];
		$pol['car_number'] = $carinfo['car_number'];
	    $pol["car_img"] = $carinfo['car_img'];
		$pol["pick_lat"] = $carinfo['pick_lat'];
		$pol["pick_lng"] = $carinfo['pick_lng'];
		$pol["pick_address"] = $carinfo['pick_address'];
		$pol['city_title'] = $cityinfo['title'];
		$pol['car_rating'] = $carinfo['car_rate'];
		$pol['price_type'] = $sel['price_type'];
		$pol['car_price'] = $sel['car_price'];
		$pol['pickup_date'] = $sel['pickup_date'];
		$pol['pickup_time'] = $sel['pickup_time'];
		$pol['return_date'] = $sel['return_date'];
		$pol['return_time'] = $sel['return_time'];
		$pol['cou_amt'] = $sel['cou_amt'];
		if($sel['post_id'] == 0)
		{
			$pol['owner_name'] = 'admin';
			$pol['owner_contact'] = $set['contact_no'];
			$pol['owner_img'] = $set['weblogo'];
			}
		else 
		{
			$userdata = $car->query("select name,mobile,ccode,profile_pic from tbl_user where id=".$sel['post_id']."")->fetch_assoc();
			$pol['owner_name'] = $userdata['name'];
			$pol['owner_contact'] = $userdata['ccode'].$userdata['mobile'];
			$pol['owner_img'] = $userdata['profile_pic'];
		}
		$pol['book_type'] = $sel['book_type'];
		$pol['wall_amt'] = $sel['wall_amt'];
		$pol['total_day_or_hr'] = $sel['total_day_or_hr'];
		$pol['tax_amt'] = $sel['tax_amt'];
		$pol['tax_per'] = $sel['tax_per'];
	    $pol["engine_hp"] = $carinfo["engine_hp"];
	    $pol["fuel_type"] = $carinfo["fuel_type"];
	    $pol["total_seat"] = $carinfo["total_seat"];
		$pol["car_gear"] = $carinfo["car_gear"];
		$pol['cancle_reason'] = $sel['cancle_reason'];
		$pol['is_rate'] = $sel['is_rate'];
		$pol['subtotal'] = $sel['subtotal'];
		$pol['o_total'] = $sel['o_total'];
		$pol['Payment_method_name'] = $paymentinfo['title'];
		$pol['transaction_id'] = $sel['transaction_id'];
		$pol['book_status'] = $sel['book_status'];
		$pol['exter_photo'] = empty($sel['exter_photo']) ? [] : explode('$;',$sel['exter_photo']);
		$pol['inter_photo'] = empty($sel['inter_photo']) ? [] : explode('$;',$sel['inter_photo']);
		$c[] = $pol;
	
	

if(empty($c))
{
	$returnArr = array("book_details"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Book Details Not Founded!");
}
else 
{
$returnArr = array("book_details"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Details  Founded!");
}
}
echo json_encode($returnArr);
?>