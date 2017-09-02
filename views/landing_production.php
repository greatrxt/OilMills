<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                Production Summary
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayProductionsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Production ID</th>
                    <th>Date</th>
                    <th>Number Of Products</th>
					<th>Number Of Units</th>
					<th>Sent For Production By</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Production ID</th>
                    <th>Date</th>
                    <th>Number Of Products</th>
					<th>Number Of Units</th>
					<th>Sent For Production By</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayProductionsTableBody'>
				<?php
				$i = 1;
				foreach ($productions as $production): ?>
				<tr>
                    <td>PROD<?php echo $production['ProductionId']; ?></td>
                    <td><?php echo $production['ProductionTime']; ?></td>
					<td><?php echo $production['ProductCount']; ?></td>
					<td><?php echo $production['Quantity']; ?></td>
					<td><?php echo $production['Username']; ?></td>
					<td><a href = "<?php echo 'production/view/'.$production['ProductionId']; ?>"><i class='icmn-pencil5'></i> View</a></td>
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
                      /*[2, 'desc'],*/[1, 'desc']      
		]});
    });

</script>