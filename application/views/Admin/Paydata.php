<?php if(!empty($VendorPayment)){
                                        foreach($VendorPayment as $vendor){?>
                                        <tr>
                                            <td><?php echo $vendor->name;?></td>
                                            <td><?php echo $vendor->date;?></td>
                                            <td><?php echo $vendor->amount;?></td>
                                            <td>
                                            <input id="ofid" type="hidden" value="<?php echo $vendor->vaid;?>">
                                            <a class="Accept" title="Reject Payment"><i class="material-icons">done</i></a>
                                            <a class="Reject" title="Accept Payment"><i class="material-icons">clear</i></a></td>
                                        </tr><?php }}?>

                                        <script>
            $(document).ready(function($){
                $('.Accept').on('click',function(){
                    var id=$(this).parent().find('#ofid').val();
                    var form=$('#OfferDetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/AcceptPayment",
                    method:"post",
                    data: {'ofid' : id},
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
                        alert("There is some problem please try agian later.");
                    }
                });
            });
            $('.Reject').on('click',function(){
                    var id=$(this).parent().find('#ofid').val();
                    var form=$('#OfferDetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/RejectPayment",
                    method:"post",
                    data: {'ofid' : id},
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
                        alert("There is some problem please try agian later.");
                    }
                });
            });
        });
        </script>