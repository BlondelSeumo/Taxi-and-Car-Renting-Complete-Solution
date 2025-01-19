<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['mobile'] == '' or $data['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $mobile = strip_tags(mysqli_real_escape_string($car,$data['mobile']));
	$code = strip_tags(mysqli_real_escape_string($car,$data['ccode']));
    
    
$chek = $car->query("select * from tbl_user where mobile='".$mobile."' and ccode='".$code."'")->num_rows;
$achek = $car->query("select * from admin where mobile='".$mobile."'")->num_rows;
if($chek != 0)
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Already Exist Mobile Number!");
}
elseif($achek != 0)
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Already Exist Mobile Number!");
}
else 
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"New Number!");
}
}
echo json_encode($returnArr);