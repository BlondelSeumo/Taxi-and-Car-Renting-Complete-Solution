
<?php 
if(isset($_GET['amt']))
{


/**
 * @param array $data
 * @param null $passPhrase
 * @return string
 */
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=12")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
$mode = $kk[2];
function generateSignature($data, $passPhrase = null) {
    // Create parameter string
    $pfOutput = '';
    foreach( $data as $key => $val ) {
        if($val !== '') {
            $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
        }
    }
    // Remove last ampersand
    $getString = substr( $pfOutput, 0, -1 );
    if( $passPhrase !== null ) {
        $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
    }
    return md5( $getString );
} 
$payment_id = uniqid();
// Construct variables
$cartTotal = $_GET['amt']; // This amount needs to be sourced from your application
$passphrase = 'jt7NOE43FZPn';
$data = array(
    // Merchant details
    'merchant_id' => $kk[1],
    'merchant_key' => $kk[0],
    'return_url' => 'https://carlink.cscodetech.cloud/Payfast/success.php?payment_id='.$payment_id.'&status=success',
    'cancel_url' => 'https://carlink.cscodetech.cloud/Payfast/cancle.php?payment_id='.$payment_id.'&status=failed',
    'notify_url' => 'https://carlink.cscodetech.cloud/Payfast/success.php?payment_id='.$payment_id.'&status=success',
    // Buyer details
    'name_first' => 'First Name',
    'name_last'  => 'Last Name',
    'email_address'=> 'test@test.com',
    // Transaction details
    'm_payment_id' => $payment_id, //Unique payment ID to pass through to notify_url
    'amount' => number_format( sprintf( '%.2f', $cartTotal ), 2, '.', '' ),
    'item_name' => 'Order#123',
	'custom_int1'=>2
);



$signature = generateSignature($data, $passphrase);
$data['signature'] = $signature;

// If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
if($mode == 0)
{
$testingMode = true;
}
else 
{
$testingMode = false;	
}
$pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
$htmlForm = '<form id="checkoutForm" action="https://'.$pfHost.'/eng/process" method="post">';
foreach($data as $name=> $value)
{
    $htmlForm .= '<input name="'.$name.'" type="hidden" value=\''.$value.'\' />';
}

echo $htmlForm; 

?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 <script>
    // jQuery script to auto-submit the form on page load
    $(document).ready(function() {
      $("#checkoutForm").submit();
    });
  </script>
<?php } ?>
