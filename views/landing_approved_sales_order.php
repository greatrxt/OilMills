<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
			    <div class="dropdown pull-right">

					<button type="button" class="btn btn-primary"  onclick = "sendFor('production');">
						Send for Production
					</button>

					<button type="button" class="btn btn-primary"  onclick = "changeSelectedOrderStatus('reject');">
						Send for Dispatch
					</button>
				
                </div>
                Approved Sales Order
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
					<th>Payment</th>
					<th>Product Name</th>
					<th>Order Qty</th>
					<th>Rate</th>
					<th>Ordered By</th>
					<th>Production</th>
					<th>Production Date</th>
					<th>Dispatch</th>
					<th>Dispatch Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
					<th>Entry ID</th>
                    <th>Order ID</th>
                    <th>Date</th>				
					<th>Customer Name</th>				
					<th>Payment</th>
					<th>Product Name</th>
					<th>Order Qty</th>
					<th>Rate</th>
					<th>Ordered By</th>
					<th>Production</th>
					<th>Production Date</th>
					<th>Dispatch</th>
					<th>Dispatch Date</th>
                </tr>
                </tfoot>
                <tbody id = 'displayRoutesTableBody'>
				<?php foreach ($order_entries as $order_entry): ?>
				<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
					<td><?php echo $order_entry['OrderEntryId']; ?></td>
					<td><?php echo $order_entry['OrderId']; ?></td>
                    <td><?php echo $order_entry['OrderTime']; ?></td>
                    <td><?php echo $order_entry['CustomerName']; ?></td>
                    <td><?php echo $order_entry['PaymentTerms']; ?></td>
					<td><?php echo $order_entry['ProductName']; ?></td>
					<td><?php echo $order_entry['OrderQuantity']; ?></td>
					<td><?php echo $order_entry['SellingPriceAtOrderTime']; ?></td>
					<td><?php echo $order_entry['Username']; ?></td>
					<td><input type = "checkbox" <?php if($order_entry['ProductionId'] !=null) echo "checked disabled"?> <?php if($order_entry['DispatchID'] !=null) echo "disabled"?> onchange = "addForProduction(this, <?php echo $order_entry['OrderEntryId']; ?>)" >
					<?php if($order_entry['ProductionId'] !=null) echo "<a href = "."production/view/".$order_entry['ProductionId'].">  PROD".$order_entry['ProductionId']."</a>";?>
					</td>
					<td><?php echo $order_entry['ProductionTime']; ?></td>
					<td><input type = "checkbox" <?php if($order_entry['DispatchID'] !=null) echo "checked disabled"?> onchange = "addForDispatch(this, <?php echo $order_entry['OrderEntryId']; ?>)" >
					<?php if($order_entry['DispatchID'] !=null) echo 'DISP'.$order_entry['DispatchID'];?>
					</td>
					<td></td>
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
var entriesProduction = new Array();
function addForProduction(checkbox, id){
	if(checkbox.checked){
		entriesProduction.push(id);
	} else {
		entriesProduction.splice(entriesProduction.indexOf(id), 1);
	}
}

var entriesDispatch = new Array();
function addForDispatch(checkbox, id){
	if(checkbox.checked){
		entriesDispatch.push(id);
	} else {
		entriesDispatch.splice(entriesDispatch.indexOf(id), 1);
	}
}

function sendFor(status){
	if(entriesProduction.length == 0){
		document.getElementById('error').style.display = "block";
		document.getElementById('notification').innerHTML = "Please select at least 1 entry for " + status;
		document.getElementById('buttonClose').onclick = function (){
			document.getElementById('error').style.display = "none";
		}
		return;
	}
	document.getElementById('reviewOrderEntryModal').style.display = "block";
	document.getElementById('textConfirmReview').innerHTML = "Are you sure you want to " + status + " the selected Sales Order Entries ?";
	var parameters = "";
	if(status == 'production'){
		for(var i = 0; i < entriesProduction.length; i++){
			parameters+="entryId[]="+entriesProduction[i];
			if(i != entriesProduction.length -1){
				parameters+="&";
			}
		}
	}
	document.getElementById('buttonConfirmReview').onclick = function (){
		window.location = status+"/estimate?"+parameters;
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
    <div class="modal-body">
		<span id = "textConfirmReview"></span>	
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

<div id="error" class="modal-outer-body">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Notification</h3>
    </div>
    <div class="modal-body">
		<span id = "notification">Error. Please contact system admin.</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonClose" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">OK</button></td>
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
		$('#displayRoutesTable').DataTable();
    });
</script>