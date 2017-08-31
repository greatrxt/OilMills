<section class = "page-content">
<div class="page-content-inner">

    <!-- Dashboard -->
    <div class="dashboard-container">
	<div class="row">
	<a href = "<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_sales_order_approval">
		<div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
		
			<div class="widget widget-seven">
				<div class="carousel-widget carousel slide" data-ride="carousel">
					<div class="carousel-inner" role="listbox">
						
						<div class="carousel-item active  background-success">
							<div class="widget-body">
								<div href="javascript: void(0);" class="widget-body-inner">
									<h5 style = "color:white" class="text-uppercase">Orders Received Today</h5>
									<i class="counter-icon icmn-server" style = "color:white"></i>
									<span class="counter-count">
										<i class="icmn-arrow-up5" style = "color:white"></i>
										<span style = "color:white" class="counter-init" data-from="0" data-to="<?php echo $orders['count']; ?>"></span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="carousel-item  background-default">
							   <div class="widget-body">
								<div href="javascript: void(0);" class="widget-body-inner">
									<h5 style = "color:white" class="text-uppercase">Orders Received Today (INR)</h5>
									<i class="counter-icon icmn-server"  style = "color:white"></i>
									<span class="counter-count" style = "color:white">
										<i class="icmn-arrow-up5"></i>
										₹ <span class="counter-init" data-from="0" data-to="<?php echo $orders['value']; ?>"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="carousel-widget carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
							<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_sales_order_approval">
                                <div class="widget-body">
									<div href="javascript: void(0);" class="widget-body-inner">
										<h5 class="text-uppercase">Items For Approval</h5>
										<i class="counter-icon icmn-server"></i>
										<span class="counter-count">
											<i class="icmn-arrow-up5"></i>
											<span class="counter-init" data-from="0" data-to="<?php echo $pending_approval_order_entries['OrderEntryCount']; ?>"></span>
										</span>
									</div>
                                </div>
								</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="carousel-widget carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
							<div class="carousel-item  background-default active">
							       <div class="widget-body">
									<div href="javascript: void(0);" class="widget-body-inner">
										<h5 style = "color:white" class="text-uppercase">Items Dispatched Today</h5>
										<i class="counter-icon icmn-server"  style = "color:white"></i>
										<span class="counter-count" style = "color:white">
											<i class="icmn-arrow-up5"></i>
											<span class="counter-init" data-from="0" data-to="<?php echo $order_entries_dispatched_today['OrderEntryCount']; ?>"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="carousel-item">
							<div class="widget-body">
								<div href="javascript: void(0);" class="widget-body-inner">
									<h5 class="text-uppercase">Today's Dispatch Value (INR)</h5>
									<i class="counter-icon icmn-cash4"></i>
									<span class="counter-count">
										<i class="icmn-arrow-up5"></i>
										₹ <span class="counter-init" data-from="0" data-to="<?php echo $get_orders_entries_dispatched_today_amount['total']; ?>"></span>
									</span>
								</div>
							</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
  
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="widget-body">
                        <div href="javascript: void(0);" class="widget-body-inner">
                            <h5 class="text-uppercase">Items Pending Dispatch</h5>
                            <i class="counter-icon icmn-server"></i>
                            <span class="counter-count">
                                <i class="icmn-arrow-up5"></i>
                                <span class="counter-init" data-from="0" data-to="<?php echo $approved_order_entries['count']; ?>"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="carousel-widget carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <div class="widget-body">
                                    <div class="widget-body-icon">
                                    </div>
                                    <a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/Live_rates" class="widget-body-inner">
                                        <h2>Live Rates</h2>
                                    </a>
                                </div>
                            </div>
                            <!--<div class="carousel-item">
                                <div class="widget-body">
                                    <div class="widget-body-icon">
                                        <i class="icmn-download"></i>
                                    </div>
                                    <a href="javascript: void(0);" class="widget-body-inner">
                                        <h2>All Reports</h2>
                                        <p>Pdf Download</p>
                                    </a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="carousel-widget-2 carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/production" class="widget-body">
                                    <h2>
                                        <i class="icmn-database"></i> Monthly Production
                                    </h2>
                                    <p>
                                        Total Orders : <?php echo $production['orderCount'] ?>
                                        <br />
                                        Total Value : ₹ <?php echo $production['value'] ?>
                                    </p>
                                </a>
                            </div>
                            <!--<div class="carousel-item">
                                <a href="javascript: void(0);" class="widget-body">
                                    <h2>
                                        <i class="icmn-users"></i> Users
                                    </h2>
                                    <p>
                                        Total: 24 467
                                        <br />
                                        New: 456
                                    </p>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven background-danger">
                    <div class="carousel-widget carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/dispatch" class="widget-body">
                                    <h2>
                                        <i class="icmn-books"></i> Monthly Dispatch
                                    </h2>
                                    <p>
                                        Total Orders : <?php echo $order_entries_dispatched_for_current_month['OrderCount']; ?>
                                        <br />
                                        Total Value : ₹ <?php echo $order_entries_dispatched_for_current_month['total']; ?>
                                    </p>
                                </a>
                            </div>
                            <!--<div class="carousel-item">
                                <a href="javascript: void(0);" class="widget-body">
                                    <h2>
                                        <i class="icmn-download"></i> Finish
                                    </h2>
                                    <p>
                                        1. Upgrade
                                        <br />
                                        2. Prepare
                                    </p>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven background-info" style="background-image: url(../assets/common/img/temp/photos/9.jpeg)">
                    <div class="carousel-widget-2 carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/landing_approved_sales_order" class="widget-body">
                                    <h2>Pending Dispatch Orders</h2>
                                    <p>
                                        Number Of Orders : <?php echo $approved_and_pending_dispatch_orders_entries['OrderCount']; ?>
                                        <br />
                                        Number Of Customers : <?php echo $approved_and_pending_dispatch_orders_entries['CustomerCount']; ?>
                                    </p>
                                </a>
                            </div>
                            <!--<div class="carousel-item">
                                <a href="javascript: void(0);" class="widget-body">
                                    <h2>Clean</h2>
                                    <p>
                                        Simple
                                        <br />
                                        Responsive
                                    </p>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-6">
			 <div class="panel panel-with-borders m-b-0">
                    <div class="panel-body">
						<table class="table table-hover nowrap" width="100%" id = 'displayProductsTable'>
							<thead class="thead-default">
							<tr>
								<th>Name</th>
								<th>Live Rate</th>
								<th>Price Last Updated By</th>
								<th>Last Price Update Time</th>
							</tr>
							</thead>
							<tbody >
							<?php foreach ($products as $product): ?>
							<tr>
								<td><?php echo $product['Name']; ?></td>
								<td>₹ <?php echo $product['SellingPrice']; ?></td>
								<td><?php echo $product['PriceLastUpdatedBy']; ?></td>
								<td><?php echo $product['LastPriceUpdateTime']; ?></td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
                </div>
           
            </div>
            <div class="col-xl-6">
                <div class="widget widget-three">
                    <div class="calendar-block"></div>
                </div>
            </div>
		</div>
   <!-- 
   Closing tags commented out for home_footer in case of admin
   </div> 

