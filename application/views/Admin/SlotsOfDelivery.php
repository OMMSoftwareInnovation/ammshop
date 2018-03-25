<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Delivery Slots Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddDeliverySlot" title="AddDeliverySlot">
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
                                        <th>Shop Name</th>
                                        <th>Address</th>
                                        <th>Open Time</th>
                                        <th>Close Time</th>                                     
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Vendor Details</th>
                                        <th>Shop Name</th>
                                        <th>Address</th>
                                        <th>Open Time</th>
                                        <th>Close Time</th>                                     
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="DeliverySlotDetails">
                                <?php $i=1;if(!empty($DeliverySlotsDetails)){
                                    foreach($DeliverySlotsDetails as $timeslot){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto">
                                                Name: <?php echo $timeslot->name;?></br>
                                                Mobile No: <?php echo $timeslot->mobile_no;?>
                                            </div>
                                        </td>
                                        <td><?php echo $timeslot->shop_name;?></td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto">
                                                Address: <?php echo $timeslot->address;?></br>
                                                City: <?php echo $timeslot->city_name;?></br>
                                                Area: <?php echo $timeslot->area_name;?>
                                            </div>
                                        </td>	  
                                        <td><?php echo $timeslot->opentime;?></td>
                                        <td><?php echo $timeslot->closetime;?></td>
                                        <td>
                                            <a href="#" class="clsEditDeliverySlot" id="idEditDeliverySlot" title="Edit" data-toggle="modal" data-target="#largeModalEditDeliverySlot" data-id="<?php echo $timeslot->delivery_slot_id;?>" data-vid="<?php echo $timeslot->vid;?>" data-opentime="<?php echo date('H:m:s',strtotime($timeslot->opentime));?>" data-closetime="<?php echo date('H:m:s',strtotime($timeslot->closetime));?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Vendor" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteDeliverySlot" id="idDeleteDeliverySlot" title="Delete" data-id="<?php echo $timeslot->delivery_slot_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Delivery Slot" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAddDeliverySlot" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Delivery Slot</h4>
                </div>
                <form class="form_add_delivery_slot" id="form_add_delivery_slot" method="post" action="<?php echo base_url();?>Admin/AddDeliverySlot" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" data-live-search="true" id="txtvendorid" name="txtvendorid" required>
                                            <option value="">Select Vendor</option>
                                            <?php if(!empty($VendorDetails)){
                                                foreach($VendorDetails as $vendor){?>
                                                    <option value="<?php echo $vendor->vid;?>"><?php echo $vendor->name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select User<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>                                                  
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control timepicker" id="txtopentime" name="txtopentime" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Open Time<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control timepicker" id="txtclosetime" name="txtclosetime" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Close Time<b style="color:red">*</b></div> 
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
    <div class="modal fade" id="largeModalEditDeliverySlot" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Update Delivery Slot</h4>
                </div>
                <form class="form_edit_delivery_slot" id="form_edit_delivery_slot" method="post" action="<?php echo base_url();?>Admin/EditDeliverySlot" enctype="multipart/form-data"> 
                    <input type="hidden" name="deliveryslot_id" id="deliveryslot_id" value="">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtvendorid" name="edittxtvendorid" required>
                                            <option value="">Select Vendor</option>
                                            <?php if(!empty($VendorDetails)){
                                                foreach($VendorDetails as $vendor){?>
                                                    <option value="<?php echo $vendor->vid;?>"><?php echo $vendor->name;?></option>
                                            <?php }}?>
                                        </select> 
                                        <div class="help-info">Select User<b style="color:red">*</b></div>                           
                                    </div>
                                </div>
                            </div>                                                  
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control timepicker" id="edittxtopentime" name="edittxtopentime" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Open Time<b style="color:red">*</b></div> 
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control timepicker" id="edittxtclosetime" name="edittxtclosetime" value="" required >
                                        <label class="form-label"></label>
                                        <div class="help-info">Close Time<b style="color:red">*</b></div> 
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
     
       /*Datetimepicker plugin
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false
        });*/
        var starttime;
       //Datetimepicker plugin
        $('#txtopentime').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false,      
        }).on('change', function (e, date) {
            starttime = $("#txtopentime").val();   
                  
        });  
        $('#txtclosetime').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false,        
        }).on('change', function (e, date) {
            var endtime = $("#txtclosetime").val();
                  
            if(starttime > endtime){
                   swal('Please select open time greater than close time!');
             }
             else{
                 //alert("hii");
             }
            
        });       
        $('#form_add_delivery_slot').validate({   
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        });  
        $('#form_edit_delivery_slot').validate({        
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
        }); 
        $('.clsEditDeliverySlot').on('click',function(){         
            var dsid = $(this).data("id");
            var vid=$(this).data('vid');
            var opentime=$(this).data('opentime');
            var closetime=$(this).data('closetime');
      
            $('.form_edit_delivery_slot input#deliveryslot_id').val(dsid).parent().addClass('focused');                
            $('.form_edit_delivery_slot input#edittxtopentime').val(opentime).parent().addClass('focused');          
            $('.form_edit_delivery_slot input#edittxtclosetime').val(closetime).parent().addClass('focused'); 
            $('.form_edit_delivery_slot select#edittxtvendorid').val(vid).parent().addClass('focused');
            $(".selectpicker").selectpicker("refresh");
        });
        $('.clsDeleteDeliverySlot').on('click',function(){
                var deliveryslot_id=$(this).data('id');
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
                    url: "<?php echo base_url();?>Admin/DeleteDeliverySlot",
                    method:"post",
                    data: {'deliveryslot_id' : deliveryslot_id},
                    dataType: 'json',
                    success: function(result)
                    {
                        if(result.success == 'true')
                        {                        
                           swal("Deleted!", "Your Delivery Slot record deleted successfully!", "success");                            
                        }
                        else
                        {
                            swal("Error!", "Something went wroung!", "error");
                        }
                    location.replace('SlotsOfDelivery');
                        
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