<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>MonthlyAmount Update</h2>
            </div>
<!-- Advanced Validation -->
            <div class="row clearfix">
                <div class="col-md-4 col-xs-0"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MonthlyAmount</h2>
                        </div>
                        <div class="body">
                        <?php if(!empty($MonthlyAmount)){
                         foreach($MonthlyAmount as $MonthlyAmount){?>
                            <form id="sign_up" method="POST" action="<?php echo base_url();?>Admin/UpdateMonthlyAmount">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="MonthlyAmount" value="<?php echo $MonthlyAmount->amount;?>" required>
                                        <label class="form-label">MonthlyAmount</label>
                                    </div>
                                    <div class="help-info">MonthlyAmount</div>
                                </div>
                                <input type="hidden" value="<?php echo $MonthlyAmount->mpid;?>" name="mpid">
                                <button class="btn btn-primary waves-effect " type="submit">SUBMIT</button>
                            </form><?php }}?>
                        </div>
                    </div>
                </div>
            </div></div></section>