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
                  <h3>Report Data</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
		 
            <div class="row">
             
           <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Banner<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_banner")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon1.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">City<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_city")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                         <img src="images/dashboard/icon2.svg" style="width: 60px;">

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			 
			  
			  
			  
			  
			 
			  
			  
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">FAQ<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_faq")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon5.svg" style="width: 60px;">

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Payment Gateway<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_payment_list")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon6.svg" style="width: 60px;">

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Dynamic Pages<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_page")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon7.svg" style="width: 60px;">
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Users<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_user")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon8.svg" style="width: 60px;">

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Car<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_car")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon8.svg" style="width: 60px;">

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Gallery<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $car->query("select * from tbl_gallery")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/icon8.svg" style="width: 60px;">

                      </div>
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