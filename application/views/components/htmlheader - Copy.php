<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dashboard</title>
        <meta name="description" content="Kiwi is a premium adman dashboard template based on bootstrap">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="apple-touch-icon" href="apple-touch-icon.html">

        <!-- core plugins -->

        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR; ?>/css/hamburgers.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/animate.css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/perfect-scrollbar/css/perfect-scrollbar.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/switchery/dist/switchery.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/sweetalert/dist/sweetalert.css">
        <!-- Site-wide styles -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR; ?>/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR; ?>/css/site.css">
        <!-- current page styles -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR ?>/examples/css/dashboards/dashboard.v1.css">
        <!-- Fonts -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/material-design-iconic-font/dist/css/material-design-iconic-font.css">
        
        <!-- text editor css -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/bootstrap-wysihtml5/bootstrap-wysihtml5.css">
        <!-- Date Picker CSS -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/datepicker/datepicker3.css">
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/daterangepicker/daterangepicker.css">

        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/timepicker/bootstrap-timepicker.min.css">
        <!-- Date Picker CSS End -->

        <!-- Alertify -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/alertifyjs/css/alertify.min.css">
        <!-- End  -->
        <!-- Full Calnder -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . VENDOR_DIR . BOWER_COMPNENT; ?>/fullcalendar/dist/fullcalendar.min.css">
        <!-- Full Calnder End -->
        <!-- Select 2 -->
		<link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/select2/select2.min.css">
		<!-- Select 2 end -->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

        <!-- Custom Css Added -->
        <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR; ?>/global/css/custom.css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.css" rel="stylesheet">
</head>

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
	</script>
	<script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url() . ASSETS_DIR ?>/angular/angular.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-sanitize.js"></script>
    <script src="<?php echo base_url() . ASSETS_DIR ?>/angular/ui-bootstrap-tpls-2.5.0.min.js"></script>
	
	<script src="<?php echo base_url().ASSETS_DIR .PLUGINS_DIR?>/angular-ui-select/select.js"></script>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js"></script>
    <script src="<?php echo base_url() ?>app/routes.js"></script>
    <script src="<?php echo base_url() ?>app/services/myServices.js"></script>
     <script src="<?php echo base_url() ?>app/controllers/LeadController.js"></script>
	 <link rel="stylesheet" href="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR; ?>/angular-ui-select/select.css">
	 
	 <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
    <body  ng-app="crm-App" class="menubar-left menubar-light dashboard dashboard-v1 menubar-fold">

