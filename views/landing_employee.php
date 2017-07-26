<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="employee/create">
					<button type="button" class="btn btn-primary">
                        Add Employee
                    </button>
				</a>
                </div>
                Employee Master
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayEmployeesTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
					<th>Designation</th>					
                    <th>City</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
					<th>Designation</th>					
                    <th>City</th>
					<th>Date Created</th>
					<th>Action</th>
                </tr>
                </tfoot>
                <tbody id = 'displayEmployeesTableBody'>
				<?php foreach ($employee as $employees): ?>
				<tr>
				    <td>EMP<?php echo $employees['EmployeeID']; ?></td>
                    <td><?php echo $employees['NAME']; ?></td>
                    <td><?php echo $employees['department']; ?></td>
                    <td><?php echo $employees['designation']; ?></td>
                    <td><?php echo $employees['City']; ?></td>
                    <td><?php echo $employees['RecordCreationTime']; ?></td>
					<td><a href='employee/view/<?php echo $employees['EmployeeID']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteEmployeeDialog(<?php echo $employees['EmployeeID']; ?>)' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
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
		$('#displayEmployeesTable').DataTable();
    });
</script>