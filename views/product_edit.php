<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Edit -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                Product
            </h2>
        </div>
		<?php echo validation_errors(); ?>
		<?php $attributes = array('name' => 'form-validation'); echo form_open_multipart('ParmarOilMills/web/product/edit/'.$product['ProductId'], $attributes); ?>
        <div id = "form-validation"  class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Product Name*</label>
                                <input type="text" name = "name" class="form-control" value="<?php if(set_value('name')!=null) echo set_value('name'); else echo $product['Name']; ?>" data-validation="[L>=2]"
																						data-validation-message="Please enter a valid product name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productId">Product ID</label>
                                <input type="text" class="form-control" readonly value="PRO<?php echo $product['ProductId']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCode">Product Code*</label>
                                <input type="text" name = "productCode" data-validation="[L>=2]" class="form-control"  value="<?php if(set_value('productCode')!=null) echo set_value('productCode'); else echo $product['Code']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCategory">Product Category</label>
								<select class="form-control" name  = "productCategory">
									<option value="RBD Palmolien Oil" <?php if($product['ProductCategory'] == "RBD Palmolien Oil") echo "selected" ?>>RBD Palmolien Oil</option>
									<option value="Refined Soyabean Oil" <?php if($product['ProductCategory'] == "Refined Soyabean Oil") echo "selected" ?>>Refined Soyabean Oil</option>
									<option value="Vanaspati Oil" <?php if($product['ProductCategory'] == "Vanaspati Oil") echo "selected" ?>>Vanaspati Oil</option>
									<option value="Sunflower Oil" <?php if($product['ProductCategory'] == "Sunflower Oil") echo "selected" ?>>Sunflower Oil</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for="unitOfMeasurement">Unit Of Measurement</label>
                                <select class="form-control" name  = "unitOfMeasurement">
									<option value="Litre" <?php if($product['UnitOfMeasurement'] == "Litre") echo "selected" ?>>Litre</option>
									<option value="Millilitre" <?php if($product['UnitOfMeasurement'] == "Millilitre") echo "selected" ?>>Millilitre</option>
									<option value="Kilogram" <?php if($product['UnitOfMeasurement'] == "Kilogram") echo "selected" ?>>Kilogram</option>
									<option value="Gram" <?php if($product['UnitOfMeasurement'] == "Gram") echo "selected" ?>>Gram</option>
								</select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="sellingPrice">Selling Price</label>
								<input type="number" name = "sellingPrice" class="form-control" value="<?php if(set_value('sellingPrice')!=null) echo set_value('sellingPrice'); else echo $product['SellingPrice']; ?>" step="0.01">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="form-group">
						<div class="form-group"  style = "width:49%">
							<label for="productStatus">Product Status</label>
							<select class="form-control" name  = "productStatus">
								<option value="Active" <?php if($product['Status'] == "ACTIVE") echo "selected" ?>>Active</option>
								<option value="Deactivated" <?php if($product['Status'] == "DEACTIVATED") echo "selected" ?>>Deactivated</option>
							</select>
						</div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary width-150">Save Product</button>
                        <a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_product"><button type="button" class="btn btn-default">Cancel</button></a>
                    </div>

                </div>

                <div class="col-lg-4">
                    <h4>Product Image</h4>
					<div class='preview-area' id = 'logo'>
							<div id='logoctr'><i style='color:gray' id='delete-logo' class='fa fa-trash fa-2x' onclick='showDeleteFileDialog();'></i></div>
								<div id = "imagesToUpload" class="cui-ecommerce--catalog--item--img">
									<img style = 'height:100%;' src = "<?php 
								
										$defaultImageURL = base_url()."assets/common/img/temp/ecommerce/ecommerce-empty.jpg";
										$imageUrlJpg = base_url().$product['ProductImage'];
										if(@getimagesize($imageUrlJpg)){
											echo $imageUrlJpg;
										} else {
											echo $defaultImageURL;
										}
		
								
								?>">
								</div>
							</br>
                        </div>
					<style>
						#logo { margin-top: 5px; border: 0px solid #ccc; padding:20px; width:100%}
						#logo:hover, #logo.edit { border: 0px solid #ccc; margin-top: 0px; }
						#logoctr { position:absolute; display: none; cursor: pointer; cursor: hand;  z-index: 20}
						#logo:hover #logoctr, #logo.edit #logoctr { display: block; line-height: 25px; padding: 10px; font-size: 20px;}
						#logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
						#logohelp input { margin-bottom: 5px; }
						.edit #logohelp { display: block; }
						.edit #save-logo, .edit #cancel-logo { display: inline; }
						.edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
					</style>
                    <div class="form-group">
                        <input id = "productImage" name = "productImage" type="file"  accept=".jpg" >
                        <br>
                        <small>Image of Product</small>
                    </div>
					<script>
						var inputLocalFile = document.getElementById("productImage");
						inputLocalFile.addEventListener("change", previewImages, false);

						function previewImages(){
							var fileList = this.files;					
							var anyWindow = window.URL || window.webkitURL;
							$('#imagesToUpload').html("");
							for(var i = 0; i < fileList.length; i++){
							  var objectUrl = anyWindow.createObjectURL(fileList[i]);
							  $('#imagesToUpload').append('<img style="height:100%" src="' + objectUrl + '" /><br/><br/><br/>');
							  window.URL.revokeObjectURL(fileList[i]);
							}	
						}
						
						function showDeleteFileDialog() {
							document.getElementById('deleteFileModal').style.display = "block";
							document.getElementById('buttonConfirmDelete').onclick = function (){
								window.location = "<?php echo base_url(). "index.php/ParmarOilMills/web/product/delete_image/".$product['ProductId']; ?>";
							}
							document.getElementById('buttonCancel').onclick = function (){
								document.getElementById('deleteFileModal').style.display = "none";
							}
						}
					</script>
                </div>
            </div>
        </div>
		</form>
	</section>
    <!-- End Ecommerce Product Edit -->

</div>
<div id="deleteFileModal" class="modal-outer-body">

<!-- Modal content -->
<div class="modal-content">
	<div class="modal-header">
	<h3 style="padding:5px;font-size:15px;">Delete image ?</h3>
	</div>
	<div class="modal-body">
	<span id = "confirmDeleteText">Product Image will be permanently deleted. Are you sure you want to continue ? ?</span>	
	</div>
	<div class="modal-footer" style="height:70px;">
	<table>
	<tr>
	<td><button id="buttonConfirmDelete" style = "width:150px;height:40px;display:inline;" class="btn btn Primary">Yes</button></br></td>
	<td><button id="buttonCancel" style = "width:150px;height:40px;display:inline;" class="btn btn Primary" onclick = "closeDeleteFileModal()">Cancel</button></td>
	</tr>
	</table>
	</div>
</div>

</div>
</section>