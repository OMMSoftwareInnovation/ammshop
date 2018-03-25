<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Area Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddArea" title="AddArea">
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
                                        <th>City</th>
                                        <th>Area</th>
                                        <th>Actions</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Area</th>
                                    <th>Actions</th>	
                                    </tr>
                                </tfoot>
                                <tbody ID="CatDetails">
                                <?php $i=1;if(!empty($AreaDetails)){
                                    foreach($AreaDetails as $area){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $area->city_name;?></td>
                                        <td><?php echo $area->area_name;?></td>
                                        <td>
                                            <a href="#" class="clsEditArea" id="idEditArea" title="Edit" data-toggle="modal" data-target="#largeModalEditArea" data-id="<?php echo $area->area_id;?>" data-cid="<?php echo $area->city_id;?>" data-aname="<?php echo $area->area_name;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit Area" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteArea" id="idDeleteArea" title="Delete" data-id="<?php echo $area->area_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete Area" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAddArea" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Area</h4>
                </div>
                <form class="form_add_area" id="form_add_area" method="post" action="<?php echo base_url();?>Admin/AddArea" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="txtcityid" name="txtcityid" required>
                                            <option value="">Select City</option>
                                            <?php if(!empty($CityDetails)){
                                                foreach($CityDetails as $city){?>
                                                    <option value="<?php echo $city->city_id;?>"><?php echo $city->city_name;?></option>
                                            <?php }}?>
                                        </select> 
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" id="txtareaname" name="txtareaname" value="" required style="text-transform: capitalize;">
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
    <div class="modal fade" id="largeModalEditArea" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Update Area</h4>
                </div>
                <form class="form_edit_area" id="form_edit_area" method="post" action="<?php echo base_url();?>Admin/EditArea" enctype="multipart/form-data"> 
                <input type="hidden" name="areaid" id="areaid" value="">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="edittxtcityid" name="edittxtcityid" required>
                                        <option value="">Select City</option>
                                        <?php if(!empty($CityDetails)){
                                            foreach($CityDetails as $city){?>
                                                <option value="<?php echo $city->city_id;?>"><?php echo $city->city_name;?></option>
                                        <?php }}?>
                                    </select> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input type="text" class="form-control" id="edittxtareaname" name="edittxtareaname" value="" required style="text-transform: capitalize;">
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
    $('#form_add_area').validate({
        
        rules:{
            txtareaname:{remote:{url: "<?php echo base_url();?>Admin/CheckAreaNameExist",type:"post",
                    data:{
                    cityidval:function(){return $("#txtcityid").val()},
                    areanameval:function(){return $("#txtareaname").val()},
                    }}
                }},
        messages:{
            txtareaname:{remote:"Area Present For Given City Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_area').validate({
        
        rules:{
            edittxtareaname:{remote:{url: "<?php echo base_url();?>Admin/EditCheckAreaNameExist",type:"post",
                    data:{
                    areaidval:function(){return $("#areaid").val()},
                    cityidval:function(){return $("#edittxtcityid").val()},
                    areanameval:function(){return $("#edittxtareaname").val()},
                    }}
                }},
        messages:{
            edittxtareaname:{remote:"Area Present For Given City Name Exist!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditArea').on('click',function(){ 
        var aid=$(this).data('id');
        var cityid = $(this).data("cid");
        var areaname = $(this).data("aname");
        $('.form_edit_area input#areaid').val(aid).parent().addClass('focused');                
        $('.form_edit_area input#edittxtareaname').val(areaname).parent().addClass('focused');
        $('.form_edit_area select#edittxtcityid').val(cityid).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
    });
    $('.clsDeleteArea').on('click',function(){
            var areaid=$(this).data('id');
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
                url: "<?php echo base_url();?>Admin/DeleteArea",
                method:"post",
                data: {'areaid' : areaid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chkareapresent == 1)
                        {
                            swal("Can Not Deleted!", "Your area record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your area record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                   location.replace('Area');
                    
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