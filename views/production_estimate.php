<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
				<a href="#">
					<button type="button" class="btn btn-primary" onclick = "showConfirmProductionDialog()">
                        Confirm Production
                    </button>
				</a>
				<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order">
					<button type="button" class="btn btn-primary">
                        Cancel
                    </button>
				</a>
                </div>
                Production Estimate
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" id="displayProductionsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Sr No</th>
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

<!-- Page Scripts -->
			
<div id="yesNoModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Confirm Production ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmText">Are you sure you want to confirm this production ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirm" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeProductionModal()">Cancel</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>


<script>
	function showConfirmProductionDialog() {
		document.getElementById('yesNoModal').style.display = "block";
		document.getElementById('buttonConfirm').onclick = function (){
			window.location = "<?php 
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
			?>";
		}
	}

	function closeProductionModal(){
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
		$('#displayProductionsTable').DataTable();
    });
</script>
