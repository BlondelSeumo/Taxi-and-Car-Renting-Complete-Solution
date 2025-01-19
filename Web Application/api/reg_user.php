<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
function generate_random()
{
	require dirname( dirname(__FILE__) ).'/inc/Connection.php';
	$six_digit_random_number = mt_rand(100000, 999999);
	$c_refer = $car->query("select * from tbl_user where code=".$six_digit_random_number."")->num_rows;
	if($c_refer != 0)
	{
		generate_random();
	}
	else 
	{
		return $six_digit_random_number;
	}
}


if($data['name'] == '' or $data['email'] == '' or $data['mobile'] == ''   or $data['password'] == '' or $data['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $fname = strip_tags(mysqli_real_escape_string($car,$data['name']));
    $email = strip_tags(mysqli_real_escape_string($car,$data['email']));
    $mobile = strip_tags(mysqli_real_escape_string($car,$data['mobile']));
	$ccode = strip_tags(mysqli_real_escape_string($car,$data['ccode']));
	
    $password = strip_tags(mysqli_real_escape_string($car,$data['password']));
    $refercode = strip_tags(mysqli_real_escape_string($car,$data['rcode']));
    $checkmob = $car->query("select * from tbl_user where mobile=".$mobile."");
	$acheckmob = $car->query("select * from admin where mobile=".$mobile."");
    $checkemail = $car->query("select * from tbl_user where email='".$email."'");
   
    if($checkmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Mobile Number Already Used!");
    }
	else if($acheckmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Mobile Number Already Used!");
    }
     else if($checkemail->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Email Address Already Used!");
    }
    else
    {
        if($refercode != '')
	   {
		 $c_refer = $car->query("select * from tbl_user where code=".$refercode."")->num_rows;
		 if($c_refer != 0)
		 {
			 
        
        $prentcode = generate_random();
		$wallet = $car->query("select * from tbl_setting")->fetch_assoc();
		$fin = $wallet['scredit'];
        $timestamp = date("Y-m-d H:i:s");
        
		$table="tbl_user";
  $field_values=array("name","email","mobile","rdate","password","ccode","refercode","wallet","code");
  $data_values=array("$fname","$email","$mobile","$timestamp","$password","$ccode","$refercode","$fin","$prentcode");
		
  
      $h = new Demand($car);
	  $check = $h->carinsertdata_Api_Id($field_values,$data_values,$table);
	  $timestamps    = date("Y-m-d");
 $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$check",'Sign up Credit Added!!','Credit',"$fin","$timestamps");
   
      $h = new Demand($car);
	  $checks = $h->carinsertdata_Api($field_values,$data_values,$table);
	  
 $c = $car->query("select * from tbl_user where id=".$check."")->fetch_assoc();
    
        $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
    }
	else 
		 {
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Refer Code Not Found Please Try Again!!");
	   }
	   }
	    else 
	   {
		   $timestamp = date("Y-m-d H:i:s");
		   $prentcode = generate_random();
		   
		   $table="tbl_user";
  $field_values=array("name","mobile","rdate","password","ccode","code","email");
  $data_values=array("$fname","$mobile","$timestamp","$password","$ccode","$prentcode","$email");
		
   $h = new Demand($car);
	  $check = $h->carinsertdata_Api_Id($field_values,$data_values,$table);
  $c = $car->query("select * from tbl_user where id=".$check."")->fetch_assoc();
  $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
  
	   }
	}
    
    
}

echo json_encode($returnArr);