<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/production">
					<button type="button" class="btn btn-primary">
                        Go to Production Summary
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order">
					<button type="button" class="btn btn-primary">
                        Go to Approved Orders
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/production/view_print/<?php echo $id?>">
					<button type="button" class="btn btn-primary">
                        Print
                    </button>
				</a>
                </div>
                Production Details : <?php echo $title ?>
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayProductionsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
					<th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Sr No</th>
					<th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </tfoot>
                <tbody id = 'displayProductionsTableBody'>
				<?php
				$i = 1;
				foreach ($productions as $production): ?>
				<tr>
				    <td><?php echo $i; ?></td>
					<td>OD<?php echo $production['OrderId']; ?></td>
                    <td><?php echo $production['Name']; ?></td>
                    <td><?php echo $production['Quantity']; ?></td>
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
    $(function () {
		$('#displayProductionsTable').DataTable({
			"pageLength": 10,
			"order": [
                      /*[2, 'desc'],*/[0, 'asc']      
		]});
    });

</script>