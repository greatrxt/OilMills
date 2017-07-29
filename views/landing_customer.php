<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Customers List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="customer/create">
					<button type="button" class="btn btn-primary">
                        Add Customer
                    </button>
				</a>
                </div>
                Customer Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayCustomersTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Contact Number</th>
					<th>Route</th>
					<th>Username</th>
					<th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Contact Number</th>
					<th>Route</th>
					<th>Username</th>
					<th>Actions</th>
                </tr>
                </tfoot>
                <tbody id = 'displayCustomersTableBody'>
				<?php foreach ($customer as $customers): ?>
				<tr>
				    <td>CUST<?php echo $customers['CustomerID']; ?></td>
                    <td><?php echo $customers['NAME']; ?></td>
                    <td><?php echo $customers['AREA']; ?></td>
                    <td><?php echo $customers['City']; ?></td>
                    <td><?php echo $customers['ContactNumber']; ?></td>
                    <td><?php echo $customers['routename']; ?></td>
					<td><?php echo $customers['Username']; ?></td>
					<td><a href='customer/edit/<?php echo $customers['CustomerID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteCustomerDialog(<?php echo $customers['CustomerID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Customers List -->

</div>
</section>
			
<div id="deleteCustomerModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Customer ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this customer ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteCustomerModal()">Cancel</button></td>
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
		<span id = "confirmDeleteText">Could not delete this customer since it is linked to other items in the system. Please delete those items first and try deleting again.</span>	
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
	function showDeleteCustomerDialog(id) {
		document.getElementById('deleteCustomerModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_customer"; //refresh
							} else {
								//show error dialog box
								document.getElementById('errorWhileDeletingModal').style.display = "block";
								document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									//document.getElementById('errorWhileDeletingModal').style.display = "none";
									//document.getElementById('deleteCustomerModal').style.display = "none";
									window.location = "landing_customer"; //refresh
								}
							}
						} else {
							window.location = "landing_customer";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_customer/delete/" + id, true);
				request.send();
		}
	}

	function closeDeleteCustomerModal(){
		document.getElementById('deleteCustomerModal').style.display = 'none';
	}
	
</script>
<!-- End Page Scripts -->
<!-- Page Scripts -->
<script>
    $(function () {
		$('#displayCustomersTable').DataTable();
    });
</script>