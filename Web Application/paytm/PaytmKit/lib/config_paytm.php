<?php
require dirname(dirname(dirname( dirname(__FILE__) ))).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=8")->fetch_assoc();
$kk = explode(',',$kb['attributes']);



//$PAYTM_ENVIRONMENT = "PROD";	// For Production /LIVE
$PAYTM_ENVIRONMENT = $kk[2];	// For Staging / TEST

if(!defined("PAYTM_ENVIRONMENT") ){
	define('PAYTM_ENVIRONMENT', $PAYTM_ENVIRONMENT); 
}

// For LIVE
if (PAYTM_ENVIRONMENT == 'PROD') {
	//===================================================
	//	For Production or LIVE Credentials
	//===================================================
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';

	//Change this constant's value with Merchant key received from Paytm.
	$PAYTM_MERCHANT_MID 		= $kk[0];
	$PAYTM_MERCHANT_KEY 		= $kk[1];

	$PAYTM_CHANNEL_ID 	= "WEB";
	$PAYTM_INDUSTRY_TYPE_ID = "";
	$PAYTM_MERCHANT_WEBSITE = "";
	$PAYTM_CALLBACK_URL 	= "https://carlink.cscodetech.cloud/paytm/response.php";
	
}else{
	//===================================================
	//	For Staging or TEST Credentials
	//===================================================
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';

	//Change this constant's value with Merchant key received from Paytm.
	$PAYTM_MERCHANT_MID 		= $kk[0];
	$PAYTM_MERCHANT_KEY 		= $kk[1];

	$PAYTM_CHANNEL_ID 		= "WEB";
	$PAYTM_INDUSTRY_TYPE_ID = "Retail";
	$PAYTM_MERCHANT_WEBSITE = "WEBSTAGING";

	$PAYTM_CALLBACK_URL 	= "https://carlink.cscodetech.cloud/paytm/response.php";
	
}

define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 
define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);


define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

?>
