<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("PaytmKit/lib/config_paytm.php");
require_once("PaytmKit/lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	
if(isset($_POST['STATUS']))
{
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		
		
		
		?>
		<script>
		window.location.href="response.php?status=successful&transaction_id="+<?php echo $_POST['TXNID'];?>
		</script>
		<?php 
		
	}
	else {
		
		?>
		<script>
		window.location.href="response.php?status=failed&transaction_id="+<?php echo $_POST['TXNID'];?>
		</script>
		<?php 
	}
}

}
else {
	if($_GET['status'] == 'successful')
	{
		$returnArr = array("Transaction_id"=>$_GET['transaction_id'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
	}
	else if($_GET['status'] == 'failed')
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
	}
	else 
	{
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}
}

?>