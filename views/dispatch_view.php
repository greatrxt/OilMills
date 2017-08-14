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
                </div>
                Dispatch Details : <?php echo $title ?>
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayDispatchsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
					<th>Route Name</th>
					<th>Customer</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Sr No</th>
					<th>Route Name</th>
					<th>Customer</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </tfoot>
                <tbody id = 'displayDispatchsTableBody'>
				<?php
				$i = 1;
				foreach ($dispatchs as $dispatch): ?>
				<tr <?php if(((int)$dispatch['RouteId'])%2 == 0) { echo 'style = "background-color:#eff0f1"'; } else { echo 'style = "background-color:#ffffff"'; }?> >
				    <td><?php echo $i; ?></td>
					<td><?php echo $dispatch['RouteName']. '  ( RT'.$dispatch['RouteId'].' )'; ?></td>
					<td><?php echo $dispatch['CustomerName']; ?></td>
                    <td><?php echo $dispatch['ProductName']; ?></td>
                    <td><?php echo $dispatch['OrderQuantity']; ?></td>
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
