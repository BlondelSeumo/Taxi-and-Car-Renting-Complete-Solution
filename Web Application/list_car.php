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
				<?php 
				if(isset($_GET["id"]))
				{
					?>
					<h3>Decision  Management</h3>
					<?php 
				}else {
				?>
                  <h3>Car  List Management</h3>
				<?php } ?>
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
				<?php 
				if(isset($_GET["id"]))
				{
				?>
				<form class="form" method="post">
							<div class="form-body">
								

							    <div class="form-group">
								<select class="form-control" name="decision_id" required>
								<option value="">Select A Decision</option>
								<option value="1">Approve</option>
								<option value="2">Reject</option>
								</select>
								</div>

								<div class="form-group">
									<label for="cname">Reject Reason</label>
									<textarea name="c_reason" class="form-control" style="resize:none;"></textarea>
									<input type="hidden" name="type" value="make_decision"/>
											
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
								</div>
                                
								
								
								<div class=" text-left">
                                        <button  class="btn btn-primary">Send Decision</button>
                                    </div>
								</div>
								</form>
				<?php } else { ?>
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Sr No.</th>
							<th>Car  Title</th>
											<th>Car  Image</th>
												<th>Car  Status</th>
												<th>Car  Owner?</th>
												<th>is approve?</th>
												<th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $car->query("select * from tbl_car");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                
												<td>
                                                    <?php echo $row['car_title']; ?>
                                                </td>
												
                                                <td class="align-middle">
												<img src="<?php $image = explode('$;',$row['car_img']); echo $image[0]; ?>" width="70" height="80"/>
                                                   
                                                </td>
                                                
                                               
												<?php if($row['car_status'] == 1) { ?>
												
                                                <td><span class="badge badge-success">Publish</span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger">Unpublish</span></td>
												<?php } ?>
												
												<?php 
												if($row['post_id'] == 0)
												{
													?>
													 <td><span class="badge badge-info">Admin</span></td>
													<?php 
												}
												else 
												{
													$uinfo = $car->query("select * from tbl_user where id=".$row['post_id']."")->fetch_assoc();
													?>
													<td><span class="badge badge-info"><?php echo $uinfo['name'];?></span></td>
													<?php 
												}
												
												?>
												<?php if($row['is_approve'] == 0) { ?>
												
                                                <td><span class="badge badge-info">Waiting For Decision</span></td>
												<?php } else if($row['is_approve'] == 1) { ?>
												
												<td>
												<span class="badge badge-success">Approved</span></td>
												<?php } else 
												{ ?>
											<td>
												<span class="badge badge-danger">Rejected</span></td>
												<?php } ?>
                                                <td style="white-space: nowrap; width: 15%;"><div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">
										   <a href="add_car.php?id=<?php echo $row['id'];?>" class="btn btn-info" style="float: none; margin: 5px;">Edit Car</a>
										   <?php if($row['is_approve'] == 0) { ?>
										   <a href="list_car.php?id=<?php echo $row['id'];?>" class="btn btn-warning" style="float: none; margin: 5px;">Make A Decision</a>
										   <?php } ?>
										   </div>
                                           
                                       </div></td>
                                                </tr>
											<?php 
										}
										?>
                          
                        </tbody>
                      </table>
					  </div>
				<?php } ?>
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
  </body>


</html>