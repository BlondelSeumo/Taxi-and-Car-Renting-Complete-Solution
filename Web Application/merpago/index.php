<?php
if(isset($_GET['amt']))
{
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=11")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
$endpoint = 'https://api.mercadopago.com/checkout/preferences';

$data = array(
    'back_urls' => new stdClass(), // You can replace with your specific back_urls data
    'differential_pricing' => null,
    'expires' => false,
    'items' => array(
        array(
            'title' => 'Dummy Title',
            'description' => 'Dummy description',
            'picture_url' => 'http://www.myapp.com/myimage.jpg',
            'category_id' => 'car_electronics',
            'quantity' => 1,
            'currency_id' => 'BRL',
            'unit_price' => intval($_GET['amt'])
        )
    ),
    'marketplace_fee' => null,
    'metadata' => null,
    'payer' => array(
        'phone' => array('number' => null),
        'identification' => new stdClass(), // You can replace with your specific identification data
        'address' => array('street_number' => null)
    ),
    'payment_methods' => array(
        'excluded_payment_methods' => array(new stdClass()), // You can replace with your specific excluded_payment_methods data
        'excluded_payment_types' => array(new stdClass()), // You can replace with your specific excluded_payment_types data
        'installments' => null,
        'default_installments' => null
    ),
	'back_urls'=>array(
	'success'=>'https://carlink.cscodetech.cloud/merpago/success.php',
	'failure'=>'https://carlink.cscodetech.cloud/merpago/fail.php',
	'pending'=>'https://carlink.cscodetech.cloud/merpago/pending.php'
	),
	'redirect_urls'=>array(
	'success'=>'https://carlink.cscodetech.cloud/merpago/success.php',
	'failure'=>'https://carlink.cscodetech.cloud/merpago/fail.php',
	'pending'=>'https://carlink.cscodetech.cloud/merpago/pending.php'
	),
    'shipments' => array(
        'local_pickup' => false,
        'default_shipping_method' => null,
        'free_methods' => array(array('id' => null)),
        'cost' => null,
        'free_shipping' => false,
        'receiver_address' => array('street_number' => null)
    ),
    
);

$jsonData = json_encode($data);

$ch = curl_init($endpoint);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$kk[0]
));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);


$db = json_decode($response,true);
if($kk[1] == 0)
{
$url = $db['sandbox_init_point'];
}
else 
{
$url = $db['init_point'];	
}
?>
<script>
window.location.href="<?php echo $url;?>"
</script>
<?php } ?>