<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Shipping Charges Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddShipping" title="AddShipping">
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
                                    <th>Range</th>
                                    <th>Charges</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>	
                                    <th>Actions</th>			
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Range</th>
                                    <th>Charges</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>	
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody ID="ShippingCharges">
                            <?php $i=1;if(!empty($ShippingCharges)){
                                foreach($ShippingCharges as $ship_charge){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $ship_charge->range;?></td>
                                    <td><?php echo $ship_charge->chanrges;?></td>
                                    <td><?php echo $ship_charge->created_at;?></td>
                                    <td>
                                    <?php if($ship_charge->updated_at){echo $ship_charge->updated_at;}else{echo "----";}?>
                                    </td>
                                    <td>
                                        <a href="#" class="clsEditShipping" id="idEditShipping" title="Edit" data-toggle="modal" data-target="#largeModalEditShipping" data-id="<?php echo $ship_charge->shipping_id;?>" data-range="<?php echo $ship_charge->range;?>" data-charges="<?php echo $ship_charge->chanrges;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Shipping" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteShipping" id="idDeleteShipping" title="Delete" data-id="<?php echo $ship_charge->shipping_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Shipping" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddShipping" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Shipping</h4>
            </div>
            <form class="form_add_Shipping" id="form_add_Shipping" method="post" action="<?php echo base_url();?>Admin/AddShipping" enctype="multipart/form-data"> 
                <div class="modal-body">                   
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtstartrange" name="txtstartrange" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Start Range<b style="color:red">*</b></label>                            
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtendrange" name="txtendrange" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">End Range<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>                         
                    </div>    
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtcharges" name="txtcharges" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Charges<b style="color:red">*</b></label>
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
<div class="modal fade" id="largeModalEditShipping" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Edit Shipping</h4>
            </div>
            <form class="form_edit_Shipping" id="form_edit_Shipping" method="post" action="<?php echo base_url();?>Admin/EditShipping" enctype="multipart/form-data"> 
               <input type="hidden" name="shippingid" id="shippingid" value="">
                <div class="modal-body">                   
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtstartrange" name="edittxtstartrange" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Start Range<b style="color:red">*</b></label>                            
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtendrange" name="edittxtendrange" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">End Range<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>                         
                    </div>    
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtcharges" name="edittxtcharges" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Charges<b style="color:red">*</b></label>
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
    $('#form_add_Shipping').validate({        
        rules:{
            
            'txtstartrange':{remote:{url: "<?php echo base_url();?>Admin/CheckShippingChargePresent",type:"post",
                    data:{
                    startval:function(){return $("#txtstartrange").val()},
                    endval:function(){return $("#txtendrange").val()},
                    chargesval:function(){return $("#txtcharges").val()},
                    }},
        },
        'txtendrange':{remote:{url: "<?php echo base_url();?>Admin/CheckShippingChargePresent",type:"post",
                    data:{
                    startval:function(){return $("#txtstartrange").val()},
                    endval:function(){return $("#txtendrange").val()},
                    chargesval:function(){return $("#edittxtcharges").val()},
                    }},
        }},
        messages:{
                    'txtstartrange':{remote:"This Record already present!"},
                    'txtendrange':{remote:"This Record already present!"},
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });    
    $('#form_edit_Shipping').validate({        
        rules:{
            
            'edittxtstartrange':{remote:{url: "<?php echo base_url();?>Admin/EditCheckShippingChargePresent",type:"post",
                    data:{
                        id:function(){return $("#shippingid").val()},
                        startval:function(){return $("#edittxtstartrange").val()},
                        endval:function(){return $("#edittxtendrange").val()},
                        chargesval:function(){return $("#edittxtcharges").val()},
                    }},
        },
        'edittxtendrange':{remote:{url: "<?php echo base_url();?>Admin/EditCheckShippingChargePresent",type:"post",
                    data:{
                    id:function(){return $("#shippingid").val()},
                    startval:function(){return $("#edittxtstartrange").val()},
                    endval:function(){return $("#edittxtendrange").val()},
                    chargesval:function(){return $("#edittxtcharges").val()},
                    }},
        }},
        messages:{
                    'edittxtstartrange':{remote:"This Record already present!"},
                    'edittxtendrange':{remote:"This Record already present!"},
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });  
    $('.clsEditShipping').on('click',function(){ 
       
        var shipid = $(this).data("id");
        var range=$(this).data('range');
        var charges=$(this).data('charges');    
        var split_range = range.split(",");      
       
        $('.form_edit_Shipping input#shippingid').val(shipid).parent().addClass('focused');                
        $('.form_edit_Shipping input#edittxtstartrange').val(split_range[0]).parent().addClass('focused');
        $('.form_edit_Shipping input#edittxtendrange').val(split_range[1]).parent().addClass('focused');
        $('.form_edit_Shipping input#edittxtcharges').val(charges).parent().addClass('focused');
      
  
       
    });
    $('.clsDeleteShipping').on('click',function(){
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
                url: "<?php echo base_url();?>Admin/DeleteShipping",
                method:"post",
                data: {'vid' : vid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                       
                        if(result.chkShippingpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your Shipping record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your Shipping record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('Shipping');
                    
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