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
                  <h3>Car Management</h3>
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
					$data = $car->query("select * from tbl_car where id=".$_GET["id"]."")->fetch_assoc();
					
	
					?>
						<form method="post" enctype="multipart/form-data">
    <div class="card-body">
        <h5 class="h5_set"><i class="fa fa-car"></i> Car Information</h5>
        <div class="row">
            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Name</label>
                <input type="text" class="form-control" placeholder="Enter Car Name" name="car_title"  value="<?php echo $data['car_title']; ?>" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Number</label>
                <input type="text" class="form-control" placeholder="Enter Car Number" name="car_number" value="<?php echo $data['car_number']; ?>" required />
                <input type="hidden" name="type" value="edit_car" />
				<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Image</label>
                <div class="custom-file">
                    <input type="file" name="car_img[]" class="custom-file-input form-control" multiple />
					<input type="hidden" name="imlist" id="imlist">
                    <label class="custom-file-label">Choose Car Image</label>
					<br>
					<div id="imageList" >
            <?php
            $bn = explode('$;', $data['car_img']);
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

            <div class="form-group col-3">
                <label> <span class="text-danger">*</span> Car Status</label>
                <select name="car_status" class="form-control" required>
                    <option value="">Select A Status</option>
                    <option value="1" <?php if($data['car_status'] == 1){echo 'selected';}?>>Publish</option>
                    <option value="0" <?php if($data['car_status'] == 0){echo 'selected';}?>>UnPublish</option>
                </select>
            </div>

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Rating</label>
                <input type="number" min="1" max="5" class="form-control" step="0.01" placeholder="Enter Rating" value="<?php echo $data['car_rating']; ?>" name="car_rating" required />
            </div>

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Total Seat</label>
                <input type="text" class="form-control numberonly" placeholder="Enter Total Seat" name="total_seat" value="<?php echo $data['total_seat']; ?>" required />
            </div>

            

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Ac ?</label>
                <select name="car_ac" class="form-control" required>
                    <option value="">Select A Status</option>
                    <option value="1" <?php if($data['car_ac'] == 1){echo 'selected';}?>>Yes</option>
                    <option value="0" <?php if($data['car_ac'] == 0){echo 'selected';}?>>No</option>
                </select>
            </div>

           
			
			
			
			

 <div class="form-group col-2">
                <label><span class="text-danger">*</span> Driver Name</label>
                <input type="text" class="form-control" placeholder="Enter Driver Name" name="driver_name" value="<?php echo $data['driver_name']; ?>" required />
            </div>
			
			 <div class="form-group col-2">
                <label><span class="text-danger">*</span> Driver Mobile</label>
                <input type="text" class="form-control numberonly" placeholder="Enter Driver Mobile" name="driver_mobile"  value="<?php echo $data['driver_mobile']; ?>" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Gear System ?</label>
                <select name="car_gear" class="form-control" required>
                    <option value="">Select A System</option>
                    <option value="1" <?php if($data['car_gear'] == 1){echo 'selected';}?>>Auto</option>
                    <option value="0" <?php if($data['car_gear'] == 0){echo 'selected';}?>>Manual</option>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Facility?</label>
                <select name="car_facility[]" class="form-control select2-multi-facility" Multiple required>
                    
                    <?php 
					$people = explode(',',$data['car_facility']);
					$flist = $car->query("select * from tbl_facility");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>" <?php if(in_array($row['id'], $people)){echo 'selected';}?>><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Type?</label>
                <select name="car_type" class="form-control select2-car-type">
                    
                    <?php 
					$flist = $car->query("select * from car_type");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>" <?php if($data['car_type'] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Brand?</label>
                <select name="car_brand" class="form-control select2-car-brand">
                    
                    <?php 
					$flist = $car->query("select * from car_brand");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>" <?php if($data['car_brand'] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Available Car City?</label>
                <select name="car_available" class="form-control select2-car-city">
                    
                    <?php 
					$flist = $car->query("select * from tbl_city");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>" <?php if($data['car_available'] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Rent Price(Without Driver)</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Rent Price(Without Driver)" value="<?php echo $data['car_rent_price']; ?>" name="car_rent_price" required />
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Rent Price(With Driver)</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Rent Price(With Driver)" value="<?php echo $data['car_rent_price_driver']; ?>" name="car_rent_price_driver" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Engine Hp</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Engine Hp" name="engine_hp" value="<?php echo $data['engine_hp']; ?>" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Price Type ?</label>
                <select name="price_type" class="form-control" required>
                    <option value="">Select A Price Type</option>
                    <option value="1" <?php if($data['price_type'] == 1){echo 'selected';}?>>Hourly</option>
                    <option value="0" <?php if($data['price_type'] == 0){echo 'selected';}?>>Daily</option>
                </select>
            </div>
			
			
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Fuel Type ?</label>
                <select name="fuel_type" class="form-control" required>
                    <option value="">Select A Fuel Type</option>
                    <option value="0" <?php if($data['fuel_type'] == 0){echo 'selected';}?>>Petrol</option>
                    <option value="1" <?php if($data['fuel_type'] == 1){echo 'selected';}?>>Diesel</option>
					<option value="2" <?php if($data['fuel_type'] == 2){echo 'selected';}?>>Electric</option>
					<option value="3" <?php if($data['fuel_type'] == 3){echo 'selected';}?>>CNG</option>
					<option value="4" <?php if($data['fuel_type'] == 4){echo 'selected';}?>>Petrol & CNG</option>
                </select>
            </div>
			
			
			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>
