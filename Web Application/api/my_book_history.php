<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['uid'] == ''  || $data['status'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
$pol = array();
$c = array();
$uid = $data['uid'];
$status = $data['status'];
if($status == 'Booked')
{
$sel = $car->query("select * from tbl_book where post_id=".$uid." and book_status!='Cancelled' and book_status!='Completed' order by id desc");
}
else 
{
$sel = $car->query("select * from tbl_book where post_id=".$uid." and (book_status='Cancelled' or book_status='Completed') order by id desc");	
}

while($row = $sel->fetch_assoc())
{
	$car_id = $row['car_id'];
   $carinfo = $car->query("select tcar.car_title,tcar.car_number,tcar.car_img,tcar.id,tcar.engine_hp,tcar.fuel_type,tcar.total_seat,tcar.car_gear,(
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
   $cityinfo = $car->query("select * from tbl_city where id=".$row['city_id']."")->fetch_assoc();
		$pol['book_id'] = $row['id'];
		$pol['car_title'] = $carinfo['car_title'];
		$pol['car_number'] = $carinfo['car_number'];
		$im = explode('$;',$carinfo['car_img']);
	    $pol["car_img"] = $im[0];
		$pol['total_day_or_hr'] = $row['total_day_or_hr'];
		$pol['city_title'] = $cityinfo['title'];
		$pol['car_rating'] = $carinfo['car_rate'];
		$pol['price_type'] = $row['price_type'];
		$pol['car_price'] = $row['car_price'];
		$pol["engine_hp"] = $carinfo["engine_hp"];
	    $pol["fuel_type"] = $carinfo["fuel_type"];
	    $pol["total_seat"] = $carinfo["total_seat"];
		$pol["car_gear"] = $carinfo["car_gear"];
		$pol['o_total'] = $row['o_total'];
		$pol['wall_amt'] = $row['wall_amt'];
		$pol['cou_amt'] = $row['cou_amt'];
		$pol['pickup_date'] = $row['pickup_date'];
		$pol['pickup_time'] = $row['pickup_time'];
		$pol['return_date'] = $row['return_date'];
		$pol['return_time'] = $row['return_time'];
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("book_history"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Book History Not Founded!");
}
else 
{
$returnArr = array("book_history"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book History List Founded!");
}
}
echo json_encode($returnArr);
?>