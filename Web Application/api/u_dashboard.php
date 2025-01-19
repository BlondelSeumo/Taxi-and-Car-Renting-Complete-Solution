<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header("Content-type: text/json");
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
$data = json_decode(file_get_contents("php://input"), true);
$uid = $data["uid"];
if ($uid == "") {
    $returnArr = [
        "ResponseCode" => "401",
        "Result" => "false",
        "ResponseMsg" => "Something Went Wrong!",
    ];
} else {
    $total_car = $car->query(
        "select * from tbl_car where post_id=" . $uid . ""
    )->num_rows;
    $current_booking = $car->query(
        "select * from tbl_book where post_id=" . $uid . " and (book_status!='Completed' and book_status!='Cancelled')"
    )->num_rows;
    
	$past_booking = $car->query(
        "select * from tbl_book where post_id=" . $uid . " and (book_status='Completed' or book_status='Cancelled')"
    )->num_rows;
	
	$earn = $car->query("select sum((subtotal-cou_amt) - ((subtotal-cou_amt) * commission/100)) as total_earning from tbl_book where book_status='Completed' and post_id=".$uid."")->fetch_assoc();
    $earning = empty($earn['total_earning']) ? "0" : $earn['total_earning'];
	
	$pay = $car->query("select sum(amt) as total_payout from payout_setting where uid=".$uid."")->fetch_assoc();
	$payout = empty($pay['total_payout']) ? "0" : $pay['total_payout'];
	$papi = [
        [
            "title" => "Number of Cars",
            "report_data" => $total_car,
            "url" => "images/dashboard/numberofcar.png",
        ],
		[
            "title" => "Current Booking",
            "report_data" => $current_booking,
            "url" => "images/dashboard/currentbooking.png",
        ],
		[
            "title" => "Past Booking",
            "report_data" => $past_booking,
            "url" => "images/dashboard/passbooking.png",
        ]
		,
		[
            "title" => "Earning",
            "report_data" => $earning-$payout,
            "url" => "images/dashboard/earning.png",
        ],
		[
            "title" => "Payout",
            "report_data" => number_format($payout, 2),
            "url" => "images/dashboard/payout.png",
        ],
		[
            "title" => "Withdraw Limit",
            "report_data" => $set["wlimit"],
            "url" => "images/dashboard/withdraw-limit.png",
        ]
    ];

    $returnArr = [
        "ResponseCode" => "200",
        "Result" => "true",
        "ResponseMsg" => "Report List Get Successfully!!!",
        "report_data" => $papi,
		"Currency" => $set['currency']
    ];
}
echo json_encode($returnArr);
?>