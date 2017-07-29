
<section class = "page-content">
<div class="page-content-inner">

    <!-- Ecommerce Product Details -->
    <section class="panel panel-with-borders" style="overflow:auto">
        <div class="panel-heading">
            <h2>
                <div id = "title">Create New Route</div>
            </h2>
        </div>
        <div class="panel-body">
			<div class="nav-tabs-horizontal">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tab1" role="tab" aria-expanded="false">Route Details</a>
					</li>
				</ul>
				<?php echo validation_errors(); ?>

				<?php echo form_open('ParmarOilMills/web/route/edit/'.$route['RouteId']); ?>
				<div id = "form-validation" class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tab1" role="tabpanel" aria-expanded="false">
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="textRouteId">Route ID</label>
                                <input class="form-control" id="textRouteId" type="text" disabled value = "RT<?php echo $route['RouteId']; ?>">
                            </div>

							<div class="form-group">
								<label class="form-control-label" for="routeCode">Route Code</label>
								<input class="form-control" tabindex="2" name="routeCode" type="text" value = "<?php echo $route['RouteCode']; ?>">
							</div>
						
						</div>
						
						
						<div class = "col-lg-5">
							<div class="form-group">
                                <label for="routeName">Route Name*</label>
                                <input class="form-control" tabindex="1" name="routeName" type="text" value = "<?php echo $route['RouteName']; ?>">
                            </div>

							
						</div>
					</div>
					<div class="form-group" >
						<div class="col-md-9" style="padding-bottom:20px;">
							<button type="submit" class="btn width-150 btn-primary" style="margin:10px" id = "btnSave" tabindex="3">Save</button>
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_route"><button type="button" class="btn width-150 btn-default" style="margin:10px" tabindex="4">Cancel</button></a>
						</div>
                    </div>

				</div>
				</form>
			</div>

		</div>
	</section>
</div>	
</section>
