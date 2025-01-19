<?php 
require 'inc/Header.php';
?>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
    <?php require 'inc/Navbar.php';?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
       <?php require 'inc/Sidebar.php';?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Total Drop Book Management</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
            <div class="row">
           <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Sr No.</th>
							
											
											<th>Car Name</th>
											<th>Car Image</th>
											<th>Car Pickup Date</th>
											<th>Car Pickup Time</th>
											<th>Car Drop Date</th>
											<th>Car Drop Time</th>
											<th>Car Drop OTP</th>
												<th>customer <br> Name</th>
												<th>customer <br> Mobile</th>
												<th>Preview<br> Data</th>
												<th>Action</th>
								
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $car->query("SELECT * FROM `tbl_book` where book_status='Drop' order by id desc");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$cardata = $car->query("SELECT * from tbl_car where id=".$row['car_id']."")->fetch_assoc();
											$i = $i + 1;
											$img = explode('$;',$cardata['car_img']);
											$userdata = $car->query("select * from tbl_user where id=".$row['uid']."")->fetch_assoc();
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                
												
												 <td>
                                                    <?php echo $cardata['car_title']; ?>
                                                </td>
                                              
											  <td>
                                                    <img src="<?php echo $img[0]; ?>" width="50px"/>
                                                </td>
												
												<td>
                                                    <?php echo $row['pickup_date']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['pickup_time']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['return_date']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['return_time']; ?>
                                                </td>
												
												<td>
                                                   <b> <?php echo $row['drop_otp']; ?></b>
                                                </td>
												
												<td>
                                                    <?php echo $userdata['name']; ?>
                                                </td>
												<td>
                                                    <?php echo $userdata['ccode'].$userdata['mobile']; ?>
                                                </td>
												<td> <button class="preview_d btn btn-sm btn-primary" data-id="<?php echo $row['id'];?>" data-bs-toggle="modal" data-bs-target="#myModal">Preview</button></td>
												<td><a class=" drop btn btn-success" data-id="<?php echo $row['id'];?>" data-status="Completed" data-type="update_status" coll-type="bookcomplete">Make Complete</a></td>
                                                </tr>
											<?php 
										}
										?>
                          
                        </tbody>
                      </table>
					  </div>
					  </div>
				 
                </div>
              
                
              </div>
            
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       
      </div>
    </div>
    <!-- latest jquery-->
   <?php require 'inc/Footer.php'; ?>
    <!-- login js-->
	
	<div div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    
    <div class="modal-content">
      <div class="modal-header">
        <h4>Order Preivew</h4>
        <button type="button" class="close" data-bs-dismiss="modal" style="position: absolute;
    right: 0;
    top: 0;
    width: 50px;
    height: 50px;
    border-radius: 29px;
    padding: 10px;
    background: #D9534F;
    color: #fff;
    opacity: 1;">&times;</button>
      </div>
      <div class="modal-body p_data">
      
      </div>
     
    </div>

  </div>
</div>

<script>
	$(document).ready(function()
{
	$("#basic-1").on("click", ".preview_d", function()
	{
		var id = $(this).attr('data-id');
		$.ajax({
			type:'post',
			url:'book_data.php',
			data:
			{
				book_id:id
			},
			success:function(data)
			{
				
				$('#myModal').modal('show');
				$(".p_data").html(data);
			}
		});
	});
	
	
});
</script>
<style>
span.ml-auto.float-right {
    float: right;
}</style>
  </body>

</html>