<section class="content">
    <div class="container-fluid">       
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Current Order Details                                
                        </h2>                           
                    </div>
                    <div class="body">                         
                        <div class="table-responsive " id="fetchCityWiseOrders">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="OrderDetailsTable">
                            <thead>
                                <tr>
                                    <!--th>Sr.No</th-->
                                    <th>Order Id</th>
                                    <th>Delivery Date</th>
                                    <th>Items</th>
                                    <th>Qty</th> 
                                    <!--th>Delivery Charges</th-->
                                    <th>Total</th>                                                
                                <!--th>Payment Type</th-->
                                    <th>Delivery Boy Details</th>
                                    <th>Status</th>   
                                    <th>Action</th>                                                     

                                </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                <!--th>Sr.No</th-->
                                <th>Order Id</th>
                                <th>Delivery Date</th>
                                <th>Items</th>
                                <th>Qty</th> 
                                <!--th>Delivery Charges</th-->
                                <th>Total</th>                                                
                                <!--th>Payment Type</th-->
                                <th>Delivery Boy Details</th>
                                <th>Status</th>   
                                <th>Action</th>        
                                </tr>
                            </tfoot>
                            <tbody ID="OrderDetails">
                            <?php $i=1;if(!empty($CurrentOrderDetails)){
                                foreach($CurrentOrderDetails as $order){?>
                                <tr>
                                    <!--td><?php echo $i++;?></td-->
                                    <td><?php echo $order->order_id;?></td>
                                    <td><?php echo $order->date;?></td>           
                                    <td><?php 
                                        $itemcount=explode(',',$order->iname);
                                            echo(count($itemcount));
                                        ?>
                                    </td>
                                    <td>
                                    <?php 

                                        $viid=explode(',',$order->vi_id);
                                        $vitem=explode(',',$order->vendoritem);
                                        $qty=explode(',',$order->qty);
                                        $arr_vi=array();
                                        $arr_qty=array();
                                            for($i=0;$i<count($vitem);$i++)
                                        {
                                            $arr_vi_key=array_search($vitem[$i],$viid);
                                            array_push($arr_vi,$arr_vi_key);
                                        }
                                        
                                        for($i=0;$i<count($arr_vi);$i++)
                                        {
                                            
                                            array_push($arr_qty,$qty[$arr_vi[$i]]);
                                        }
                                        
                                        echo implode(",",$arr_qty); 
                                        
                                    ?></td>
                                    <td>
                                        <?php $total=($order->total)-((($order->total)*($order->discount/100))+$order->walletpay);
                                            echo $total;
                                        ?>
                                    </td>           
                                    <td>
                                    <?php if($order->dname){?>
                                        <?php echo $order->dname;?>,<br>
                                        <?php echo $order->dmobile_no;?><br>
                                        <?php }else{ echo "------";}?>
                                    </td>                                              
                                    <td>
                                        <?php if($order->status == 1){?>
                                            <span class="label label-default">Pending</span>
                                        <?php } elseif($order->status == 2){?>
                                            <span class="label label-primary">Confirmed</span>
                                        <?php } elseif($order->status == 3){?>
                                            <span class="label label-success">Shipped</span>
                                        <?php } elseif($order->status == 4){?>
                                            <span class="label label-info">Deliverd</span>
                                        <?php } elseif($order->status == 5){?>
                                            <span class="label label-warning">Completed</span>                                                  
                                        <?php } elseif($order->status == 6){?>
                                            <span class="label label-warning">Rejected</span>
                                        <?php } ?>                                                      
                                    </td>
                                    <td>
                                        <a href="#" class="GenerateInvoice" id="GenerateInvoice" title="GenerateInvoice" data-toggle="modal" data-target="#largeModalInvoice" data-id="<?php echo $order->order_id;?>" data-uid="<?php echo $order->uid;?>" data-uaid="<?php echo $order->user_add_id;?>" data-viid="<?php echo $order->vi_id;?>"><span class="label label-warning">Generate Invoice</span></a>
                                        <!--a href="#" class="clsEditQuantity"  data-id="<?php echo $order->order_id;?>" data-itemid="<?php echo $order->vi_id;?>" data-iname="<?php echo $order->iname;?>" data-iprice="<?php echo $order->iprice;?>" data-updateattempt="<?php echo $order->updateattempt;?>" data-stock="<?php echo $order->istock;?>" data-qty="<?php echo $order->qty;?>"> <span class="label label-default">Edit Qty</span></a-->
                                        <a href="#" class="clsCancelOrder" data-id="<?php echo $order->order_id;?>"> <span class="label label-danger">Cancel</span></a>
                                        <a href="#" class="clsAssignDeliveryBoy  <?php if($order->dname){?>collapse <?php } ?>" data-id="<?php echo $order->order_id;?>"> <span class="label label-danger">Assign Delivery Boy</span></a>
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
</section>
<div class="modal fade" id="largeModalInvoice" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Invoice Details</h4>
            </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>                    
        </div>
    </div>
</div>
<div class="modal fade" id="largeModalAssignDeliveryBoy" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Assign Delivery Boy</h4>
            </div>
            <form class="form_assign_dboy" id="form_assign_dboy" method="post" action="<?php echo base_url();?>Vendor/AssignDeliveryBoyByVendor" enctype="multipart/form-data"> 
                <input type="hidden" name="orderid" id="orderid" value="">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="txtdelid" name="txtdelid" required>
                                        <option value="">Select DeliveryBoy</option>
                                        <?php if(!empty($DeliveryBoy)){
                                            foreach($DeliveryBoy as $dboy){if($dboy->verified == 1){?>
                                                <option value="<?php echo $dboy->del_id;?>"><?php echo $dboy->name;?></option>
                                        <?php }}}?>
                                    </select> 
                                </div>
                            </div>  
                        </div>                 
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="submit" id="btnQtySubmit">SUBMIT</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>                    
        </div>
    </div>
</div> 
<script>
 $(document).ready(function($){
    $('.GenerateInvoice').on('click',function(){ 
        var orderid=$(this).data('id');
        var userid=$(this).data('uid');
        var useraddressid=$(this).data('uaid'); 
        var viid=$(this).data('viid'); 
        alert(viid);
            $.ajax({
            url: "<?php echo base_url();?>Vendor/GenerateInvoice",
            method:"post",
            data: {'orderid' : orderid,'uid' : userid,'uaid' : useraddressid,'viid' : viid},
            success: function(result)
            {
                $("#largeModalInvoice").modal();
                $("#largeModalInvoice .modal-body").html(result);                 
            },
            error: function()
            {
            alert("Something Went Wroung!");
            }
        });
    });
    $('.clsAssignDeliveryBoy').on('click',function(){ 
        var orderid=$(this).data('id');
        $("#largeModalAssignDeliveryBoy").modal();
        $('.form_assign_dboy input#orderid').val(orderid).parent().addClass('focused');
       // $(".selectpicker").selectpicker("refresh"); 
    });
    $('#form_assign_dboy').validate({        
        rules:{
            'txtdelid':{remote:{url: "<?php echo base_url();?>Vendor/CheckDelBoyAvailability",type:"post",
                    data:{
                    delval:function(){return $('#txtdelid').val()},
                    }}
        }},
        messages:{
            'txtdelid':{remote:"Already Assigned,Please select other delivery boy!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
});

</script>