<body>
<header id="header">
	<div class="container">
  	<a href="#" class="logo"><img src="<?php echo base_url();?>assets/Vendor/images/logo.png"></a>
	</div>
</header>
<!--[header]-->
<section class="partner-withus">
	<div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <div class="partnerus">
                    <h1>Partner with us</h1>
                    <h2>Grow your business and your expertise.</h2>      
                </div>
            </div>            
            <div class="col-md-4 col-sm-6">
                <!--[login-sect]-->
                <div class="partnerlogin clearfix">
                    <h3 class="textcenter">Log In</h3>
                    <span class="">
                    <?php
                    if (isset($message_display)) {
                    echo "<div class='message'>";
                    echo $message_display;
                    echo "</div>";
                    }
                    ?>
                    <?php
                    echo "<div class='error_msg'>";
                    if (isset($error_message)) {
                    echo $error_message;
                    }
                    echo validation_errors();
                    echo "</div>";
                    ?>
                    </span>
					<form id="sign_in" method="POST" action="<?php echo base_url();?>Vendor/Vendor_login_process">
                        <!--div class="msg textcenter">Sign in to Display Your Business</div-->
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="username" placeholder="User Name or Mobile No " required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-xs-8 p-t-5">
                                <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                                <label for="rememberme">Remember Me</label>
                            </div>-->
                            <div class="col-xs-12">
                                <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                            </div>
                        </div><br>
                        <div class="row textcenter">
                            <div class="form-group">
                                <a href="<?php echo base_url();?>Vendor/Forgot" class="forget-link forgotpass" data-title="Forgot Password" data-type="password" id="forgotpass"> Forgot Your Password</a> 
                                <div class="orlogin"><strong>or</strong></div>
                                <h2 class="newuser">New Vendor ? <a href="<?php echo base_url();?>Vendor/Register">Register Here</a></h2>
                            </div>
                        </div>
                    </form>
                </div>
            </div>              

        </div>
	</div>
</section>
<footer style=" margin-top:0;">
		<div class="container">
        	<ul class="login-footer">
            	<li><a href="<?php echo base_url();?>" target="_blank">Home</a></li>
                <li><a href="" target="_blank" id="term">Terms of Use</a></li>                
            </ul>
        </div>    
    </footer>


