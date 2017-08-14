<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                Dispatch Summary
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayDispatchsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Dispatch ID</th>
                    <th>Date</th>
                    <th>Number Of Products</th>
					<th>Number Of Units</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Dispatch ID</th>
                    <th>Date</th>
                    <th>Number Of Products</th>
					<th>Number Of Units</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayDispatchsTableBody'>
				<?php
				$i = 1;
				foreach ($dispatchs as $dispatch): ?>
				<tr>
                    <td>DISP<?php echo $dispatch['DispatchId']; ?></td>
                    <td><?php echo $dispatch['DispatchTime']; ?></td>
					<td><?php echo $dispatch['ProductCount']; ?></td>
					<td><?php echo $dispatch['Quantity']; ?></td>
					<td><a href = "<?php echo 'dispatch/view/'.$dispatch['DispatchId']; ?>">View</a></td>
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
