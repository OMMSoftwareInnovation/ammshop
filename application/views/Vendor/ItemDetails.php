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
                                        <th>Actions</th>		
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
                                        <th>Actions</th>
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
                                        <td>
                                            <a href="" class="clsUpdateStock" id="idEditUpdateStock" title="Edit" data-viid="<?php echo $item->vi_id;?>" data-stock="<?php echo $item->stock;?>" data-price="<?php echo $item->qtyprice;?>" data-qtytype="<?php echo $item->qty_type_name;?>" data-discount="<?php echo $item->discount;?>" data-qty="<?php echo $item->qty_name;?>" data-toggle="modal" data-target="#largeModalUpdateItemStock"><i class="glyphicon glyphicon-edit icon-white"  title="Update Item Stock" data-toggle="tooltip"></i></a>
                                        </td>                                        
                                    </tr><?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="modal fade" id="largeModalUpdateItemStock" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Update Item Stock</h4>
                </div>
                    <form class="form_update_stock" id="form_update_stock" method="post" action="<?php echo base_url();?>Vendor/UpdateItemStock" enctype="multipart/form-data"> 
                    <input type="hidden" name="vendoritemid" id="vendoritemid" value="">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="qtytype" name="qtytype" value="" readonly>
                                        <label class="form-label">Qty Type <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="qty" name="qty" value="" readonly>
                                        <label class="form-label">Qty <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>  
                         </div> 
                        <div class="row clearfix"> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="itemprice" name="itemprice" value="" required>
                                        <label class="form-label">Item Price <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                              
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="stock" name="stock" value="" required>
                                        <label class="form-label">Stock<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="discount" name="discount" value="" required>
                                        <label class="form-label">Stock<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                           
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" type="submit" id="btnSubmitCourse">SUBMIT</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>                    
            </div>
        </div>
    </div> 
</section>   
<script>
    $(document).ready(function($){     
         $('.clsUpdateStock').on('click',function(){       
            var viid = $(this).data("viid");
            var stock=$(this).data('stock'); 
            var price=$(this).data('price');     
            var qtytype=$(this).data('qtytype'); 
            var qty=$(this).data('qty');  
            var discount=$(this).data('discount'); 
            $('.form_update_stock input#vendoritemid').val(viid);
            $('.form_update_stock input#itemprice').val(price).parent().addClass('focused');
            $('.form_update_stock input#stock').val(stock).parent().addClass('focused');
            $('.form_update_stock input#qtytype').val(qtytype).parent().addClass('focused');
            $('.form_update_stock input#qty').val(qty).parent().addClass('focused');   
            $('.form_update_stock input#discount').val(discount).parent().addClass('focused');   
        });
    }); 
</script>