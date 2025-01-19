<?php
require 'inc/Config.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=10")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
$merchant_id = $kk[0];
$secretkey = $kk[1];
if(isset($_GET['detail']) && isset($_GET['amount']) && isset($_GET['order_id']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['phone']))
{
    $hashed_string = hash_hmac('sha256', $secretkey.urldecode($_GET['detail']).urldecode($_GET['amount']).urldecode($_GET['order_id']), $secretkey);
    ?>
    <html>
    <head>
    <title>senangPay Sample Code</title>
    </head>
    <body onload="document.order.submit()">
	
	<?php 
	if($kk[2] == 'TEST')
	{
	?>
        <form name="order" method="post" action="https://sandbox.senangpay.my/payment/<?php echo $merchant_id; ?>">
	<?php } else { ?>
	<form name="order" method="post" action="https://app.senangpay.my/payment/<?php echo $merchant_id; ?>">
	<?php } ?>
            <input type="hidden" name="detail" value="<?php echo $_GET['detail']; ?>">
            <input type="hidden" name="amount" value="<?php echo $_GET['amount']; ?>">
            <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">
            <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="hidden" name="phone" value="<?php echo $_GET['phone']; ?>">
            <input type="hidden" name="hash" value="<?php echo $hashed_string; ?>">
        </form>
    </body>
    </html>
    <?php
}

else if(isset($_GET['status_id']) && isset($_GET['order_id']) && isset($_GET['msg']) && isset($_GET['transaction_id']) && isset($_GET['hash']))
{
    
    $hashed_string = hash_hmac('sha256', $secretkey.urldecode($_GET['status_id']).urldecode($_GET['order_id']).urldecode($_GET['transaction_id']).urldecode($_GET['msg']), $secretkey);
    
   
    if($hashed_string == urldecode($_GET['hash']))
    {
        
        if(urldecode($_GET['status_id']) == '1')
		{
            
		$returnArr = array("Transaction_id"=>$_GET['transaction_id'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>urldecode($_GET['msg']));
		echo json_encode($returnArr);
		}
        else
		{
           $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>urldecode($_GET['msg']));
		echo json_encode($returnArr);
		}
    }
    else
        echo 'Hashed value is not correct';
}
else
{
?>
    
<?php
}
?>