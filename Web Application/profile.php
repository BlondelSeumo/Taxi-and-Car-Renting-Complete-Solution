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
                  <h3>Profile  Management</h3>
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
				 $admindata = $car->query("SELECT * FROM `admin`")->fetch_assoc();
				?>
                               
				<form method="post" enctype="multipart/form-data">
				
                                       <div class="form-group mb-3">
                                            <label>Username</label>
                                            <input type="text" min="1" step="1"  class="form-control" name="username" required="" value="<?php echo $admindata['username']; ?>">
											<input type="hidden" name="type" value="edit_profile"/>
										<input type="hidden" name="id" value="1"/>
                                        </div>
										 
                                        
										<div class="form-group mb-3">
                                            <label>Password</label>
                                            <input type="text" min="1" step="1"  class="form-control" name="password" value="<?php echo $admindata['password']; ?>" required="">
                                        </div>
										
										<div class="form-group mb-3">
                                            <label>Mobile</label>
                                            <input type="text" min="1" step="1"  class="form-control" name="mobile" value="<?php echo $admindata['mobile']; ?>" required="">
                                        </div>
										
										
	
										
										<div class="form-group mb-3">
                                                <button type="submit" class="btn btn-primary mb-2">Edit Profile</button>
                                            </div>
											</div>
                                    </form> 
						
					
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