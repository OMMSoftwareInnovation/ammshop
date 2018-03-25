<section class="content collapse" id="NoNotificationSection">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                             No Notification Found
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content" id="VendorsRequestNotification">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Vendor Requests
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="VendorsRequestTable">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Shop Name</th>
                                        <th>Business Image</th>
                                        <th>Address</th>
                                        <th>Open/Close Time</th>
                                        <th>Short Desc</th>
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Shop Name</th>
                                        <th>Business Image</th>
                                        <th>Address</th>                                        
                                        <th>Open/Close Time</th>
                                        <th>Short Desc</th>
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->	
                                    </tr>
                                </tfoot>
                                <tbody ID="VendorDetails">
                                <?php $i=1;if(!empty($VendorsDataNoti)){
                                    foreach($VendorsDataNoti as $vendor){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $vendor->name;?></td>
                                        <td><?php echo $vendor->mobile_no;?></td>
                                        <td><?php echo $vendor->shop_name;?></td>
                                        <td><img name="Image" height="50" width="50" src="<?php echo base_url().$vendor->business_image	;?>"></td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto"> 
                                                <b>Address:</b> <?php echo $vendor->address;?><br>
                                                <b>Area:</b> <?php echo $vendor->area_name;?><br>
                                                <b>City:</b> <?php echo $vendor->city_name;?><br>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100%; max-height:60px; overflow:auto"> 
                                                <b>Open Time:</b> <?php echo $vendor->open_time;?><br>
                                                <b>Close Time:</b> <?php echo $vendor->close_time;?><br>
                                            </div>
                                        </td>
                                        <td><div style="width:100%; max-height:60px; overflow:auto"><?php echo $vendor->short_desc;?></div></td>
                                        <td>
                                            <?php if($vendor->verified == 0){?>
                                                <a href="#" class="ChangeStatusVendor" id="ChangeStatus" title="Accepted"  data-id="<?php echo $vendor->vid;?>" data-status="Accepted" > <span class="label label-default">Accept</span></a>
                                                <a href="#" class="ChangeStatusVendor" id="ChangeStatus" title="Rejected"  data-id="<?php echo $vendor->vid;?>" data-status="Rejected" ><span class="label label-danger">Reject</span></a>                                           
                                            <?php }else{?>
                                                -----
                                            <?php }?>
                                        </td>
                                        <!--td>
                                            <div class="row clearfix">
                                                <div class="col-xs-12 col-sm-6 align-right">
                                                    <div class="switch panel-switch-btn">                                                         
                                                        <label>
                                                            <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $vendor->block;?>" data-id="<?php echo $vendor->vid;?>"
                                                                <?php if($vendor->block == '0'){?>checked
                                                                <?php }?>><span class="lever switch-col-cyan"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td-->
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
<section class="content" id="ItemsRequestNotification">
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
                            <table class="table table-bordered table-striped table-hover" id="ItemsRequestTable">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Items Name</th>
                                        <th>Category</th>
                                        <th>Vendor Details</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Items Name</th>
                                        <th>Category</th>
                                        <th>Vendor Details</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->		
                                    </tr>
                                </tfoot>
                                <tbody ID="ItemsDetails">
                                <?php $i=1;if(!empty($ItemsDataNoti)){
                                    foreach($ItemsDataNoti as $item){?>
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
                                            <?php if($item->verified == 0){?>
                                                <a href="#" class="ChangeStatusItem" id="ChangeStatus" title="Accepted"  data-id="<?php echo $item->item_id;?>" data-status="Accepted" > <span class="label label-default">Accept</span></a>
                                                <a href="#" class="ChangeStatusItem" id="ChangeStatus" title="Rejected"  data-id="<?php echo $item->item_id;?>" data-status="Rejected" ><span class="label label-danger">Reject</span></a>                                           
                                            <?php }else{?>
                                                -----
                                            <?php }?>
                                        </td>
                                        <!--td>
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
                                        </td-->
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
          /*  setTimeout(function () {
                $.ajax({
                url: "<?php echo base_url();?>Admin/setchecknoti",
                method:"post",
                success: function(result)
                {
                },
                error: function()
                {
                    alert("There is some problem please try agian later.");
                }
            });
        }, 1000);*/

        var ItemsRequest = $('#ItemsRequestTable').DataTable();
        var countItemsRequestTable = ItemsRequest.data().count();
        if(countItemsRequestTable == 0)
        {
           $('#ItemsRequestNotification').addClass('collapse');

        }
        var VendorsRequest = $('#VendorsRequestTable').DataTable();
        var countVendorsRequestTable = VendorsRequest.data().count();
        if(countVendorsRequestTable == 0)
        {
           $('#VendorsRequestNotification').addClass('collapse');

        }
        if(countItemsRequestTable == 0 && countVendorsRequestTable == 0)        
        {
            $('#NoNotificationSection').removeClass("collapse");
        }
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
        $('.ChangeStatusItem').on('click',function(){
            var itemstatus = $(this).data('status');
            var itemid = $(this).data('id');   
            $.ajax({
                url: "<?php echo base_url();?>Admin/ItemAcceptRejectStatus",
                method:"post",
                data: {'itemstatus' : itemstatus,'itemid' : itemid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.status == 'Accepted')
                    {                            
                        swal({
                                title: "Accepted!",
                                text: "Item Accepted!",
                                type: "success",
                                timer: 2000,
                                closeOnConfirm: true
                            }, function () {
                                
                            });
                            
                    }
                    else
                    {
                        swal({
                            title: "Rejected!",
                            text: "Item Rejected!",
                            type: "error",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                            
                        });
                        
                    }                     
                    location.replace('Notification')            
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });                 
        });
        $('.ChangeStatusVendor').on('click',function(){
            var vendorstatus = $(this).data('status');
            var vendorid = $(this).data('id');   
            $.ajax({
                url: "<?php echo base_url();?>Admin/VendorAcceptRejectStatus",
                method:"post",
                data: {'vendorstatus' : vendorstatus,'vendorid' : vendorid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.status == 'Accepted')
                    {                            
                        swal({
                                title: "Accepted!",
                                text: "Vendor Accepted!",
                                type: "success",
                                timer: 2000,
                                closeOnConfirm: true
                            }, function () {
                                
                            });
                            
                    }
                    else
                    {
                        swal({
                            title: "Rejected!",
                            text: "Vendor Rejected!",
                            type: "error",
                            timer: 2000,
                            closeOnConfirm: true
                        }, function () {
                            
                        });
                        
                    }                     
                    location.replace('Notification')            
                },
                error: function()
                {
                    alert("Something went wroung!");
                }
            });                 
        });
    });
</script>