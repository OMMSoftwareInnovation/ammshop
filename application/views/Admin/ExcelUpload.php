<section class="content">
        <div class="container-fluid">
            <!-- Advanced Validation -->
            <div class="row clearfix">
                <div class="col-md-4 col-xs-0"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add Vendors</h2>
                        </div>
                        <div class="body">
                            <form id="form_advanced_validation" action="<?php echo base_url();?>Admin/AddExcel" method="POST" enctype="multipart/form-data">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="Excel" value="" required>
                                    </div>
                                    <div class="help-info">Excel File</div>
                                </div>
                                <button class="btn btn-primary waves-effect " type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>