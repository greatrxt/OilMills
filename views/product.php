<div style = "padding-top:20px;padding-left:20px;padding-right:20px;">
	<?php echo validation_errors('  <div style = "border-color: #ebccd1;background-color:#f2dede; color:#a94442" class="alert alert-danger alert-dismissable"><a style = "padding-bottom:10px" href="#" class="close" data-dismiss="alert" aria-label="close">×</a>', '</div>'); ?>
</div>
<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Edit -->
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h2>
                Create New Product
            </h2>
        </div>
		<?php echo validation_errors(); ?>
		<?php $attributes = array('name' => 'form-validation'); echo form_open_multipart('ParmarOilMills/web/product/create', $attributes); ?>
        <div id = "form-validation"  class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Product Name*</label>
                                <input type="text" name = "name" class="form-control" data-validation="[L>=2]"
																						data-validation-message="Please enter a valid product name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productId">Product ID</label>
                                <input type="text" class="form-control" disabled value = "Not Assigned Yet">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCode">Product Code*</label>
                                <input type="text" name = "productCode" class="form-control" data-validation="[L>=2]">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="productCategory">Product Category</label>
								<select class="form-control" name  = "productCategory">
									<option value="RBD Palmolien Oil">RBD Palmolien Oil</option>
									<option value="Refined Soyabean Oil">Refined Soyabean Oil</option>
									<option value="Vanaspati Oil">Vanaspati Oil</option>
									<option value="Sunflower Oil">Sunflower Oil</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for="unitOfMeasurement">Unit Of Measurement</label>
                                <select class="form-control" name  = "unitOfMeasurement">
									<option value="Litre">Litre</option>
									<option value="Millilitre">Millilitre</option>
									<option value="Kilogram">Kilogram</option>
									<option value="Gram">Gram</option>
								</select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="sellingPrice">Selling Price</label>
								<input type="number" name = "sellingPrice" class="form-control" step="0.01">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="form-group">
						<div class="form-group" style = "width:49%">
							<label for="productStatus">Product Status</label>
							<select class="form-control" name  = "productStatus">
								<option value="Active">Active</option>
								<option value="Deactivated">Deactivated</option>
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
                            <a href="javascript: void(0);">
                                <img src="<?php echo base_url();?>assets/common/img/temp/ecommerce/ecommerce-empty.jpg" />
                            </a>
                            <a href="javascript: void(0);" class="link-underlined cui-ecommerce--catalog--item--img-remove">
                                <i class="icmn-cross2"><!-- --></i> Remove
                            </a>
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