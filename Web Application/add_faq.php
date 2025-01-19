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
                  <h3>FAQ Management</h3>
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
				 if(isset($_GET['id']))
				 {
					 $data = $car->query("select * from tbl_faq where id=".$_GET['id']."")->fetch_assoc();
					 ?>
					 <form method="POST"  enctype="multipart/form-data">
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1">Enter Question</label>
                                    
                                  <input type="text" class="form-control" placeholder="Enter Question" value="<?php echo $data['question'];?>" name="question" aria-label="Username" aria-describedby="basic-addon1">
                               
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1">Enter Answer</label>
                                    
                                  <input type="text" class="form-control" placeholder="Enter Answer" value="<?php echo $data['answer'];?>" name="answer" aria-label="Username" aria-describedby="basic-addon1">
                                <input type="hidden" name="type" value="edit_faq"/>
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
								</div>
								
                                    
                                   <div class="form-group mb-3">
                                    
                                        <label  for="inputGroupSelect01">Select Status</label>
                                    
                                    <select  class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value="">Choose...</option>
                                        <option value="1" <?php if($data['status'] == 1){echo 'selected';}?>>Publish</option>
                                        <option value="0" <?php if($data['status'] == 0){echo 'selected';}?>>Unpublish</option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary">Edit FAQ</button>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="POST"  enctype="multipart/form-data">
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1">Enter Question</label>
                                    
                                  <input type="text" class="form-control" placeholder="Enter Question"  name="question" aria-label="Username" aria-describedby="basic-addon1">
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1">Enter Answer</label>
                                    
                                  <input type="text" class="form-control" placeholder="Enter Answer"  name="answer" aria-label="Username" aria-describedby="basic-addon1">
                                <input type="hidden" name="type" value="add_faq"/>	
								</div>
								
                                    
                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01">Select Status</label>
                                    
                                    <select class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value="">Choose...</option>
                                        <option value="1">Publish</option>
                                        <option value="0">Unpublish</option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                                </form>
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