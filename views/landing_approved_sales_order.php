<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
				<div class="dropdown pull-right">

					<button type="button" id = "btnSendForProduction" class="btn btn-primary"  onclick = "sendFor('production');">
						Send for Production
					</button>

					<button type="button" id = "btnSendForDispatch" class="btn btn-primary"  onclick = "sendFor('dispatch');">
						Send for Dispatch
					</button>
					<button type="button" id = "btnClose" class="btn btn-primary"  onclick = "sendFor('close');">
						Close
					</button>				
                </div>
                Approved Sales Orders
            </h2>
        </div>
		<script>
		function toggleButtonVisibility(visible){
			if(visible){
				document.getElementById('btnSendForDispatch').style.display = 'inline-block';
				document.getElementById('btnSendForProduction').style.display = 'inline-block';
				document.getElementById('btnClose').style.display = 'inline-block';
			} else {
				document.getElementById('btnSendForDispatch').style.display = 'none';
				document.getElementById('btnSendForProduction').style.display = 'none';
				document.getElementById('btnClose').style.display = 'none';
			}
		}
		</script>

        <div class="panel-body">
			<div class="nav-tabs-horizontal" id = "homeTabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" onclick = "toggleButtonVisibility(true)">
						<a id = "0" class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Pending Dispatch</a>
					</li>
					<li class="nav-item" onclick = "toggleButtonVisibility(false);">
						<a id = "1" class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab2" role="tab" aria-expanded="true">Dispatched</a>
					</li>
				</ul>
				<div class="tab-content padding-vertical-20">
				<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
					<div class="panel-body">
						<table class="table table-hover nowrap" id="displayPendingDispatchTable" width="100%">
							<thead class="thead-default">
							<tr>
								<th>Order ID</th>
								<th>Date</th>				
								<th>Customer</th>				
								<th>Payment</th>
								<th>Product</th>
								<th>Order Qty</th>
								<th>Rate</th>
								<th>Ordered By</th>
								<th>Approved By</th>
								<th><input type = "checkbox" style = "margin-right:5px" onchange = "toggleProductionSelection(this)">Production</th>
								<th>Production Date</th>
								<th>Status</th>
								<th>Balance Qty</th>
								<th><input type = "checkbox" style = "margin-right:5px" onchange = "toggleDispatchSelection(this)">Dispatch</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>Order ID</th>
								<th>Date</th>				
								<th>Customer</th>				
								<th>Payment</th>
								<th>Product</th>
								<th>Order Qty</th>
								<th>Rate</th>
								<th>Ordered By</th>
								<th>Approved By</th>
								<th>Production</th>
								<th>Production Date</th>
								<th>Status</th>
								<th>Balance Qty</th>
								<th>Dispatch</th>
							</tr>
							</tfoot>
							<tbody>
							<?php 
							$count = 0;
							$orderId = 0;
							foreach ($pending_dispatch_order_entries as $order_entry): ?>
							<tr <?php 
							if(((int)$order_entry['OrderId'])!= $orderId){
								$count++;
								$orderId = ((int)$order_entry['OrderId']);
							}
							
							if($count%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
								<td>OD<?php echo $order_entry['OrderId']; ?></td>
								<td><?php echo $order_entry['OrderTime']; ?></td>
								<td><?php echo $order_entry['CustomerName']; ?></td>
								<td><?php echo $order_entry['PaymentTerms']; ?></td>
								<td><?php echo $order_entry['ProductName']; ?></td>
								<td><?php echo $order_entry['OrderQuantity']; ?></td>
								<td><?php echo $order_entry['SellingPriceAtOrderTime']; ?></td>
								<td><?php echo $order_entry['OrderBy']; ?></td>
								<td><?php echo $order_entry['ApprovedBy']; ?></td>
								<td><input class = "productionItem" type = "checkbox" <?php if($order_entry['ProductionId'] !=null) echo "checked disabled"?> <?php if($order_entry['DispatchID'] !=null) echo "disabled"?> onchange = "addForProduction(this, <?php echo $order_entry['OrderEntryId']; ?>)" >
								<?php if($order_entry['ProductionId'] !=null) echo "<a href = "."production/view/".$order_entry['ProductionId'].">  PROD".$order_entry['ProductionId']."</a>";?>
								</td>
								<td><?php echo $order_entry['ProductionTime']; ?></td>
								<td><?php echo ucwords(strtolower(str_replace("_", " ", $order_entry['Status']))); ?></td>
								<td><?php echo $order_entry['Balance']; ?></td>
								<td><input class = "dispatchItem" type = "checkbox" onchange = "addForDispatch(this, <?php echo $order_entry['OrderEntryId']; ?>)">
								</td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="tab-pane" id="tab2" role="tabpanel" aria-expanded="false">
						<div class="panel-body">
						<table class="table table-hover nowrap" id="displayDispatchedTable" width="100%">
							<thead class="thead-default">
							<tr>
								<th>Order ID</th>
								<th>Date</th>				
								<th>Customer Name</th>				
								<th>Payment</th>
								<th>Product Name</th>
								<th>Order Qty</th>
								<th>Rate</th>
								<th>Ordered By</th>
								<th>Approved By</th>
								<th>Production</th>
								<th>Production Date</th>
								<th>Dispatch</th>
								<th>Dispatch Quantity</th>
								<th>Dispatch Date</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>Order ID</th>
								<th>Date</th>				
								<th>Customer Name</th>				
								<th>Payment</th>
								<th>Product Name</th>
								<th>Order Qty</th>
								<th>Rate</th>
								<th>Ordered By</th>
								<th>Approved By</th>
								<th>Production</th>
								<th>Production Date</th>
								<th>Dispatch</th>
								<th>Dispatch Quantity</th>
								<th>Dispatch Date</th>
							</tr>
							</tfoot>
							<tbody>
							<?php
							$count = 0;
							$orderId = 0;
							foreach ($dispatched_order_entries as $order_entry): ?>
							<tr <?php 
								if(((int)$order_entry['OrderId'])!= $orderId){
															$count++;
															$orderId = ((int)$order_entry['OrderId']);
														}
														
								if($count%2 == 0){ echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
								<td>OD<?php echo $order_entry['OrderId']; ?></td>
								<td><?php echo $order_entry['OrderTime']; ?></td>
								<td><?php echo $order_entry['CustomerName']; ?></td>
								<td><?php echo $order_entry['PaymentTerms']; ?></td>
								<td><?php echo $order_entry['ProductName']; ?></td>
								<td><?php echo $order_entry['OrderQuantity']; ?></td>
								<td><?php echo $order_entry['SellingPriceAtOrderTime']; ?></td>
								<td><?php echo $order_entry['OrderBy']; ?></td>
								<td><?php echo $order_entry['ApprovedBy']; ?></td>
								<td><input type = "checkbox" disabled <?php if($order_entry['ProductionId'] !=null) echo "checked"?> >
								<?php if($order_entry['ProductionId'] !=null) echo "<a href = "."production/view/".$order_entry['ProductionId'].">  PROD".$order_entry['ProductionId']."</a>";?>
								</td>
								<td><?php echo $order_entry['ProductionTime']; ?></td>
								<td><input type = "checkbox" disabled <?php if($order_entry['DispatchID'] !=null) echo "checked";?>>
								<?php if($order_entry['DispatchID'] !=null) echo "<a href = "."dispatch/view/".$order_entry['DispatchID'].">  DISP".$order_entry['DispatchID']."</a>";?> <span style = "color:#d9534f"><?php if($order_entry['Status'] == 'CLOSED') echo 'CLOSED'; ?></span>
								</td>
								<td><?php echo $order_entry['DispatchQuantity']; ?></td>
								<td><?php echo $order_entry['DispatchTime']; ?></td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</div>
		</div>
	</section>
</div>
</section>

<script>

function toggleProductionSelection(element){
	var productionCheckboxes =  document.getElementsByClassName('productionItem');
	for(var c = 0; c < productionCheckboxes.length; c++){
		if(!productionCheckboxes[c].disabled){
			productionCheckboxes[c].checked = element.checked;
			productionCheckboxes[c].onchange();
		}
	}
}

function toggleDispatchSelection(element){
	var dispatchCheckboxes =  document.getElementsByClassName('dispatchItem');
	for(var c = 0; c < dispatchCheckboxes.length; c++){
		if(!dispatchCheckboxes[c].disabled){
			dispatchCheckboxes[c].checked = element.checked;
			dispatchCheckboxes[c].onchange();
		}
	}
}
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
	var entries = null;
	if(status == 'production'){
		entries = entriesProduction;
	} else if (status == 'dispatch' || status == 'close'){
		entries = entriesDispatch;
	} else {
		return;
	}
	
	if(entries.length == 0){
		document.getElementById('error').style.display = "block";
		if(status == 'close'){
			document.getElementById('notification').innerHTML = "Please select at least 1 entry to " + status;
		} else {
			document.getElementById('notification').innerHTML = "Please select at least 1 entry for " + status;
		}
		document.getElementById('buttonClose').onclick = function (){
			document.getElementById('error').style.display = "none";
		}
		return;
	}
	
	document.getElementById('reviewOrderEntryModal').style.display = "block";
	if(status == 'close'){
		document.getElementById('textConfirmReview').innerHTML = "Are you sure you want to close the selected Sales Order Entries ?";
	} else {
		document.getElementById('textConfirmReview').innerHTML = "Are you sure you want to send the selected Sales Order Entries for " + status +" ?";
	}
	var parameters = "";
	
	for(var i = 0; i < entries.length; i++){
		parameters+="entryId[]="+entries[i];
		if(i != entries.length -1){
			parameters+="&";
		}
	}
	document.getElementById('buttonConfirmReview').onclick = function (){
		if(status == 'close'){
			window.location = 'landing_approved_sales_order/close?' + parameters;
		} else {
			window.location = status + '/estimate?' + parameters;
		}
	}
}

function closeOrderReviewModal(){
	document.getElementById('reviewOrderEntryModal').style.display = 'none';
}

function closeErrorModal(){
	document.getElementById('error').style.display = 'none';
}

</script>
			
<div id="reviewOrderEntryModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick = "closeOrderReviewModal(); return false">&times;</span>
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
      <span class="close" onclick = "closeErrorModal(); return false;">&times;</span>
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
    $(function () {
		$('#displayDispatchedTable').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"pageLength": 100,
			"order": [
                      /*[2, 'desc'],*/[13, 'desc']      
		]});
    });
	
	$(function () {
		$('#displayPendingDispatchTable').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"pageLength": 100,
			"order": [
                     [1, 'asc']      
		]});
    });
</script>