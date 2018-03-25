<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Profit Update</h2>
            </div>
<!-- Advanced Validation -->
            <div class="row clearfix">
                <div class="col-md-4 col-xs-0"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Profit</h2>
                        </div>
                        <div class="body">
                        <?php if(!empty($profit)){
                         foreach($profit as $Profit){?>
                            <form id="sign_up" method="POST" action="<?php echo base_url();?>Admin/Updateprofit">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="Profit" value="<?php echo $Profit->profitamount;?>" required>
                                        <label class="form-label">Profit</label>
                                    </div>
                                    <div class="help-info">Profit</div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="percent" value="<?php echo $Profit->paypercent;?>" required>
                                        <label class="form-label">payable percentage</label>
                                    </div>
                                    <div class="help-info">payable percentage</div>
                                </div>
                                <input type="hidden" value="<?php echo $Profit->profitid;?>" name="pid">
                                <button class="btn btn-primary waves-effect " type="submit">SUBMIT</button>
                            </form><?php }}?>
                        </div>
                    </div>
                </div>
            </div></div></section>