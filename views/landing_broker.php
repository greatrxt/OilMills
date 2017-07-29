<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="broker/create">
					<button type="button" class="btn btn-primary"  onclick = "addBroker();">
                        Add Broker
                    </button>
				</a>
                </div>
                Broker Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayBrokersTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Broker ID</th>
                    <th>Broker Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Created By</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Broker ID</th>
                    <th>Broker Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Created By</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayBrokersTableBody'>
				<?php foreach ($brokers as $broker): ?>
				<tr>
				    <td>BRK<?php echo $broker['BrokerID']; ?></td>
                    <td><?php echo $broker['NAME']; ?></td>
                    <td><?php echo $broker['AREA']; ?></td>
                    <td><?php echo $broker['City']; ?></td>
                    <td><?php echo $broker['Username']; ?></td>
					<td><a href='broker/view/<?php echo $broker['BrokerID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteBrokerDialog(<?php echo $broker['BrokerID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
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
			
<div id="deleteBrokerModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Broker ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this broker ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteBrokerModal()">Cancel</button></td>
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
		<span id = "confirmDeleteText">Could not delete this broker since it is linked to other items in the system. Please delete those items first and try deleting again.</span>	
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
	function showDeleteBrokerDialog(id) {
		document.getElementById('deleteBrokerModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_broker"; //refresh
							} else {
								//show error dialog box
								document.getElementById('errorWhileDeletingModal').style.display = "block";
								document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									//document.getElementById('errorWhileDeletingModal').style.display = "none";
									//document.getElementById('deleteBrokerModal').style.display = "none";
									window.location = "landing_broker"; //refresh
								}
							}
						} else {
							window.location = "landing_broker";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_broker/delete/"+id, true);
				request.send();
		}
	}

	function closeDeleteBrokerModal(){
		document.getElementById('deleteBrokerModal').style.display = 'none';
	}
	
	// Get the modal
	var modal = document.getElementById('deleteBrokerModal');
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
    $(function () {
		$('#displayBrokersTable').DataTable();
    });
</script>