</div>

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Description</label>
                <textarea name="car_desc" rows="10" class="form-control" style="resize:none;"><?php echo $data['car_desc']; ?></textarea>
            </div>
			
			 <div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Pickup Address</label>
                <textarea name="pick_address" rows="10" class="form-control" id="location" style="resize:none;"><?php echo $data['pick_address']; ?></textarea>
            </div>
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Latitude</label>
               <input type="text" class="form-control mb-3"  id="lat" placeholder="Enter Car Latitude" name="pick_lat" value="<?php echo $data['pick_lat']; ?>" required  readonly />
			   
			    <label ><span class="text-danger">*</span> Car Longtitude</label>
               <input type="text" class="form-control mb-3"  id="lng" placeholder="Enter Car Longtitude" name="pick_lng" value="<?php echo $data['pick_lng']; ?>" required  readonly />
			   
			   <label ><span class="text-danger">*</span> Car Total Driven Km</label>
               <input type="text" class="form-control mb-3"   placeholder="Enter Car Total Driven Km" name="total_km" value="<?php echo $data['total_km']; ?>" required   />
			   
			    <label ><span class="text-danger">*</span> Car Minimum Hrs Required</label>
               <input type="text" class="form-control mb-3"   placeholder="Enter Car Minimum Hrs" name="min_hrs" value="<?php echo $data['min_hrs']; ?>" required   />
			   
            </div>
            

            <div class="col-12">
                <button type="submit"  class="btn btn-primary mb-2">Edit Car</button>
            </div>
        </div>
    </div>
