<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Assigned Coupon Code
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAssignCouponCode" title="AssignCouponCode">
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
                                        <th>User Details</th>
                                        <th>Coupon Code</th>
                                        <th>Activate Date</th>
                                        <th>Expired Date</th>
                                        <th>Shopping Range</th>
                                        <th>Discount Amount</th>                                       
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>User Details</th>
                                        <th>Coupon Code</th>
                                        <th>Activate Date</th>
                                        <th>Expired Date</th>
                                        <th>Shopping Range</th>
                                        <th>Discount Amount</th>                                       
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="AssignCouponDetails">
                                <?php $i=1;if(!empty($AssignCouponDetails)){
                                    foreach($AssignCouponDetails as $coupon){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td>Name: <?php echo $coupon->name;?><br>
                                            Mobile No: <?php echo $coupon->mobile_no;?><br>
                                        </td>
                                        <td><?php echo $coupon->coupon_code;?></td>
                                        <td><?php echo $coupon->activate_date;?></td>
                                        <td><?php echo $coupon->expired_date;?></td>	  
                                        <td><?php echo $coupon->shopping_range;?></td>
                                        <td><?php echo $coupon->discount_amt;?> <?php if($coupon->discount_amt_type == "R"){echo "Rs";}elseif($coupon->discount_amt_type == "P"){echo "%";}?></td>
                                        <td>
                                            <a href="#" class="clsEditAssignedCoupon" id="idEditAssignedCoupon" title="Edit" data-toggle="modal" data-target="#largeModalEditAssignCouponCode" data-id="<?php echo $coupon->ccassign_id;?>" data-uid="<?php echo $coupon->uid;?>" data-couponcodeid="<?php echo $coupon->coupon_id;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteAssignedCoupon" id="idDeleteAssignedCoupon" title="Delete" data-id="<?php echo $coupon->ccassign_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Coupon Code" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAssignCouponCode" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Coupon Code</h4>
                </div>
                <form class="form_assign_coupon_code" id="form_assign_coupon_code" method="post" action="<?php echo base_url();?>Admin/AddAssinedCouponCode" enctype="multipart/form-data"> 
                    <div class="modal-body">                      
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" data-live-search="true" id="txtuserid" name="txtuserid" required>
                                            <option value="">Select User</option>
                                            <?php if(!empty($AllUsers)){
                                                foreach($AllUsers as $user){?>
                                                    <option value="<?php echo $user->uid;?>"><?php echo $user->name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select User<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" data-live-search="true" id="txtcoupencodeid" name="txtcoupencodeid" required>
                                            <option value="">Select Coupon Code</option>
                                            <?php if(!empty($CouponCodeDetails)){
                                                foreach($CouponCodeDetails as $code){?>
                                                    <option value="<?php echo $code->coupon_id;?>"><?php echo $code->coupon_code;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select Coupon Code<b style="color:red">*</b></div>                           
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
    <div class="modal fade" id="largeModalEditAssignCouponCode" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Update Coupon Code</h4>
                </div>
                <form class="form_edit_assign_coupon_code" id="form_edit_assign_coupon_code" method="post" action="<?php echo base_url();?>Admin/EditAssinedCouponCode" enctype="multipart/form-data"> 
                    <input type="hidden" name="assignccid" id="assignccid" value="">
                    <div class="modal-body">                      
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtuserid" name="edittxtuserid" required>
                                            <option value="">Select User</option>
                                            <?php if(!empty($AllUsers)){
                                                foreach($AllUsers as $user){?>
                                                    <option value="<?php echo $user->uid;?>"><?php echo $user->name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select User<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtcoupencodeid" name="edittxtcoupencodeid" required>
                                            <option value="">Select Coupon Code</option>
                                            <?php if(!empty($CouponCodeDetails)){
                                                foreach($CouponCodeDetails as $code){?>
                                                    <option value="<?php echo $code->coupon_id;?>"><?php echo $code->coupon_code;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select Coupon Code<b style="color:red">*</b></div>                           
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
    $('#form_assign_coupon_code').validate({
        
        rules:{
            txtcoupencodeid:{remote:{url: "<?php echo base_url();?>Admin/AlreadyUsedCoupen",type:"post",
                    data:{
                    useridval:function(){return $("#txtuserid").val()},
                    couponidval:function(){return $("#txtcoupencodeid").val()},
                    }}
                }},
        messages:{
            txtcoupencodeid:{remote:"This Coupen already used for this user!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_assign_coupon_code').validate({
        
        rules:{
            edittxtcoupencodeid:{remote:{url: "<?php echo base_url();?>Admin/EditAlreadyUsedCoupen",type:"post",
                    data:{
                    assignccidval:function(){return $("#assignccid").val()},
                    useridval:function(){return $("#edittxtuserid").val()},
                    couponidval:function(){return $("#edittxtcoupencodeid").val()},
                    }}
                }},
        messages:{
            edittxtcoupencodeid:{remote:"This Coupen already used for this user!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditAssignedCoupon').on('click',function(){ 
        var assignccid=$(this).data('id');
        var uid = $(this).data("uid");
        var couponcodeid = $(this).data("couponcodeid");
      
        $('.form_edit_assign_coupon_code input#assignccid').val(assignccid).parent().addClass('focused');                
        $('.form_edit_assign_coupon_code select#edittxtuserid').val(uid).parent().addClass('focused');
        $('.form_edit_assign_coupon_code select#edittxtcoupencodeid').val(couponcodeid).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
    });
    $('.clsDeleteAssignedCoupon').on('click',function(){
        var assignccid=$(this).data('id');  
           
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
                url: "<?php echo base_url();?>Admin/DeleteAssignedCoupon",
                method:"post",
                data: {'assignid' : assignccid},
                dataType: 'json',
                success: function(result)
                {
                   
                    if(result.success == 'true')
                    {
                       
                        swal("Deleted!", "Your area record deleted successfully!", "success");
                        location.replace('AssignedCoupons');
                      
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                  
                    
                },
                error: function()
                {
                    alert("This Event is in Use So you can't Delete it");
                }
            });
        });
    });
});
</script>
