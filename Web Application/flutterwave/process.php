<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$kb = $car->query("SELECT * FROM `tbl_payment_list` where id=7")->fetch_assoc();
$kk = explode(',',$kb['attributes']);
    if(isset($_GET['status']))
    {
        //* check payment status
        if($_GET['status'] == 'cancelled')
        {
            $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
        }
		elseif($_GET['status'] == 'completed')
        {
            $returnArr = array("Transaction_id"=>$_GET['transaction_id'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
        }
        elseif($_GET['status'] == 'successful')
        {
            $txid = $_GET['transaction_id'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "Content-Type: application/json",
                  "Authorization: Bearer ".$kk[0],
                ),
              ));
              
              $response = curl_exec($curl);
              
              curl_close($curl);
              
              $res = json_decode($response);
              if($res->status)
              {
                $amountPaid = $res->data->charged_amount;
                $amountToPay = $res->data->meta->price;
                if($amountPaid >= $amountToPay)
                {
					$returnArr = array("Transaction_id"=>$_GET['transaction_id'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
                    

                    //* Continue to give item to the user
                }
                else
                {
					$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
		
                    
                }
              }
              else
              {
                  $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>urldecode($_GET['status']));
		echo json_encode($returnArr);
              }
        }
    }
?>