</form>

					<?php 
				}
				else 
				{
				?>
                
				<form method="post" enctype="multipart/form-data">
    <div class="card-body">
        <h5 class="h5_set"><i class="fa fa-car"></i> Car Information</h5>
        <div class="row">
            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Name</label>
                <input type="text" class="form-control" placeholder="Enter Car Name" name="car_title" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Number</label>
                <input type="text" class="form-control" placeholder="Enter Car Number" name="car_number" required />
                <input type="hidden" name="type" value="add_car" />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Image</label>
                <div class="custom-file">
                    <input type="file" name="car_img[]" class="custom-file-input form-control" required multiple />
                    <label class="custom-file-label">Choose Car Image</label>
                </div>
            </div>

            <div class="form-group col-3">
                <label> <span class="text-danger">*</span> Car Status</label>
                <select name="car_status" class="form-control" required>
                    <option value="">Select A Status</option>
                    <option value="1">Publish</option>
                    <option value="0">UnPublish</option>
                </select>
            </div>

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Rating</label>
                <input type="number" min="1" max="5" class="form-control" step="0.01" placeholder="Enter Rating" name="car_rating" required />
            </div>

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Total Seat</label>
                <input type="text" class="form-control numberonly" placeholder="Enter Total Seat" name="total_seat" required />
            </div>

            

            <div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Ac ?</label>
                <select name="car_ac" class="form-control" required>
                    <option value="">Select A Status</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

           
			
			
			
			

 <div class="form-group col-2">
                <label><span class="text-danger">*</span> Driver Name</label>
                <input type="text" class="form-control" placeholder="Enter Driver Name" name="driver_name" required />
            </div>
			
			 <div class="form-group col-2">
                <label><span class="text-danger">*</span> Driver Mobile</label>
                <input type="text" class="form-control numberonly" placeholder="Enter Driver Mobile" name="driver_mobile" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Gear System ?</label>
                <select name="car_gear" class="form-control" required>
                    <option value="">Select A System</option>
                    <option value="1">Auto</option>
                    <option value="0">Manual</option>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Facility?</label>
                <select name="car_facility[]" class="form-control select2-multi-facility" Multiple required>
                    
                    <?php 
					$flist = $car->query("select * from tbl_facility");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Type?</label>
                <select name="car_type" class="form-control select2-car-type">
                    
                    <?php 
					$flist = $car->query("select * from car_type");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Brand?</label>
                <select name="car_brand" class="form-control select2-car-brand">
                    
                    <?php 
					$flist = $car->query("select * from car_brand");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Available Car City?</label>
                <select name="car_available" class="form-control select2-car-city">
                    
                    <?php 
					$flist = $car->query("select * from tbl_city");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Rent Price(Without Driver)</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Rent Price(Without Driver)" name="car_rent_price" required />
            </div>
			
			<div class="form-group col-3">
                <label><span class="text-danger">*</span> Car Rent Price(With Driver)</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Rent Price(With Driver)" name="car_rent_price_driver" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Engine Hp</label>
                <input type="number" class="form-control" step="0.01" placeholder="Enter Car Engine Hp" name="engine_hp" required />
            </div>
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Price Type ?</label>
                <select name="price_type" class="form-control" required>
                    <option value="">Select A Price Type</option>
                    <option value="1">Hourly</option>
                    <option value="0">Daily</option>
                </select>
            </div>
			
			
			
			<div class="form-group col-2">
                <label><span class="text-danger">*</span> Car Fuel Type ?</label>
                <select name="fuel_type" class="form-control" required>
                    <option value="">Select A Fuel Type</option>
                    <option value="0">Petrol</option>
                    <option value="1">Diesel</option>
					<option value="2">Electric</option>
					<option value="3">CNG</option>
					<option value="4">Petrol & CNG</option>
                </select>
            </div>
			
			
			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>
</div>

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Description</label>
                <textarea name="car_desc" rows="10" class="form-control" style="resize:none;"></textarea>
            </div>
			
			 <div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Pickup Address</label>
                <textarea name="pick_address" rows="10" class="form-control" id="location" style="resize:none;"></textarea>
            </div>
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span> Car Latitude</label>
               <input type="text" class="form-control mb-3"  id="lat" placeholder="Enter Car Latitude" name="pick_lat" required  readonly />
			   
			    <label ><span class="text-danger">*</span> Car Longtitude</label>
               <input type="text" class="form-control mb-3"  id="lng" placeholder="Enter Car Longtitude" name="pick_lng" required  readonly />
			   
			   <label ><span class="text-danger">*</span> Car Total Driven Km</label>
               <input type="text" class="form-control mb-3"   placeholder="Enter Car Total Driven Km" name="total_km" required   />
			   
			    <label ><span class="text-danger">*</span> Car Minimum Hrs Required</label>
               <input type="text" class="form-control mb-3"   placeholder="Enter Car Minimum Hrs" name="min_hrs"  required   />
			   
           
		   
            </div>
            

            <div class="col-12">
                <button type="submit"  class="btn btn-primary mb-2">Add Car</button>
            </div>
        </div>
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
function initializeMap() {
    <?php 
    if(isset($_GET['id'])) {
        ?>
        var latlng = new google.maps.LatLng(<?php echo $data['pick_lat'];?>,<?php echo $data['pick_lng'];?>);
        <?php 
    } else {
    ?>
    var latlng = new google.maps.LatLng(28.5355161, 77.39102649999995);
    <?php } ?>
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 13
    });
    var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29)
    });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
        bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
    });
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) { 
                    bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });
}

function bindDataToForm(address, lat, lng) {
    $('#location').val(address);
    $('#lat').val(lat);
    $('#lng').val(lng);
}

function loadGoogleMapsScript() {
    var script = document.createElement('script');
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDNuJFHTBoAJeSsDdJhyuQrpkDo5_bl6As&libraries=places&callback=initializeMap";
    document.body.appendChild(script);
}

window.addEventListener('load', loadGoogleMapsScript, { passive: true });
</script>

<style type="text/css">
#map 
{
	width: 100%; height: 300px;
}

    .input-controls {
      margin-top: 10px;
      border: 1px solid transparent;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      height: 32px;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #searchInput {
      background-color: #fff;
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
      margin-left: 12px;
      padding: 0 11px 0 13px;
      text-overflow: ellipsis;
      width: 50%;
    }
    #searchInput:focus {
      border-color: #4d90fe;
    }
</style>

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


$(document).ready(function() {
    // jQuery to handle image removal and update imlist input
    const $imageList = $('#imageLists');
    const $imlistInput = $('#imlists');

    $imageList.on('click', '.close-icons', function() {
        const $closeIcon = $(this);
        const imageUrlToRemove = $closeIcon.data('url');
        const $images = $('.image-containers');

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
        const $images = $('.image-containers');
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