<?php 

require 'inc/Connection.php';

$book_id = $_POST['book_id'];
$c = $car->query("select * from tbl_book where id=".$book_id."")->fetch_assoc();
$udata = $car->query("select * from tbl_user where id=".$c['uid']."")->fetch_assoc();
$pdata = $car->query("select * from tbl_payment_list where id=".$c['p_method_id']."")->fetch_assoc();
$cardata = $car->query("select * from tbl_car where id=".$c['car_id']."")->fetch_assoc();
$img = explode('$;',$cardata['car_img']);
?>

<div style="margin-left: auto;">

<button class="fa fa-picture-o btn btn-primary text-right cmd" style="float:right;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></button>

</div>

<div id="divprint">
 
  <div class="card-body bg-white mb-2">
   
                <div class="row d-flex">
                  <div class="col-md-3">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1">Order No:</h6>
                    <!-- Text -->
                    <p class="mb-lg-0 font-size-sm font-weight-bold"><?php echo $book_id;?></p>
                  </div>
                  <?php 
$date=date_create($c['pickup_date']);
$pickupTime = new DateTime($c['pickup_time']);
$formattedTime = $pickupTime->format("g A");
$order_date =  date_format($date,"d-m-Y").'( '.$formattedTime.' )';

$dates=date_create($c['return_date']);
$pickupTime = new DateTime($c['return_time']);
$formattedTimes = $pickupTime->format("g A");
$order_dates =  date_format($dates,"d-m-Y").'( '.$formattedTimes.' )';
?>
                  <div class="col-md-3 mb-3">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1">Pickup date:</h6>
                    <!-- Text -->
                    <p class="mb-lg-0 font-size-sm font-weight-bold">
                      <span><?php echo $order_date;?></span>
                    </p>
                  </div>
				  
				  <div class="col-md-3">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1">Return date:</h6>
                    <!-- Text -->
                    <p class="mb-lg-0 font-size-sm font-weight-bold">
                      <span><?php echo $order_dates;?></span>
                    </p>
                  </div>
                  
                  <div class="col-md-3">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1">Mobile Number:</h6>
                    <!-- Text -->
                    <p class="mb-0 font-size-sm font-weight-bold"> <?php echo $udata['ccode'].$udata['mobile'];?></p>
                  </div>
                  
                  <div class="col-md-3">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1">Customer Name:</h6>
                    <!-- Text -->
                    <p class="mb-0 font-size-sm font-weight-bold"><?php echo $udata['name'];?></p>
                  </div>
				  
				  
                  
                </div>
              </div>
              
              <div class="card style-2 mb-2">
                <div class="card-header">
                  <h4 class="mb-0">Total Booking Details </h4>
                </div>
                <div class="card-body">
				
				<div class="col-md-6">
                    <!-- Heading -->
                    <h6 class="text-muted mb-1"></h6>
                    <!-- Text -->
                    <p class="mb-3 font-size-sm font-weight-bold"> <img src="<?php echo $img[0];?>" width="100px"/> <?php echo $cardata['car_title'];?></p>
                  </div>
                  
                  
				  
                  <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
				  
				  <li class="list-group-item">
                      <span>Total <?php echo $c['price_type'];?></span>
                      <span class="ml-auto float-right"><?php echo $c['total_day_or_hr'].' '.$c['price_type'];?></span>
                    </li>
					
                    <li class="list-group-item">
                      <span>Subtotal</span>
                      <span class="ml-auto float-right"><?php echo $c['subtotal'].' '.$set['currency'];?></span>
                    </li>
                  <?php 
  if($c['cou_amt'] != 0)
  {
  ?>
                    <li class="list-group-item">
                      <span>Coupon Code</span>
                      <span class="ml-auto float-right"><?php echo $c['cou_amt'].' '.$set['currency'];?></span>
                    </li>
                     <?php } ?>
					 
					 <?php 
  if($c['wall_amt'] != 0)
  {
  ?>
                    <li class="list-group-item">
                      <span>Wallet</span>
                      <span class="ml-auto float-right"><?php echo $c['wall_amt'].' '.$set['currency'];?></span>
                    </li>
                     <?php } ?>
					 
					 
                    <li class="list-group-item">
                      <span>Tax Amount</span>
                      <span class="ml-auto float-right"><?php echo $c['tax_amt'].' '.$set['currency'];?></span>
                    </li>
                    
                    <li class="list-group-item font-size-lg font-weight-bold">
                      <span>Net Amount</span>
                      <span class="ml-auto float-right"><?php echo $c['o_total'].' '.$set['currency'];?></span>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card style-2">
                <div class="card-header">
                  <h4 class="mb-0">Car Pickup  Details</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                                       
                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
					
					 <p class="mb-2 font-weight-bold ">
                        Payment Gateway:
                      </p>

                      <p class="mb-7 mb-3 md-0 ">
                       <?php echo $pdata['title'];?>
                      </p>
                      <!-- Heading -->
                      <p class="mb-2 font-weight-bold">
                        Pickup Car Address:
                      </p>

                      <p class="mb-7 mb-3 md-0">
                       <?php echo $cardata['pick_address'];?>
                      </p>
                    </div>
                    
                    <div class="col-12 col-md-6">

                      <!-- Heading -->
                      <p class="mb-2 font-weight-bold">
                       Transaction Id:
                      </p>

                      <p class="mb-2 text-gray-500">
                        <?php echo $c['transaction_id'];?>
                      </p>

                      <!-- Heading -->
                      <p class="mb-2 font-weight-bold">
                        Book Status:
                      </p>

                      <p class="mb-0">
                        <?php echo $c['book_status'];?>
                      </p>

                    </div>
					<br><br>
					
                  </div>
                </div>
              </div>
              
</div>