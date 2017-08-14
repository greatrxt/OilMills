    <!--<section class = "page-content">
<div class="page-content-inner">


    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="#">
					<button type="button" class="btn btn-primary" onclick = "showConfirmDispatchDialog()">
                        Confirm Dispatch
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order">
					<button type="button" class="btn btn-primary">
                        Cancel
                    </button>
				</a>
                </div>
                Dispatch Estimate
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayDispatchsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Entry ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Entry ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </tfoot>
                <tbody id = 'displayDispatchsTableBody'>
				<?php
				foreach ($dispatchs as $dispatch): ?>
				<tr>
				    <td><?php echo $dispatch['OrderEntryId']; ?></td>
                    <td><?php echo $dispatch['Name']; ?></td>
                    <td><input type="text" class="form-control width-50" value="<?php echo $dispatch['OrderQuantity']; ?>" /></td>
				</tr>
				<?php 
				endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
</section>-->

					
<script>

function updateRoute(element, name){
	var routeFields = document.getElementsByClassName(name);
	for(var i = 0; i < routeFields.length; i++){
		routeFields[i].innerHTML = element.options[element.selectedIndex].text;
	}
}
/**
	Always limit first, then calculateDispatch
*/
function limitWithin(element, min, max){
	
	if(element.value.trim() == ""){
		element.value = max;
	} else {
		if(element.value < min){
			element.value = min;
		} else if (element.value > max){
			element.value = max;
		}
	}
}

/**
	Always limit first, then calculateDispatch
*/
function calculateDispatch(name){
	
	var fields = document.getElementsByClassName(name);
	var totalField = document.getElementById(name);
	var total = 0;
	for(var i = 0; i < fields.length; i++){
		total+=parseInt(fields[i].value);
	}
	if(totalField!=null){
		totalField.innerHTML = total;
	} else {
		alert('Cannot find field : ' + name);
	}
}

var customDispatchQuantity = new Object();
function addToCustomDispatch(orderEntryId, orderQuantity, element){
	if(element.value!=orderQuantity){
		customDispatchQuantity[orderEntryId] = element.value;
	} else {
		delete customDispatchQuantity[orderEntryId];
	}
}

