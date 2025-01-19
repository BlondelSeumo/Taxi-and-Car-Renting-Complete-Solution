<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Demand.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['name'] == '' or $data['password'] == '' or $data['uid'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $name = strip_tags(mysqli_real_escape_string($car,$data['name']));
   
    $email = strip_tags(mysqli_real_escape_string($car,$data['email']));
     $password = strip_tags(mysqli_real_escape_string($car,$data['password']));
	 
$uid =  strip_tags(mysqli_real_escape_string($car,$data['uid']));
$checkimei = $car->query("select * from tbl_user where  `id`=".$uid."")->num_rows;

if($checkimei == 0)
    {
		     $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"User Not Exist!!!!");  
	}

else 
{	
	   $table="tbl_user";
  $field = array('name'=>$name,'password'=>$password,'email'=>$email);
  $where = "where id=".$uid."";
$h = new Demand($car);
	  $check = $h->carupdateData_Api($field,$table,$where);
	  
            $c = $car->query("select * from tbl_user where  `id`=".$uid."")->fetch_assoc();
        $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Update successfully!");
        
    
	}
    
}

echo json_encode($returnArr);