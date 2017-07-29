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

		<?php echo form_open_multipart('ParmarOilMills/web/product/edit/'.$product['ProductId']); ?>
        <div id = "form-validation"  class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name = "name" class="form-control" value="<?php if(set_value('name')!=null) echo set_value('name'); else echo $product['Name']; ?>">
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
                                <label for="productCode">Product Code</label>
                                <input type="text" name = "productCode" class="form-control"  value="<?php if(set_value('productCode')!=null) echo set_value('productCode'); else echo $product['Code']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCategory">Product Category</label>
								<select class="form-control" name  = "productCategory">
									<option value="Vegetable Oil">Vegetable Oil</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for="unitOfMeasurement">Unit Of Measurement</label>
                                <select class="form-control" name  = "unitOfMeasurement">
									<option value="Kilograms" <?php if($product['UnitOfMeasurement'] == "Kilograms") echo "selected" ?>>Kilograms</option>
									<option value="Litres" <?php if($product['UnitOfMeasurement'] == "Litres") echo "selected" ?>>Litres</option>
								</select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="sellingPrice">Selling Price</label>
								<input type="text" name = "sellingPrice" class="form-control" value="<?php if(set_value('sellingPrice')!=null) echo set_value('sellingPrice'); else echo $product['SellingPrice']; ?>">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="form-group">
						<div class="form-group">
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
                    <div class="cui-ecommerce--catalog--item">
                        <div id = "imagesToUpload" class="cui-ecommerce--catalog--item--img">
                           <img style = 'height:100%;' 
							src = "<?php 
							
							$defaultImageURL = base_url()."assets/common/img/temp/ecommerce/ecommerce-empty.jpg";
							$imageUrlJpg = base_url()."/uploads/product/".$product['ProductId'].".jpg";
							//$imageUrlPng = base_url()."/uploads/product/".$product['ProductId'].".png";
							/*
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$imageUrl);
							// don't download content
							curl_setopt($ch, CURLOPT_NOBODY, 1);
							curl_setopt($ch, CURLOPT_FAILONERROR, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							if(curl_exec($ch)!==FALSE)
							{
								echo $imageUrl;
							}
							else
							{
								echo $defaultImageURL;
							}*/
							
							if(@getimagesize($imageUrlJpg)){
								echo $imageUrlJpg;
							//} else if (@getimagesize($imageUrlPng)){
							//	echo $imageUrlPng;
							} else {
								echo $defaultImageURL;
							}
	
							
						?>">
                        </div>
                    </div>

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
					</script>
                </div>
            </div>
        </div>
		</form>
	</section>
    <!-- End Ecommerce Product Edit -->

</div>
</section>