 <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Vendors</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $getdashboard['VendorCount'];?>" data-speed="1" data-fresh-interval="20"><?php echo $getdashboard['VendorCount'];?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Users</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $getdashboard['UserCount'];?>" data-speed="1000" data-fresh-interval="20"><?php echo $getdashboard['UserCount'];?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Delivery Boy</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $getdashboard['DeliveryBoyCount'];?>" data-speed="1000" data-fresh-interval="20"><?php echo $getdashboard['DeliveryBoyCount'];?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            </div>
        </div>
    </section>