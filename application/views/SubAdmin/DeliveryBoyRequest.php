<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Delivery Boy Requests
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
                                        <th>Email</th>	
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                        <!--th>Block/Unblock</th-->
                                    </tr>
                                </tfoot>
                                <tbody ID="DeliveryBoyDetails">
                                <?php $i=1;if(!empty($DeliveryBoyRequest)){
                                    foreach($DeliveryBoyRequest as $deliveryboy){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $deliveryboy->name;?></td>
                                        <td><?php echo $deliveryboy->mobile_no;?></td>
                                        <td><?php echo $deliveryboy->email;?></td>
                                         <td>
                                            <?php if($deliveryboy->verified == 0){?>
                                                <a href="#" class="ChangeStatus" id="ChangeStatus" title="Accepted"  data-id="<?php echo $deliveryboy->del_id;?>" data-status="Accepted" > <span class="label label-default">Accept</span></a>
                                                <a href="#" class="ChangeStatus" id="ChangeStatus" title="Rejected"  data-id="<?php echo $deliveryboy->del_id;?>" data-status="Rejected" ><span class="label label-danger">Reject</span></a>                                           
                                            <?php }else{?>
                                                -----
                                            <?php }?>
                                        </td>
                                        <!--td>
                                            <div class="row clearfix">
                                                <div class="col-xs-12 col-sm-6 align-right">
                                                    <div class="switch panel-switch-btn">                                                         
                                                        <label>
                                                            <input type="checkbox" name="chkBlock" class="chkblock" value="<?php echo $deliveryboy->block;?>" data-id="<?php echo $deliveryboy->del_id;?>"
                                                                <?php if($deliveryboy->block == '0'){?>checked
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
    /*$('.chkblock').on('change',function(){
        $(this).val(this.checked ? "0" : "1");
        var blockValue = $(this).val();
        var deliveryboyid = $(this).data('id');                             
        $.ajax({
            url: "<?php echo base_url();?>Admin/BlokUnblockDeliveryBoy",
            method:"post",
            data: {'blockValue' : blockValue,'deliveryboyid' : deliveryboyid},
            dataType: 'json',
            success: function(result)
            {
                if(result.blockval == 0)
                {                            
                    swal({
                            title: "Unblocked!",
                            text: "Delivery Boy unblocked!",
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
                        text: "Delivery Boy blocked!",
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
        var deliveryboystatus = $(this).data('status');
        var deliveryboyid = $(this).data('id');   
        $.ajax({
            url: "<?php echo base_url();?>Admin/DeliveryBoyAcceptRejectStatus",
            method:"post",
            data: {'deliveryboystatus' : deliveryboystatus,'deliveryboyid' : deliveryboyid},
            dataType: 'json',
            success: function(result)
            {
                if(result.status == 'Accepted')
                {                            
                    swal({
                            title: "Accepted!",
                            text: "Delivery Boy Accepted!",
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
                        text: "Delivery Boy Rejected!",
                        type: "error",
                        timer: 2000,
                        closeOnConfirm: true
                    }, function () {
                        
                    });
                    
                }                     
                location.replace('DeliveryBoyRequest')            
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });                 
    });
    });
</script>