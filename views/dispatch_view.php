<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch">
					<button type="button" class="btn btn-primary">
                        Go to Dispatch Summary
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order">
					<button type="button" class="btn btn-primary">
                        Go to Approved Orders
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch/view_print/<?php echo $id ?>">
					<button type="button" class="btn btn-primary">
                        Print Preview
                    </button>
				</a>
                </div>
                Dispatch Details : DISP<?php echo $id ?>
            </h2>
			<div class="form-group">
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
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayDispatchsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
					<th>Customer</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
					<th>Route Name</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Sr No</th>
					<th>Customer</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
					<th>Route Name</th>
                </tr>
                </tfoot>
                <tbody>
				<?php
				$i = 1;
				foreach ($dispatchs as $dispatch): ?>
				<tr data-user = "<?php echo $dispatch['RouteId'] ?>" class = "route route_<?php echo $dispatch['RouteId'] ?>" <?php if(((int)$dispatch['RouteId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
				    <td><?php echo $i; ?></td>
					<td><?php echo $dispatch['CustomerName']; ?></td>
                    <td><?php echo $dispatch['ProductName']; ?></td>
                    <td><?php echo $dispatch['OrderQuantity']; ?></td>
					<td><?php echo $dispatch['RouteName']. '  ( RT'.$dispatch['RouteId'].' )'; ?></td>
				</tr>
				<?php 
				$i++;
				endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</section>
<script>
	var dispatchTable = null;
    $(function () {
		dispatchTable = $('#displayDispatchsTable').DataTable({
			"pageLength": 10,
			"order": [
                      /*[2, 'desc'],*/[1, 'desc']      
		]});
    });
	
	function hasClass(element, cls) {
		return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
	}
	
	/*function refreshDispatchTable(element){
		var selectedRouteId = element.options[element.selectedIndex].value;
		var rows = document.getElementsByClassName('route');
		for (i = 0; i < rows.length; i++) {
			var row = rows[i];
			if(hasClass(row, 'route_' + selectedRouteId)){
				row.style.display = "block";
			} else {
				row.style.display = "none";
			}
		}
	}*/
	function refreshDispatchTable(element){
		var selectedRouteId = element.options[element.selectedIndex].value;
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
