<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="employee/create">
					<button type="button" class="btn btn-primary">
                        Create New Employee
                    </button>
				</a>
                </div>
                Employee Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayEmployeesTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
					<th>Designation</th>					
                    <th>City</th>
					<th>Username</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
					<th>Designation</th>					
                    <th>City</th>
					<th>Username</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayEmployeesTableBody'>
				<?php foreach ($employee as $employees): ?>
				<tr>
				    <td>EMP<?php echo $employees['EmployeeID']; ?></td>
                    <td><?php echo $employees['NAME']; ?></td>
                    <td><?php echo $employees['department']; ?></td>
                    <td><?php echo $employees['designation']; ?></td>
                    <td><?php echo $employees['City']; ?></td>
					<td><?php echo $employees['Username']; ?></td>
                    <td><?php echo $employees['RecordCreationTime']; ?></td>
					<td><a href='employee/edit/<?php echo $employees['EmployeeID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteEmployeeDialog(<?php echo $employees['EmployeeID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</section>
			
<div id="deleteEmployeeModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Employee ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this employee ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteEmployeeModal()">Cancel</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>

<div id="errorWhileDeletingModal" class="modal-outer-body">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Error while deleting</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Could not delete this employee since this account is linked to certain Sales orders in the system. </span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonCloseErrorWhileDeletingModal" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">OK</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>


<script>
	function showDeleteEmployeeDialog(id) {
		document.getElementById('deleteEmployeeModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_employee"; //refresh
							} else {
								//show error dialog box
								document.getElementById('errorWhileDeletingModal').style.display = "block";
								document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									//document.getElementById('errorWhileDeletingModal').style.display = "none";
									//document.getElementById('deleteEmployeeModal').style.display = "none";
									window.location = "landing_employee"; //refresh
								}
							}
						} else {
							window.location = "landing_employee";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_employee/delete/" + id, true);
				request.send();
		}
	}

	function closeDeleteEmployeeModal(){
		document.getElementById('deleteEmployeeModal').style.display = 'none';
	}
	
</script>
<!-- Page Scripts -->
<script>
    $(function () {
		$('#displayEmployeesTable').DataTable({
			"pageLength": 10,
			"order": [
                     [6, 'asc']      
		]});
    });
</script>