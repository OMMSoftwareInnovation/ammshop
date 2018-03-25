<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Item Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddItem" title="Add Item">
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
                                        <th>Items Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Block/Unblock</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Items Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                         <th>Block/Unblock</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="ItemsDetails">
                                <?php $i=1;if(!empty($Items)){
                                    foreach($Items as $item){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $item->item_name;?></td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto"> 
                                                <b>Category:</b> <?php echo $item->category_name;?><br>
                                                <b>Sub Category:</b> <?php echo $item->sub_cat_name;?><br>
                                                <b>Sub Sub Category:</b> <?php echo $item->filt_name;?><br>
                                            </div>
                                        </td>
                                        <td><div style="width:100%; max-height:60px; overflow:auto"><?php echo $item->description;?></div></td>
                                        <td>
                                            <a href="<?php echo base_url();?>Vendor/ItemDetails/<?php echo $item->item_id;?>" class="clsViewItems" id="idViewItems" title="Edit" data-id="<?php echo $item->item_id;?>" ><i class="glyphicon glyphicon-edit icon-white"  title="View Item Details" data-toggle="tooltip"></i></a>
                                            
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
    <div class="modal fade" id="largeModalAddItem" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Item</h4>
                </div>
                    <form id="form_add_item" method="post" action="<?php echo base_url();?>Vendor/AddItem" enctype="multipart/form-data"> 
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectmaincat selectpicker" data-live-search="true" id="txtcatid" name="txtcatid" required>
                                            <option value="">Select Category</option>
                                            <?php if(!empty($CategoryDetails)){
                                                foreach($CategoryDetails as $cat){//if($cat->category_name != 'Restaurents'){?>
                                                    <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->category_name;?></option>
                                            <?php }}//}?>
                                        </select> 
                                        <div class="help-info">Main Category<b style="color:red">*</b></div>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4 DivfetchSubCat collapse">
                               
                            </div>    
                            <div class="col-md-4 DivfetchSubSubCat collapse">
                               
                            </div>                     
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-4 DivfetchQtytype collapse" id="fetchQtytype">
                                
                            </div> 
                            <div class="col-md-4 DivfetchQty collapse" id="fetchQty">
                                
                            </div>                       
                        </div> 
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="itemname" name="itemname" value="" >
                                        <label class="form-label">Item Name <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="itemprice" name="itemprice" value="" >
                                        <label class="form-label">Item Price <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="stock" name="stock" value="" >
                                        <label class="form-label">Stock<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                            
                        </div> 
                        <div class="row clearfix">    
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="gstamt" name="gstamt" value="" >
                                        <label class="form-label">Gst Amount <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                        
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="discount" name="discount" value="" >
                                        <label class="form-label">Discount <b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" class="form-control" id="description" name="description" value="" ></textarea>
                                        <label class="form-label">Description<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row clearfix">   
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="file" class="form-control image" id="userFiles" name="userFiles[]" value="" multiple required>
                                    <div class="help-info">Item Images<b style="color:red">*</b></div>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" type="submit" id="btnSubmitCourse">SUBMIT</button>
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

                url: "<?php echo base_url();?>Vendor/GetSubCategory",
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
        
    });
</script>