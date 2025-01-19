<?php

// Check whether token is not empty
if(!empty($_POST['token'])){
    
    // Token info
    $token  = $_POST['token'];
    
    // Card info
    $card_num = $_POST['card_num'];
    $card_cvv = $_POST['cvv'];
    $card_exp_month = $_POST['exp_month'];
    $card_exp_year = $_POST['exp_year'];
    
    // Buyer info
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = '555-555-5555';
    $addrLine1 = '123 Test St';
    $city = 'Columbus';
    $state = 'OH';
    $zipCode = '43123';
    $country = 'USA';
    
    // Item info
    $itemName = 'Premium Script CodexWorld';
    $itemNumber = 'PS123456';
    $itemPrice = '25.00';
    $currency = 'USD';
    $orderID = 'SKA92712382139';
    
    
    // Include 2Checkout PHP library
    require_once("lib/Twocheckout.php");
    
    // Set API key
    Twocheckout::privateKey('6D72A334-93B9-4106-8713-D1A2069DBD67');
    Twocheckout::sellerId('254816786696');
    Twocheckout::sandbox(true);
    
    try {
        // Charge a credit card
        $charge = Twocheckout_Charge::auth(array(
            "merchantOrderId" => $orderID,
            "token"      => $token,
            "currency"   => $currency,
            "total"      => $itemPrice,
            "billingAddr" => array(
                "name" => $name,
                "addrLine1" => $addrLine1,
                "city" => $city,
                "state" => $state,
                "zipCode" => $zipCode,
                "country" => $country,
                "email" => $email,
                "phoneNumber" => $phoneNumber
            )
        ));
        
        // Check whether the charge is successful
        if ($charge['response']['responseCode'] == 'APPROVED') {
            
            // Order details
            $orderNumber = $charge['response']['orderNumber'];
            $total = $charge['response']['total'];
            $transactionId = $charge['response']['transactionId'];
            $currency = $charge['response']['currencyCode'];
            $status = $charge['response']['responseCode'];
            
          
            
            $statusMsg = '<h2>Thanks for your Order!</h2>';
            $statusMsg .= '<h4>The transaction was successful. Order details are given below:</h4>';
           
            $statusMsg .= "<p>Order Number: {$orderNumber}</p>";
            $statusMsg .= "<p>Transaction ID: {$transactionId}</p>";
            $statusMsg .= "<p>Order Total: {$total} {$currency}</p>";
        }
    } catch (Twocheckout_Error $e) {
        $statusMsg = '<h2>Transaction failed!</h2>';
        $statusMsg .= '<p>'.$e->getMessage().'</p>';
    }
    
}else{
    $statusMsg = "<p>Form submission error...</p>";
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>2Checkout Payment Status</title>
<meta charset="utf-8">
</head>
<body>
<div class="container">
  <!-- Display payment status -->
  <?php echo $statusMsg; ?>
  
  <p><a href="index.html">Back to Payment</a></p>
</div>
</body>
</html>