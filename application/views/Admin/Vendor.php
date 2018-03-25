<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Vendor Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddVendor" title="AddVendor">
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
                                    <th>Vendor Details</th>
                                    <th>Shop Details</th>
                                    <th>Business Category</th>
                                    <th>Open/Close Time</th>
                                    <th>Short Desc</th>
                                    <th>Action</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Vendor Details</th>
                                    <th>Shop Details</th>
                                    <th>Business Category</th>                                        
                                    <th>Open/Close Time</th>
                                    <th>Short Desc</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody ID="VendorDetails">
                            <?php $i=1;if(!empty($VendorDetails)){
                                foreach($VendorDetails as $vendor){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td>
                                       <b> Name:</b> <?php echo $vendor->name;?><br>
                                       <b> Mobile No:</b> <?php echo $vendor->mobile_no;?>
                                    </td>                                   
                                    <td width="20%">
                                     
                                            <b>Name:</b> <?php echo $vendor->shop_name;?><br>
                                            <b>Address:</b> <?php echo $vendor->address;?><br>
                                            <b>Area:</b> <?php echo $vendor->area_name;?><br>
                                            <b>City:</b> <?php echo $vendor->city_name;?><br>
                                       
                                    </td>
                                    <td><?php echo $vendor->cname;?></td>
                                    <td>
                                       
                                            <b>Open Time:</b> <?php echo $vendor->open_time;?><br>
                                            <b>Close Time:</b> <?php echo $vendor->close_time;?><br>
                                       
                                    </td>
                                    <td><div style="width:100%; max-height:80px; overflow:auto"><?php echo $vendor->short_desc;?></div></td>
                                    <td>
                                        <a href="#" class="clsEditVendor" id="idEditVendor" title="Edit" data-toggle="modal" data-target="#largeModalEditVendor" data-id="<?php echo $vendor->vid;?>" data-name="<?php echo $vendor->name;?>" data-shopname="<?php echo $vendor->shop_name;?>" data-address="<?php echo $vendor->address;?>" data-cityid="<?php echo $vendor->city_id;?>" data-areaid="<?php echo $vendor->area_id;?>" data-mobileno="<?php echo $vendor->mobile_no;?>" data-opentime="<?php echo $vendor->open_time;?>" data-closetime="<?php echo $vendor->close_time;?>" data-cat="<?php echo $vendor->business_category;?>" data-shoptype="<?php echo $vendor->shop_type;?>" ><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteVendor" id="idDeleteVendor" title="Delete" data-id="<?php echo $vendor->vid;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Vendor" data-toggle="tooltip"></i></a>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-6 align-right">
                                                <div class="switch panel-switch-btn">                                                         
                                                    <label>
                                                        <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $vendor->block;?>" data-id="<?php echo $vendor->vid;?>"
                                                            <?php if($vendor->block == '0'){?>checked
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
<div class="modal fade" id="largeModalAddVendor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Vendor</h4>
            </div>
            <form class="form_add_vendor" id="form_add_vendor" method="post" action="<?php echo base_url();?>Admin/AddVendor" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtvendorname" name="txtvendorname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectmaincat selectpicker" data-live-search="false" id="txtshoptype" name="txtshoptype" required>
                                        <option value="">Select Shop Type</option>
                                        <option value="1">Restaurent</option> 
                                        <option value="0">Other</option>                                    
                                    </select> 
                                    <div class="help-info">Shop Type<b style="color:red">*</b></div>                        
                                </div>
                            </div>
                        </div>                         
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtshopname" name="txtshopname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Shop Name<b style="color:red">*</b></label>                            
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control only_number" id="txtmobileno" name="txtmobileno" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Mobile No<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>                         
                    </div>    
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="timepicker form-control" name="txtopentime" id="txtopentime" placeholder="Please choose a open time...">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="timepicker form-control" name="txtclosetime" id="txtclosetime" placeholder="Please choose a close time...">
                                </div>
                            </div>
                        </div>                         
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtaddress" name="txtaddress" value="" required style="text-transform: capitalize;">
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
                    <div class="row clearfix collapse DivCategory">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectcat selectpicker" data-live-search="true" id="txtcatid" name="txtcatid[]" multiple required>
                                        <option disabled value="">Select Category</option>
                                        <?php if(!empty($CategoryDetails)){
                                            foreach($CategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Select Category<b style="color:red">*</b></div>
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
<div class="modal fade" id="largeModalEditVendor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Vendor</h4>
            </div>
            <form class="form_edit_vendor" id="form_edit_vendor" method="post" action="<?php echo base_url();?>Admin/EditVendor" enctype="multipart/form-data"> 
               <input type="hidden" name="vid" id="vid" value=""> 
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtvendorname" name="edittxtvendorname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectmaincat selectpicker" data-live-search="false" id="edittxtshoptype" name="edittxtshoptype" required>
                                        <option value="">Select Shop Type</option>
                                        <option value="1">Restaurent</option> 
                                        <option value="0">Other</option>                                    
                                    </select> 
                                    <div class="help-info">Shop Type<b style="color:red">*</b></div>                        
                                </div>
                            </div>
                        </div>                         
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtshopname" name="edittxtshopname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Shop Name<b style="color:red">*</b></label>                            
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control only_number" id="edittxtmobileno" name="edittxtmobileno" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Mobile No<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>                         
                    </div>    
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="timepicker form-control" name="edittxtopentime" id="edittxtopentime" placeholder="Please choose a open time...">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="timepicker form-control" name="edittxtclosetime" id="edittxtclosetime" placeholder="Please choose a close time...">
                                </div>
                            </div>
                        </div>                         
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtaddress" name="edittxtaddress" value="" required style="text-transform: capitalize;">
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
                    <div class="row clearfix collapse editDivCategory">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectcat selectpicker" data-live-search="true" id="edittxtcatid" name="edittxtcatid[]" multiple required>
                                        <option value="">Select Category</option>
                                        <?php if(!empty($CategoryDetails)){
                                            foreach($CategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Select Category<b style="color:red">*</b></div>
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
    $('.chkblock').on('change',function(){
        $(this).val(this.checked ? "0" : "1");
        var blockValue = $(this).val();
        var vendorid = $(this).data('id');                             
        $.ajax({
            url: "<?php echo base_url();?>Admin/BlokUnblockVendor",
            method:"post",
            data: {'blockValue' : blockValue,'vendorid' : vendorid},
            dataType: 'json',
            success: function(result)
            {
                if(result.blockval == 0)
                {                            
                    swal({
                            title: "Unblocked!",
                            text: "Vendor unblocked!",
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
                        text: "Vendor blocked!",
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
    $('#form_add_vendor').validate({        
        rules:{
            txtmobileno:{maxlength:10,minlength:10},
            /*'txtcatid[]':{remote:{url: "<?php echo base_url();?>Admin/CheckCategoryExistForCity",type:"post",
                    data:{
                    cityidval:function(){return $("#txtcityid").val()},
                    catidval:function(){return $("#txtcatid").val()},
                    }}
        }*/},
        messages:{
            txtmobileno:{maxlength:"Please enter 10 digits mobile number!",minlength:"Please enter 10 digits mobile number!"},
           // 'txtcatid[]':{remote:"This Category already in use for given city!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });    
    $('#form_edit_vendor').validate({        
        rules:{
          /*  'edittxtcatid[]':{remote:{url: "<?php echo base_url();?>Admin/EditCheckCategoryExistForCity",type:"post",
                    data:{
                    vendoridval:function(){return $("#vid").val()},
                    cityidval:function(){return $("#edittxtcityid").val()},
                    catidval:function(){return $("#edittxtcatid").val()},
                    }}
                }*/},
        messages:{
           // 'edittxtcatid[]':{remote:"This Category already in use for given city!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditVendor').on('click',function(){ 
        $('.editDivFetchArea').removeClass('collapse'); 
        $('.editDivCategory').removeClass('collapse');  
   
        var vid = $(this).data("id");
        var name=$(this).data('name');
        var shopname=$(this).data('shopname');
        var address = $(this).data("address");
        var cityid = $(this).data("cityid");
        var areaid=$(this).data('areaid');
        var mobileno=$(this).data('mobileno');
        var opentime=$(this).data('opentime');
        var closetime=$(this).data('closetime');
        var catid = $(this).data("cat");
        var shoptype = $(this).data("shoptype");

       
        if(catid.length == undefined)
        {
            var  selectedOptions = catid;
            $('.form_edit_vendor select#edittxtcatid').selectpicker('val', ' ');
            $(".form_edit_vendor select#edittxtcatid").find("option[value="+selectedOptions+"]").prop("selected", "selected");
         
        }
        else{
            var selectedOptions = "";
            selectedOptions = catid.split(",");
            $('.form_edit_vendor select#edittxtcatid').selectpicker('val', ' ');
            for(var i in selectedOptions) {
                var optionVal = selectedOptions[i];
                $(".form_edit_vendor select#edittxtcatid").find("option[value="+optionVal+"]").prop("selected", "selected");
            
            }          
           
        }
                
        $.ajax({
            
                url: "<?php echo base_url();?>Admin/Getarea",
                method:"post",
                data: {'cityid' : cityid},
                success: function(result)
                {
                    $('.editDivFetchArea').html();
                    $('.editDivFetchArea').html(result);
                    $('.form_edit_vendor select#txtareaid').val(areaid).parent().addClass('focused');
                    $(".selectpicker").selectpicker("refresh");          
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });
        $('.form_edit_vendor input#vid').val(vid).parent().addClass('focused');                
        $('.form_edit_vendor input#edittxtvendorname').val(name).parent().addClass('focused');
        $('.form_edit_vendor select#edittxtshoptype').val(shoptype).parent().addClass('focused');
        $('.form_edit_vendor input#edittxtshopname').val(shopname).parent().addClass('focused');                
        $('.form_edit_vendor input#edittxtmobileno').val(mobileno).parent().addClass('focused');
        $('.form_edit_vendor input#edittxtopentime').val(opentime).parent().addClass('focused');                
        $('.form_edit_vendor input#edittxtclosetime').val(closetime).parent().addClass('focused');
        $('.form_edit_vendor input#edittxtaddress').val(address).parent().addClass('focused');
        $('.form_edit_vendor select#edittxtcityid').val(cityid).parent().addClass('focused');  
       // $('.form_edit_vendor select#edittxtcatid').val(catid).parent().addClass('focused');   
        $(".selectpicker").selectpicker("refresh");
       
    });
    $('.clsDeleteVendor').on('click',function(){
            var vid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteVendor",
                method:"post",
                data: {'vid' : vid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                       
                        if(result.chkvendorpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your vendor record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your vendor record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('Vendor');
                    
                },
                error: function()
                {
                    alert("This sub category is in use so you can't Delete it");
                }
            });
        });
    });
});
</script>