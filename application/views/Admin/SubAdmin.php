<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sub Admin Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddSubAdmin" title="AddSubAdmin">
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
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="SubAdminDetails">
                                <?php $i=1;if(!empty($SubAdminDetails)){
                                    foreach($SubAdminDetails as $subadmin){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $subadmin->sub_admin_name;?></td>
                                        <td><?php echo $subadmin->mobile_no;?></td>
                                        <td><?php echo $subadmin->email;?></td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto">
                                                <b>Address:</b> <?php echo $subadmin->address;?><br>
                                                <b>Area:</b> <?php echo $subadmin->area_name;?><br>
                                                <b>City:</b> <?php echo $subadmin->city_name;?><br>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="clsEditSubAdmin" id="idEditSubAdmin" title="Edit" data-toggle="modal" data-target="#largeModalEditSubAdmin" data-id="<?php echo $subadmin->sub_admin_id;?>" data-name="<?php echo $subadmin->sub_admin_name;?>" data-mobileno="<?php echo $subadmin->mobile_no;?>" data-email="<?php echo $subadmin->email;?>" data-address="<?php echo $subadmin->address;?>" data-cityid="<?php echo $subadmin->city_id;?>" data-areaid="<?php echo $subadmin->area_id;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteSubAdmin" id="idDeleteSubAdmin" title="Delete" data-id="<?php echo $subadmin->sub_admin_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Vendor" data-toggle="tooltip"></i></a>
                                            <div class="row clearfix">
                                                <div class="col-xs-12 col-sm-6 align-right">
                                                    <div class="switch panel-switch-btn">                                                         
                                                        <label>
                                                            <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $subadmin->block;?>" data-id="<?php echo $subadmin->sub_admin_id;?>"
                                                                <?php if($subadmin->block == '0'){?>checked
                                                                <?php }?>><span class="lever switch-col-cyan"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
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
    <div class="modal fade" id="largeModalAddSubAdmin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Sub Admin</h4>
                </div>
                <form class="form_add_sub_admin" id="form_add_sub_admin" method="post" action="<?php echo base_url();?>Admin/AddSubAdmin" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="txtsubadminname" name="txtsubadminname" value="" required style="text-transform: capitalize;">
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
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" class="form-control" id="txtaddress" name="txtaddress" required ></textarea>
                                        <label class="form-label">Address<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>                          
                        </div>   
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectcity selectpicker" data-live-search="true" id="txtcityid" name="txtcityid" required>
                                            <option value="">Select City</option>
                                            <?php if(!empty($CityDetails)){
                                                foreach($CityDetails as $city){?>
                                                    <option value="<?php echo $city->city_id;?>"><?php echo $city->city_name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select City<b style="color:red">*</b></div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6 DivFetchArea">
                                
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
    <div class="modal fade" id="largeModalEditSubAdmin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Edit Sub Admin</h4>
                </div>
                <form class="form_edit_sub_admin" id="form_edit_sub_admin" method="post" action="<?php echo base_url();?>Admin/EditSubAdmin" enctype="multipart/form-data"> 
                    <input type="hidden" name="said" id="said" value="">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="edittxtsubadminname" name="edittxtsubadminname" value="" required style="text-transform: capitalize;">
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
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" class="form-control" id="edittxtaddress" name="edittxtaddress" required ></textarea>
                                        <label class="form-label">Address<b style="color:red">*</b></label>                            
                                    </div>
                                </div>
                            </div>                           
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick editselectcity selectpicker" data-live-search="true" id="edittxtcityid" name="edittxtcityid" required>
                                            <option value="">Select City</option>
                                            <?php if(!empty($CityDetails)){
                                                foreach($CityDetails as $city){?>
                                                    <option value="<?php echo $city->city_id;?>"><?php echo $city->city_name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select City<b style="color:red">*</b></div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6 editDivFetchArea">
                                
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
        $('.chkblock').on('change',function(){
            $(this).val(this.checked ? "0" : "1");
            var blockValue = $(this).val();
            var SubAdminid = $(this).data('id');                             
            $.ajax({
                url: "<?php echo base_url();?>Admin/BlokUnblockSubAdmin",
                method:"post",
                data: {'blockValue' : blockValue,'said' : SubAdminid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.blockval == 0)
                    {                            
                        swal({
                                title: "Unblocked!",
                                text: "Sub Admin unblocked!",
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
                            text: "Sub Admin blocked!",
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
        $('.selectcity').on('change',function(){ 
            var cityid=$(this).val(); 
            if(cityid == "")
            {
                $('.DivFetchArea').addClass('collapse');
                $('.DivCategory').addClass('collapse');
            }
            else
            {
                $('.DivFetchArea').removeClass('collapse');
                $('.DivCategory').removeClass('collapse');
            }
            $.ajax({

                url: "<?php echo base_url();?>Admin/Getarea",
                method:"post",
                data: {'cityid' : cityid},
                success: function(result)
                {
                    $('.DivFetchArea').html();
                    $('.DivFetchArea').html(result);
                    $(".selectpicker").selectpicker("refresh");          
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });
        }); 
        $('.editselectcity').on('change',function(){ 
            var cityid=$(this).val(); 
            if(cityid == "")
            {
                $('.editDivFetchArea').addClass('collapse');
                $('.editDivCategory').addClass('collapse');
            }
            else
            {
                $('.editDivFetchArea').removeClass('collapse');
                $('.editDivCategory').removeClass('collapse');
            }
            $.ajax({

                url: "<?php echo base_url();?>Admin/Getarea",
                method:"post",
                data: {'cityid' : cityid},
                success: function(result)
                {
                    $('.editDivFetchArea').html();
                    $('.editDivFetchArea').html(result);
                    $(".selectpicker").selectpicker("refresh");          
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });
        });
        $('#form_add_sub_admin').validate({        
           /* rules:{
                txtmobileno:{maxlength:10,minlength:10,remote:{url: "<?php echo base_url();?>Admin/CheckMobileNoExistForSubAdmin",type:"post",
                        data:{
                        mobilenoval:function(){return $("#txtmobileno").val()},
                        }}
                    }},
            messages:{
                        txtmobileno:{maxlength:"Please enter 10 digits mobile number!",minlength:"Please enter 10 digits mobile number!",remote:"This Mobile Number already exist!"}
                    },*/
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        });  
        $('#form_edit_sub_admin').validate({        
            rules:{
                edittxtmobileno:{maxlength:10,minlength:10,remote:{url: "<?php echo base_url();?>Admin/EditCheckMobileNoExistForSubAdmin",type:"post",
                        data:{
                        said:function(){return $("#said").val()},
                        mobilenoval:function(){return $("#edittxtmobileno").val()},
                        }}
                    }},
            messages:{
                edittxtmobileno:{maxlength:"Please enter 10 digits mobile number!",minlength:"Please enter 10 digits mobile number!",remote:"This Mobile Number already exist!"}
                    },
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        }); 
        $('.clsEditSubAdmin').on('click',function(){       
            var said = $(this).data("id");
            var name=$(this).data('name');
            var email=$(this).data('email');
            var mobileno=$(this).data('mobileno');
            var address=$(this).data('address');
            var cityid = $(this).data("cityid");
            var areaid=$(this).data('areaid');
        
            $.ajax({
            
                url: "<?php echo base_url();?>Admin/Getarea",
                method:"post",
                data: {'cityid' : cityid},
                success: function(result)
                {
                    $('.editDivFetchArea').html();
                    $('.editDivFetchArea').html(result);
                    $('.form_edit_sub_admin select#txtareaid').val(areaid).parent().addClass('focused');
                    $(".selectpicker").selectpicker("refresh");          
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });
            $('.form_edit_sub_admin input#said').val(said).parent().addClass('focused');                
            $('.form_edit_sub_admin input#edittxtsubadminname').val(name).parent().addClass('focused');
            $('.form_edit_sub_admin input#edittxtmobileno').val(mobileno).parent().addClass('focused');
            $('.form_edit_sub_admin textarea#edittxtaddress').val(address).parent().addClass('focused');
            $('.form_edit_sub_admin input#edittxtemail').val(email).parent().addClass('focused'); 
            $('.form_edit_sub_admin select#edittxtcityid').val(cityid).parent().addClass('focused'); 
        });
        $('.clsDeleteSubAdmin').on('click',function(){
                var said=$(this).data('id');
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
                    url: "<?php echo base_url();?>Admin/DeleteSubAdmin",
                    method:"post",
                    data: {'said' : said},
                    dataType: 'json',
                    success: function(result)
                    {
                        if(result.success == 'true')
                        {                        
                           swal("Deleted!", "Your Sub Admin record deleted successfully!", "success");                            
                        }
                        else
                        {
                            swal("Error!", "Something went wroung!", "error");
                        }
                    location.replace('SubAdmin');
                        
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