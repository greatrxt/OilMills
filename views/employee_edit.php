<div style = "padding-top:20px;padding-left:20px;padding-right:20px;">
	<?php echo validation_errors('  <div style = "border-color: #ebccd1;background-color:#f2dede; color:#a94442" class="alert alert-danger alert-dismissable"><a style = "padding-bottom:10px" href="#" class="close" data-dismiss="alert" aria-label="close">×</a>', '</div>'); ?>
</div>
<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "employeeTitle">View Employee</div>
            </h2>
        </div>

        <div class="panel-body">
			<div class="nav-tabs-horizontal" id = "homeTabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a id = "0" class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Employee Details</a>
					</li>
					<li class="nav-item">
						<a id = "1" class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab2" role="tab" aria-expanded="true">Application Credentials</a>
					</li>
				</ul>

				<?php $attributes = array('name' => 'form-validation'); echo form_open('ParmarOilMills/web/employee/edit/'.$employee['EmployeeId'], $attributes); ?>
				<div id = "form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="name">Employee Name*</label>
                                <input class="form-control" id="name" type="text"  value="<?php if(set_value('name')!=null) echo set_value('name'); else echo $employee['Name']; ?>" name="name" data-validation="[L>=3]"
																					   data-validation-message="Must contain atleast 3 characters">
                            </div>
							<div class="form-group">
								<label class="form-control-label" for="address">Address*</label>
                                <input class="form-control" id="address" type="text" name="address" value="<?php if(set_value('address')!=null) echo set_value('address'); else echo $employee['Address']; ?>" data-validation="[L>=2]" data-validation-message="Please enter a valid address">
							</div>

							<div class="form-group">
                                <label for="city">City*</label>
								<select class="form-control" name="city"  id="city" onChange = "refreshLocationDistrictAndState()">
								<?php
									foreach($location as $loc)
									{
										?>
										<option 
										<?php 
										$LocationID = $employee['Location']; 
										if(set_value('city')!=null) $LocationID = set_value('city');
										if($LocationID == $loc['LocationID']) echo "selected" ?> 
										value="<?=$loc['LocationID']?>"><?=$loc['City']?>
										</option>
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
                                <label for="department">Department*</label>
                                <input class="form-control" id = "department" type="text" name="department" value="<?php if(set_value('department')!=null) echo set_value('department'); else echo $employee['Department']; ?>" data-validation="[L>=2]"  data-validation-message="Must contain atleast 2 characters">
                            </div>

						</div>
						
						
						<div class = "col-lg-5" style="padding-left:100px;">
							<div class="form-group">
                                <label for="employeeId">Employee ID</label>
								<input class="form-control" name="employeeId" type="text" readonly value="EMP<?php if(set_value('employeeId')!=null) echo set_value('employeeId'); else echo $employee['EmployeeId']; ?>">
                            </div>	
							<div class="form-group">
								<label class="form-control-label" for="area">Area*</label>
                                <input class="form-control" name="area" type="text" name="area" value="<?php if(set_value('area')!=null) echo set_value('area'); else echo $employee['Area']; ?>" data-validation="[L>=3]">
							</div>						
							<div class="form-group">
                                <label for="district">District</label>
                                <input class="form-control" id="district" type="text" readonly value="<?php echo set_value('district'); ?>">
                            </div>							
							
							<div class="form-group">
                                <label for="designation">Designation*</label>
                                <input class="form-control" id = "designation" type="text" name="designation"  value="<?php if(set_value('designation')!=null) echo set_value('designation'); else echo $employee['Designation']; ?>" data-validation="[L>=2]"
																					   data-validation-message="Must contain atleast 2 characters">
                            </div>

							
						</div>
					</div>

					<div class="tab-pane" id="tab2" role="tabpanel" aria-expanded="true">

						<div class = "col-lg-4">							
						<div class="form-group">
                                <label for="username">Username</label>
                                <input class="form-control" id="username" type="text" name = "username" value="<?php if(set_value('username')!=null) echo set_value('username'); else echo $employee['Username']; ?>" data-validation="[L>=3]">
                            </div>
						</div>
						<div class = "col-lg-4">						
						<div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" type="password" name = "password" value="<?php if(set_value('password')!=null) echo set_value('password'); else echo $employee['Password']; ?>" data-validation="[L>=3]">
                            </div>
						</div>
						<div class = "col-lg-1">
							<div class="form-group">
								<label class="form-control-label" for="userActive">Active</label><br/>
                                <input name = "userActive" type="checkbox"  style="margin:11px"
										<?php 
										$userActive = ($employee['Active'] == 1); 
										if(set_value('userActive')!=null) $userActive = (set_value('userActive') == "on");
										if($userActive) echo "checked" ?> 
										onclick="document.getElementById('username').disabled=!this.checked;document.getElementById('password').disabled=!this.checked;">
                            </div>
						</div>
						<div class = "col-lg-9">							
						<div class="form-group">
                                <label for="role">Role</label><br/>
								<input id = "roleSales" name = "role[]" type="checkbox" value = "SALES" <?php if(in_array('SALES', explode(",", $employee['Role']))) echo "checked"; ?> style="margin:11px" onclick="manageRoles()">Sales
								<input id = "roleOperations" name = "role[]" type="checkbox" value = "OPERATIONS" <?php if(in_array('OPERATIONS', explode(",", $employee['Role']))) echo "checked"; ?>  style="margin:11px" onclick="manageRoles()">Operations
								<input id = "roleAdmin" name = "role[]" type="checkbox" value = "ADMIN" <?php if(in_array('ADMIN', explode(",", $employee['Role']))) echo "checked"; ?>  style="margin:11px" onclick="manageRoles()">Management
                            </div>
						</div>
					</div>

					<div class="form-group" >
						<div class="col-md-9" style="padding-bottom:20px;">
							<button type="submit" class="btn width-150 btn-primary" id = "btnSave"  style="margin:10px" onclick = "return validateForm()">Save</button>
							<button type="button" class="btn width-150 btn-default" id = "btnBack" style="margin:10px">Back</button>
							<button type="button" class="btn width-150 btn-default" id = "btnNext" style="margin:10px">Next</button>
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_employee"><button type="button" class="btn width-150 btn-default" style="margin:10px" >Cancel</button></a>
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
function manageRoles(){
	if(document.getElementById('roleSales').checked
	|| document.getElementById('roleOperations').checked){	
		document.getElementById('roleAdmin').disabled = true;
	} else if(document.getElementById('roleAdmin').checked){
		document.getElementById('roleSales').disabled = true;
		document.getElementById('roleOperations').disabled = true;
	} else {
		document.getElementById('roleAdmin').disabled = false;
		document.getElementById('roleSales').disabled = false;
		document.getElementById('roleOperations').disabled = false;
	}
}
manageRoles();
function validateForm(){
	if(document.getElementById('name').value.length < 3
		|| document.getElementById('department').value.length < 2
		|| document.getElementById('designation').value.length < 2
		|| document.getElementById('address').value.length < 3){
		 $('.nav-tabs-horizontal li:eq(0) a').tab('show');
		 
		return false;
	}
	if(document.getElementById('userActive').checked){
		if(document.getElementById('username').value.length < 3
			|| document.getElementById('password').value.length < 3){
			 $('.nav-tabs-horizontal li:eq(1) a').tab('show');
			 
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