<section class="content">
        <div class="container-fluid">       
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Rejected Order Details
                            </h2>
                        </div>
                        <div class="body">
                            <!--div class="demo-radio-button">
                                    <input name="orders" type="radio" class="with-gap radio_orders" id="radio_1" value="NewOrders">
                                    <label for="radio_1">Pending Orders</label>
                                    <input name="orders" type="radio" id="radio_2" class="with-gap radio_orders" value="CompletedOrders">
                                    <label for="radio_2">Confirmed Orders</label>
                                    <input name="orders" type="radio" id="radio_3" class="with-gap radio_orders" value="CriticalOrders">
                                    <label for="radio_3">Delivered Orders</label>
                                    <input name="orders" type="radio" id="radio_4" class="with-gap radio_orders" value="FailedOrders">
                                    <label for="radio_4">Completed Orders</label>                                  
                            </div-->                                                   
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="OrderDetailsTable">
                                    <thead>
                                        <tr>
                                           <!--th>Sr.No</th-->
                                            <th>Order Id</th>
                                            <th>Delivery Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>City</th>                                          
                                            <th>Payment Type</th>
                                            <th>Delivery Boy Details</th>
                                            <th>Reson</th>   
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
                                        <th>City</th>                                          
                                        <th>Payment Type</th>
                                        <th>Delivery Boy Details</th>
                                        <th>Reson</th>   
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
                                            <td><?php echo $order->city_name;?></td>
                                            <td><span class="label label-success"><?php echo $order->Paymentname;?></span></td>
                                            <td>
                                            <?php if($order->dname){?>
                                                <?php echo $order->dname;?>,<br>
                                                <?php echo $order->dmobile_no;?><br>
                                                <?php }else{ echo "------";}?>     
                                            </td>                                         
                                            <td>
                                                <div style="width:100%; max-height:60px; overflow:auto"> 
                                                    <?php echo $order->reject_reson;?>
                                                </div>                                                  
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
            </form>                    
        </div>
    </div>
</div>
<script>
 $(document).ready(function($){
    $('.radio_orders').on('change',function(){ 
        var radio_val=$(this).val();
        // alert(radio_val);
        $.ajax({
            url: "<?php echo base_url();?>Admin/GetOrderstatusResult",
            method:"post",
            data: {'orderstatus' : radio_val},
            success: function(result)
            {
                $('.table-responsive').html();
                $('.table-responsive').html(result);                                
            },
            error: function()
            {
                alert("This Banners is in Use So you can't Delete it");
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
});

</script>