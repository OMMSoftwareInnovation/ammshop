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
    <?php $i=1;if(!empty($OrdersDetails)){
        foreach($OrdersDetails as $order){?>
        <tr>
            <!--td><?php echo $i++;?></td-->
            <td><?php echo $order->order_id;?></td>
            <td><?php echo $order->date;?></td>           
            <td><?php 
                $itemcount=explode(',',$order->vi_id);
                echo(count($itemcount));
                ?>
            </td>
            <td><?php echo $order->qty;?></td>
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
                <a href="#" class="clsEditQuantity"  data-id="<?php echo $order->order_id;?>" data-itemid="<?php echo $order->vi_id;?>" data-iname="<?php echo $order->iname;?>" data-iprice="<?php echo $order->iprice;?>" data-updateattempt="<?php echo $order->updateattempt;?>" data-stock="<?php echo $order->istock;?>" data-qty="<?php echo $order->qty;?>"> <span class="label label-default">Edit Qty</span></a>
                <a href="#" class="clsCancelOrder" data-id="<?php echo $order->order_id;?>"> <span class="label label-danger">Cancel</span></a>
                <a href="#" class="clsAssignDeliveryBoy <?php if($order->dname){?>collapse <?php }?>" data-id="<?php echo $order->order_id;?>"> <span class="label label-danger">Assign Delivery Boy</span></a>
            </td>
        </tr><?php }}?>
    </tbody>
</table>
<script>
    $(document).ready(function($){

    $('#OrderDetailsTable').DataTable( {
       
    } );
    $('.Changestatus').on('click',function(){
        var status = $(this).data('status');
        var oid = $(this).data('id');
        
        $.ajax({
            url: "<?php echo base_url();?>SubAdmin/ChangeOrderStatus",
            method:"post",
            data: {'oid' : oid,'status' : status},
            dataType: 'json',
            success: function(result)
            {
                    
                swal({
                        title:"Order Status Changed!",
                        text: "Order Status Sucessfully Changed!",
                        type: "success",
                        timer: 2000,
                        closeOnConfirm: true
                    }, function () {
                            location.replace('Orders');
                });

                
            
            },
            error: function()
            {
                alert("Something Went Wroung!");
            }
        });                
    });  
    $('.GenerateInvoice').on('click',function(){ 
        var orderid=$(this).data('id');
        var userid=$(this).data('uid');
        var useraddressid=$(this).data('uaid'); 
        var viid=$(this).data('viid'); 
        alert(viid);
            $.ajax({
            url: "<?php echo base_url();?>SubAdmin/GenerateInvoice",
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
    $('.clsEditQuantity').on('click',function(){ 
        var orderid=$(this).data('id');
        var viid=$(this).data('itemid'); 
        var qty=$(this).data('qty'); 
        var istock=$(this).data('stock');
        var iname=$(this).data('iname');
        var iprice=$(this).data('iprice');
        var updateattempt=$(this).data('updateattempt');
        $("#largeModalUpdateQty").modal();
        $('.form_update_qty input#txtitemname').val(iname).parent().addClass('focused');
        $('.form_update_qty input#stock').val(istock).parent().addClass('focused');
        $('.form_update_qty input#txtitemqty').val(qty).parent().addClass('focused');
        $('.form_update_qty input#vitemid').val(viid).parent().addClass('focused');
        $('.form_update_qty input#orderid').val(orderid).parent().addClass('focused');
        $('.form_update_qty input#iprice').val(iprice).parent().addClass('focused');
        $('.form_update_qty input#updateattempt').val(updateattempt).parent().addClass('focused');
          /*  $.ajax({
            url: "<?php echo base_url();?>SubAdmin/GenerateInvoice",
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
        });*/
    });
    $('.clsCancelOrder').on('click',function(){
            var oid=$(this).data('id');
            swal({
            title: "Are you sure?",
            text: "You will not be able to recover this city record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, cancel it!",
            closeOnConfirm: false
        }, function () {
            
                $.ajax({
                url: "<?php echo base_url();?>SubAdmin/CancelOrderBySubAdmin",
                method:"post",
                data: {'oid' : oid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {                  
                      swal("Cancelled!", "Your order cancelled successfully!", "success");
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('CurrentOrders');
                    
                },
                error: function()
                {
                    alert("Something went wroung");
                }
            });
        });
    });
    $('.clsAssignDeliveryBoy').on('click',function(){ 
        var orderid=$(this).data('id');
        $("#largeModalAssignDeliveryBoy").modal();
        $('.form_assign_dboy input#orderid').val(orderid).parent().addClass('focused');
       // $(".selectpicker").selectpicker("refresh"); 
    });
} );
</script>