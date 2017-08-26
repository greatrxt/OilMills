        
		<div class="widget widget-four background-transparent">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_customer" class="widget-body">
                    <div class="step-block ">
                        <span class="step-digit">
                            <i class="icmn-database"><!-- --></i>
                        </span>
                        <div class="step-desc">
                            <span class="step-title">Customers</span>
                            <p>
                                Total: <?php echo $customer['count'] ?>
                            </p>
                        </div>
                    </div>
					</a>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_broker" class="widget-body">
                    <div class="step-block">
                        <span class="step-digit">
                            <i class="icmn-users"><!-- --></i>
                        </span>
                        <div class="step-desc">
                            <span class="step-title">Brokers</span>
                            <p>Total: <?php echo $broker['count'] ?></p>
                        </div>
                    </div>
					</a>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_employee" class="widget-body">
                    <div class="step-block step-warning">
                        <span class="step-digit">
                            <i class="icmn-stats-growth"><!-- --></i>
                        </span>
                        <div class="step-desc">
                            <span class="step-title">Employees</span>
                            <p>
                                Total: <?php echo $employee['count'] ?>
                            </p>
                        </div>
                    </div>
					</a>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                    <div class="step-block step-primary">
                        <span class="step-digit">
                            <i class="icmn-stats-dots"><!-- --></i>
                        </span>
                        <div class="step-desc">
                            <span class="step-title">Users</span>
                            <p>
                                <span><?php echo $user['count'] ?></span>
                                <span>&nbsp;</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>