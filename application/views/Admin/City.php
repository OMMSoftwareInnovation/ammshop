<section class="content">
<div class="container-fluid">           
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        City Details
                        <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddCity" title="AddCity">
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
                                    <th>Actions</th>		
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Actions</th>	
                                </tr>
                            </tfoot>
                            <tbody ID="CatDetails">
                            <?php $i=1;if(!empty($CityDetails)){
                                foreach($CityDetails as $city){?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $city->city_name;?></td>
                                    <td>
                                        <a href="#" class="clsEditCity" id="idEditCity" title="Edit" data-toggle="modal" data-target="#largeModalEditCity" data-id="<?php echo $city->city_id;?>" data-cname="<?php echo $city->city_name;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit City" data-toggle="tooltip"></i></a>
                                        <a href="#" class="clsDeleteCity" id="idDeleteCity" title="Delete" data-id="<?php echo $city->city_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete City" data-toggle="tooltip"></i></a>
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
<div class="modal fade" id="largeModalAddCity" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Add City</h4>
            </div>
            <form class="form_add_city" id="form_add_city" method="post" action="<?php echo base_url();?>Admin/AddCity" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input type="text" class="form-control" id="txtcityname" name="txtcityname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Name<b style="color:red">*</b></label>
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
<div class="modal fade" id="largeModalEditCity" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update City</h4>
            </div>
            <form class="form_edit_city" id="form_edit_city" method="post" action="<?php echo base_url();?>Admin/EditCity" enctype="multipart/form-data"> 
                <input type="hidden" name="txtcityid" id="txtcityid" value="">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input type="text" class="form-control" id="edittxtcityname" name="edittxtcityname" value="" required style="text-transform: capitalize;">
                                    <label class="form-label">Name<b style="color:red">*</b></label>
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
    $('#form_add_city').validate({
        
        rules:{
            txtcityname:{remote:{url: "<?php echo base_url();?>Admin/CheckCityNameExist",type:"post",
                    data:{
                    citynameval:function(){return $("#txtcityname").val()},
                    }}
                }},
        messages:{
            txtcityname:{remote:"City Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_city').validate({
        
        rules:{
            edittxtcityname:{remote:{url: "<?php echo base_url();?>Admin/EditCheckCityNameExist",type:"post",
                    data:{
                    cityidval:function(){return $("#txtcityid").val()},
                    citynameval:function(){return $("#edittxtcityname").val()},
                    }}
                }},
        messages:{
            edittxtcityname:{remote:"City Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditCity').on('click',function(){ 
        var cid=$(this).data('id');
        var cityname = $(this).data("cname");
        $('.form_edit_city input#edittxtcityname').val(cityname).parent().addClass('focused');                
        $('.form_edit_city input#txtcityid').val(cid).parent().addClass('focused');
    });
    $('.clsDeleteCity').on('click',function(){
            var cityid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteCity",
                method:"post",
                data: {'cityid' : cityid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chkcitypresent == 1)
                        {
                            swal("Can Not Deleted!", "Your city record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your city record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                   location.replace('City');
                    
                },
                error: function()
                {
                    alert("This Event is in Use So you can't Delete it");
                }
            });
        });
    });
});
</script>