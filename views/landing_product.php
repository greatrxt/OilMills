<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Products List -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                <div class="dropdown pull-right">
                    <a href="product/create">
						<button type="button" class="btn btn-primary">
							Add Product
						</button>
					</a>
                </div>
                Products List
            </h2>
        </div>
        <div class="panel-body">
            <table class="table table-hover nowrap" width="100%" id = 'displayProductsTable'>
                <thead class="thead-default">
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>ProductCategory</th>
                    <th>SellingPrice</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>ProductCategory</th>
                    <th>SellingPrice</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Action</th>
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
							$imageUrlJpg = $product['ProductImage'];
							//$imageUrlPng = base_url()."/uploads/product/".$product['ProductId'].".png";
							if(@getimagesize($imageUrlJpg)){
								echo $imageUrlJpg;
							//} else if (@getimagesize($imageUrlPng)){
							//	echo $imageUrlPng;
							} else {
								echo $defaultImageURL;
							}
	
							
						?>">
					</td>
                    <td><?php echo $product['Name']; ?></td>
                    <td><?php echo $product['ProductCategory']; ?></td>
					<td><?php echo $product['SellingPrice']; ?></td>
                    <td><?php echo $product['Status']; ?></td>
                    <td><?php echo $product['RecordCreationTime']; ?></td>
					<td><a href='product/view/<?php echo $product['ProductId']; ?>'; class='link-underlined margin-right-5'><i class='icmn-pencil5'></i> View</a>
					<a href='javascript: void(0)' onclick = 'showDeleteProductDialog("<?php echo $product['ProductId']; ?>")' class='link-underlined'><i class='icmn-cross2'></i> Remove</a></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Ecommerce Products List -->

</div>
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

<div id="errorWhileDeletingModal" class="modal-outer-body">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
		<h3 style="padding:5px;font-size:15px;">Error while deleting</h3>
    </div>
    <div class="modal-body">
		<span id = "confirmDeleteText">Could not delete this product since it is linked to other items in the system. Please delete those items first and try deleting again.</span>	
    </div>
    <div class="modal-footer" style="height:70px;">
		<table>
		<tr>
			<td><button id="buttonCloseErrorWhileDeletingModal" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">OK</button></td>
		</tr>
		</table>
    </div>
  </div>

</div>


<script>
	function showDeleteProductDialog(id) {
		document.getElementById('deleteProductModal').style.display = "block";
		document.getElementById('buttonConfirmDelete').onclick = function (){
				var request = new XMLHttpRequest();
				NProgress.start();
				request.onreadystatechange = function(){
					NProgress.inc();
					if(request.readyState == 4){
						var response = request.response;
						if(request.status == 200){
							if(response.trim() == "success"){
								window.location = "landing_product"; //refresh
							} else {
								//show error dialog box
								document.getElementById('errorWhileDeletingModal').style.display = "block";
								document.getElementById('buttonCloseErrorWhileDeletingModal').onclick = function (){
									//document.getElementById('errorWhileDeletingModal').style.display = "none";
									//document.getElementById('deleteProductModal').style.display = "none";
									window.location = "landing_product"; //refresh
								}
							}
						} else {
							window.location = "landing_product";
						}
						NProgress.done();
					}
				};
				
				request.open ("DELETE", "landing_product/delete/" + id, true);
				request.send();
		}
	}

	function closeDeleteProductModal(){
		document.getElementById('deleteProductModal').style.display = 'none';
	}
	
</script>
<!-- Page Scripts -->
<script>
    $(function () {
		$('#displayProductsTable').DataTable();
    });
</script>


<!-- End Page Scripts -->


</section>