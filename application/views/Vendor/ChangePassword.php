<section class="content">
<div class="container-fluid">
    <div class="block-header">
        <h2>Change Password</h2>
    </div>
<!-- Advanced Validation -->
    <div class="row clearfix">
        <div class="col-md-4 col-xs-0"></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Password</h2>
                </div>
                <div class="body">
                    <form id="oldpasscheck_form" method="POST" action="<?php echo base_url();?>Vendor/Updatepassword">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="oldpassword" id="oldpassword" value="" required>
                                <label class="form-label">Old Password</label>
                            </div>
                            <div class="help-info">Old Password</div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" value="" required>
                                <label class="form-label">New Password</label>
                            </div>
                            <div class="help-info">New Password</div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="confirm" value="" required>
                                <label class="form-label">Conform Password</label>
                            </div>
                            <div class="help-info">Conform Password</div>
                        </div>
                        <button class="btn btn-primary waves-effect " type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div></section>

    <script>
        $(document).ready(function($){
            $('#oldpasscheck_form input').parent().addClass('focused');  
            $('#oldpasscheck_form').validate({
                
                rules:{
                    'confirm':{equalTo:'[name="password"]'},   
                    oldpassword:{remote:{url: "<?php echo base_url();?>Vendor/Checkpassword",type:"post",
                          data:{
                            oldpass:function(){return $("#oldpassword").val()},
                          }}
                      }},
                messages:{
                    oldpassword:{remote:"Enter Correct Old Password!"}
                      },
                highlight:function(input){$(input).parents('.form-line').addClass('error')},
                unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}
            });
        });
    </script>