<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sub Sub Category Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddSubSubCategory" title="AddSubSubCategory">
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
                                        <th>Sub Sub Category Name</th>
                                        <th>Vendor Details</th>
                                        <th>Actions</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th>Sub Sub Category Name</th>
                                        <th>Vendor Details</th>
                                        <th>Actions</th>	
                                    </tr>
                                </tfoot>
                                <tbody ID="SubSubCatDetails">
                                <?php $i=1;if(!empty($SubSubCategoryDetails)){
                                    foreach($SubSubCategoryDetails as $subsubcat){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $subsubcat->category_name;?></td>
                                        <td><?php echo $subsubcat->sub_cat_name;?></td>
                                        <td><?php echo $subsubcat->filt_name;?></td>
                                        <td>
                                            <?php if($subsubcat->name != ""){?>
                                            <div style="width:100%; max-height:60px; overflow:auto"> 
                                                <b>Name:</b> <?php echo $subsubcat->name;?><br>
                                                <b>Mobile No:</b> <?php echo $subsubcat->mobile_no;?><br>
                                            </div>
                                            <?php }else{ echo "------";}?>
                                        </td>
                                        <td>
                                            <a href="#" class="clsEditSubSubCategory" id="idEditSubSubCategory" title="Edit" data-toggle="modal" data-target="#largeModalEditSubSubCategory" data-id="<?php echo $subsubcat->filt_id;?>" data-scid="<?php echo $subsubcat->sub_cat_id;?>" data-sscname="<?php echo $subsubcat->filt_name;?>" data-cid="<?php echo $subsubcat->cat_id;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Sub Category" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteSubSubCategory" id="idDeleteSubSubCategory" title="Delete" data-id="<?php echo $subsubcat->filt_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Sub Category" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAddSubSubCategory" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Sub Sub Category</h4>
                </div>
                <form class="form_add_subsubcat" id="form_add_subsubcat" method="post" action="<?php echo base_url();?>Admin/AddSubSubCategory" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">  
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectmaincat selectpicker" data-live-search="true" id="txtcatid" name="txtcatid" required>
                                            <option value="">Select Category</option>
                                            <?php if(!empty($CategoryDetails)){
                                                foreach($CategoryDetails as $cat){if($cat->category_name != 'Restaurents'){?>
                                                    <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                            <?php }}}?>
                                        </select> 
                                        <div class="help-info">Main Category<b style="color:red">*</b></div>
                                    </div>
                                </div>  
                            </div>  
                            <div class="col-md-6 DivfetchSubCat collapse">
                                
                            </div>  
                        </div>
                        <div class="row clearfix DivSubSubCat collapse">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="txtsubsubcatname" name="txtsubsubcatname" value="" required style="text-transform: capitalize;">
                                        <label class="form-label">Sub Sub Category Name<b style="color:red">*</b></label>
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
    <div class="modal fade" id="largeModalEditSubSubCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Sub Sub Category</h4>
            </div>
            <form class="form_edit_subsubcat" id="form_edit_subsubcat" method="post" action="<?php echo base_url();?>Admin/EditSubSubCategory" enctype="multipart/form-data"> 
                <input type="hidden" name="subsubcatid" id="subsubcatid">
                <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick editselectmaincat selectpicker" data-live-search="true" id="edittxtcatid" name="edittxtcatid" required>
                                        <option value="">Select Category</option>
                                        <?php if(!empty($CategoryDetails)){
                                            foreach($CategoryDetails as $cat){if($cat->category_name != 'Restaurents'){?>
                                                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                        <?php }}}?>
                                    </select> 
                                    <div class="help-info">Main Category<b style="color:red">*</b></div>
                                </div>
                            </div>  
                        </div>  
                        <div class="col-md-6 editDivfetchSubCat collapse">
                            
                        </div>  
                    </div>
                    <div class="row clearfix editDivSubSubCat collapse">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtsubsubcatname" name="edittxtsubsubcatname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Sub Sub Category Name<b style="color:red">*</b></label>
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
    $('.selectmaincat').on('change',function(){ 
        var catid=$(this).val(); 
        if(catid == "")
        {
            $('.DivfetchSubCat').addClass('collapse');
            $('.DivSubSubCat').addClass('collapse');  

        }
        else
        {
            $('.DivfetchSubCat').removeClass('collapse'); 
            $('.DivSubSubCat').removeClass('collapse');
        }
        $.ajax({

            url: "<?php echo base_url();?>Admin/GetSubCategory",
            method:"post",
            data: {'catid' : catid},
            success: function(result)
            {
                $('.DivfetchSubCat').html();
                $('.DivfetchSubCat').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
    });
    $('.editselectmaincat').on('change',function(){ 
        var catid=$(this).val(); 
        if(catid == "")
        {
            $('.editDivfetchSubCat').addClass('collapse');
            $('.editDivSubSubCat').addClass('collapse');  

        }
        else
        {
            $('.editDivfetchSubCat').removeClass('collapse'); 
            $('.editDivSubSubCat').removeClass('collapse');
        }
        $.ajax({

            url: "<?php echo base_url();?>Admin/GetSubCategory",
            method:"post",
            data: {'catid' : catid},
            success: function(result)
            {
                $('.editDivfetchSubCat').html();
                $('.editDivfetchSubCat').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
    });
    $('#form_add_subsubcat').validate({
        
        rules:{
            txtsubsubcatname:{remote:{url: "<?php echo base_url();?>Admin/CheckSubSubCategoryNameExist",type:"post",
                    data:{
                    subcatidval:function(){return $("#txtsubcatid").val()},
                    subsubcatnameval:function(){return $("#txtsubsubcatname").val()},
                    }}
                }},
        messages:{
            txtsubsubcatname:{remote:"Sub Sub Category exist for this sub category!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_subsubcat').validate({        
         rules:{
            edittxtsubsubcatname:{remote:{url: "<?php echo base_url();?>Admin/EditCheckSubSubCatNameExist",type:"post",
                        data:{
                        subcatidval:function(){return $("#txtsubcatid").val()},
                        subsubcatidval:function(){return $("#subsubcatid").val()},
                        subsubcatnameval:function(){return $("#edittxtsubsubcatname").val()},
                        }}
                    }},
            messages:{
                edittxtsubsubcatname:{remote:"Sub Sub Category Present For Given Sub Category!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditSubSubCategory').on('click',function(){ 
        $('.editDivfetchSubCat').removeClass('collapse'); 
        $('.editDivSubSubCat').removeClass('collapse');  
        var cid = $(this).data("cid");       
        var scid=$(this).data('scid');
        var sscid=$(this).data('id');
        var sscname = $(this).data("sscname");
         $.ajax({

            url: "<?php echo base_url();?>Admin/GetSubCategory",
            method:"post",
            data: {'catid' : cid},
            success: function(result)
            {
                $('.editDivfetchSubCat').html();
                $('.editDivfetchSubCat').html(result);
                $('.form_edit_subsubcat select#txtsubcatid').val(scid).parent().addClass('focused');
                $(".selectpicker").selectpicker("refresh");     
                 
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
        alert(cid);
        $('.form_edit_subsubcat input#subsubcatid').val(sscid).parent().addClass('focused');                
        $('.form_edit_subsubcat input#edittxtsubsubcatname').val(sscname).parent().addClass('focused');
        $('.form_edit_subsubcat select#edittxtcatid').val(cid).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
       
    });
    $('.clsDeleteSubSubCategory').on('click',function(){
            var subsubcatid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteSubSubCategory",
                method:"post",
                data: {'subsubcatid' : subsubcatid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                       
                        if(result.chksubsubcatpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your sub sub category record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your sub sub category record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('SubSubCategory');
                    
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