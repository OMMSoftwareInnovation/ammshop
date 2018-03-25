<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Sub Category Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddSubCategory" title="AddSubCategory">
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
                                    <th>Sub Category Icon</th>
                                    <th>Actions</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Sr.No</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Sub Category Icon</th>
                                <th>Actions</th>	
                                </tr>
                            </tfoot>
                            <tbody ID="SubCatDetails">
                            <?php $i=1;if(!empty($SubCategoryDetails)){
                                foreach($SubCategoryDetails as $subcat){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $subcat->category_name;?></td>
                                    <td><?php echo $subcat->sub_cat_name;?></td>
                                    <td><img name="Image" height="50" width="50" src="<?php echo base_url().$subcat->sub_cat_image;?>"></td>
                                    <td>
                                        <a href="#" class="clsEditSubCategory" id="idEditSubCategory" title="Edit" data-toggle="modal" data-target="#largeModalEditSubCategory" data-id="<?php echo $subcat->sub_cat_id;?>" data-cid="<?php echo $subcat->cat_id;?>" data-scname="<?php echo $subcat->sub_cat_name;?>" data-scimage="<?php echo base_url().$subcat->sub_cat_image;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Sub Category" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteSubCategory" id="idDeleteSubCategory" title="Delete" data-id="<?php echo $subcat->sub_cat_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Sub Category" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddSubCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Sub Category</h4>
            </div>
            <form class="form_add_subcat" id="form_add_subcat" method="post" action="<?php echo base_url();?>Admin/AddSubCategory" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="txtcatid" name="txtcatid" required>
                                        <option value="">Select Category</option>
                                        <?php if(!empty($CategoryDetails)){
                                            foreach($CategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Main Category<b style="color:red">*</b></div>
                                </div>
                            </div>  
                        </div>                      
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtsubcatname" name="txtsubcatname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Sub Category Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row clearfix">   
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input type="file" class="form-control image" id="txtsubcatimage" name="txtsubcatimage" value="" required>
                                <div class="help-info">Sub Category Image<b style="color:red">*</b></div>
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
<div class="modal fade" id="largeModalEditSubCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Sub Category</h4>
            </div>
            <form class="form_edit_subcat" id="form_edit_subcat" method="post" action="<?php echo base_url();?>Admin/EditSubCategory" enctype="multipart/form-data"> 
               <input type="hidden" name="subcatid" id="subcatid" value="">
                <div class="modal-body">
                    <div class="row clearfix">  
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtcatid" name="edittxtcatid" required>
                                        <option value="">Select Category</option>
                                        <?php if(!empty($CategoryDetails)){
                                            foreach($CategoryDetails as $cat){?>
                                                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                        <?php }}?>
                                    </select> 
                                    <div class="help-info">Main Category<b style="color:red">*</b></div>
                                </div>
                            </div>  
                        </div>                      
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtsubcatname" name="edittxtsubcatname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Sub Category Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row clearfix">   
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="col-md-11 center-block ">
                                    <img class="img-responsive center-block col-md-8" id="subcatimg"  src="" style="border: 1px solid #222;" height="20" width:"20"></img>
                                </div> 
                                <div class="form-line">
                                    <input type="file" class="form-control image" id="edittxtsubcatimage" name="edittxtsubcatimage" value="" onchange="readURL(this);" >
                                    <div class="help-info">Sub Category Image<b style="color:red">*</b></div>
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
function readURL(input) {      

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#subcatimg').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function($){    
    $('#form_add_subcat').validate({
        
        rules:{
            txtsubcatname:{remote:{url: "<?php echo base_url();?>Admin/CheckSubCategoryNameExist",type:"post",
                    data:{
                    catidval:function(){return $("#txtcatid").val()},
                    subcatnameval:function(){return $("#txtsubcatname").val()},
                    }}
                }},
        messages:{
            txtsubcatname:{remote:"Sub Category exist for this main category!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_subcat').validate({        
         rules:{
            edittxtsubcatname:{remote:{url: "<?php echo base_url();?>Admin/EditCheckSubCatNameExist",type:"post",
                        data:{
                        catidval:function(){return $("#edittxtcatid").val()},
                        subcatidval:function(){return $("#subcatid").val()},
                        subcatnameval:function(){return $("#edittxtsubcatname").val()},
                        }}
                    }},
            messages:{
                edittxtsubcatname:{remote:"Area Present For Given City Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditSubCategory').on('click',function(){ 
        var scid=$(this).data('id');
        var cid = $(this).data("cid");
        var scname = $(this).data("scname");
        var scimage = $(this).data("scimage");
        $('.form_edit_subcat input#subcatid').val(scid).parent().addClass('focused');                
        $('.form_edit_subcat input#edittxtsubcatname').val(scname).parent().addClass('focused');
        $('.form_edit_subcat img#subcatimg').attr('src',scimage);
        $('.form_edit_subcat select#edittxtcatid').val(cid).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
       
    });
    $('.clsDeleteSubCategory').on('click',function(){
            var subcatid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteSubCategory",
                method:"post",
                data: {'subcatid' : subcatid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chksubcatpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your sub category record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your sub category record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('SubCategory');
                    
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