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
                  <h3>Gallery  Management</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
            <div class="row">
            <div class="col-sm-12">
                <div class="card">
                 <?php 
				 if(isset($_GET['id']))
				 {
					 $data = $car->query("select * from tbl_gallery where id=".$_GET['id']."")->fetch_assoc();
					 
					 ?>
					 <form method="post" enctype="multipart/form-data">
                                     <div class="card-body">
                                        
										
										
										
										<div class="form-group mb-3">
                                            <label>Select Car</label>
                                            <select name="car_id"  class="select2-car form-control"  required>
											
									  <option value="">Select Car</option>
<?php 
$sel = $car->query("select * from tbl_car where post_id=0");
while($row = $sel->fetch_assoc())
{
?>
<option value="<?php echo $row['id'];?>" <?php if($row['id'] == $data['car_id']){echo 'selected';}?>><?php echo $row['car_title'];?></option>
<?php } ?>
									   </select>
                                        </div>
										
										
										
                                        
										<div class="form-group mb-3">
                                            <label>Gallery Image</label>
                                            <input type="file" class="form-control" name="cat_img[]" multiple>
											<br>
											
											<input type="hidden" name="type" value="edit_gal"/>
											
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
										<input type="hidden" name="imlist" id="imlist">
										<div id="imageList" >
            <?php
            $bn = explode('$;', $data['img']);
            foreach($bn as $v) {
            ?>
            <div class="image-container">
                <img  src="<?php echo $v;?>" width="100" height="100">
                <span class="close-icon" data-url="<?php echo $v;?>">&times;</span>
            </div>
            <?php } ?>
        </div>
                                        </div>
										
										
										
                                        
										
                                    </div>
                                    <div class="card-footer text-left">
                                        <button type="submit" class="btn btn-primary">Edit  Gallery</button>
                                    </div>
                                </form>
					<?php
				 }
				 else 
				 {
				 ?>
                  <form method="post" enctype="multipart/form-data">
                                    
                                    <div class="card-body">
                                        
										
										
										
										<div class="form-group mb-3">
                                            <label>Select Car</label>
                                            <select name="car_id"  class="select2-car form-control"  required>
											
									  <option value=""> Select Car</option>
<?php 
$sel = $car->query("select * from tbl_car where post_id=0");
while($row = $sel->fetch_assoc())
{
?>
<option value="<?php echo $row['id'];?>"><?php echo $row['car_title'];?></option>
<?php } ?>
									   </select>
                                        </div>
										
										
										
                                        
										<div class="form-group mb-3">
                                            <label>Gallery Image</label>
                                            <input type="file" class="form-control" name="cat_img[]"  required="" multiple>
											<input type="hidden" name="type" value="add_gal"/>
                                        </div>
										
										
										
                                        
										
                                    </div>
                                    <div class="card-footer text-left">
                                        <button type="submit" class="btn btn-primary">Add Gallery </button>
                                    </div>
                                </form>
				 <?php } ?>
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
	
	<script>
$(document).ready(function() {
    // jQuery to handle image removal and update imlist input
    const $imageList = $('#imageList');
    const $imlistInput = $('#imlist');

    $imageList.on('click', '.close-icon', function() {
        const $closeIcon = $(this);
        const imageUrlToRemove = $closeIcon.data('url');
        const $images = $('.image-container');

        // Remove the image container with the clicked close icon
        $closeIcon.parent().remove();

        // Update imlist with remaining images
        const remainingImages = [];
        $images.each(function() {
            remainingImages.push($(this).find('img').attr('src'));
        });

        // Check if there are no remaining images, set imlist to '0'
        if (remainingImages.length === 0) {
            $imlistInput.val('0');
        } else {
            // Update the hidden imlist input
            $imlistInput.val(remainingImages.join('$;'));
        }

        // Call the updateImList function
        updateImList();
    });

    // Initial update
    updateImList();

    function updateImList() {
        const $images = $('.image-container');
        const imageUrls = [];

        $images.each(function() {
            imageUrls.push($(this).find('img').attr('src'));
        });

        // Check if there are no remaining images, set imlist to '0'
        if (imageUrls.length === 0) {
            $imlistInput.val('0');
        } else {
            // Update the hidden imlist input
            $imlistInput.val(imageUrls.join('$;'));
        }
    }
});




</script>
<style>
    .image-container,.image-containers {
    position: relative;
    display: inline-block;
    margin-right: 10px; /* Adjust as needed */
    margin-bottom: 10px; /* Adjust as needed */
}

/* Style for the close icon */
.close-icon,.close-icons {
    position: absolute;
    top: -12px;
    right: -8px;
    width: 29px;
    height: 29px;
    background: rebeccapurple;
    color: white;
    text-align: center;
    line-height: 29px;
    border-radius: 50%;
    cursor: pointer;
}
</style>
  </body>


</html>