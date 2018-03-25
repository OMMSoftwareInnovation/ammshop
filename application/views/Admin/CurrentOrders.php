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
            </form>                    
        </div>
    </div>
</div>
<script>
 $(document).ready(function($){
    $('.radio_orders').on('change',function(){ 
        var radio_val=$(this).val();
        // alert(radio_val);
        $.ajax({
            url: "<?php echo base_url();?>Admin/GetOrderstatusResult",
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
    });   
    $('.Changestatus').on('click',function(){
        var status = $(this).data('status');
        var oid = $(this).data('id');
        
        $.ajax({
            url: "<?php echo base_url();?>Admin/ChangeOrderStatus",
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
    $('#btnCitySubmit').on('click',function(){ 
        var cityname=$('#txtcityname').val();
        if(cityname)
        {
            $.ajax({
                url: "<?php echo base_url();?>Admin/GetCityWiseOrders",
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
    
});

</script>