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
                  <h3>Coupon List Management</h3>
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
												<th>Title</th>
												<th>Subtitle</th>
                                               <th>Code</th>
                                                
                                                <th>Image</th>
                                                 <th>Expired Date</th>
                                                <th>Min Amount</th>
												<th>Discount</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $car->query("select * from tbl_coupon  order by id desc");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$i = $i + 1;
											?>
											<tr>
                                               <td>
                                                    <?php echo $i; ?>
                                                </td>
												<td> <?php echo $row['title']; ?></td>
												<td> <?php echo $row['subtitle']; ?></td>
												<td> <?php echo $row['coupon_code']; ?></td>
                                                
                                                <td class="align-middle">
                                                   <img src="<?php echo $row['coupon_img']; ?>" width="60" height="60"/>
                                                </td>
                                                
                                               <td> <?php 
											   $date=date_create($row['expire_date']);
echo date_format($date,"d-m-Y");
											   ?></td>
											   <td> <?php echo $row['min_amt']; ?></td>
											   <td> <?php echo $row['coupon_val']; ?></td>
                                               
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span class="badge badge-success">Publish</span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger">Unpublish</span></td>
												<?php } ?>
												
												
												
                                                <td style="white-space: nowrap; width: 15%;"><div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">
										   <a href="add_coupon.php?id=<?php echo $row['id'];?>" class="tabledit-edit-button" style="float: none; margin: 5px;">
<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="30" height="30" rx="15" fill="#79F9B4"/><path d="M22.5168 9.34109L20.6589 7.48324C20.0011 6.83703 18.951 6.837 18.2933 7.49476L16.7355 9.06416L20.9359 13.2645L22.5052 11.7067C23.163 11.0489 23.163 9.99885 22.5168 9.34109ZM15.5123 10.2873L8 17.8342V22H12.1658L19.7127 14.4877L15.5123 10.2873Z" fill="#25314C"/></svg></a>
										  </div>
                                           
                                       </div></td>
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
  </body>


</html>