 <section class="content">
    <div class="container-fluid">     
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Vendor Payment Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddPayment" title="Add Payment">
                                <i class="material-icons">add</i>
                            </button>
                        </h2>
                    </div>
                    <div class="body">             
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="CourseTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vendor Name</th>
                                        <th>Mobile No</th>
                                        <th>Amount</th>
                                        <th>BillDate</th>
                                        <th>Status</th>
                                        <th>Change Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>ID</th>
                                    <th>Vendor Name</th>
                                    <th>Mobile No</th>
                                    <th>Amount</th>
                                    <th>BillDate</th>
                                    <th>Status</th>
                                    <th>Change Status</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="VendorPaymentDetails">
                                <?php $i=1;if(!empty($VendorPaymentDetails)){
                                    foreach($VendorPaymentDetails as $payment){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td width="15%"><?php echo $payment->VName;?></td>
                                        <td><?php echo $payment->VMobileno;?></td>                                        
                                        <td><?php echo $payment->Amount;?></td> 
                                        <td><?php echo date("jS M, Y h:i:m a", strtotime($payment->Billdate));?></td>
                                        <td>
                                            <?php if($payment->Status == 'PaidRequestPending'){?>
                                                <span class="label label-primary">Payment Paid Request</span>
                                            <?php }elseif($payment->Status == 'NotPaid'){?>
                                                <span class="label label-danger">Not Paid</span>
                                            <?php }elseif($payment->Status == 'Paid'){?>
                                                <span class="label label-success">Paid</span>
                                            <?php }?>
                                        </td>                                        
                                        <td>
                                        <?php if($payment->Status == 'PaidRequestPending'){?>
                                            <a href="#" class="chkPaymnentStatus" data-id="<?php echo $payment->Vbid;?>" data-status="Accepted"><i class="glyphicon glyphicon-ok icon-white"  title="AcceptRequest" data-toggle="tooltip"></i></a>
                                            <a href="#" class="chkPaymnentStatus" data-id="<?php echo $payment->Vbid;?>" data-status="Rejected"><i class="glyphicon glyphicon-remove icon-white"  title="RejectRequest" data-toggle="tooltip"></i></a>
                                        <?php }else{?>
                                        -----
                                        <?php }?>                                          
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
    <div class="modal fade" id="largeModalAddPayment" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Payment</h4>
                </div>
                    <form id="form_add_payment" method="post" action="<?php echo base_url();?>Admin/AddPayment" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker selectcity" data-live-search="true" id="txtcityid" name="txtcityid" required>
                                            <option value="">Select City</option>
                                            <?php if(!empty($CityDetails)){
                                                foreach($CityDetails as $city){?>
                                                    <option value="<?php echo $city->city_id;?>"><?php echo $city->city_name;?></option>
                                            <?php }}?>
                                        </select> 
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6 DivfetchVendor collapse">
                               
                            </div>                        
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" id="amount" name="amount" value="" required >
                                        <label class="form-label">Amount<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control datepicker" id="billdate" name="billdate" value="" required >
                                        <label class="form-label">Billdate<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                        
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" data-live-search="true" id="paymenttype" name="paymenttype" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque </option>
                                            <option value="Online">Online</option>
                                        </select> 
                                        <div class="help-info">Select Vendors<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6 collapse" id="Divchequeno">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="chequeno" name="chequeno" value="" >
                                        <label class="form-label">Cheque No <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 collapse" id="Divtransactionid">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="transactionid" name="transactionid" value="" >
                                        <label class="form-label">Trasaction Id <b style="color:red">*</b></label>
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
        $('.chkPaymnentStatus').on('click',function(){
            var status = $(this).data('status');
            var vbid = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url();?>Admin/ChangePaymentStatus",
                method:"post",
                data: {'vbid' : vbid,'status' : status},
                dataType: 'json',
                success: function(result)
                {                       
                    if(status == 'Accepted')
                    { 
                    swal({
                            title: "Accepted!",
                            text: "Payment Paid Request Accepted!",
                            type: "success",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                                location.replace('VendorPayments');
                    });
                    }
                else 
                {
                    swal({
                            title: "Rejected!",
                            text: "Payment Paid Request Rejected!",
                            type: "error",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                                location.replace('VendorPayments');
                    });      
                }
                },
                error: function()
                {
                    alert("Something Went Wroung!");
                }
            });              
        });
        $('.selectcity').on('change',function(){ 
            var cityid=$(this).val(); 
            if(cityid == "")
            {
                $('.DivfetchVendor').addClass('collapse');
            }
            else
            {
                $('.DivfetchVendor').removeClass('collapse');
            }
            $.ajax({

                url: "<?php echo base_url();?>Admin/GetVendor",
                method:"post",
                data: {'cityid' : cityid},
                success: function(result)
                {
                    $('.DivfetchVendor').html();
                    $('.DivfetchVendor').html(result);
                    $(".selectpicker").selectpicker("refresh");          
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });
        });
        $('#form_add_payment').validate({        
          
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        });
        $('#paymenttype').on('change',function(){
            var $payment_status = $(this).val(); 
            if($payment_status == 'Cheque')
            {
                $('#Divchequeno').removeClass('collapse');
                $('#Divtransactionid').addClass('collapse');
            }
            else if($payment_status == 'Online')
            {
                $('#Divtransactionid').removeClass('collapse'); 
                $('#Divchequeno').addClass('collapse');
            } 
            else{
                $('#Divchequeno').addClass('collapse');
                $('#Divtransactionid').addClass('collapse');
            }  
        });
    });
</script>