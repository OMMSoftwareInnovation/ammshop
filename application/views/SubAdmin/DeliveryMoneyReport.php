<section class="content">
        <div class="container-fluid">       
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                             Delivery Money Report
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="OrderDetailsTable">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Order Id</th>
                                            <th>Deliverd Date</th>
                                            <th>Items</th>
                                            <th>Delivery Charges</th>
                                            <th>Total</th>
                                            <th>Payment Type</th>
                                            <th>Delivery Boy Details</th>
                                            <th>Status</th>                                                     

                                        </tr>

                                    </thead>

                                    <tfoot>

                                        <tr>
                                        <th>Sr.No</th>
                                        <th>Order Id</th>
                                        <th>Delivery Date</th>
                                        <th>Items</th>
                                        <th>Delivery Charges</th>
                                        <th>Total</th>
                                        <th>Payment Type</th>
                                        <th>Delivery Boy Details</th>
                                        <th>Status</th>         
                                        </tr>
                                    </tfoot>
                                    <tbody ID="OrderDetails">
                                    <?php $i=1;if(!empty($DeliveryMoneyDetails)){
                                        foreach($DeliveryMoneyDetails as $order){?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $order->orderid_no;?></td>
                                            <td><?php echo $order->delivered_date;?></td>
                                            <td><?php 
                                                $itemcount=explode(',',$order->vi_id);
                                                echo(count($itemcount));
                                                ?>
                                            </td>
                                            <td><?php echo $order->delivery_charge;?></td>
                                            <td>
                                                <?php $total=($order->total)-((($order->total)*($order->discount/100))+$order->walletpay);
                                                    echo $total;
                                                ?>
                                            </td>
                                            <td><span class="label label-success"><?php echo $order->Paymentname;?></span></td>
                                            <td>
                                                <?php if($order->name){?>
                                                <?php echo $order->name;?>,<br>
                                                <?php echo $order->mobile_no;?><br>
                                                <?php }else{ echo "------";}?> 
                                            </td>                                             
                                            <td>
                                               
                                              <span class="label label-warning">Completed</span>                                                  
                                                                                                     
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