$(function(){skinChanger();activateNotificationAndTasksScroll();setSkinListHeightAndScroll(!0);setSettingListHeightAndScroll(!0);$(window).resize(function(){setSkinListHeightAndScroll(!1);setSettingListHeightAndScroll(!1)})});function skinChanger(){$('.right-sidebar .demo-choose-skin li').on('click',function(){var $body=$('body');var $this=$(this);var existTheme=$('.right-sidebar .demo-choose-skin li.active').data('theme');$('.right-sidebar .demo-choose-skin li').removeClass('active');$body.removeClass('theme-'+existTheme);$this.addClass('active');$body.addClass('theme-'+$this.data('theme'))})}
function setSkinListHeightAndScroll(isFirstTime){var height=$(window).height()-($('.navbar').innerHeight()+$('.right-sidebar .nav-tabs').outerHeight());var $el=$('.demo-choose-skin');if(!isFirstTime){$el.slimScroll({destroy:!0}).height('auto');$el.parent().find('.slimScrollBar, .slimScrollRail').remove()}
$el.slimscroll({height:height+'px',color:'rgba(0,0,0,0.5)',size:'6px',alwaysVisible:!1,borderRadius:'0',railBorderRadius:'0'})}
function setSettingListHeightAndScroll(isFirstTime){var height=$(window).height()-($('.navbar').innerHeight()+$('.right-sidebar .nav-tabs').outerHeight());var $el=$('.right-sidebar .demo-settings');if(!isFirstTime){$el.slimScroll({destroy:!0}).height('auto');$el.parent().find('.slimScrollBar, .slimScrollRail').remove()}
$el.slimscroll({height:height+'px',color:'rgba(0,0,0,0.5)',size:'6px',alwaysVisible:!1,borderRadius:'0',railBorderRadius:'0'})}
function activateNotificationAndTasksScroll(){$('.navbar-right .dropdown-menu .body .menu').slimscroll({height:'254px',color:'rgba(0,0,0,0.5)',size:'4px',alwaysVisible:!1,borderRadius:'0',railBorderRadius:'0'})}
addLoadEvent(loadTracking);var trackingId='UA-30038099-6';function addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func}else{window.onload=function(){oldonload();func()}}}
function loadTracking(){(function(i,s,o,g,r,a,m){i.GoogleAnalyticsObject=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create',trackingId,'auto');ga('send','pageview')}