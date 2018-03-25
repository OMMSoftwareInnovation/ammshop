 <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">               
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
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">add_shopping_cart</i>
                        </div>
                        <div class="content">
                            <div class="text">Current Orders</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $getdashboard['CurrentOrders'];?>" data-speed="1" data-fresh-interval="20"><?php echo $getdashboard['CurrentOrders'];?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">shopping_cart</i>
                        </div>
                        <div class="content">
                            <div class="text">Completed Orders</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $getdashboard['CompletedOrders'];?>" data-speed="1000" data-fresh-interval="20"><?php echo $getdashboard['CompletedOrders'];?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            </div>
        </div>
    </section>