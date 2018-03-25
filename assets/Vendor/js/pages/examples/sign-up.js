$(function(){
    $('#sign_up').validate({
        rules:{'confirm':{equalTo:'[name="password"]'},
        'mobile':{
            phoneIN:!0,
            remote:{
                    url:"checkmobileavailability",
                    type:"post",
                    data:{
                            mobile:function(){
                                return $("#mobile").val()
                            }
                        }
                  }},
    Username:{
        remote:{url:"checkavailability",
        type:"post",
        data:{
            Username:function(){return $("#Username").val()}
        }}}},
        messages:{mobile:{remote:"Mobile Number is already registered"},
        Username:{remote:"This User Name is already Taken"}},
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},
        errorPlacement:function(error,element){$(element).parents('.input-group').append(error);
        $(element).parents('.form-group').append(error)}});
        
$('#Passwords').validate({rules:{'confirm':{equalTo:'[name="password"]'},
        oldpassword:{remote:{url:"Checkpassword",
        type:"post",data:
        {oldpassword:function(){return $("#oldpassword").val()}}}}},
        messages:{oldpassword:{remote:"Please Enter Valid Password"}},
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}});$('#businesssign_up').validate({rules:{'confirm':{equalTo:'[name="password"]'},'mobile':{phoneIN:!0,remote:{url:"checkmobileavailability",type:"post",data:{mobile:function(){return $("#mobile").val()}}}},email:{remote:{url:"checkavailability",type:"post",data:{email:function(){return $("#email").val()}}}}},messages:{mobile:{remote:"Mobile Number is already registered"},email:{remote:"This Email Id is already Registered"}},highlight:function(input){$(input).parents('.form-line').addClass('error')},unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},errorPlacement:function(error,element){$(element).parents('.input-group').append(error);$(element).parents('.form-group').append(error)}})});

        $('#profile').validate({rules:{'confirm':{equalTo:'[name="password"]'},
Username:{remote:{url:"checkavailability",type:"post",
data:{Username:function(){return $("#Username").val()}}}}},
messages:{Username:{remote:"This User Name is already Taken"}},
highlight:function(input){$(input).parents('.form-line').addClass('error')},
unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},
errorPlacement:function(error,element){$(element).parents('.input-group').append(error);
$(element).parents('.form-group').append(error)}});


$('#contactForm').validate({
    rules:{
        'confirm':{equalTo:'[name="password"]'},
        uname:{
            remote:{
                    url: "checkusername",
                    type:"post",
                    data:{
                            username:function(){
                                return $("#uname").val()
                            }
                        }
                  }},
        mobile:{
            required:true,
            intlTelNumber:true
            },
        mob:{
            required:true,
            intlTelNumber:true,
            remote:{
                url: "checkmobilenumber",
                type:"post",
                data:{
                        mob:function(){
                            return $("#mob").val()
                        }
                    }
              }
        }},
    messages:{
        mobile:"phone number is not valid",
        uname:{remote:"Username already taken please choose another."},
        mob:{remote:"Mobile Number already used please use another."}},
    highlight:function(input){$(input).parents('.form-line').addClass('error')},
    unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},
    errorPlacement:function(error,element){$(element).parents('.input-group').append(error);
    $(element).parents('.form-group').append(error)}});		
    

    $('#verifyfrm').validate({
        rules:{
        otp:{
            remote:{
                    url: "checkotp",
                    type:"post",
                    data:{
                            otp:function(){
                                return $("#otp").val()
                            },
                            mobile:function(){
                                return $("#mobile").val()
                            }
                        }
                  }}},
        messages:{otp:{remote:"Please Enter Valid OTP"}},
        highlight:function(input){$(input).parents('.form-line').addClass('error')},
        unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},
        errorPlacement:function(error,element){$(element).parents('.input-group').append(error);
        $(element).parents('.form-group').append(error)}});

        $('#Signin').validate({
            rules:{
                'confirm':{equalTo:'[name="password"]'},
                'mobile':{
                    // phoneIN:!0,
                    }},
                messages:{mobile:"Enter Valid Mobile Number"},
            highlight:function(input){$(input).parents('.form-line').addClass('error')},
            unhighlight:function(input){$(input).parents('.form-line').removeClass('error')},
            errorPlacement:function(error,element){$(element).parents('.input-group').append(error);
            $(element).parents('.form-group').append(error)}});		