< <?php if(!empty($Vendor)){
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
                                        </tr><?php }}?>

<script>
            $(document).ready(function($){
                $('.Unblock').on('click',function(){
                    var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/Unblockvendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                         $(form).fadeOut(800, function(){
                            form.html(result).fadeIn().delay(2000);
                        });
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("Error");
                    }
                });
            });
            $('.Block').on('click',function(){
                   var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/blockvendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                         $(form).fadeOut(800, function(){
                            form.html(result).fadeIn().delay(2000);
                        });
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("error");
                    }
                });
            });
            $('.Delete').on('click',function(){
                    var id=$(this).parent().find('#vid').val();
                    var form=$('#Vdetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/Deletevendor",
                    method:"post",
                    data: {'vid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                         $(form).fadeOut(800, function(){
                            form.html(result).fadeIn().delay(2000);
                        });
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