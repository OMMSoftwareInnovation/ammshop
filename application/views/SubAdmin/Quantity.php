<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Quantity Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddQty" title="AddQty">
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
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Qty Unit</th>
                                    <th>Qty Amount</th>
                                    <th>Actions</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Sr.No</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Qty Unit</th>
                                <th>Qty Amount</th>
                                <th>Actions</th>	
                                </tr>
                            </tfoot>
                            <tbody ID="SubCatDetails">
                            <?php $i=1;if(!empty($QuantityDetails)){
                                foreach($QuantityDetails as $qty){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $qty->category_name;?></td>
                                    <td><?php echo $qty->sub_cat_name;?></td>
                                    <td><?php echo $qty->qty_type_name;?></td>
                                    <td><?php echo $qty->qty_name;?></td>
                                    <td>
                                        <a href="#" class="clsEditQty" id="idEditQty" title="Edit" data-toggle="modal" data-target="#largeModalEditQty" data-id="<?php echo $qty->qty_id;?>" data-qtyname="<?php echo $qty->qty_name;?>" data-qtytypeid="<?php echo $qty->qty_type_id;?>" data-scid="<?php echo $qty->sub_cat_id;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Sub Category" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteQty" id="idDeleteQty" title="Delete" data-id="<?php echo $qty->qty_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Sub Category" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddQty" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Quantity</h4>
            </div>
            <form class="form_add_qty" id="form_add_qty" method="post" action="<?php echo base_url();?>Admin/AddQuantity" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker selectsubcat" data-live-search="true" id="txtsubcatid" name="txtsubcatid" required>
                                        <option value="">Select Sub Category</option>
                                        <?php if(!empty($SubCategoryDetails)){
                                            foreach($SubCategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->sub_cat_id;?>"><?php echo $cat->sub_cat_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Sub Category<b style="color:red">*</b></div>
                                </div>
                            </div>  
                        </div>        
                        <div class="col-md-6 DivfetchQtytype" id="fetchQtytype">
                            
                        </div>
                    </div>
                    <div class="row clearifix DivQtyName collapse">                      
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control only_number" id="txtqtyname" name="txtqtyname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Quantity Amount<b style="color:red">*</b></label>
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
<div class="modal fade" id="largeModalEditQty" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Quantity </h4>
            </div>
            <form class="form_edit_qty" id="form_edit_qty" method="post" action="<?php echo base_url();?>Admin/EditQuantity" enctype="multipart/form-data"> 
               <input type="hidden" name="qtyid" id="qtyid" value="">
               <div class="modal-body">
                        <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker editselectsubcat" data-live-search="true" id="edittxtsubcatid" name="edittxtsubcatid" required>
                                        <option value="">Select Sub Category</option>
                                        <?php if(!empty($SubCategoryDetails)){
                                            foreach($SubCategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->sub_cat_id;?>"><?php echo $cat->sub_cat_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Sub Category<b style="color:red">*</b></div>
                                </div>
                            </div>  
                        </div>        
                        <div class="col-md-6 editDivfetchQtytype" id="editfetchQtytype">
                            
                        </div>
                    </div>
                    <div class="row clearifix editDivQtyName collapse">                      
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control only_number" id="edittxtqtyname" name="edittxtqtyname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Quantity Amount<b style="color:red">*</b></label>
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
    $('.selectsubcat').on('change',function(){ 
        var subcatid=$(this).val(); 
        if(subcatid == "")
        {
            $('.DivfetchQtytype').addClass('collapse');
            $('.DivQtyName').addClass('collapse');  

        }
        else
        {
            $('.DivfetchQtytype').removeClass('collapse'); 
            $('.DivQtyName').removeClass('collapse');
        }
        $.ajax({

            url: "<?php echo base_url();?>Admin/GetQtyType",
            method:"post",
            data: {'subcatid' : subcatid},
            success: function(result)
            {
                $('.DivfetchQtytype').html();
                $('.DivfetchQtytype').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
    });
    $('.editselectsubcat').on('change',function(){ 
        var subcatid=$(this).val(); 
        if(subcatid == "")
        {
            $('.editDivfetchQtytype').addClass('collapse');
            $('.editDivQtyName').addClass('collapse');  

        }
        else
        {
            $('.editDivfetchQtytype').removeClass('collapse'); 
            $('.editDivQtyName').removeClass('collapse');
        }
        $.ajax({

            url: "<?php echo base_url();?>Admin/GetQtyType",
            method:"post",
            data: {'subcatid' : subcatid},
            success: function(result)
            {
                $('.editDivfetchQtytype').html();
                $('.editDivfetchQtytype').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
    });    
    $('#form_add_qty').validate({
        rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        txtqtyname: "required",
        txtsubcatid: "required",
        
      },
      // Specify validation error messages
      messages: {
        txtqtyname: "Please enter quantity!",
        txtsubcatid: "Please select sub category!",
      
      },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
     
    });
    $('#form_edit_qty').validate({        
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            edittxtqtyname: "required",
            edittxtsubcatid: "required",
            
          },
          // Specify validation error messages
          messages: {
            edittxtqtyname: "Please enter quantity!",
            edittxtsubcatid: "Please select sub category!",
          
          },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditQty').on('click',function(){ 
        $('.editDivfetchQtytype').removeClass('collapse'); 
        $('.editDivQtyName').removeClass('collapse');
        var qtyid=$(this).data('id');
        var qtyname = $(this).data("qtyname");
        var subcatid = $(this).data("scid");
        var qtytypeid = $(this).data("qtytypeid");
       $.ajax({

            url: "<?php echo base_url();?>Admin/GetQtyType",
            method:"post",
            data: {'subcatid' : subcatid},
            success: function(result)
            {
                $('.editDivfetchQtytype').html();
                $('.editDivfetchQtytype').html(result);
                $('.form_edit_qty select#qtytype').val(qtytypeid);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
        $('.form_edit_qty input#qtyid').val(qtyid).parent().addClass('focused');                
        $('.form_edit_qty input#edittxtqtyname').val(qtyname).parent().addClass('focused');
        $('.form_edit_qty select#edittxtsubcatid').val(subcatid).parent().addClass('focused');      
        $(".selectpicker").selectpicker("refresh");
       
    });
    $('.clsDeleteQty').on('click',function(){
            var qtyid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteQuantity",
                method:"post",
                data: {'qtyid' : qtyid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        swal("Deleted!", "Your quantity record deleted successfully!", "success");                        
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('Quantity');
                    
                },
                error: function()
                {
                    alert("This quantity is in use so you can't Delete it");
                }
            });
        });
    });
});
</script>