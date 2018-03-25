(function($){var keys={tab:9,enter:13,esc:27,left:37,up:38,right:39,down:40}
var defaults={throttle:300,renderItem:defaultRenderItem,noResults:defaultNoResults,regexpMatcher:defaultRegexpMatcher}
$.fn.event=function(opts){opts=$.extend({},defaults,opts)
return this.each(function(){if($(this).parent().length===0)throw new Error('<select> element must have a parent')
var $select=$(this).hide().data('eventItem',selectItem).data('refreshItem',refreshItem).data('reset',reset)
var $event=$('<div>').addClass('event')
var $selected=$('<div>').addClass('evented')
var $dropdown=$('<div>').addClass('dropdown').hide()
var $noResults=$('<div>').addClass('no-results')
var $search=$('<input>').addClass('zearch')
var $list=$('<ol>')
var listNavigator=navigable($list)
var itemHandler=opts.loader?infiniteScroll($list,opts.loader,appendItem):selectBased($select,$list,opts.regexpMatcher,appendItem)
var filter=throttled(opts.throttle,function(){var term=searchTerm()
itemHandler.load(term,function(){checkResults(term)})})
$search.keyup(function(e){switch(e.which){case keys.esc:hide();return;case keys.up:return;case keys.down:return;case keys.enter:var curr=listNavigator.current().data('event-item')
if(curr)selectItem(curr)
return
default:filter()}})
$search.keydown(function(e){switch(e.which){case keys.tab:e.preventDefault();hide();return;case keys.up:e.preventDefault();listNavigator.prev();return;case keys.down:e.preventDefault();listNavigator.next();return}})
$list.on('click','li',function(){selectItem($(this).data('event-item'))})
$event.mouseenter(function(){$event.addClass('hover')})
$event.mouseleave(function(){$event.removeClass('hover')})
$event.attr("tabindex",$select.attr("tabindex"))
$event.blur(function(){if(!$event.hasClass('hover'))hide()})
$search.blur(function(){if(!$event.hasClass('hover'))hide()})
$selected.click(toggle)
$event.insertAfter($select).append($selected).append($dropdown.append($('<div>').addClass('zearch-container').append($search).append($noResults)).append($list))
itemHandler.load($search.val(),function(){initialSelection(!0)
$select.trigger('ready')})
function selectItem(item,triggerChange){renderContent($selected,opts.renderItem(item)).removeClass('placeholder')
hide()
if(item&&item.value!==undefined)$select.val(item.value)
$select.data('evented',item)
if(triggerChange==null||triggerChange===!0)$select.trigger('change',item)}
function refreshItem(item,identityCheckFn){var eq=function(a,b){return identityCheckFn(a)===identityCheckFn(b)}
if(eq($select.data('evented'),item)){renderContent($selected,opts.renderItem(item))
$select.data('evented',item)}
var term=searchTerm()
$list.find('li').each(function(){if(eq($(this).data('event-item'),item)){renderContent($(this),opts.renderItem(item,term)).data('event-item',item)}})}
function reset(){$search.val('')
itemHandler.load('',function(){initialSelection(!1)})}
function toggle(){$dropdown.toggle()
$event.toggleClass('open')
if($dropdown.is(':visible')){$search.focus().select()
itemHandler.check()
listNavigator.ensure()}}
function hide(){$dropdown.hide()
$event.removeClass('open')}
function renderContent($obj,content){$obj[htmlOrText(content)](content)
return $obj
function htmlOrText(x){return(x instanceof jQuery||x.nodeType!=null)?'html':'text'}}
function appendItem(item,term){$list.append(renderContent($('<li>').data('event-item',item),opts.renderItem(item,term)))}
function checkResults(term){if($list.children().size()===0){$noResults.html(opts.noResults(term)).show()}else{$noResults.hide()
listNavigator.ensure()}}
function searchTerm(){return $.trim($search.val())}
function initialSelection(useOptsInitial){$selected.html(opts.placeholder).addClass('placeholder')
var $s=$select.find('option[selected="selected"]')
if(useOptsInitial&&opts.initial){selectItem(opts.initial)}else if(!opts.loader&&$s.size()>0){selectItem($list.children().eq($s.index()).data('event-item'))}else if(opts.placeholder!=""){$selected.html(opts.placeholder).addClass('placeholder')}else{var first=$list.find(':first').data('event-item')
first!==undefined?selectItem(first):$selected.html(opts.noResults()).addClass('placeholder')}
checkResults()}})}
function selectBased($select,$list,regexpMatcher,appendItemFn){var dummyRegexp={test:function(){return!0}}
var options=$select.find('option').map(function(){return itemFromOption($(this))}).get()
function filter(term){var regexp=(term==='')?dummyRegexp:regexpMatcher(term)
$list.empty()
$.each(options,function(ii,item){if(regexp.test(item.label))appendItemFn(item,term)})}
function itemFromOption($option){return{value:$option.attr('value'),label:$option.text()}}
function newTerm(term,callback){filter(term)
if(callback)callback()}
return{load:newTerm,check:function(){}}}
function infiniteScroll($list,loadFn,appendItemFn){var state={id:0,term:'',page:0,loading:!1,exhausted:!1,callback:undefined}
$list.scroll(maybeLoadMore)
function load(){if(state.loading||state.exhausted)return
state.loading=!0
$list.addClass('loading')
var stateId=state.id
loadFn(state.term,state.page,function(items){if(stateId!==state.id)return
if(state.page==0)$list.empty()
state.page++
if(!items||items.length===0)state.exhausted=!0
$.each(items,function(ii,item){appendItemFn(item,state.term)})
state.loading=!1
if(!maybeLoadMore()){if(state.callback)state.callback()
state.callback=undefined
$list.removeClass('loading')}})}
function maybeLoadMore(){if(state.exhausted)return!1
var $lastChild=$list.children(':last')
if($lastChild.size()===0){load()
return!0}else{var lastChildTop=$lastChild.offset().top-$list.offset().top
var lastChildVisible=lastChildTop<$list.outerHeight()
if(lastChildVisible)load()
return lastChildVisible}}
function newTerm(term,callback){state={id:state.id+1,term:term,page:0,loading:!1,exhausted:!1,callback:callback}
load()}
return{load:newTerm,check:maybeLoadMore}}
$.fn.eventItem=callInstance('eventItem')
$.fn.refresheventItem=callInstance('refreshItem')
$.fn.resetevent=callInstance('reset')
function callInstance(fnName){return function(){var args=[].slice.call(arguments)
return this.each(function(){var fn=$(this).data(fnName)
fn&&fn.apply(undefined,args)})}}
function throttled(ms,callback){if(ms<=0)return callback
var timeout=undefined
return function(){if(timeout)clearTimeout(timeout)
timeout=setTimeout(callback,ms)}}
function defaultRenderItem(item,term){if(item==undefined||item==null){return ''}else if($.type(item)==='string'){return item}else if(item.label){return item.label}else if(item.toString){return item.toString()}else{return item}}
function defaultNoResults(term){return "No results for '"+(term||'')+"'"}
function defaultRegexpMatcher(term){return new RegExp('(^|\\s)'+term,'i')}
function navigable($list){var skipMouseEvent=!1
$list.on('mouseenter','li',onMouseEnter)
function next(){var $next=current().next('li')
if(set($next))ensureBottomVisible($next)}
function prev(){var $prev=current().prev('li')
if(set($prev))ensureTopVisible($prev)}
function current(){return $list.find('.current')}
function ensure(){if(current().size()===0){$list.find('li:first').addClass('current')}}
function set($item){if($item.size()===0)return!1
current().removeClass('current')
$item.addClass('current')
return!0}
function onMouseEnter(){if(skipMouseEvent){skipMouseEvent=!1
return}
set($(this))}
function itemTop($item){return $item.offset().top-$list.offset().top}
function ensureTopVisible($item){var scrollTop=$list.scrollTop()
var offset=itemTop($item)+scrollTop
if(scrollTop>offset){moveScroll(offset)}}
function ensureBottomVisible($item){var scrollBottom=$list.height()
var itemBottom=itemTop($item)+$item.outerHeight()
if(scrollBottom<itemBottom){moveScroll($list.scrollTop()+itemBottom-scrollBottom)}}
function moveScroll(offset){$list.scrollTop(offset)
skipMouseEvent=!0}
return{next:next,prev:prev,current:current,ensure:ensure}}})(jQuery)