<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="customer/create">
					<button type="button" class="btn btn-primary">
                        Add Customer
                    </button>
				</a>
                </div>
                Customer Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayCustomersTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Contact Number</th>
					<th>Route</th>
					<th>Username</th>
					<th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Area</th>
					<th>City</th>					
                    <th>Contact Number</th>
					<th>Route</th>
					<th>Username</th>
					<th>Actions</th>
                </tr>
                </tfoot>
                <tbody id = 'displayCustomersTableBody'>
				<?php foreach ($customer as $customers): ?>
				<tr>
				    <td>CUST<?php echo $customers['CustomerID']; ?></td>
                    <td><?php echo $customers['NAME']; ?></td>
                    <td><?php echo $customers['AREA']; ?></td>
                    <td><?php echo $customers['City']; ?></td>
                    <td><?php echo $customers['ContactNumber']; ?></td>
                    <td><?php echo $customers['routename']; ?></td>
					<td><?php echo $customers['Username']; ?></td>
					<td><a href='customer/view/<?php echo $customers['CustomerID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteCustomerDialog(<?php echo $customers['CustomerID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</section>

<!-- Page Scripts -->
<script>
    $(function () {
		$('#displayCustomersTable').DataTable();
    });
</script>