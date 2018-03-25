$(function(){$('.js-sweetalert button').on('click',function(){var type=$(this).data('type');if(type==='basic'){showBasicMessage()}
else if(type==='with-title'){showWithTitleMessage()}
else if(type==='success'){showSuccessMessage()}
else if(type==='confirm'){showConfirmMessage()}
else if(type==='cancel'){showCancelMessage()}
else if(type==='with-custom-icon'){showWithCustomIconMessage()}
else if(type==='html-message'){showHtmlMessage()}
else if(type==='autoclose-timer'){showAutoCloseTimerMessage()}
else if(type==='prompt'){showPromptMessage()}
else if(type==='ajax-loader'){showAjaxLoaderMessage()}})});function showBasicMessage(){swal("Here's a message!")}
function showWithTitleMessage(){swal("Here's a message!","It's pretty, isn't it?")}
function showSuccessMessage(){swal("Good job!","You clicked the button!","success")}
function showConfirmMessage(){swal({title:"Are you sure?",text:"You will not be able to recover this imaginary file!",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes, delete it!",closeOnConfirm:!1},function(){swal("Deleted!","Your imaginary file has been deleted.","success")})}
function showCancelMessage(){swal({title:"Are you sure?",text:"You will not be able to recover this imaginary file!",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes, delete it!",cancelButtonText:"No, cancel plx!",closeOnConfirm:!1,closeOnCancel:!1},function(isConfirm){if(isConfirm){swal("Deleted!","Your imaginary file has been deleted.","success")}else{swal("Cancelled","Your imaginary file is safe :)","error")}})}
function showWithCustomIconMessage(){swal({title:"Sweet!",text:"Here's a custom image.",imageUrl:"../../images/thumbs-up.png"})}
function showHtmlMessage(){swal({title:"HTML <small>Title</small>!",text:"A custom <span style=\"color: #CC0000\">html<span> message.",html:!0})}
function showAutoCloseTimerMessage(){swal({title:"Auto close alert!",text:"I will close in 2 seconds.",timer:2000,showConfirmButton:!1})}
function showPromptMessage(){swal({title:"An input!",text:"Write something interesting:",type:"input",showCancelButton:!0,closeOnConfirm:!1,animation:"slide-from-top",inputPlaceholder:"Write something"},function(inputValue){if(inputValue===!1)return!1;if(inputValue===""){swal.showInputError("You need to write something!");return!1}
swal("Nice!","You wrote: "+inputValue,"success")})}
function showAjaxLoaderMessage(){swal({title:"Ajax request example",text:"Submit to run ajax request",type:"info",showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0,},function(){setTimeout(function(){swal("Ajax request finished!")},2000)})}