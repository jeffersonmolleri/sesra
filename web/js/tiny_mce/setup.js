tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	file_browser_callback : 'sfAssetsLibrary.fileBrowserCallBack',
	//plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,forecolor,backcolor,|,bullist,numlist,|,undo,redo,link,unlink,anchor,image,|,paste,fontsizeselect,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_resizing : false,

	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
});