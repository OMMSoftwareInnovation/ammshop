<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>AMM Shop</title>
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
     
      <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Multi Select Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Colorpicker Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/dropzone/dropzone.css" rel="stylesheet">
    
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url();?>assets/Vendor/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url();?>assets/Vendor/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/Vendor/css/custom.css" rel="stylesheet">

    <!-- VendorBSB Themes. You can choose a theme from css/themes instead of get all themes -->
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
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
    <!-- #END# Page Loader -->
   
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url();?>Vendor/index">Vendor</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">              
               <!-- Notifications -->
                <li class="dropdown">               
                    <a href="<?php echo base_url();?>Vendor/Notification" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count"><?php print_r($this->site_notification["NewOrdersNoti"] /*+ $this->site_notification["NewVendorsNoti"] + $this->site_notification["NewItemsNoti"] */+ $this->site_notification["RejectedOrderNoti"] + $this->site_notification["CompletedOrderNoti"]);?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php print_r($this->site_notification["NewOrdersNoti"]);?> new Orders </h4>
                                            <p>
                                                Click For Check
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php print_r($this->site_notification["CompletedOrderNoti"]);?> Completed Orders </h4>
                                            <p>
                                                Click For Check
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">remove_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php print_r($this->site_notification["RejectedOrderNoti"]);?> rejected Orders </h4>
                                            <p>
                                                Click For Check
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <!--li>
                                    <a href="<?php echo base_url();?>Vendor/VendorRequest">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php print_r($this->site_notification["NewVendorsNoti"]);?> new Vendor joined</h4>
                                            <p>                                               
                                                Click for check
                                            </p>
                                        </div>
                                    </a>
                                </li>                               
                                <li>
                                    <a href="<?php echo base_url();?>Vendor/ItemsRequest">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php print_r($this->site_notification["NewItemsNoti"]);?> new Items </h4>
                                            <p>
                                                Click For Check
                                            </p>
                                        </div>
                                    </a>
                                </li-->                               
                            </ul>
                        </li>
                        <!--li class="footer">
                            <a href="<?php echo base_url();?>Vendor/Notification">View All Notifications</a>
                        </li-->
                    </ul>
                </li>
                <!-- #END# Notifications -->        
            </ul>
        </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url();?>assets/Vendor/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata['Vlogged_in']['VName'];?></div>
                    <div class="email"><?php echo $this->session->userdata['Vlogged_in']['VShopName'];?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo base_url();?>Vendor/ChangePassword"><i class="material-icons">lock</i>Change Password</a></li>
                            <li><a href="<?php echo base_url();?>Vendor/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="<?php if($this->router->method == "index" ||$this->router->method == "Vendor_login_process" || $this->router->method == "Notification" || $this->router->method == "Profile"){?>active<?php }?>">
                        <a href="<?php echo base_url();?>Vendor/index">
                            <i class="material-icons">dashboard</i>
                            <span>Home</span>
                        </a>
                    </li> 
                    <li class="<?php if($this->router->method == "Items" ||$this->router->method == "AddItems" || $this->router->method == "Notification" || $this->router->method == "Profile"){?>active<?php }?>">
                        <a href="<?php echo base_url();?>Vendor/Items">
                            <i class="material-icons">border_color</i>
                            <span>Item Details</span>
                        </a>
                    </li>                 
                    <!--li class="<?php if($this->router->method == "AddSubVendor" || $this->router->method == "Vendor" || $this->router->method == "AddVendor" || $this->router->method == "DeliveryBoy" || $this->router->method == "AddDeliveryBoy" || $this->router->method == "Items"){?>active<?php }?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Person Master</span>
                        </a>
                        <ul class="ml-menu">                           
                            <li class="<?php if($this->router->method == "Vendor" || $this->router->method == "AddVendor"){?>active<?php }?>">
                                <a href="<?php echo base_url();?>Vendor/Vendor">
                                    <i class="material-icons">person</i>
                                    <span>Vendor</span>
                                </a>
                            </li>
                            <li class="<?php if($this->router->method == "DeliveryBoy" || $this->router->method == "AddDeliveryBoy"){?>active<?php }?>">
                                <a href="<?php echo base_url();?>Vendor/DeliveryBoy">
                                    <i class="material-icons">person</i>
                                    <span>Delivery Boy</span>
                                </a>
                            </li>                      
                        </ul> 
                    </li>  
                    <li class="<?php if($this->router->method == "Orders"){?>active<?php }?>">
                        <a href="<?php echo base_url();?>Vendor/Orders">
                            <i class="material-icons">shopping_cart</i>
                            <span>Orders Details</span>
                        </a>
                    </li>   
                    <li class="<?php if($this->router->method == "CurrentOrders"){?>active<?php }?>">
                        <a href="<?php echo base_url();?>Vendor/CurrentOrders">
                            <i class="material-icons">add_shopping_cart</i>
                            <span>Current Orders Details</span>
                        </a>
                    </li>   
                    <li class="<?php if($this->router->method == "WalletMoney" || $this->router->method == "AddWalletMoney"){?>active<?php }?>">
                        <a href="<?php echo base_url();?>Vendor/WalletMoney">
                            <i class="material-icons">money</i>
                            <span>Wallet Money</span>
                        </a>
                    </li>                    
                    <li class="<?php if($this->router->method == "DeliveryMoneyReporting" ){?>active<?php }?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">done_all</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if($this->router->method == "DeliveryMoneyReporting"){?>active<?php }?>">
                                <a href="<?php echo base_url();?>Vendor/DeliveryMoneyReporting">
                                    <i class="material-icons">money</i>
                                    <span>Delivery Money Reporting</span>
                                </a>
                            </li>                                               
                        </ul> 
                    </li-->        
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 <a href="#">Amm Shop</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.4
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>