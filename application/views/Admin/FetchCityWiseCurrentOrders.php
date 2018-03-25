<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="OrderDetailsTable">
    <thead>
        <tr>
            <!--th>Sr.No</th-->
            <th>Order Id</th>
            <th>Delivery Date</th>
            <th>Items</th>
                <!--th>Delivery Charges</th-->
            <th>Total</th>
            <th>Invoice No</th>                                          
            <th>Payment Type</th>
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
        <!--th>Delivery Charges</th-->
        <th>Total</th>
        <th>Invoice No</th>                                          
        <th>Payment Type</th>
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
            <td>
                <?php $total=($order->total)-((($order->total)*($order->discount/100))+$order->walletpay);
                    echo $total;
                ?>
            </td>
            <td><?php echo $order->invoiceno;?></td>
            <td><span class="label label-success"><?php echo $order->Paymentname;?></span></td>
            <td>
            <?php if($order->dname){?>
                <?php echo $order->dname;?>,<br>
                <?php echo $order->dmobile_no;?><br>
                <?php }else{ echo "------";}?>                                              
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
                <a href="#" class="Changestatus <?php if($order->status=="1"|| $order->status=="2" || $order->status=="3" || $order->status=="4" || $order->status=="5" || $order->status=="5"){?>collapse<?php }?>" id="Changestatus" title="Pending"  data-id="<?php echo $order->order_id;?>" data-status="1" > <span class="label label-default">Pending</span></a>
                <a href="#" class="Changestatus <?php if($order->status=="2" || $order->status=="3" || $order->status=="4" || $order->status=="5" || $order->status=="6"){?>collapse<?php }?>" id="Changestatus" title="Confirmed"  data-id="<?php echo $order->order_id;?>" data-status="2" ><span class="label label-primary">Confirmed</span></a>
                <a href="#" class="Changestatus <?php if($order->status=="3" || $order->status=="4" || $order->status=="5" || $order->status=="6"){?>collapse<?php }?>" id="Changestatus" title="Shipping"  data-id="<?php echo $order->order_id;?>" data-status="3" ><span class="label label-info">Shipped</span></a>
                <a href="#" class="Changestatus <?php if($order->status=="4" || $order->status=="5" || $order->status=="6"){?>collapse<?php }?>" id="Changestatus" title="Delivered"  data-id="<?php echo $order->order_id;?>" data-status="4" ><span class="label label-warning">Delivered</span></a>
                <a href="#" class="Changestatus <?php if($order->status=="5" || $order->status=="6"){?>collapse<?php }?>" id="Changestatus" title="Completed "  data-id="<?php echo $order->order_id;?>" data-status="5" ><span class="label label-success">Completed</span></a>
                <a href="#" class="Changestatus <?php if($order->status=="6"){?>collapse<?php }?>" id="Changestatus" title="Rejected "  data-id="<?php echo $order->order_id;?>" data-status="6" ><span class="label label-danger">Rejected</span></a>
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
            url: "<?php echo base_url();?>Admin/ChangeOrderStatus",
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
            $.ajax({
            url: "<?php echo base_url();?>Admin/GenerateInvoice",
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
} );
</script>