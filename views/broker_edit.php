<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "customerTitle">Edit Broker</div>
            </h2>
        </div>
        <div class="panel-body">
			<div class="nav-tabs-horizontal" id = "homeTabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a id = "0" class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Broker Details</a>
					</li>
				</ul>

				<?php echo form_open('ParmarOilMills/web/broker/edit/'.$broker['BrokerId']); ?>
				<div id = "form-validation" name="form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="name">Broker / Company Name*</label>
                                <input class="form-control" name="name" type="text" value = "<?php echo $broker['Name']; ?>">
                            </div>
							<div class="form-group">
								<label class="form-control-label" for="address">Address*</label>
                                <input class="form-control" name="address" type="text" value = "<?php echo $broker['Address']; ?>">
							</div>

							<div class="form-group">
                                <label for="city">City*</label>
								<select class="form-control" name="city" id="city" onChange = "refreshLocationDistrictAndState()">
								<?php
									foreach($location as $loc)
									{
										?>
										<option <?php if($loc['LocationID'] == $broker['Location']) echo "selected"?> value="<?=$loc['LocationID']?>"><?=$loc['City']?></option>
										<?php
									}
									?>
								</select>
                            </div>								
							<div class="form-group">
                                <label for="state">State*</label>
								<input class="form-control" name="state" id="state" type="text" readonly >
                            </div>
						
							<div class="form-group">
                                <label for="contactPerson">Contact Person*</label>
                                <input class="form-control" name="contactPerson" type="text" value = "<?php echo $broker['ContactPerson']; ?>">
                            </div>

						</div>
						
						
						<div class = "col-lg-5" style="padding-left:100px;">
							<div class="form-group">
                                <label for="brokerId">Broker ID</label>
								<input class="form-control" type="text" readonly value = "BRK<?php echo $broker['BrokerId']; ?>">
                            </div>	
							<div class="form-group">
								<label class="form-control-label" for="area">Area</label>
                                <input class="form-control" name="area" type="text" value = "<?php echo $broker['Area']; ?>">
							</div>						
							<div class="form-group">
                                <label for="district">District</label>
                                <input class="form-control" name="district" id="district" type="text" readonly>
                            </div>							
							
							
							<div class="form-group">
                                <label for="emailAddress">Email Address</label><span id = "emailAddressError" style = "color:red; display:none;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Please check email address format !</span>
                                <input class="form-control" name="emailAddress" type="text" value = "<?php echo $broker['EmailAddress']; ?>">
                            </div>
							
							<div class="form-group">
                                <label for="contactNumber">Contact Number*</label>
                                <input class="form-control" name="contactNumber" type="text" value = "<?php echo $broker['ContactNumber']; ?>">
                            </div>							
						</div>
					</div>
					<div class="form-group" >
						<div class="col-md-9" style="padding-bottom:20px;">
							<button type="submit" class="btn width-150 btn-primary" id = "btnSave"  style="margin:10px" onclick="createOrUpdateCustomer()">Save</button>
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_broker"><button type="button" class="btn width-150 btn-default" style="margin:10px" >Cancel</button></a>
						</div>
                    </div>
					</div>
				</form>
				</div>
			</div>

		</div>
	</section>
</div>	
</section>
<script>
		locationsArray = new Array();
		var jsLoc;
		<?php
		foreach($location as $loc)
		{
			?>
			jsLoc = new Object();
			jsLoc.cityName = "<?php echo $loc['City'] ?>";
			jsLoc.district = "<?php echo $loc['District'] ?>";
			jsLoc.state = "<?php echo $loc['State'] ?>";
			locationsArray.push(jsLoc);
			<?php
		}
		?>
		refreshLocationDistrictAndState();
</script>