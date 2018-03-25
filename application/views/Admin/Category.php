<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Category Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddCategory" title="AddCategory">
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
                                    <th>Icon</th>
                                    <th>Actions</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Actions</th>	
                                </tr>
                            </tfoot>
                            <tbody ID="CatDetails">
                            <?php $i=1;if(!empty($CategoryDetails)){
                                foreach($CategoryDetails as $cat){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $cat->category_name;?></td>
                                    <td><img name="Image" height="50" width="50" src="<?php echo base_url().$cat->category_image;?>"></td>
                                    <td>
                                        <a href="#" class="clsEditCategory" id="idEditCategory" title="Edit" data-toggle="modal" data-target="#largeModalEditCategory" data-id="<?php echo $cat->cat_id;?>" data-cname="<?php echo $cat->category_name;?>" data-cimage="<?php echo base_url().$cat->category_image;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Category" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteCategory" id="idDeleteCategory" title="Delete" data-id="<?php echo $cat->cat_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Category" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add Category</h4>
            </div>
            <form class="form_add_cat" id="form_add_cat" method="post" action="<?php echo base_url();?>Admin/AddCategory" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">                        
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="txtcatname" name="txtcatname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Category Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input type="file" class="form-control image" id="txtcatimage" name="txtcatimage" value="" required>
                                <div class="help-info">Category Image<b style="color:red">*</b></div>
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
<div class="modal fade" id="largeModalEditCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Edit Category</h4>
            </div>
            <form class="form_edit_cat" id="form_edit_cat" method="post" action="<?php echo base_url();?>Admin/EditCategory" enctype="multipart/form-data"> 
                <input type="hidden" name="catid" id="catid" value="">
                <div class="modal-body">
                    <div class="row clearfix">                        
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="edittxtcatname" name="edittxtcatname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Category Name<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="col-md-11 center-block ">
                                    <img class="img-responsive center-block col-md-8" id="catimg"  src="" style="border: 1px solid #222;" height="20" width:"20"></img>
                                </div>    
                                <div class="form-line">
                                    <input type="file" class="form-control image" id="edittxtcatimage" name="edittxtcatimage" value=""  onchange="readURL(this);">
                                    <div class="help-info">Category Image<b style="color:red">*</b></div>
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
            $('#catimg').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function($){    
    $('#form_add_cat').validate({
        
        rules:{
            txtcatname:{remote:{url: "<?php echo base_url();?>Admin/CheckCategoryNameExist",type:"post",
                    data:{
                    catnameval:function(){return $("#txtcatname").val()},
                    }}
                }},
        messages:{
            txtcatname:{remote:"Category Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_cat').validate({        
        rules:{
            edittxtcatname:{remote:{url: "<?php echo base_url();?>Admin/EditChecCatNameExist",type:"post",
                    data:{
                    catidval:function(){return $("#catid").val()},
                    catnameval:function(){return $("#edittxtcatname").val()},
                    }}
                }},
        messages:{
            edittxtcatname:{remote:"Category Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditCategory').on('click',function(){ 
        var cid=$(this).data('id');
        var cname = $(this).data("cname");
        var cimage = $(this).data("cimage");
        $('.form_edit_cat input#catid').val(cid).parent().addClass('focused');                
        $('.form_edit_cat input#edittxtcatname').val(cname).parent().addClass('focused');
        $('.form_edit_cat img#catimg').attr('src',cimage);
       
    });
    $('.clsDeleteCategory').on('click',function(){
            var catid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteCategory",
                method:"post",
                data: {'catid' : catid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chkcatpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your category record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your categgory record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                location.replace('Category');
                    
                },
                error: function()
                {
                    alert("This category is in Use So you can't Delete it");
                }
            });
        });
    });
});
</script>