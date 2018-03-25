<section class="content">
        <div class="container-fluid">       
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Current Order Details                                
                            </h2>                           
                        </div>
                        <div class="body">
                         
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control AutocompleteCityName" id="txtcityname" name="txtcityname" value="" required style="text-transform: capitalize;" required>
                                                <label class="form-label">City Name<b style="color:red">*</b></label>
                                            </div>
                                        </div>                                     
                                    </div>
                                    <button class="btn btn-primary waves-effect" type="submit" id="btnCitySubmit">SUBMIT</button>
                                </div>
                           
                           
                            <!--div class="demo-radio-button">
                                    <input name="orders" type="radio" class="with-gap radio_orders" id="radio_1" value="NewOrders">
                                    <label for="radio_1">Pending Orders</label>
                                    <input name="orders" type="radio" id="radio_2" class="with-gap radio_orders" value="CompletedOrders">
                                    <label for="radio_2">Confirmed Orders</label>
                                    <input name="orders" type="radio" id="radio_3" class="with-gap radio_orders" value="CriticalOrders">
                                    <label for="radio_3">Delivered Orders</label>
                                    <input name="orders" type="radio" id="radio_4" class="with-gap radio_orders" value="FailedOrders">
                                    <label for="radio_4">Completed Orders</label>                                  
                            </div-->                                                   
                            <div class="table-responsive collapse" id="fetchCityWiseOrders">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="largeModalInvoice" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Invoice Details</h4>
            </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>                    
        </div>
    </div>
</div>
<div class="modal fade" id="largeModalUpdateQty" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Update Quantity</h4>
            </div>
            <form class="form_update_qty" id="form_update_qty" method="post" action="<?php echo base_url();?>SubAdmin/UpdateQtyBySubAdmin" enctype="multipart/form-data"> 
                <input type="hidden" name="orderid" id="orderid" value="">
                <input type="hidden" name="vitemid" id="vitemid" value="">
                <input type="hidden" name="iprice" id="iprice" value="">
                <input type="hidden" name="updateattempt" id="updateattempt" value="">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">                              
                                    <input type="text" class="form-control" id="txtitemname" name="txtitemname" value="" required readonly>
                                    <label class="form-label">Item Names<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">                               
                                    <input type="text" class="form-control" id="stock" name="stock" value="" required readonly>
                                    <label class="form-label">Item Stock<b style="color:red">*</b></label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">                                    
                                    <input type="text" class="form-control only_numbers" id="txtitemqty" name="txtitemqty" value="" required >
                                    <label class="form-label">Item Qty<b style="color:red">*</b></label>
                                </div>
                                <p class="qtyerror" style="color:red;"></p>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="submit" id="btnQtySubmit">SUBMIT</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>                    
        </div>
    </div>
</div>
<div class="modal fade" id="largeModalAssignDeliveryBoy" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Assign Delivery Boy</h4>
            </div>
            <form class="form_assign_dboy" id="form_assign_dboy" method="post" action="<?php echo base_url();?>SubAdmin/AssignDeliveryBoyBySubAdmin" enctype="multipart/form-data"> 
                <input type="hidden" name="orderid" id="orderid" value="">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" id="txtdelid" name="txtdelid" required>
                                        <option value="">Select DeliveryBoy</option>
                                        <?php if(!empty($DeliveryBoy)){
                                            foreach($DeliveryBoy as $dboy){if($dboy->verified == 1){?>
                                                <option value="<?php echo $dboy->del_id;?>"><?php echo $dboy->name;?></option>
                                        <?php }}}?>
                                    </select> 
                                </div>
                            </div>  
                        </div>                 
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="submit" id="btnQtySubmit">SUBMIT</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>                    
        </div>
    </div>
</div> 
<script>
 $(document).ready(function($){
    /*$('.radio_orders').on('change',function(){ 
        var radio_val=$(this).val();
        // alert(radio_val);
        $.ajax({
            url: "<?php echo base_url();?>SubAdmin/GetOrderstatusResult",
            method:"post",
            data: {'orderstatus' : radio_val},
            success: function(result)
            {
                $('.table-responsive').html();
                $('.table-responsive').html(result);                                
            },
            error: function()
            {
                alert("This Banners is in Use So you can't Delete it");
            }
        });
    });  */ 
    $('.Changestatus').on('click',function(){
        var status = $(this).data('status');
        var oid = $(this).data('id');
        
        $.ajax({
            url: "<?php echo base_url();?>SubAdmin/ChangeOrderStatus",
            method:"post",
            data: {'oid' : oid,'status' : status},
            dataType: 'json',
            success: function(result)
            {
                    
                swal({
                        title:"Order Status Changed!",
                        text: "Order Status Sucessfully Changed!",
                        type: "success",
                        timer: 2000,
                        closeOnConfirm: true
                    }, function () {
                            location.replace('Orders');
                });

                
            
            },
            error: function()
            {
                alert("Something Went Wroung!");
            }
        });                
    });  
    $( ".AutocompleteCityName" ).autocomplete({
        source: "CityNameAutocomplete",
        minLength: 2,
        autoFocus:true
    });
    /*$('#txtitemqty').on('blur',function(){ 
        $('.qtyerror').empty();
        var array_iqty = $('#txtitemqty').val().split(",");
        var array_istock = $('#stock').val().split(",");
        $.each(array_iqty,function(i){
            //alert(array_iqty[i]);alert(array_istock[i]);
            if(array_iqty[i]>array_istock[i])
            {               
                var error = array_iqty[i]+'Quantity is out of stock'+array_istock[i]+' ,';
                $('#txtitemqty').parents('.form-line').addClass('error');
                //$('#txtitemqty').parents('.form-group').append(error);
                $('.qtyerror').append(error)
                //swal(array_iqty[i]+'Quantity is out of stock'+array_istock[i]);
               // highlight:function(input){$(input).parents('.form-line').addClass('error')},
            }
            else
            {
               // swal(array_iqty[i]+'Quantity is match stock'+array_istock[i]);
               $('#txtitemqty').parents('.form-line').removeClass('error');
               
            }
        });
    });*/
    $('#btnCitySubmit').on('click',function(){ 
        var cityname=$('#txtcityname').val();
    
        if(cityname)
        {
            $.ajax({
                url: "<?php echo base_url();?>SubAdmin/GetCityWiseOrders",
                method:"post",
                data: {'cityname' : cityname},
                success: function(result)
                {
                    $("#fetchCityWiseOrders").removeClass('collapse');
                    $("#fetchCityWiseOrders").html(result);                 
                },
                error: function()
                {
                alert("Something Went Wroung!");
                }
            }); 
        }
        else{
            
            swal('Enter City Name!');
        }      
    
    });
    $('#form_update_qty').validate({        
        rules:{
            'txtitemqty':{remote:{url: "<?php echo base_url();?>SubAdmin/CheckQtyStock",type:"post",
                    data:{
                    qtyval:function(){return $('#txtitemqty').val()},
                    stockval:function(){return $('#stock').val()},
                    }}
        }},
        messages:{
            'txtitemqty':{remote:"Quantity Out Of Stock!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_assign_dboy').validate({        
        rules:{
            'txtdelid':{remote:{url: "<?php echo base_url();?>SubAdmin/CheckDelBoyAvailability",type:"post",
                    data:{
                    delval:function(){return $('#txtdelid').val()},
                    }}
        }},
        messages:{
            'txtdelid':{remote:"Already Assigned,Please select other delivery boy!"}
                },
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
});

</script>