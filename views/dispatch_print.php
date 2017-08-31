<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Dispatch</title>
	
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/preview-style.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/preview-print.css' media="print" />
	<script src="<?php echo base_url();?>assets/vendors/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/html5-form-validation/dist/jquery.validation.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/nprogress/nprogress.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/float-modal.css">
</head>
<body>

	<div id="page-wrap">
	<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch/view/<?php echo $id ?>">
		<button id="buttonBack" class = "no-print">Back</button>
	</a>
	<button id = "buttonPrintPage" class = "no-print" onClick="window.print();">Print</button>
	<div class="form-group no-print" style = "margin:20px;">
		<label for="route">Route</label>
		<select class="form-control" id="route" name="Route" onchange = "refreshDispatchTable(this)">
			<?php
			foreach($routes as $route)
			{
				?>
				<option value="<?=$route['RouteID']?>"><?=$route['RouteName']?></option>
				<?php
			}
			?>	
		</select> 
	</div>
	<textarea id="header" readonly style = "height:50px"></textarea>
	<textarea readonly>Dispatch : <?php echo "DISP".$id ?></textarea>
	<span style="float:right" readonly>Date : <?php echo $dispatch_details['DispatchTime'] ?></span>
<div id="identity">	
            <table class="table table-hover nowrap" id="displayDispatchsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
					<th>Customer</th>
					<th>Broker</th>
					<th>Payment</th>
                    <th>Product Name</th>
                    <th>Qty</th>
					<th>Rate</th>
					<th>Bill No</th>
					<th>Amount</th>
					<th>Remarks</th>
                </tr>
                </thead>
                <tbody id = 'displayDispatchsTableBody'>
				<?php
				$i = 1;
				foreach ($dispatchs as $dispatch): ?>
				<tr class = "route" data-user = "<?php echo $dispatch['RouteId'] ?>">
				    <td><center><?php echo $i; ?></center></td>
					<td><center><?php echo $dispatch['CustomerName']; ?></center></td>
					<td><center><?php echo $dispatch['BrokerName']; ?></center></td>
					<td><center><?php echo $dispatch['PaymentTerms']; ?></center></td>
                    <td><center><?php echo $dispatch['ProductName']; ?></center></td>
                    <td><center><?php echo $dispatch['DispatchQuantity']; ?></center></td>
					<td><center><?php echo $dispatch['SellingPriceAtOrderTime']; ?></center></td>
					<td><center></center></td>
					<td><center><?php echo number_format($dispatch['SellingPriceAtOrderTime'] * $dispatch['DispatchQuantity']); ?></center></td>
					<td><center></center></td>
				</tr>
				<?php 
				$i++;
				endforeach; ?>
                </tbody>
            </table>
</div>
<script>
	function refreshDispatchTable(element){
		var selectedRouteId = element.options[element.selectedIndex].value;
		var selectedRouteName = element.options[element.selectedIndex].text;
		
		document.getElementById('header').value = selectedRouteName;
		
		$('tr.route').each(function(){
				if ($(this).attr('data-user') != selectedRouteId){
					$(this).hide();
				} else {
					$(this).show();
				}
		});
	}

	refreshDispatchTable(document.getElementById('route'));
</script>
</body>
</html>

