<?php
if(isset($_GET['name']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['amt']))
{
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=13")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
$liveurl = 'https://app.midtrans.com/snap/v1/transactions';
$testurl = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
if($kk[2] == 0)
{
	$api_url = $testurl;
}
else 
{
	$api_url = $liveurl;
}
$api_key = $kk[1];
$oid = uniqid().uniqid();
$amt = $_GET['amt']*1000;
$data = array(
    'transaction_details' => array(
        'order_id' => $oid,
        'gross_amount' => $amt
    ),
    'credit_card' => array(
        'secure' => true
    ),
    'customer_details' => array(
        'first_name' => $_GET['name'],
        'last_name' => $_GET['name'],
        'email' => $_GET['email'],
        'phone' => $_GET['phone']
    ),
	'callbacks' => array(
	    'finish'=> 'https://carlink.cscodetech.cloud/Midtrans/process.php'
	)
);

$headers = array(
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode($api_key),
    'Content-Type: application/json'
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

// Print the response
$data = json_decode($response,true);
$url = $data['redirect_url'];
?>
<script>
window.location.href="<?php echo $url;?>";
</script>
<?php 
}
?>

