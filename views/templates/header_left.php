<html ng-app="cleanUI">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Parmar Oil Mills</title>

    <link href="<?php echo base_url();?>assets/common/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="<?php echo base_url();?>assets/common/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="<?php echo base_url();?>assets/common/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="<?php echo base_url();?>assets/common/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="<?php echo base_url();?>assets/common/img/favicon.png" rel="icon" type="image/png">
    <link href="../favicon.ico" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for < IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Vendors Styles -->
    <!-- v1.0.0 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/jscrollpane/style/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/ladda/dist/ladda-themeless.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/cleanhtmlaudioplayer/src/player.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/cleanhtmlvideoplayer/src/player.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/summernote/dist/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/ionrangeslider/css/ion.rangeSlider.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/datatables/media/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/c3/c3.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/chartist/dist/chartist.min.css">
    <!-- v1.4.0 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/jquery-steps/demo/css/jquery.steps.css">
    <!-- v1.4.2 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- v1.7.0 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/dropify/dist/css/dropify.min.css">

    <!-- Clean UI Styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/common/css/source/main.css">

    <!-- Vendors Scripts -->
    <!-- v1.0.0 -->
    <script src="<?php echo base_url();?>assets/vendors/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/jquery-mousewheel/jquery.mousewheel.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/jscrollpane/script/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/spin.js/spin.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/ladda/dist/ladda.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/select2/dist/js/select2.full.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/html5-form-validation/dist/jquery.validation.min.js"></script>   
    <script src="<?php echo base_url();?>assets/vendors/jquery-typeahead/dist/jquery.typeahead.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/autosize/dist/autosize.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/bootstrap-show-password/bootstrap-show-password.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/cleanhtmlaudioplayer/src/jquery.cleanaudioplayer.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/cleanhtmlvideoplayer/src/jquery.cleanvideoplayer.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/summernote/dist/summernote.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/ionrangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/nestable/jquery.nestable.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/datatables/media/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/editable-table/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/d3/d3.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/c3/c3.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/chartist/dist/chartist.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/peity/jquery.peity.min.js"></script>
    <!-- v1.0.1 -->
    <script src="<?php echo base_url();?>assets/vendors/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- v1.1.1 -->
    <script src="<?php echo base_url();?>assets/vendors/gsap/src/minified/TweenMax.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/hackertyper/hackertyper.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/jquery-countTo/jquery.countTo.js"></script>
    <!-- v1.4.0 -->
    <script src="<?php echo base_url();?>assets/vendors/nprogress/nprogress.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/jquery-steps/build/jquery.steps.min.js"></script>
    <!-- v1.4.2 -->
    <script src="<?php echo base_url();?>assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/chart.js/src/Chart.bundle.min.js"></script>
    <!-- v1.7.0 -->
    <script src="<?php echo base_url();?>assets/vendors/dropify/dist/js/dropify.min.js"></script>


    <!-- Angular Version Scripts -->
    <script src="<?php echo base_url();?>assets/vendors/angular/angular.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/angular-route/angular-route.min.js"></script>
    <script src="<?php echo base_url();?>assets/common/js/version_angular/app.js"></script>

    <!-- Angular Version Controllers 
    <script src="pages/register.ctrl.js"></script>
    <script src="pages/login.ctrl.js"></script>
    <script src="pages/lockscreen.ctrl.js"></script>-->


    <!-- Clean UI Scripts -->
    <script src="<?php echo base_url();?>assets/common/js/common.js"></script>
    <script src="<?php echo base_url();?>assets/common/js/demo.temp.js"></script>
	<script src="<?php echo base_url();?>js/common.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/float-modal.css">
</head>
<body class="theme-dark colorful-enabled" ng-controller="MainCtrl">
