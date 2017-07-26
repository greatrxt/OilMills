
<section class = "page-content">
<div class="page-content-inner">
	
    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "locationTitle">Location</div>
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

				<?php echo form_open('index.php/ParmarOilMills/web/location/create'); ?>

				<div id = "form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="city">City Name*</label>
                                <input class="form-control" tabindex="1" name="city" type="text" required>
                            </div>
							<div class="form-group">
								<label class="form-control-label" for="district">District</label>
								<input class="form-control" tabindex="2" name="district" type="text">
							</div>
						
						</div>
						
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="LocationID">Location ID</label>
                                <input class="form-control" name="LocationID" type="text" disabled value = "Not Assigned Yet">
                            </div>
							<div class="form-group">
                                <label for="state">State*</label>
								<select class="form-control" name="state" tabindex="3">
									<optgroup label="States">
										<option>Andhra Pradesh</option>
										<option>Arunachal Pradesh</option>
										<option>Assam</option>
										<option>Bihar</option>
										<option>Chhattisgarh</option>
										<option>Goa</option>
										<option>Gujarat</option>
										<option>Haryana</option>
										<option>Himachal Pradesh</option>
										<option>Jammu and Kashmir</option>
										<option>Jharkhand</option>
										<option>Karnataka</option>
										<option>Kerala</option>
										<option>Madhya Pradesh</option>
										<option selected>Maharashtra</option>
										<option>Manipur</option>
										<option>Meghalaya</option>
										<option>Mizoram</option>
										<option>Nagaland</option>
										<option>Odisha</option>
										<option>Punjab</option>
										<option>Rajasthan</option>
										<option>Sikkim</option>
										<option>Tamil Nadu</option>
										<option>Telangana</option>
										<option>Tripura</option>
										<option>Uttar Pradesh</option>
										<option>Uttarakhand</option>
										<option>West Bengal</option>
									</optgroup>
									<optgroup label="Union Territories">
										<option>Andaman and Nicobar Islands</option>
										<option>Chandigarh</option>
										<option>Dadar and Nagar</option>
										<option>Daman and Diu</option>
										<option>Delhi</option>
										<option>Lakshadweep</option>
										<option>Puducherry</option>
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
