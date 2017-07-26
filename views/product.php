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

		<?php echo form_open_multipart('index.php/ParmarOilMills/web/product/create'); ?>
        <div id = "form-validation"  class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name = "name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productId">Product ID</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCode">Product Code</label>
                                <input type="text" name = "productCode" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCategory">Product Category</label>
								<select class="form-control" name  = "productCategory">
									<option value="Option 1">Vegetable Oil</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for="unitOfMeasurement">Unit Of Measurement</label>
                                <input type="text" name = "unitOfMeasurement" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="sellingPrice">Selling Price</label>
								<input type="text" name = "sellingPrice" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="form-group">
						<div class="form-group">
							<label for="productStatus">Product Status</label>
							<select class="form-control" name  = "productStatus">
								<option value="Option 1">Option 1</option>
							</select>
						</div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary width-150">Save Product</button>
                        <button type="button" class="btn btn-default">Cancel</button>
                    </div>

                </div>

                <div class="col-lg-4">
                    <h4>Product Image</h4>
                    <div class="cui-ecommerce--catalog--item">
                        <div id = "imagesToUpload" class="cui-ecommerce--catalog--item--img">
                            <a href="javascript: void(0);">
                                <img src="<?php echo base_url();?>assets/common/img/temp/ecommerce/ecommerce-empty.jpg" />
                            </a>
                            <a href="javascript: void(0);" class="link-underlined cui-ecommerce--catalog--item--img-remove">
                                <i class="icmn-cross2"><!-- --></i> Remove
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <input name = "productImage" type="file" id="l16">
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
							  $('#imagesToUpload').append('<img style="width:50%" src="' + objectUrl + '" /><br/><br/><br/>');
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