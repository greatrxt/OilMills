<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
				<div class="dropdown pull-right">

					<button type="button" class="btn btn-primary"  onclick = "sendFor('production');">
						Send for Production
					</button>

					<button type="button" class="btn btn-primary"  onclick = "sendFor('dispatch');">
						Send for Dispatch
					</button>
				
                </div>
                Approved Sales Orders
            </h2>
        </div>

        <div class="panel-body">
			<div class="nav-tabs-horizontal" id = "homeTabs">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a id = "0" class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Pending Dispatch</a>
					</li>
					<li class="nav-item">
						<a id = "1" class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tab2" role="tab" aria-expanded="true">Dispatched</a>
					</li>
				</ul>
				<div class="tab-content padding-vertical-20">
				<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
					<div class="panel-body">
						<table class="table table-hover nowrap" id="displayPendingDispatchTable" width="100%">
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
							<tbody>
							<?php foreach ($order_entries as $order_entry): ?>
							<?php if($order_entry['DispatchID'] !=null)
								continue;
							?>
							<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
								<td>ODE<?php echo $order_entry['OrderEntryId']; ?></td>
								<td>OD<?php echo $order_entry['OrderId']; ?></td>
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
								<?php if($order_entry['DispatchID'] !=null) echo "<a href = "."dispatch/view/".$order_entry['DispatchID'].">  DISP".$order_entry['DispatchID']."</a>";?>
								</td>
								<td><?php echo $order_entry['DispatchTime']; ?></td>
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
							<tbody>
							<?php foreach ($order_entries as $order_entry): ?>
							<?php if($order_entry['DispatchID'] == null)
								continue;
							?>
							<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
								<td>ODE<?php echo $order_entry['OrderEntryId']; ?></td>
								<td>OD<?php echo $order_entry['OrderId']; ?></td>
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
								<?php if($order_entry['DispatchID'] !=null) echo "<a href = "."dispatch/view/".$order_entry['DispatchID'].">  DISP".$order_entry['DispatchID']."</a>";?>
								</td>
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
<!--
<section class = "page-content">
<div class="page-content-inner">
    <section class="panel panel-with-borders">
		<div class="panel-heading">
            <h2>
                Approved Sales Orders
            </h2>
        </div>
	</section>

    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>
			    <div class="dropdown pull-right">

					<button type="button" class="btn btn-primary"  onclick = "sendFor('production');">
						Send for Production
					</button>

					<button type="button" class="btn btn-primary"  onclick = "sendFor('dispatch');">
						Send for Dispatch
					</button>
				
                </div>
                Pending Dispatch
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayPendingDispatchTable" width="100%">
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
                <tbody>
				<?php foreach ($order_entries as $order_entry): ?>
				<?php if($order_entry['DispatchID'] !=null)
					continue;
				?>
				<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
					<td>ODE<?php echo $order_entry['OrderEntryId']; ?></td>
					<td>OD<?php echo $order_entry['OrderId']; ?></td>
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
					<?php if($order_entry['DispatchID'] !=null) echo "<a href = "."dispatch/view/".$order_entry['DispatchID'].">  DISP".$order_entry['DispatchID']."</a>";?>
					</td>
					<td><?php echo $order_entry['DispatchTime']; ?></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    

	
	    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>
                Dispatched
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayDispatchedTable" width="100%">
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
                <tbody>
				<?php foreach ($order_entries as $order_entry): ?>
				<?php if($order_entry['DispatchID'] == null)
					continue;
				?>
				<tr <?php if(((int)$order_entry['OrderId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
					<td>ODE<?php echo $order_entry['OrderEntryId']; ?></td>
					<td>OD<?php echo $order_entry['OrderId']; ?></td>
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
					<?php if($order_entry['DispatchID'] !=null) echo "<a href = "."dispatch/view/".$order_entry['DispatchID'].">  DISP".$order_entry['DispatchID']."</a>";?>
					</td>
					<td><?php echo $order_entry['DispatchTime']; ?></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
	
	
	

</div>
</section>-->
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
	var entries = null;
	if(status == 'production'){
		entries = entriesProduction;
	} else if (status == 'dispatch'){
		entries = entriesDispatch;
	} else {
		return;
	}
	
	if(entries.length == 0){
		document.getElementById('error').style.display = "block";
		document.getElementById('notification').innerHTML = "Please select at least 1 entry for " + status;
		document.getElementById('buttonClose').onclick = function (){
			document.getElementById('error').style.display = "none";
		}
		return;
	}
	
	document.getElementById('reviewOrderEntryModal').style.display = "block";
	document.getElementById('textConfirmReview').innerHTML = "Are you sure you want to send the selected Sales Order Entries for " + status +" ?";
	var parameters = "";
	
	for(var i = 0; i < entries.length; i++){
		parameters+="entryId[]="+entries[i];
		if(i != entries.length -1){
			parameters+="&";
		}
	}
	document.getElementById('buttonConfirmReview').onclick = function (){
		window.location = status + '/estimate?' + parameters;
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
    $(function () {
		$('#displayDispatchedTable').DataTable({
			"pageLength": 10,
			"order": [
                      [2, 'desc'],[0, 'desc']      
		]});
    });
	
	$(function () {
		$('#displayPendingDispatchTable').DataTable({
			"pageLength": 10,
			"order": [
                    //  [2, 'desc'],[0, 'desc']      
		]});
    });
</script>