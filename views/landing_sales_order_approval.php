<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
			    <div class="dropdown pull-right">

					<button type="button" class="btn btn-primary"  onclick = "changeSelectedOrderStatus('approve');">
						Approve
					</button>

					<button type="button" class="btn btn-primary"  onclick = "changeSelectedOrderStatus('reject');">
						Reject
					</button>
				
                </div>
                Sales Order Approval
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayRoutesTable" width="100%">
                <thead class="thead-default">
                <tr>
					<th>Entry ID</th>
                    <th>Order ID</th>
                    <th>Date</th>				
					<th>Customer Name</th>				
                    <th>Broker Name</th>
					<th>Payment</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>Rate</th>
					<th>Order By User</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
					<th>Entry ID</th>
                    <th>Order ID</th>
                    <th>Date</th>				
					<th>Customer Name</th>				
                    <th>Broker Name</th>
					<th>Payment</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>Rate</th>
					<th>Order By User</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayRoutesTableBody'>
				<?php foreach ($order_entries as $order_entry): ?>
				<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
					<td>ODE<?php echo $order_entry['OrderEntryId']; ?></td>
					<td>OD<?php echo $order_entry['OrderId']; ?></td>
                    <td><?php echo $order_entry['OrderTime']; ?></td>
                    <td><?php echo $order_entry['CustomerName']; ?></td>
                    <td><?php echo $order_entry['BrokerName']; ?></td>
                    <td><?php echo $order_entry['PaymentTerms']; ?></td>
					<td><?php echo $order_entry['ProductName']; ?></td>
					<td><?php echo $order_entry['OrderQuantity']; ?></td>
					<td><?php echo $order_entry['SellingPriceAtOrderTime']; ?></td>
					<td><?php echo $order_entry['Username']; ?></td>
					<td><input type = "checkbox" onchange = "addForReview(this, <?php echo $order_entry['OrderEntryId']; ?>)"></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</section>
<script>
var entriesToReview = new Array();
var payload = new Object();
function addForReview(checkbox, id){
	if(checkbox.checked){
		entriesToReview.push(id);
	} else {
		entriesToReview.splice(entriesToReview.indexOf(id), 1);
	}
	payload.entries = entriesToReview;
}

function changeSelectedOrderStatus(status){
	
		if(entriesToReview.length == 0){
			document.getElementById('errorWhileReview').style.display = "block";
			document.getElementById('notificationMessage').innerHTML = "Please select at least 1 entry to Approve to Reject";
			document.getElementById('buttonCloseReviewModal').onclick = function (){
				document.getElementById('errorWhileReview').style.display = "none";
			}
			return;
		}
		document.getElementById('reviewOrderEntryModal').style.display = "block";
		document.getElementById('textConfirmReview').innerHTML = "Are you sure you want to " + status + " the selected Sales Order Entries ?";
		document.getElementById('buttonConfirmReview').onclick = function (){
			
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						window.location = "landing_sales_order_approval";
						NProgress.done();
					}
				};

				request.open ("POST", "landing_sales_order_approval/" + status, true);
				request.setRequestHeader("Accept", "text/html");
				request.send(JSON.stringify(payload));
		}
}

function closeOrderReviewModal(){
	document.getElementById('reviewOrderEntryModal').style.display = 'none';
}

</script>
			
<div id="reviewOrderEntryModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Confirm Action</h3>
    </div>
    <div class="modal-body" >
		<span id = "textConfirmReview" onclick = "closeOrderReviewModal()"></span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmReview" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancelReview" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeOrderReviewModal()">Cancel</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>

<div id="errorWhileReview" class="modal-outer-body">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Notification</h3>
    </div>
    <div class="modal-body">
		<span id = "notificationMessage">Error. Please contact system admin.</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonCloseReviewModal" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">OK</button></td>
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
			"pageLength": 50,
			"order": [
                      [2, 'desc'],[0, 'desc']      
		]});
    });
</script>