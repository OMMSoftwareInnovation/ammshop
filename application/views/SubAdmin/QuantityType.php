<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Quantity Type Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddQtyType" title="AddQtyType">
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
                                    <th>Actions</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Sr.No</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Qty Unit</th>
                                <th>Actions</th>	
                                </tr>
                            </tfoot>
                            <tbody ID="SubCatDetails">
                            <?php $i=1;if(!empty($QuantityTypeDetails)){
                                foreach($QuantityTypeDetails as $qtytype){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $qtytype->category_name;?></td>
                                    <td><?php echo $qtytype->sub_cat_name;?></td>
                                    <td><?php echo $qtytype->qty_type_name;?></td>
                                    <td>
                                        <a href="#" class="clsEditQtyType" id="idEditQtyType" title="Edit" data-toggle="modal" data-target="#largeModalEditQtyType" data-id="<?php echo $qtytype->qty_type_id;?>" data-qtytypetname="<?php echo $qtytype->qty_type_name;?>" data-scid="<?php echo $qtytype->sub_cat_id;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Sub Category" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteQtyType" id="idDeleteQtyType" title="Delete" data-id="<?php echo $qtytype->qty_type_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Sub Category" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddQtyType" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Quantity Type</h4>
            </div>
            <form class="form_add_qtytype" id="form_add_qtytype" method="post" action="<?php echo base_url();?>Admin/AddQuantityType" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="txtsubcatid" name="txtsubcatid" required>
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
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtqtytype" name="txtqtytype" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Quantity Type<b style="color:red">*</b></label>
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
<div class="modal fade" id="largeModalEditQtyType" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Quantity Type</h4>
            </div>
            <form class="form_edit_qtytype" id="form_edit_qtytype" method="post" action="<?php echo base_url();?>Admin/EditQuantityType" enctype="multipart/form-data"> 
               <input type="hidden" name="qtytypeid" id="qtytypeid" value="">
               <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtsubcatid" name="edittxtsubcatid" required>
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
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtqtytype" name="edittxtqtytype" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Quantity Type<b style="color:red">*</b></label>
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
    $('#form_add_qtytype').validate({
        rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        txtqtytype: "required",
        txtsubcatid: "required",
        
      },
      // Specify validation error messages
      messages: {
        txtqtytype: "Please enter quantity type!",
        txtsubcatid: "Please select sub category!",
      
      },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
     
    });
    $('#form_edit_qtytype').validate({        
          // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            txtqtytype: "required",
            txtsubcatid: "required",
            
        },
        // Specify validation error messages
        messages: {
            txtqtytype: "Please enter quantity type!",
            txtsubcatid: "Please select sub category!",
        
        },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditQtyType').on('click',function(){ 
        var qtytypeid=$(this).data('id');
        var cid = $(this).data("cid");
        var qtytypetname = $(this).data("qtytypetname");
        var scid = $(this).data("scid");
        $('.form_edit_qtytype input#qtytypeid').val(qtytypeid).parent().addClass('focused');                
        $('.form_edit_qtytype input#edittxtqtytype').val(qtytypetname).parent().addClass('focused');
        $('.form_edit_qtytype select#edittxtsubcatid').val(scid).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
       
    });
    $('.clsDeleteQtyType').on('click',function(){
            var qtytypeid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteQuantityType",
                method:"post",
                data: {'qtytypeid' : qtytypeid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chkqtytypepresent == 1)
                        {
                            swal("Can Not Deleted!", "Your quantity type record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your quantity type record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('QuantityType');
                    
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