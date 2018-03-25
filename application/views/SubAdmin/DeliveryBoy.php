<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Delivery Boy Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddDeliveryBoy" title="AddDeliveryBoy">
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
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>	
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="DeliveryBoyDetails">
                                <?php $i=1;if(!empty($DeliveryBoyDetails)){
                                    foreach($DeliveryBoyDetails as $deliveryboy){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $deliveryboy->name;?></td>
                                        <td><?php echo $deliveryboy->mobile_no;?></td>
                                        <td><?php echo $deliveryboy->email;?></td>
                                        <td>
                                            <a href="#" class="clsEditDeliveryBoy" id="idEditDeliveryBoy" title="Edit" data-toggle="modal" data-target="#largeModalEditDeliveryBoy" data-id="<?php echo $deliveryboy->del_id;?>" data-name="<?php echo $deliveryboy->name;?>" data-mobileno="<?php echo $deliveryboy->mobile_no;?>" data-email="<?php echo $deliveryboy->email;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteDeliveryBoy" id="idDeleteDeliveryBoy" title="Delete" data-id="<?php echo $deliveryboy->del_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Vendor" data-toggle="tooltip"></i></a>
                                            <!--div class="row clearfix">
                                                <div class="col-xs-12 col-sm-6 align-right">
                                                    <div class="switch panel-switch-btn">                                                         
                                                        <label>
                                                            <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $deliveryboy->block;?>" data-id="<?php echo $deliveryboy->del_id;?>"
                                                                <?php if($deliveryboy->block == '0'){?>checked
                                                                <?php }?>><span class="lever switch-col-cyan"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div-->
                                            <?php if($deliveryboy->verified == 1){?><span class="label label-primary">Verified</span> <?php }else{?><span class="label label-warning">UnVerified</span><?php } ?>
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
    <div class="modal fade" id="largeModalAddDeliveryBoy" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Delivery Boy</h4>
                </div>
                <form class="form_add_delivery_boy" id="form_add_delivery_boy" method="post" action="<?php echo base_url();?>SubAdmin/AddDeliveryBoy" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="txtdeliveryboyname" name="txtdeliveryboyname" value="" required style="text-transform: capitalize;">
                                        <label class="form-label">Name<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control only_number" id="txtmobileno" name="txtmobileno" value="" required >
                                        <label class="form-label">Mobile No<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                         
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" id="txtemail" name="txtemail" value="" required >
                                        <label class="form-label">Email<b style="color:red">*</b></label>                            
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
    <div class="modal fade" id="largeModalEditDeliveryBoy" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Edit Delivery Boy</h4>
                </div>
                <form class="form_edit_delivery_boy" id="form_edit_delivery_boy" method="post" action="<?php echo base_url();?>SubAdmin/EditDeliveryBoy" enctype="multipart/form-data"> 
                    <input type="hidden" name="did" id="did" value="">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="edittxtdeliveryboyname" name="edittxtdeliveryboyname" value="" required style="text-transform: capitalize;">
                                        <label class="form-label">Name<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control only_number" id="edittxtmobileno" name="edittxtmobileno" value="" required >
                                        <label class="form-label">Mobile No<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                         
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" id="edittxtemail" name="edittxtemail" value="" required >
                                        <label class="form-label">Email<b style="color:red">*</b></label>                            
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
    /*$('.chkblock').on('change',function(){
        $(this).val(this.checked ? "0" : "1");
        var blockValue = $(this).val();
        var deliveryboyid = $(this).data('id');                             
        $.ajax({
            url: "<?php echo base_url();?>SubAdmin/BlokUnblockDeliveryBoy",
            method:"post",
            data: {'blockValue' : blockValue,'deliveryboyid' : deliveryboyid},
            dataType: 'json',
            success: function(result)
            {
                if(result.blockval == 0)
                {                            
                    swal({
                            title: "Unblocked!",
                            text: "Delivery Boy unblocked!",
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
                        text: "Delivery Boy blocked!",
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
    });*/
    $('#form_add_delivery_boy').validate({        
        rules:{
            txtmobileno:{maxlength:10,minlength:10,remote:{url: "<?php echo base_url();?>SubAdmin/CheckMobileNoExist",type:"post",
                    data:{
                    mobilenoval:function(){return $("#txtmobileno").val()},
                    }}
                }},
        messages:{
                    txtmobileno:{maxlength:"Please enter 10 digits mobile number!",minlength:"Please enter 10 digits mobile number!",remote:"This Mobile Number already exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });  
    $('#form_edit_delivery_boy').validate({        
        rules:{
            edittxtmobileno:{maxlength:10,minlength:10,remote:{url: "<?php echo base_url();?>SubAdmin/EditCheckMobileNoExist",type:"post",
                    data:{
                    delid:function(){return $("#did").val()},
                    mobilenoval:function(){return $("#edittxtmobileno").val()},
                    }}
                }},
        messages:{
            edittxtmobileno:{maxlength:"Please enter 10 digits mobile number!",minlength:"Please enter 10 digits mobile number!",remote:"This Mobile Number already exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    }); 
    $('.clsEditDeliveryBoy').on('click',function(){       
        var did = $(this).data("id");
        var name=$(this).data('name');
        var email=$(this).data('email');
        var mobileno=$(this).data('mobileno');
    
        $('.form_edit_delivery_boy input#did').val(did).parent().addClass('focused');                
        $('.form_edit_delivery_boy input#edittxtdeliveryboyname').val(name).parent().addClass('focused');
        $('.form_edit_delivery_boy input#edittxtmobileno').val(mobileno).parent().addClass('focused');
        $('.form_edit_delivery_boy input#edittxtemail').val(email).parent().addClass('focused'); 
    });
    $('.clsDeleteDeliveryBoy').on('click',function(){
            var did=$(this).data('id');
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
                url: "<?php echo base_url();?>SubAdmin/DeleteDeliveryBoy",
                method:"post",
                data: {'did' : did},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                    
                        if(result.chkdeliveryboypresent == 1)
                        {
                            swal("Can Not Deleted!", "Your delivery boy record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your delivery boy record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('DeliveryBoy');
                    
                },
                error: function()
                {
                    alert("Something went wroung");
                }
            });
        });
    });   
});
</script>