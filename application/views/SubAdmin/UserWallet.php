<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            User Wallet Details
                            <button type="button" class="btn bg-light-green btn-circle-lg waves-effect waves-circle waves-float pull-right" style="margin-top: -14px;" data-toggle="modal" data-target="#largeModalAddUserWallet" title="AddUserWallet">
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
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                        <th>Wallet Money</th>
                                        <th>Created On</th>
                                        <th>Updated On</th>
                                        <th>Created By</th>
                                        <th>Actions</th>		
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                        <th>Wallet Money</th>
                                        <th>Created On</th>
                                        <th>Updated On</th>
                                        <th>Created By</th>
                                        <th>Actions</th>	
                                    </tr>
                                </tfoot>
                                <tbody ID="CatDetails">
                                <?php $i=1;if(!empty($UserWallet)){
                                    foreach($UserWallet as $userwallet){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td>
                                            <?php echo $userwallet->uname;?><br>
                                        </td>
                                        <td><?php echo $userwallet->mobile_no;?></td>
                                        <td><?php echo $userwallet->email;?></td>
                                        <td><?php echo $userwallet->wallet;?></td>
                                        <td><?php echo $userwallet->created_at;?></td> 
                                        <td><?php echo $userwallet->updated_at;?></td>
                                        <td>
                                        <?php 
                                            if($userwallet->aname)
                                            { 
                                                echo $userwallet->aname; echo " (Admin)";
                                            }
                                            elseif($userwallet->sname)
                                            { 
                                                echo $userwallet->sname; echo " (SubAdmin)";
                                            }
                                        ?>
                                       </td>
                                        <td>
                                            <a href="#" class="clsEditUserWallet" id="idEditUserWallet" title="Edit" data-toggle="modal" data-target="#largeModalAddUserWallet" data-id="<?php echo $userwallet->user_wallet_id;?>" data-uid="<?php echo $userwallet->uid;?>" data-wallet="<?php echo $userwallet->wallet;?>"><i class="glyphicon glyphicon-edit icon-white"  title="Edit UserWallet" data-toggle="tooltip"></i></a>
                                            <a href="#" class="clsDeleteUserWallet" id="idDeleteUserWallet" title="Delete" data-id="<?php echo $userwallet->user_wallet_id;?>"><i class="glyphicon glyphicon-trash icon-white"  title="Delete UserWallet" data-toggle="tooltip"></i></a>
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
    <div class="modal fade" id="largeModalAddUserWallet" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Money To User Wallet </h4>
                </div>
                <form class="form_add_UserWallet" id="form_add_UserWallet" method="post" action="<?php echo base_url();?>SubAdmin/AddMoneyToUserWallet" enctype="multipart/form-data"> 
                    <input type="hidden" name="user_wallet_id" id="user_wallet_id">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" data-live-search="true" id="txtuserid" name="txtuserid" required>
                                            <option value="">Select User</option>
                                            <?php if(!empty($AllUsers)){
                                                foreach($AllUsers as $user){?>
                                                    <option value="<?php echo $user->uid;?>"><?php echo $user->name;?></option>
                                            <?php }}?>
                                        </select> 
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" id="txtwalletmoney" name="txtwalletmoney" value="" required style="text-transform: capitalize;">
                                        <label class="form-label">Wallet Amount<b style="color:red">*</b></label>
                                    </div>
                                </div>
                            </div>                  
                        </div>                          
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" type="submit" id="btnSubmit">SUBMIT</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function($){
    $('#form_add_UserWallet').validate({
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('#form_edit_UserWallet').validate({               
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
    });
    $('.clsEditUserWallet').on('click',function(){ 
        var uid=$(this).data('uid');
        var wallet = $(this).data("wallet");
        var user_wallet_id=$(this).data("id");
        $('.form_add_UserWallet input#txtwalletmoney').val(wallet).parent().addClass('focused');                
         $('.form_add_UserWallet select#txtuserid').val(uid).parent().addClass('focused');
         $('.form_add_UserWallet input#user_wallet_id').val(user_wallet_id).parent().addClass('focused');
         $(".selectpicker").selectpicker("refresh");
    });
    $('.clsDeleteUserWallet').on('click',function(){
            var UserWalletid=$(this).data('id');
            swal({
            title: "Are you sure?",
            text: "You will not be able to recover this city record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            
                $.ajax({
                url: "<?php echo base_url();?>Admin/DeleteUserWallet",
                method:"post",
                data: {'UserWalletid' : UserWalletid},
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 'true')
                    {
                        if(result.chkUserWalletpresent == 1)
                        {
                            swal("Can Not Deleted!", "Your UserWallet record can not be deleted,It is in use", "success");
                        }
                        else{
                            swal("Deleted!", "Your UserWallet record deleted successfully!", "success");
                        }
                    }
                    else
                    {
                        swal("Error!", "Something went wroung!", "error");
                    }
                   location.replace('WalletMoney');
                    
                },
                error: function()
                {
                    alert("This Event is in Use So you can't Delete it");
                }
            });
        });
    });
});
</script>