<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                        <?php echo $ItemInfo[0]->item_name;?>'s Details    (GST: <?php echo $ItemInfo[0]->gst;echo "%";?>)
                        <a href="<?php echo base_url();?>Vendor/Items" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" title="Back">
                            <i class="material-icons">arrow_back</i>
                        </a>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Qty Type</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Discount</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Qty Type</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Discount</th>	
                                    </tr>
                                </tfoot>
                                <tbody ID="ItemsDetails">
                                <?php $i=1;if(!empty($ItemDetails)){
                                    foreach($ItemDetails as $item){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>      
                                        <td><?php echo $item->qty_type_name;?></td>     
                                        <td><?php echo $item->qty_name;?></td>
                                        <td><?php echo $item->qtyprice;?></td>       
                                        <td><?php echo $item->stock;?></td>      
                                        <td><?php echo $item->discount;?></td>                                          
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
