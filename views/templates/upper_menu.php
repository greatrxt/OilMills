
		
<nav class="left-menu" left-menu ng-class="{'hidden-left-menu': hideLeftMenu}">
    <div class="logo-container">
        <a href="http://1qubit.com" target="_blank" class="logo">
            <img src="<?php echo base_url();?>assets/common/img/logo.png" alt="Parmar Oil Mills" />
            <img class="logo-inverse" src="<?php echo base_url();?>assets/common/img/logo.png" alt="Parmar Oil Mills" />
        </a>
    </div>
    <div class="left-menu-inner scroll-pane">
        <ul class="left-menu-list left-menu-list-root list-unstyled">   
		
            <li>
                <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/home">
                    <i class="left-menu-link-icon icmn-home2"></i>
                    Home
                </a>
            </li>
			<li class="left-menu-list-separator"><!-- --></li>
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-files-empty2"><!-- --></i>
                    Order Management
                </a>
                <ul class="left-menu-list list-unstyled">
                    <li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_sales_order_approval">
                            Orders Received
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order">
                            View Approved Orders
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_rejected_sales_order">
                            View Rejected Orders
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/production">
                            Production Summary
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch">
                            Dispatch Summary
                        </a>
                    </li>
                </ul>
            </li>

            <li class="left-menu-list-separator"><!-- --></li>

            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-files-empty2"><!-- --></i>
                    Masters
                </a>
                <ul class="left-menu-list list-unstyled">
                    <li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_broker">
                            Broker
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_customer">
                            Customer
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_employee">
                            Employee
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_location">
                            Location
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_product">
                            Product
                        </a>
                    </li>
					<li>
                        <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_route">
                            Route
                        </a>
                    </li>
                </ul>
            </li>
			
			<li class="left-menu-list-submenu" style = "display:none"><!-- DO NOT DELETE MENU ITEM. NEEDED TO SHOW COLOR BAND OVER MENU ITEM WHILE HOVERING MOUSE -->
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-cog util-spin-delayed-pseudo"></i>
                    <span class="menu-top-hidden">Theme</span>Theme
                </a>
                <ul class="left-menu-list list-unstyled">
                    <li>
                        <div class="left-menu-item">
                            <div class="left-menu-block">

                                <div class="left-menu-block-item">
                                    <span class="font-weight-600">Colorful Menu:</span>
                                </div>
                                <div class="left-menu-block-item" id="options-colorful">
                                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                                        <div class="btn-group">
                                            <label class="btn btn-default active">
                                                <input type="radio" name="options-colorful" value="colorful-enabled" checked=""> On
                                            </label>
                                        </div>
                                        <div class="btn-group">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options-colorful" value="colorful-disabled"> Off
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                </ul>
            </li>
			<li class="left-menu-list-separator"><!-- --></li>
            <li>
                <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/Live_rates">
                    <i class="left-menu-link-icon icmn-profile"><!-- --></i>
                    Live Rates
                </a>
            </li>
            <li class="left-menu-list-separator"><!-- --></li>
            <li>
                <a class="left-menu-link" href="<?php echo base_url() ?>index.php/ParmarOilMills/web/login/signout">
                    <i class="left-menu-link-icon icmn-profile"><!-- --></i>
                    Sign Out
                </a>
            </li>
        </ul>
    </div>
</nav>

<nav style = "height:0px;" class="top-menu" ng-class="{'hidden-top-menu': hideTopMenu}">
    <div class="menu-icon-container hidden-md-up">
        <div class="animate-menu-button left-menu-toggle">
            <div><!-- --></div>
        </div>
    </div>
	<div class="menu">
	</div>
</nav>
<div class="main-backdrop"><!-- --></div>