var customRoute = new Object();
function addToCustomRoute(customerId, defaultRoute, element){
	var newRoute = element.options[element.selectedIndex].value;
	if(newRoute!=defaultRoute){
		customRoute[customerId] = newRoute;
	} else {
		delete customRoute[customerId];
	}
}
</script>
<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Cart / Checkout -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                Dispatch
            </h2>
        </div>
        <div class="panel-body">
            <div class="cui-ecommerce--cart">
                <div id="cart-checkout" class="cui-wizard">
                    <h3>
                        <i class="icmn-cart5 cui-wizard--steps--icon"></i>
                        <span class="cui-wizard--steps--title">Product Info</span>
                    </h3>
					
                    <section>

                        <div class="invoice-block">
							<table class="table table-hover nowrap" width="100%">
								<thead class="thead-default">
								<tr>
									<th>Entry ID</th>
									<th>Order ID</th>
									<th>Date</th>				
									<th>Customer Name</th>				
									<th>Payment</th>
									<th>Product Name</th>
									<th>Order Qty</th>
									<th>Dispatch Qty</th>
									<th>Rate</th>
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
									<th>Dispatch Qty</th>
									<th>Rate</th>
								</tr>
								</tfoot>
								<tbody id = 'displayDispatchsTableBody'>
								<?php
								foreach ($dispatchs as $dispatch): ?>
								<tr>
									<td>ODE<?php echo $dispatch['OrderEntryId']; ?></td>
									<td><?php echo $dispatch['OrderId']; ?></td>
									<td><?php echo $dispatch['OrderTime']; ?></td>
									<td><?php echo $dispatch['CustomerName']; ?></td>
									<td><?php echo $dispatch['PaymentTerms']; ?></td>
									<td><?php echo $dispatch['ProductName']; ?></td>
									<td><?php echo $dispatch['OrderQuantity']; ?></td>
									
									<td>									
										<input type="number" class="form-control width-100 customer_<?php echo $dispatch['CustomerId']; ?> customer_<?php echo $dispatch['CustomerId']?>_product_<?php echo $dispatch['ProductId']; ?>"
										oninput = "limitWithin(this, 1, <?php echo $dispatch['OrderQuantity']; ?>);	
													calculateDispatch('customer_<?php echo $dispatch['CustomerId']; ?>');
													calculateDispatch('customer_<?php echo $dispatch['CustomerId']?>_product_<?php echo $dispatch['ProductId']; ?>');
													addToCustomDispatch('<?php echo $dispatch['OrderEntryId']?>', '<?php echo $dispatch['OrderQuantity']; ?>', this);"
											value="<?php echo $dispatch['OrderQuantity']; ?>" 
											min="1" max="<?php echo $dispatch['OrderQuantity']; ?>"/>									
									</td>
									
									<td><?php echo $dispatch['SellingPriceAtOrderTime']; ?></td>
								</tr>
								<?php 
								endforeach; ?>
								</tbody>
							</table>
                        </div>
                    </section>

                    
					<h3>
                        <i class="icmn-road cui-wizard--steps--icon"></i>
                        <span class="cui-wizard--steps--title">Route Info</span>
                    </h3>
                    <section>
                        <div class="invoice-block">
							<table class="table table-hover nowrap" width="100%">
								<thead class="thead-default">
								<tr>
									<th>Customer</th>
									<th>Product Count</th>
									<th>Total Order Quantity</th>
									<th>Total Dispatch Quantity</th>
									<th>Route</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>Customer</th>
									<th>Product Count</th>
									<th>Total Order Quantity</th>
									<th>Total Dispatch Quantity</th>
									<th>Route</th>
								</tr>
								</tfoot>
								<tbody id = 'displayDispatchsTableBody'>
								<?php
								foreach ($customers as $customer): ?>
								<tr>
									<td><?php echo $customer['CustomerName']; ?></td>
									<td><?php echo $customer['ProductCount']; ?></td>
									<td><?php echo $customer['OrderQuantity']; ?></td>
									<td><span id = "customer_<?php echo $customer['CustomerId']; ?>"><?php echo $customer['OrderQuantity']; ?></span></td>
									<td>
									<select class="form-control" id="route" name="Route" onchange = "updateRoute(this, 'route_<?php echo $customer['CustomerId']?>');
																									addToCustomRoute(<?php echo $customer['CustomerId']; ?>, <?php echo $customer['RouteId']; ?>, this);" >
									<?php
									foreach($routes as $route)
									{
										?>
										<option	<?php if($customer['RouteId'] == $route['RouteID']) echo " selected "?> value="<?=$route['RouteID']?>"><?=$route['RouteName']?></option>
										<?php
									}
									?>	
									</select>
									</td>
								</tr>
								<?php 
								endforeach; ?>
								</tbody>
							</table>
                        </div>
                    </section>

                    <h3>
                        <i class="icmn-checkmark cui-wizard--steps--icon"></i>
                        <span class="cui-wizard--steps--title">Confirmation</span>
                    </h3>
                    <section>

                        <div class="invoice-block">
							<table class="table table-hover nowrap" width="100%">
								<thead class="thead-default">
								<tr>			
									<th>Customer Name</th>				
									<th>Product Name</th>
									<th>Order Qty</th>
									<th>Dispatch Qty</th>
									<th>Default Route</th>
									<th>Allocated Route</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>Customer Name</th>				
									<th>Product Name</th>
									<th>Order Qty</th>
									<th>Dispatch Qty</th>
									<th>Default Route</th>
									<th>Allocated Route</th>
								</tr>
								</tfoot>
								<tbody id = 'displayDispatchsTableBody'>
								<?php
								
								foreach ($product_wise_dispatch as $dispatch):?>
								<tr>
									<td><?php echo $dispatch['CustomerName']; ?></td>
									<td><?php echo $dispatch['Name']; ?></td>
									<td><?php echo $dispatch['OrderQuantity']; ?></td>
									<td><span id = "customer_<?php echo $dispatch['CustomerId']?>_product_<?php echo $dispatch['ProductId']; ?>"><?php echo $dispatch['OrderQuantity']; ?></span></td>
									<td><?php echo $dispatch['RouteName']; ?></td>
									<td><span class = 'route_<?php echo $dispatch['CustomerId']?>'><?php echo $dispatch['RouteName']; ?></td>									
								</tr>
								<?php 
								endforeach; ?>
								</tbody>
							</table>

                        </div>

                    </section>
                </div>
            </div>
        </div>
    </section>
    <!-- End Ecommerce Cart / Checkout -->

</div>
</section>
<!-- Page Scripts -->
<script>
    $(function() {

        $("#cart-checkout").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: 0,
            autoFocus: true,
			onFinished: function (event, currentIndex)
			{
				showConfirmDispatchDialog();
			}
        });

    });
</script>
<!-- End Page Scripts -->
<!-- Page Scripts -->
			
<div id="yesNoModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Confirm Dispatch ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmText">Are you sure you want to confirm this dispatch ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirm" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDispatchModal()">Cancel</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>


<script>
	function showConfirmDispatchDialog() {
		document.getElementById('yesNoModal').style.display = "block";
		document.getElementById('buttonConfirm').onclick = function (){
			var payload = new Object();
			payload.customDispatchQuantity = customDispatchQuantity;
			payload.customRoute = customRoute;				
				
			var request = new XMLHttpRequest();
			request.onreadystatechange = function(){
			NProgress.inc();
			if(request.readyState == 4 && request.status == 200){
					var response = JSON.parse(request.response);
					alert(response);
					NProgress.done();
				}
			}

			request.open ("POST", "<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch/<?php 
				$parameters = 'confirm?';
				$count = 0;
				foreach($entryIds as $entryId){
					$parameters = $parameters.'entryId[]='.$entryId;
					$count++;
					if($count!=sizeof($entryIds)){
						$parameters = $parameters.'&';
					}
				}
				echo $parameters;
			?>", true);
			
			request.setRequestHeader("content-type", "application/json");
			request.send(JSON.stringify(payload));
		}
	}

	function closeDispatchModal(){
		document.getElementById('yesNoModal').style.display = 'none';
	}
	
	// Get the modal
	var modal = document.getElementById('yesNoModal');
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
    $(function () {
		$('#displayDispatchsTable').DataTable();
    });
</script>
