
<section class = "page-content">
<div class="page-content-inner">
	
    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "locationTitle">Edit Location</div>
            </h2>
        </div>
        <div class="panel-body">
			<div class="nav-tabs-horizontal">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Location Details</a>
					</li>
				</ul>
				
				<?php echo validation_errors(); ?>

				<?php echo form_open('ParmarOilMills/web/location/edit/'.$location['LocationID']); ?>

				<div id = "form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="city">City Name*</label>
                                <input class="form-control" tabindex="1" name="city" type="text" required value = "<?php echo $location['City']; ?>">
                            </div>
							<div class="form-group">
								<label class="form-control-label" for="district">District</label>
								<input class="form-control" tabindex="2" name="district" type="text"  value = "<?php echo $location['District']; ?>">
							</div>
						
						</div>
						
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="LocationID">Location ID</label>
                                <input class="form-control" name="LocationID" type="text" disabled  value = "LOC<?php echo $location['LocationID']; ?>">
                            </div>
							<div class="form-group">
                                <label for="state">State*</label>
								<select class="form-control" name="state" tabindex="3">
									<optgroup label="States">
										<option <?php if ($location['State'] == 'Andhra Pradesh') echo 'selected'; ?> >Andhra Pradesh</option>
										<option <?php if ($location['State'] == 'Arunachal Pradesh') echo 'selected'; ?> >Arunachal Pradesh</option>
										<option <?php if ($location['State'] == 'Assam') echo 'selected'; ?> >Assam</option>
										<option <?php if ($location['State'] == 'Bihar') echo 'selected'; ?> >Bihar</option>
										<option <?php if ($location['State'] == 'Chhattisgarh') echo 'selected'; ?> >Chhattisgarh</option>
										<option <?php if ($location['State'] == 'Goa') echo 'selected'; ?> >Goa</option>
										<option <?php if ($location['State'] == 'Gujarat') echo 'selected'; ?> >Gujarat</option>
										<option <?php if ($location['State'] == 'Haryana') echo 'selected'; ?> >Haryana</option>
										<option <?php if ($location['State'] == 'Himachal Pradesh') echo 'selected'; ?> >Himachal Pradesh</option>
										<option <?php if ($location['State'] == 'Jammu and Kashmir') echo 'selected'; ?> >Jammu and Kashmir</option>
										<option <?php if ($location['State'] == 'Jharkhand') echo 'selected'; ?> >Jharkhand</option>
										<option <?php if ($location['State'] == 'Karnataka') echo 'selected'; ?> >Karnataka</option>
										<option <?php if ($location['State'] == 'Kerala') echo 'selected'; ?> >Kerala</option>
										<option <?php if ($location['State'] == 'Madhya Pradesh') echo 'selected'; ?> >Madhya Pradesh</option>
										<option <?php if ($location['State'] == 'Maharashtra') echo 'selected'; ?> >Maharashtra</option>
										<option <?php if ($location['State'] == 'Manipur') echo 'selected'; ?> >Manipur</option>
										<option <?php if ($location['State'] == 'Meghalaya') echo 'selected'; ?> >Meghalaya</option>
										<option <?php if ($location['State'] == 'Mizoram') echo 'selected'; ?> >Mizoram</option>
										<option <?php if ($location['State'] == 'Nagaland') echo 'selected'; ?> >Nagaland</option>
										<option <?php if ($location['State'] == 'Odisha') echo 'selected'; ?> >Odisha</option>
										<option <?php if ($location['State'] == 'Punjab') echo 'selected'; ?> >Punjab</option>
										<option <?php if ($location['State'] == 'Rajasthan') echo 'selected'; ?> >Rajasthan</option>
										<option <?php if ($location['State'] == 'Sikkim') echo 'selected'; ?> >Sikkim</option>
										<option <?php if ($location['State'] == 'Tamil Nadu') echo 'selected'; ?> >Tamil Nadu</option>
										<option <?php if ($location['State'] == 'Telangana') echo 'selected'; ?> >Telangana</option>
										<option <?php if ($location['State'] == 'Tripura') echo 'selected'; ?> >Tripura</option>
										<option <?php if ($location['State'] == 'Uttar Pradesh') echo 'selected'; ?> >Uttar Pradesh</option>
										<option <?php if ($location['State'] == 'Uttarakhand') echo 'selected'; ?> >Uttarakhand</option>
										<option <?php if ($location['State'] == 'West Bengal') echo 'selected'; ?> >West Bengal</option>
									</optgroup>
									<optgroup label="Union Territories">
										<option <?php if ($location['State'] == 'Andaman and Nicobar Islands') echo 'selected'; ?> >Andaman and Nicobar Islands</option>
										<option <?php if ($location['State'] == 'Chandigarh') echo 'selected'; ?> >Chandigarh</option>
										<option <?php if ($location['State'] == 'Dadar and Nagar') echo 'selected'; ?> >Dadar and Nagar</option>
										<option <?php if ($location['State'] == 'Daman and Diu') echo 'selected'; ?> >Daman and Diu</option>
										<option <?php if ($location['State'] == 'Delhi') echo 'selected'; ?> >Delhi</option>
										<option <?php if ($location['State'] == 'Lakshadweep') echo 'selected'; ?> >Lakshadweep</option>
										<option <?php if ($location['State'] == 'Puducherry') echo 'selected'; ?> >Puducherry</option>
									</optgroup>
								</select>
                            </div>
							
						</div>
					</div>
					<div class="form-group" >
						<div class="col-md-9" style="padding-bottom:20px;">
							<button type="submit" class="btn width-150 btn-primary" style="margin:10px" name="submit" tabindex="4">Save</button>
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_location"><button type="button" class="btn width-150 btn-default" style="margin:10px" tabindex="5">Cancel</button></a>
						</div>
                    </div>

				</div>
				</form>
			</div>

		</div>
	</section>
</div>	
</section>
