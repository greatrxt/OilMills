<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="route/create">
					<button type="button" class="btn btn-primary">
                        Create New Route
                    </button>
				</a>
                </div>
                Route Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayRoutesTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Route ID</th>
                    <th>Name</th>				
					<th>Route Code</th>				
                    <th>Created By</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Route ID</th>
					<th>Name</th>				
					<th>Route Code</th>				
                    <th>Created By</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayRoutesTableBody'>
				<?php foreach ($routes as $route): ?>
				<tr>
				    <td>RT<?php echo $route['RouteID']; ?></td>
                    <td><?php echo $route['RouteName']; ?></td>
                    <td><?php echo $route['RouteCode']; ?></td>
                    <td><?php echo $route['username']; ?></td>
                    <td><?php echo $route['RecordCreationTime']; ?></td>
					<td><a href='route/view/<?php echo $route['RouteID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteRouteDialog(<?php echo $route['RouteID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
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
			
<div id="deleteRouteModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Route ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this route ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteRouteModal()">Cancel</button></td>
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
		<span id = "confirmDeleteText">Could not delete this route since it is linked to other items in the system. Please delete those items first and try deleting again.</span>	
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
	function showDeleteRouteDialog(id) {
		document.getElementById('deleteRouteModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_route"; //refresh
							} else {
								//show error dialog box
									document.getElementById('errorWhileDeletingModal').style.display = "block";
									document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									window.location = "landing_route"; //refresh
								}
							}
						} else {
							window.location = "landing_route";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_route/delete/"+id, true);
				request.send();
		}
	}

	function closeDeleteRouteModal(){
		document.getElementById('deleteRouteModal').style.display = 'none';
	}
	
	// Get the modal
	var modal = document.getElementById('deleteRouteModal');
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
    $(function () {
		$('#displayRoutesTable').DataTable({
			"pageLength": 25,
			"order": [
                      /*[2, 'desc'],*/[4, 'asc']      
		]});
    });
</script>