<section class="content">
    <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Vendor Details
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="Vendordetails" class="table table-bordered table-striped table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Joining Date</th>
                                            <th>Business Name</th>
                                            <th>Business Image</th>
                                            <th>Business Type</th>
                                            <th>Shop Address</th>
                                            <th>Area</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Kyc</th>
                                            <th>Gallery</th>
                                            <th>About</th>
                                            <th>Announcement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Joining Date</th>
                                            <th>Business Name</th>
                                            <th>Business Image</th>
                                            <th>Business Type</th>
                                            <th>Shop Address</th>
                                            <th>Area</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Kyc</th>
                                            <th>Gallery</th>
                                            <th>About</th>
                                            <th>Announcement</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody ID="Vdetails">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </section>
    <!-- <?php if(!empty($Vendor)){
                                            foreach($Vendor as $vendor){?>
                                        <tr>
                                            <td><?php echo $vendor->name;?></td>
                                            <td><?php echo $vendor->email;?></td>
                                            <td><?php echo $vendor->mobile_no;?></td>
                                            <td><?php echo $vendor->businessname;?></td>
                                            <td><img id="bimage" height="150" width-"150" src="<?php echo base_url().$vendor->business_image;?>"/></td>
                                            <td><?php echo $vendor->catname;?></td>
                                            <td><?php echo $vendor->shop_address;?></td>
                                            <td><?php echo $vendor->area;?></td>
                                            <td><?php echo $vendor->city;?></td>
                                            <td><?php echo $vendor->state;?></td>
                                            <td><?php echo $vendor->pincode;?></td>
                                            <td><a title="View KYC" href="<?php echo base_url().$vendor->kyc;?>" target="_blank"><i class="material-icons">insert_drive_file</i> KYC</a></td>
                                            <td><a title="View Gallery" href="<?php echo base_url().'Admin/VendorGallery/'.$vendor->vid.'';?>" target="_blank"><i class="material-icons">burst_mode</i>Gallery</a></td>
                                            <td><?php echo $vendor->about;?></td>
                                            <td><?php echo $vendor->anouncement;?></td>
                                            <td><input id="vid" type="hidden" value="<?php echo $vendor->vid;?>"/>
                                            <?php if($vendor->block == false){?><a class="Block" href="#" title="Block"><i class="material-icons">block</i></a><?php }else{?>
                                            <a class="Unblock" href="#" title="unblock"><i class="material-icons">remove_red_eye</i></a><?php }?>
                                            <a class="Delete" href="#" title="Delete"><i class="material-icons">delete_forever</i></a></td>
                                        </tr><?php }}?> -->
    <script>
            $(document).ready(function($){
                    $('#Vendordetails').DataTable({
                        responsive: true,
                        "processing": true,
                        "serverSide": true,
                        "ajax": "<?php echo base_url("Admin/ajax_filter");?>",
                        "order": [[ 2, "asc" ]],
                        "saveState":true		
                    });
                $('#Vendordetails').on('click','.Unblock',function(){
                    var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/Unblockvendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                        //  $(form).fadeOut(800, function(){
                        //     form.html(result).fadeIn().delay(2000);
                        // });
                        location.reload();
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("error");
                    }
                });
            });
            $('#Vendordetails').on('click','.Block',function(){
                   var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/blockvendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                        //  $(form).fadeOut(800, function(){
                        //     form.html(result).fadeIn().delay(2000);
                        // });
                        location.reload();
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("error");
                    }
                });
            });
            $('#Vendordetails').on('click','.Delete',function(){
                    var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/Deletevendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                        //  $(form).fadeOut(800, function(){
                        //     form.html(result).fadeIn().delay(2000);
                        // });
                        location.reload();
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("This Vendor is in use You can not Delete it.");
                    }
                });
            });
            
            });
        </script>