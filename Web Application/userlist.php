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
                  <h3>User List Management</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
         <div class="container-fluid general-widget">
            <div class="row">
             
             <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                           <tr>
                                                <th>Sr no.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>mobile</th>
                                                <th>Join Date</th>
                                                <th>Status</th>
												
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
											 $stmt = $car->query("SELECT * FROM `tbl_user` order by id desc");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	
	
	$i = $i + 1;
											?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $row['name'];?></td>
												<td><?php echo $row['email'];?></td>
												<td><?php echo $row['ccode'].$row['mobile'];?></td>
												<td><?php echo $row['rdate'];?></td>
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span  data-id="<?php echo $row['id'];?>" data-status="0" data-type="update_status" coll-type="userstatus" class="drop badge badge-danger">Make Deactive</span></td>
												<?php } else { ?>
												
												<td>
												<span data-id="<?php echo $row['id'];?>" data-status="1" data-type="update_status" coll-type="userstatus" class="badge drop  badge-success">Make Active</span></td>
												<?php } ?>
												
												
												</tr>
												
												
<?php } ?>
                                            
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
  </body>


</html>