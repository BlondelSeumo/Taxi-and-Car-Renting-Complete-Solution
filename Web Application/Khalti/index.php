<?php
if(isset($_GET['amt']))
{
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=15")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
$liveurl = 'https://khalti.com/api/v2/';
$testurl = 'https://a.khalti.com/api/v2/';
if($kk[1] == 0)
{
	$api_url = $testurl . 'epayment/initiate/';
}
else 
{
	$api_url = $liveurl . 'epayment/initiate/';
}
$amt = $_GET['amt'] * 100;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "return_url": "http://15.207.11.52/carento/Khalti/return.php",
    "website_url": "https://example.com/",
    "amount": '.$amt.',
    "purchase_order_id": "Order01",
        "purchase_order_name": "test",

    "customer_info": {
        "name": "Test Bahadur",
        "email": "test@khalti.com",
        "phone": "9800000001"
    }
    }

    ',
    CURLOPT_HTTPHEADER => array(
        'Authorization: key '.$kk[0],
        'Content-Type: application/json',
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response,true);
	$pay = $data['payment_url'];
	?>
	<script>
	window.location.href="<?php echo $pay;?>";
	</script>
<?php } ?>