</div>
</section>

<!-- Page Scripts -->
<script>
    $(function() {

        ///////////////////////////////////////////////////////////
        // COUNTERS
        $('.counter-init').countTo({
            speed: 1500
        });

        ///////////////////////////////////////////////////////////
        // ADJUSTABLE TEXTAREA
        autosize($('#textarea'));

        ///////////////////////////////////////////////////////////
        // CUSTOM SCROLL
        if (!cleanUI.hasTouch) {
            $('.custom-scroll').each(function() {
                $(this).jScrollPane({
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100
                });
                var api = $(this).data('jsp'),
                        throttleTimeout;
                $(window).bind('resize', function() {
                    if (!throttleTimeout) {
                        throttleTimeout = setTimeout(function() {
                            api.reinitialise();
                            throttleTimeout = null;
                        }, 50);
                    }
                });
            });
        }

        ///////////////////////////////////////////////////////////
        // CALENDAR
        $('.calendar-block').fullCalendar({
            //aspectRatio: 2,
            height: 450,
            header: {
                left: 'prev, next',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            buttonIcons: {
                prev: 'none fa fa-arrow-left',
                next: 'none fa fa-arrow-right',
                prevYear: 'none fa fa-arrow-left',
                nextYear: 'none fa fa-arrow-right'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            viewRender: function(view, element) {
                if (!cleanUI.hasTouch) {
                    $('.fc-scroller').jScrollPane({
                        autoReinitialise: true,
                        autoReinitialiseDelay: 100
                    });
                }
            },
			default: true,
            events: [
                {
                    title: 'All Day Event',
                    start: '2006-05-01',
                    className: 'fc-event-success'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2006-05-09T16:00:00',
                    className: 'fc-event-default'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2006-05-16T16:00:00',
                    className: 'fc-event-success'
                },
                {
                    title: 'Conference',
                    start: '2016-05-11',
                    end: '2006-05-14',
                    className: 'fc-event-danger'
                }
            ],
            eventClick: function(calEvent, jsEvent, view) {
                if (!$(this).hasClass('event-clicked')) {
                    $('.fc-event').removeClass('event-clicked');
                    $(this).addClass('event-clicked');
                }
            }
        });

        ///////////////////////////////////////////////////////////
        // CAROUSEL WIDGET
        $('.carousel-widget').carousel({
            interval: 4000
        });

        $('.carousel-widget-2').carousel({
            interval: 6000
        });

        ///////////////////////////////////////////////////////////
        // DATATABLES
        $('#displayProductsTable').DataTable({
            responsive: true,
            "lengthMenu": [[6], [6]]
        });
    });
</script>
<!-- End Page Scripts -->