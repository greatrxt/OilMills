<div style = "padding-top:20px;padding-left:20px;padding-right:20px;">
	<?php echo validation_errors('  <div style = "border-color: #ebccd1;background-color:#f2dede; color:#a94442" class="alert alert-danger alert-dismissable"><a style = "padding-bottom:10px" href="#" class="close" data-dismiss="alert" aria-label="close">×</a>', '</div>'); ?>
</div>
<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "customerTitle">Customer</div>
            </h2>
        </div>
        <div class="panel-body">
			<div class="nav-tabs-horizontal" id = "homeTabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a id = "0" class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Customer Details</a>
					</li>
					<li class="nav-item">
						<a id = "1" class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab2" role="tab" aria-expanded="true">Taxation & Related</a>
					</li>
					<li class="nav-item">
						<a id = "2" class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab3" role="tab" aria-expanded="true">Application Credentials</a>
					</li>
				</ul>
				<?php echo validation_errors(); ?>
				<?php $attributes = array('name' => 'form-validation'); echo form_open('ParmarOilMills/web/customer/edit/'.$customer['CustomerId'], $attributes); ?>
				<div id = "form-validation" name="form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="name">Customer / Company Name*</label>
                                <input class="form-control" id="name" type="text" name="name" value = "<?php echo $customer['Name']; ?>" data-validation="[L>=3]"
																					   data-validation-message="Must contain atleast 3 characters" tabindex = "1">
                            </div>
							<div class="form-group">
								<label class="form-control-label" for="address">Address*</label>
                                <input class="form-control" id="address" type="text" name="address" value = "<?php echo $customer['Address']; ?>" data-validation="[L>=3]"
																						data-validation-message="Please enter a valid address" tabindex = "2">
							</div>

							<div class="form-group">
                                <label for="city">City*</label>
								<select class="form-control" name="city"  id="city" onChange = "refreshLocationDistrictAndState()" tabindex = "4">
								<?php
									foreach($location as $loc)
									{
										?>
										<option <?php if($customer['Location'] == $loc['LocationID'])  echo "selected" ?> value="<?=$loc['LocationID']?>"><?=$loc['City']?></option>
										<?php
									}
									?>
								</select>
                            </div>								
							<div class="form-group">
                                <label for="state">State*</label>
								<input class="form-control" id="state" type="text" readonly>
                            </div>
						
							<div class="form-group">
                                <label for="contactPerson">Contact Person*</label>
                                <input class="form-control" id="contactPerson" type="text" name="contactPerson" value = "<?php echo $customer['ContactPerson']; ?>" data-validation="[L>=3]"
																					   data-validation-message="Please enter a valid name" tabindex = "6">
                            </div>
							
							<div class="form-group">
                                <label for="emailAddress">Email Address</label>
                                <input class="form-control" id="emailAddress" type="text" name="emailAddress"  value = "<?php echo $customer['EmailAddress']; ?>" data-validation="[OPTIONAL, EMAIL]" tabindex = "8">
                            </div>
						</div>
						
						
						<div class = "col-lg-5" style="padding-left:100px;">
							<div class="form-group">
                                <label for="customerId">Customer ID</label>
								<input class="form-control" id="customerId" type="text" readonly value = "CUST<?php echo $customer['CustomerId']; ?>">
                            </div>	
							<div class="form-group">
								<label class="form-control-label" for="area">Area*</label>
                                <input class="form-control" id="area" type="text" name="area" value = "<?php echo $customer['Area']; ?>"  data-validation="[L>=3]" tabindex = "3">
							</div>						
							<div class="form-group">
                                <label for="district">District</label>
                                <input class="form-control" id="district" type="text" readonly>
                            </div>							
							
							<div class="form-group">
                                <label for="route">Route</label>
								<select class="form-control" id="route" name="Route" tabindex = "5">
									<?php
									foreach($routes as $route)
									{
										?>
										<option <?php if($customer['Route'] == $route['RouteID']) echo " selected "?> value="<?=$route['RouteID']?>"><?=$route['RouteName']?></option>
										<?php
									}
									?>	
								</select>
                            </div>
							
							<div class="form-group">
                                <label for="contactNumber">Contact Number*</label>
                                <input class="form-control" id="contactNumber" type="text" name="contactNumber" data-validation="[L>=8]" tabindex = "7"
																					   data-validation-message="Please enter a valid Contact Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value = "<?php echo $customer['ContactNumber']; ?>">
                            </div>

							
						</div>
					</div>

					<div class="tab-pane" id="tab2" role="tabpanel" aria-expanded="true">
						<div class = "col-lg-5">
							<div class="form-group">
								<label class="form-control-label" for="gstNumberApplicable">GST Number Available</label><br/>
                                <input value="Yes" name = "GSTNumberStatus" type="radio" style="margin:11px" <?php if($customer['GSTNumberStatus'] == "Yes") echo "checked" ?> onclick="document.getElementById('gstNumber').disabled = false">Yes
								<input value="NA" name = "GSTNumberStatus" type="radio"  style="margin:11px" <?php if($customer['GSTNumberStatus'] == "NA") echo "checked" ?> onclick="document.getElementById('gstNumber').disabled = true">NA
								<input value="Applied" name = "GSTNumberStatus" type="radio" style="margin:11px" <?php if($customer['GSTNumberStatus'] == "Applied") echo "checked" ?> onclick="document.getElementById('gstNumber').disabled = true">Applied
                            </div>
							<div class="form-group">
                                <label for="gstNumber">GST Number</label>
                                <input class="form-control" id="gstNumber" name="GSTNumber" type="text" value = "<?php if($customer['GSTNumberStatus'] == "Yes") echo $customer['GSTNumber'] ?>" <?php if(!($customer['GSTNumberStatus'] == "Yes")) echo "disabled" ?> data-validation="[L>=15]">
                            </div>

						</div>
						<div class = "col-lg-5">
							<div class="form-group">
								<label class="form-control-label" for="gstNumberApplicable">FSSAI Number</label><br/>
                                <input value="Yes" name = "FSSAINumberStatus" type="radio" style="margin:11px" <?php if($customer['FSSAINumberStatus'] == "Yes") echo "checked" ?>  onclick="document.getElementById('fssaiNumber').disabled = false">Yes
								<input value="NA" name = "FSSAINumberStatus" type="radio"  style="margin:11px" <?php if($customer['FSSAINumberStatus'] == "NA") echo "checked" ?> onclick="document.getElementById('fssaiNumber').disabled = true">NA
								<input value="Applied" name = "FSSAINumberStatus" type="radio" style="margin:11px"  <?php if($customer['FSSAINumberStatus'] == "Applied") echo "checked" ?>  onclick="document.getElementById('fssaiNumber').disabled = true">Applied
                            </div>
							<div class="form-group">
                                <label for="fssaiNumber">FSSAI Number</label>
                                <input class="form-control" name="FSSAINumber" id="fssaiNumber" type="text" value = "<?php if($customer['FSSAINumberStatus'] == "Yes") echo $customer['FSSAINumber'] ?>" <?php if(!($customer['FSSAINumberStatus'] == "Yes")) echo "disabled" ?> data-validation="[L>=14]">
                            </div>

						</div>
					</div>

					<div class="tab-pane" id="tab3" role="tabpanel" aria-expanded="true">

						<div class = "col-lg-4">							
						<div class="form-group">
                                <label for="username">Username</label>
                                <input class="form-control" id="username" type="text" name = "username" <?php if($customer['Active'] != "1") echo "disabled" ?>  value = "<?php echo $customer['Username']; ?>" data-validation="[L>=3]">
                            </div></div>
						<div class = "col-lg-4">						
						<div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" type="password" name = "password" <?php if($customer['Active'] != "1") echo "disabled" ?> value = "<?php echo $customer['Password']; ?>" data-validation="[L>=3]">
                            </div>
						</div>
						<div class = "col-lg-1">
							<div class="form-group">
								<label class="form-control-label" for="userActive">Active</label><br/>
                                <input id="userIsActive" id = "userActive" name = "userActive" type="checkbox"  style="margin:11px" <?php if($customer['Active'] == "1") echo "checked" ?> 
								onclick="document.getElementById('username').disabled=!this.checked;
									document.getElementById('password').disabled=!this.checked;
									if(!this.checked) document.getElementById('username').value = '<?php echo $customer['Username'];  ?>'
									if(!this.checked) document.getElementById('password').value = '<?php echo $customer['Password'];  ?>'">
                            </div>
						</div>
					</div>
					<div class="form-group" >
						<div class="col-md-9" style="padding-bottom:20px;">
							<button type="submit" class="btn width-150 btn-primary" id = "btnSave"  style="margin:10px" onclick = "return validateForm()">Save</button>
							<button type="button" class="btn width-150 btn-default" id = "btnBack" style="margin:10px">Back</button>
							<button type="button" class="btn width-150 btn-default" id = "btnNext" style="margin:10px">Next</button>
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_customer"><button type="button" class="btn width-150 btn-default" style="margin:10px" >Cancel</button></a>
						</div>
                    </div>
					</div>
				</form>
				</div>
			</div>

		
	</section>
