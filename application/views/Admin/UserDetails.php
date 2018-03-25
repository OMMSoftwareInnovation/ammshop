<section class="content">
    <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                User Details
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Mobile No.</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>User Name</th>
                                        <th>Mobile No.</th>
                                        </tr>
                                    </tfoot>
                                    <tbody ID="OfferDetails">
                                    <?php if(!empty($User)){
                                        foreach($User as $user){?>
                                        <tr>
                                            <td><?php echo $user->uname;?></td>
                                            <td><?php echo $user->mobileno;?></td>
                                        </tr><?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </section>