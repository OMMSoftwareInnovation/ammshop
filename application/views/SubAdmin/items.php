<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Items Requests
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
                                        <th>Vendor Details</th>
                                        <th>Description</th>
                                        <th>Block/Unblock</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Items Name</th>
                                        <th>Category</th>
                                        <th>Vendor Details</th>
                                        <th>Description</th>
                                         <th>Block/Unblock</th>
                                    </tr>
                                </tfoot>
                                <tbody ID="ItemsDetails">
                                <?php $i=1;if(!empty($ItemDetails)){
                                    foreach($ItemDetails as $item){?>
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
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto"> 
                                                <b>Name:</b> <?php echo $item->name;?><br>
                                                <b>Business Name:</b> <?php echo $item->shop_name;?><br>
                                                <b>Address:</b> <?php echo $item->address;?><br>
                                                <b>Mobile No:</b> <?php echo $item->mobile_no;?><br>
                                            </div>
                                        </td>
                                        <td><div style="width:100%; max-height:60px; overflow:auto"><?php echo $item->description;?></div></td>
                                        <td>
                                            <a href="<?php echo base_url();?>Admin/ItemDetails/<?php echo $item->item_id;?>" class="clsViewItems" id="idViewItems" title="Edit" data-id="<?php echo $item->item_id;?>" ><i class="glyphicon glyphicon-edit icon-white"  title="View Item Details" data-toggle="tooltip"></i></a>
                                            <div class="row clearfix">
                                                <div class="col-xs-12 col-sm-6 align-right">
                                                    <div class="switch panel-switch-btn">                                                         
                                                        <label>
                                                            <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $item->block;?>" data-id="<?php echo $item->item_id;?>"
                                                                <?php if($item->block == '0'){?>checked
                                                                <?php }?>><span class="lever switch-col-cyan"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
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
</section>
<script>
    $(document).ready(function($){
        $('.chkblock').on('change',function(){
            $(this).val(this.checked ? "0" : "1");
            var blockValue = $(this).val();
            var itemid = $(this).data('id');                             
            $.ajax({
                url: "<?php echo base_url();?>Admin/BlokUnblockItem",
                method:"post",
                data: {'blockValue' : blockValue,'itemid' : itemid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.blockval == 0)
                    {                            
                        swal({
                                title: "Unblocked!",
                                text: "Item unblocked!",
                                type: "success",
                                timer: 2000,
                                closeOnConfirm: true
                            }, function () {
                                
                            });
                            
                    }
                    else
                    {
                        swal({
                            title: "Blocked!",
                            text: "Item blocked!",
                            type: "error",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                            
                        });
                        
                    } 
                    
                                
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });                 
        });
    });
</script>