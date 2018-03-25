<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Coupon Code Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddCouponCode" title="AddCouponCode">
                            <i class="material-icons">add</i>
                            </button>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Coupon Code</th>
                                        <th>Activate Date</th>
                                        <th>Expired Date</th>
                                        <th>Terms</th>
                                        <th>Shopping Range</th>
                                        <th>Discount Amount</th>                                       
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Coupon Code</th>
                                        <th>Activate Date</th>
                                        <th>Expired Date</th>
                                        <th>Terms</th>
                                        <th>Shopping Range</th>
                                        <th>Discount Amount</th>                                       
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="CouponCodeDetails">
                                <?php $i=1;if(!empty($CouponCodeDetails)){
                                    foreach($CouponCodeDetails as $coupon){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $coupon->coupon_code;?></td>
                                        <td><?php echo $coupon->activate_date;?></td>
                                        <td><?php echo $coupon->expired_date;?></td>	  
                                        <td><div style="width:100%; max-height:60px; overflow:auto"><?php echo $coupon->terms;?></div></td>
                                        <td><?php echo $coupon->shopping_range;?></td>
                                        <td><?php echo $coupon->discount_amt;?> <?php if($coupon->discount_amt_type == "R"){echo "Rs";}elseif($coupon->discount_amt_type == "P"){echo "%";}?></td>
                                        <td>
                                            <a href="#" class="clsEditCouponCode" id="idEditCouponCode" title="Edit" data-toggle="modal" data-target="#largeModalEditCouponCode" data-id="<?php echo $coupon->coupon_id;?>" data-couponcode="<?php echo $coupon->coupon_code;?>" data-actdate="<?php echo date('D d M Y H:m:s',strtotime($coupon->activate_date));?>" data-expdate="<?php echo date('D d M Y H:m:s',strtotime($coupon->expired_date));?>" data-terms="<?php echo $coupon->terms;?>" data-shoprange="<?php echo $coupon->shopping_range;?>" data-disamt="<?php echo $coupon->discount_amt;?>" data-disamttype="<?php echo $coupon->discount_amt_type;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteCouponCode" id="idDeleteCouponCode" title="Delete" data-id="<?php echo $coupon->coupon_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Coupon Code" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAddCouponCode" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Coupon Code</h4>
                </div>
                <form class="form_add_coupon_code" id="form_add_coupon_code" method="post" action="<?php echo base_url();?>Admin/AddCouponCode" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="txtCouponCodename" name="txtCouponCodename" value="<?php   $today = date("Ymd");$this->load->helper('string');$rand = strtoupper(random_string('alnum',5));$unique = $rand . $today;if($NextCouponId[0]->max_id){echo $unique.(($NextCouponId[0]->max_id)+1);}else{echo $unique;} ?>" required readonly>
                                        <label class="form-label">Coupon Code<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control only_number" id="txtshoppingrangeamt" name="txtshoppingrangeamt" value="" required>
                                        <label class="form-label">Shopping Range<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                         
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control datetimepicker" id="txtactivedate" name="txtactivedate" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Activate Date<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control datetimepicker" id="txtexpirydate" name="txtexpirydate" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Expiried Date<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>                          
                        </div>   
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="txtdiscountamt" name="txtdiscountamt" value="" required >
                                        <label class="form-label">Discount Amount<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" data-live-search="true" id="txtdiscounttype" name="txtdiscounttype" required>
                                            <option value="">Select Discount Type</option>
                                            <option value="R">Rs</option>
                                            <option value="P">% </option>
                                        </select> 
                                        <div class="help-info">Select Discount Type<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>                           
                        </div>  
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" class="form-control" id="txtterm" name="txtterm" required ></textarea>
                                        <label class="form-label">Term<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>                           
                        </div>                                                      
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" type="submit" id="btnSubmit">SUBMIT</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
    <div class="modal fade" id="largeModalEditCouponCode" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Update Coupon Code</h4>
                </div>
                <form class="form_edit_coupon_code" id="form_edit_coupon_code" method="post" action="<?php echo base_url();?>Admin/EditCouponCode" enctype="multipart/form-data"> 
                    <input type="hidden" name="couponid" id="couponid" value="">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="edittxtCouponCodename" name="edittxtCouponCodename" value="<?php   $today = date("Ymd");$this->load->helper('string');$rand = strtoupper(random_string('alnum',5));$unique = $rand . $today;if($NextCouponId[0]->max_id){echo $unique.(($NextCouponId[0]->max_id)+1);}else{echo $unique;} ?>" required readonly>
                                        <label class="form-label">Coupon Code<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="edittxtshoppingrangeamt" name="edittxtshoppingrangeamt" value="" required>
                                        <label class="form-label">Shopping Range<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                         
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control datetimepicker" id="edittxtactivedate" name="edittxtactivedate" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Activate Date<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control datetimepicker" id="edittxtexpirydate" name="edittxtexpirydate" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Expiried Date<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>                          
                        </div>   
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="edittxtdiscountamt" name="edittxtdiscountamt" value="" required >
                                        <label class="form-label">Discount Amount<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtdiscounttype" name="edittxtdiscounttype" required>
                                            <option value="">Select Discount Type</option>
                                            <option value="R">Rs</option>
                                            <option value="P">% </option>
                                        </select> 
                                        <div class="help-info">Select Discount Type<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>                           
                        </div>  
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" class="form-control" id="edittxtterm" name="edittxtterm" required ></textarea>
                                        <label class="form-label">Term<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>                           
                        </div>                                                      
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" type="submit" id="btnSubmit">SUBMIT</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
</section>
<script>

    $(document).ready(function($){
        var startDate;
       //Datetimepicker plugin
        $('#txtactivedate').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY HH:mm:ss',
            clearButton: true,
            weekStart: 1,
            minDate: new Date(),         
        }).on('change', function (e, date) {
        startDate = $("#txtactivedate").val();
           
        });
        $('#txtexpirydate').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY HH:mm:ss',
            clearButton: true,
            weekStart: 1,
            minDate: new Date(),         
        }).on('change', function (e, date) {
            var endDate = $("#txtexpirydate").val();
            var st = new Date(startDate);
            var ed = new Date(endDate);
         
            if(st > ed){
                   swal('Please select expriry date greater than activate date!');
             }
             else{
                 //alert("hii");
             }
            
        });
        $('.chkblock').on('change',function(){
            $(this).val(this.checked ? "0" : "1");
            var blockValue = $(this).val();
            var CouponCodeid = $(this).data('id');                             
            $.ajax({
                url: "<?php echo base_url();?>Admin/BlokUnblockCouponCode",
                method:"post",
                data: {'blockValue' : blockValue,'said' : CouponCodeid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.blockval == 0)
                    {                            
                        swal({
                                title: "Unblocked!",
                                text: "Coupon Code unblocked!",
                                type: "success",
                                timer: 2000,
                                closeOnConfirm: true
                            }, function () {
                                
                            });
                            
                    }
                    else
                    {
                        swal({
                            title: "Blocked!",
                            text: "Coupon Code blocked!",
                            type: "error",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                            
                        });
                        
                    } 
                    
                                
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });                 
        });   
        $('#form_add_coupon_code').validate({
          
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        });  
        $('#form_edit_coupon_code').validate({        
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        }); 
        $('.clsEditCouponCode').on('click',function(){         
            var said = $(this).data("id");
            var couponcode=$(this).data('couponcode');
            var actdate=$(this).data('actdate');
            var expdate=$(this).data('expdate');
            var terms=$(this).data('terms');
            var shoprange=$(this).data('shoprange');
            var terms=$(this).data('terms');
            var disamt=$(this).data('disamt');
            var terms=$(this).data('terms');
            var disamt=$(this).data('disamt');
            var disamttype=$(this).data('disamttype');
       
            $('.form_edit_coupon_code input#couponid').val(said).parent().addClass('focused');                
            $('.form_edit_coupon_code input#edittxtCouponCodename').val(couponcode).parent().addClass('focused');
            $('.form_edit_coupon_code input#edittxtshoppingrangeamt').val(shoprange).parent().addClass('focused');
            $('.form_edit_coupon_code input#edittxtactivedate').val(actdate).parent().addClass('focused');
            $('.form_edit_coupon_code input#edittxtexpirydate').val(expdate).parent().addClass('focused'); 
            $('.form_edit_coupon_code input#edittxtdiscountamt').val(disamt).parent().addClass('focused');          
            $('.form_edit_coupon_code textarea#edittxtterm').val(terms).parent().addClass('focused'); 
            $('.form_edit_coupon_code select#edittxtdiscounttype').val(disamttype).parent().addClass('focused');
            $(".selectpicker").selectpicker("refresh");
        });
        $('.clsDeleteCouponCode').on('click',function(){
                var couponid=$(this).data('id');
                swal({
                title: "Are you sure?",
                text: "You will not be able to recover this city record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/DeleteCouponCode",
                    method:"post",
                    data: {'couponid' : couponid},
                    dataType: 'json',
                    success: function(result)
                    {
                        if(result.success == 'true')
                        {                        
                           swal("Deleted!", "Your Coupon Code record deleted successfully!", "success");                            
                        }
                        else
                        {
                            swal("Error!", "Something went wroung!", "error");
                        }
                    location.replace('CouponCode');
                        
                    },
                    error: function()
                    {
                        alert("Something went wroung");
                    }
                });
            });
        });   
        $('#form_add_coupon_code').on('submit',function(e){
            var endDate = $("#txtexpirydate").val();
            var st = new Date(startDate);
            var ed = new Date(endDate);
        
            if(st > ed){
                   swal('Please select expriry date greater than activate date!');
             }
             else{
                // alert("hii");
             }
        });
    });
</script>