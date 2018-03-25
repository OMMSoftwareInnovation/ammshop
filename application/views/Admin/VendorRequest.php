<section class="content">
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
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
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
                                <?php $i=1;if(!empty($VendorRequest)){
                                    foreach($VendorRequest as $vendor){?>
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
                                                <a href="#" class="ChangeStatus" id="ChangeStatus" title="Accepted"  data-id="<?php echo $vendor->vid;?>" data-status="Accepted" > <span class="label label-default">Accept</span></a>
                                                <a href="#" class="ChangeStatus" id="ChangeStatus" title="Rejected"  data-id="<?php echo $vendor->vid;?>" data-status="Rejected" ><span class="label label-danger">Reject</span></a>                                           
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
<script>
    $(document).ready(function($){
    /* $('.chkblock').on('change',function(){
            $(this).val(this.checked ? "0" : "1");
            var blockValue = $(this).val();
            var vendorid = $(this).data('id');                             
            $.ajax({
                url: "<?php echo base_url();?>Admin/BlokUnblockVendor",
                method:"post",
                data: {'blockValue' : blockValue,'vendorid' : vendorid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.blockval == 0)
                    {                            
                        swal({
                                title: "Unblocked!",
                                text: "Vendor unblocked!",
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
                            text: "Vendor blocked!",
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
    });*/
    $('.ChangeStatus').on('click',function(){
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
                location.replace('VendorRequest')            
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });                 
    });
    });
</script>