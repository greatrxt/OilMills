<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
					<a href="location/create">
					<button type="button" class="btn btn-primary" >
                        Add Location
                    </button>
					</a>
                </div>
                Location Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayLocationsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Location ID</th>
                    <th>City</th>
					<th>District</th>
                    <th>State</th>					
                    <th>Created By</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Location ID</th>
                    <th>City</th>
					<th>District</th>
                    <th>State</th>					
                    <th>Created By</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayLocationsTableBody'>
				<?php foreach ($location as $locations): ?>
				<tr>
				    <td>LOC<?php echo $locations['LocationID']; ?></td>
                    <td><?php echo $locations['City']; ?></td>
                    <td><?php echo $locations['District']; ?></td>
                    <td><?php echo $locations['State']; ?></td>
                    <td><?php echo $locations['username']; ?></td>
                    <td><?php echo $locations['RecordCreationTime']; ?></td>
					<td><a href='location/view/<?php echo $locations['LocationID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteLocationDialog(<?php echo $locations['LocationID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</section>
<!-- Page Scripts -->
			
<div id="deleteLocationModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Location ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this location ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteLocationModal()">Cancel</button></td>
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
		<span id = "confirmDeleteText">Could not delete this location since it is linked to other items in the system. Please delete those items first and try deleting again.</span>	
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
	function showDeleteLocationDialog(id) {
		document.getElementById('deleteLocationModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_location"; //refresh
							} else {
								//show error dialog box
								document.getElementById('errorWhileDeletingModal').style.display = "block";
								document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									//document.getElementById('errorWhileDeletingModal').style.display = "none";
									//document.getElementById('deleteLocationModal').style.display = "none";
									window.location = "landing_location"; //refresh
								}
							}
						} else {
							window.location = "landing_location";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_location/delete/<?php echo $locations['LocationID']; ?>", true);
				request.send();
		}
	}

	function closeDeleteLocationModal(){
		document.getElementById('deleteLocationModal').style.display = 'none';
	}
	
	// Get the modal
	var modal = document.getElementById('deleteLocationModal');
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
    $(function () {
		$('#displayLocationsTable').DataTable();
    });
</script>
