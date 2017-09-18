<script>
function limitWithin(element, checkForBlank){
	
	if(element.value.trim() == "" && checkForBlank){
		element.value = 0;
	} else {
		if(element.value < 0){
			element.value = 0;
		} else if (element.value > 99999){
			element.value = 99999;
		}
	}
}
</script>
<section class = "page-content">
<?php echo validation_errors(); ?>
<?php $attributes = array('name' => 'form-validation'); echo form_open('ParmarOilMills/web/Live_rates/update_rates', $attributes); ?>
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
                    <a href="#">
						<button type="submit" class="btn btn-primary">
							Update Rates
						</button>
					</a>
                </div>
                Live Rates
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" width="100%" id = 'displayProductsTable'>
                <thead class="thead-default">
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Product Category</th>
                    <th>Selling Price</th>
                    <th>Status</th>
                    <th>Last Updated By</th>
                    <th>Last Price Update Time</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Product Category</th>
                    <th>Selling Price</th>
                    <th>Status</th>
					<th>Last Updated By</th>
                    <th>Last Price Update Time</th>
                </tr>
                </tfoot>
                <tbody >
				<?php foreach ($products as $product): ?>
				<tr>
				    <td>PRO<?php echo $product['ProductId']; ?></td>

                    
                    <td>
					<!--<?php echo base_url()."/uploads/product/".$product['ProductId'] ?> -->
					<img style = 'height:50px;' 
						src = "<?php 
							
							$defaultImageURL = base_url()."assets/common/img/temp/ecommerce/ecommerce-empty.jpg";
							$imageUrlJpg = base_url().$product['ProductImage'];
							if(@getimagesize($imageUrlJpg)){
								echo $imageUrlJpg;
							} else {
								echo $defaultImageURL;
							}
	
							
						?>">
					</td>
                    <td><?php echo $product['Name']; ?></td>
                    <td><?php echo $product['ProductCategory']; ?></td>
					<td>₹ <input name = "<?php echo $product['ProductId']; ?>" type = "number" class="form-control width-100" value = "<?php echo $product['SellingPrice']; ?>" min="0" step="0.01"
						onblur = "limitWithin(this, true)" oninput = "limitWithin(this, false)"/></td>
                    <td><?php echo $product['Status']; ?></td>
					<td><?php echo $product['PriceLastUpdatedBy']; ?></td>
                    <td><?php echo $product['LastPriceUpdateTime']; ?></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
</form>
<!-- Page Scripts -->
			
<div id="deleteProductModal" class="modal-outer-body">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Delete Product ?</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Are you sure you want to delete this product ?</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
			<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteProductModal()">Cancel</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>


<!-- Page Scripts -->
<script>
    $(function () {
		$('#displayProductsTable').DataTable({
			"pageLength": 100
		});
    });
</script>


<!-- End Page Scripts -->


</section>