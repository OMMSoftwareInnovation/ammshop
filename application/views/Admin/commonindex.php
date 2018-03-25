<!DOCTYPE html>
6<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Tell & Sell</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/animate-css/animate.css" rel="stylesheet" />
    
    <!-- Sweet Alert Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    
    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

     <link href="<?php echo base_url();?>assets/Vendor/css/jquery-ui.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="<?php echo base_url();?>assets/Vendor/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url();?>assets/Vendor/css/themes/all-themes.css" rel="stylesheet" />

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/js/jquery-ui.js"></script>
    <script type="text/javascript">
        var Settings = {
            base_url: '<?= base_url() ?>',
            Current_Url : '<?= $this->router->method ?>',
            Current_Controller : '<?= $this->router->class ?>'
        }
        var pagesort = {
            Current_page : '',
        }
        // console.log(Settings.Current_Controller);
    </script>
</head>

<body class="theme-red">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url();?>Admin/index">Tell & Sell</a>
            </div>
        </div>
    </nav>

<div class="gap"></div>
	<div class="gap"></div>
	<div class="gap"></div>
	<div class="gap"></div>
	<div class="gap"></div>
    <section class="">
        <div class="container-fluid">
            <!-- No Header Card -->
            <div class="block-header">
                <h2 class="commoncard">Select Category to Open Admin Panel</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url('EcomAdmin/index');?>">
                    <div class="card commoncard">
                        <div class="body">
                            <img class="Commoninimg" src="<?php echo base_url();?>assets/img/test_banner/ecomm-laptop.png">
                            <h4>E-Commorce</h4>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('Admin/Localindex');?>">
                    <div class="card commoncard">
                        <div class="body">
                            <img class="Commoninimg" src="<?php echo base_url();?>assets/img/test_banner/2.png">
                            <h4>Local Business / Shops</h4>
                        </div>
                    </div>
                </a>
                </div>
            </div>
            <!-- #END# No Header Card -->
        </div>
    </section>

    
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!--<script src="<?php echo base_url();?>assets/Vendor/plugins/bootstrap-select/js/bootstrap-select.js"></script>-->

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-validation/additional-methods.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/node-waves/waves.js"></script>

    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/morrisjs/morris.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url();?>assets/Vendor/js/admin.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/js/pages/index.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/js/pages/examples/sign-up.js"></script>
    <script src="<?php echo base_url();?>assets/Vendor/js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo base_url();?>assets/Vendor/js/demo.js"></script>
</body>

</html>