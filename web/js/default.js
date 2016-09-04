(function($) {
		$.fn.monetize = $.fn.number_format;
	})(jQuery);

//jQuery.taconite.debug = true;

function remapTHeader()
{
  $('div.content th a').click(function(e){
    e.preventDefault();
    var ord = (this.className == "asc" ? "desc" : "asc");
    $.get(this.href, { dir: ord }, function () { remapTHeader(); remapPager(); });
  });
}

function remapPager()
{
  $('div.content #pagesNav').find('a').click(function(e){
    e.preventDefault();
    $.get(this.href, function () { remapTHeader(); remapPager(); });
  });
}

function remapFilters()
{
  $('#filters').find('a').click(function(e){
    e.preventDefault();
    $.get(this.href, function () { remapTHeader(); remapPager(); });
  });
}
function doNothing(e)
{
	e.preventDefault();
}
function doAjax(e)
{
	e.preventDefault();
	$.get($(this).attr('href'));
}
function doConfirm(e)
{
	if (!confirm('Você está prestes a remover uma informação do sistema. Deseja continuar?'))
		e.preventDefault();
}
function __init__()
{
	remapTHeader(); 
	remapPager(); 
	remapFilters();
	$('#display_ctrl').find('a').click(doAjax);
	$('td.ctrls a.delete').click(doConfirm);
	
	$('.fancybox').livequery(function() {
		$(this).fancybox({
			titleShow			:	false
		});
	});

	$('.fancybox').livequery(function() {
		$(this).fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Imagem ' +  (currentIndex + 1) + ' de ' + currentArray.length + '</span>';
			}
		});
	});
}
//jQuery(document).ready(__init__);
/*$(document).ready(function(){

	$('.fancybox').fancybox({titleShow:false});
	$('#top').find('a.sf-with-ul').click(doNothing);
});*/

/*$().ajaxStart(function () { $('div.content').block() }).ajaxStop(function () { $('div.content').unblock() });
$.blockUI.defaults.message = '<h2><img src="/adm/images/ajax-loader.gif" /></h2>';
$.blockUI.defaults.css = {
	padding:        0,
	margin:         0,
	width:          '30%', 
	top:            '40%', 
	left:           '35%', 
	textAlign:      'center', 
	color:          '#000', 
	backgroundColor:'transparent',
	cursor:         'wait'
};
$.blockUI.defaults.overlayCSS = {
	backgroundColor:'#fff', 
	opacity:        '0.3' 
};
$.blockUI.defaults.applyPlatformOpacityRules = false;
$.blockUI.defaults.fadeOut = 0; */