</div>	
</section>
<script>

			
function validateForm(){
	document.getElementById("usernameError").innerHTML = '';
	document.getElementById("passwordError").innerHTML = '';
	
	if(document.getElementById('name').value.length < 3
		|| document.getElementById('contactPerson').value.length < 3
		|| document.getElementById('contactNumber').value.length < 8
		|| document.getElementById('address').value.length < 3){
		 $('.nav-tabs-horizontal li:eq(0) a').tab('show');
		 
		return false;
	}
	
	if(!document.getElementById('gstNumber').disabled){
		if(document.getElementById('gstNumber').value.length < 15){
			$('.nav-tabs-horizontal li:eq(1) a').tab('show');
			return false;
		}
	}
	
	if(!document.getElementById('fssaiNumber').disabled){
		if(document.getElementById('fssaiNumber').value.length < 14){
			$('.nav-tabs-horizontal li:eq(1) a').tab('show');
			return false;
		}
	}
	
	if(document.getElementById('userIsActive').checked){
		if(document.getElementById('username').value.length < 3
			|| document.getElementById('password').value.length < 3){
			 $('.nav-tabs-horizontal li:eq(2) a').tab('show');			 
			return false;
		}
	}
	return true;
}

// Show/Hide Password
$('#password').password({
	eyeClass: '',
	eyeOpenClass: 'icmn-eye',
	eyeCloseClass: 'icmn-eye-blocked'
});
</script>
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