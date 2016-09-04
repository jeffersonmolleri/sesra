/*
 *
 * @name		ajaxMultiFileUpload
 * @author		Kevin Crossman
 * @contact		kevincrossman@gmail.com
 * @version		2.1
 * @date			Oct 14 2008
 * @type    	 	jQuery
 *
*/
; (function($) {

    $.fn.extend({
        ajaxMultiFileUpload: function(options) { 
        	opt = $.extend({}, $.uploadSetUp.defaults, options);
            if (opt.file_types.match('jpg') && !opt.file_types.match('jpeg')) 
            	opt.file_types += ',jpeg';
            $this = $(this);
            new $.uploadSetUp();
        }
    });

    $.uploadSetUp = function() {
        $('body').append($('<div></div>').append($('<iframe src="about:blank" class="myFrame" id="myFrame" name="myFrame"></iframe>')));
        $this.append($('<form target="myFrame" enctype="multipart/form-data" action="' + opt.ajaxFile + '" method="post" class="'+opt.form_class+'" name="'+opt.form_name+'" id="'+opt.form_id+'"></form>')
            .append(
            $('<input type="hidden" name="thumb" value="' + opt.thumbFolder + '" />'),
            $('<input type="hidden" name="upload" value="' + opt.uploadFolder + '" />'),
            $('<input type="hidden" name="mode" value="' + opt.mode + '" />'),
            $('<input type="hidden" name="type" id="type_form" value="' + opt.type + '" />'),
            $('<div class="select" id="'+opt.selector_photo_id+'" title="upload new picture"></div>').append($('<input id="'+opt.input_file_id+'" class="myUploadFile file" type="file" value="" name="'+opt.file_field_id+'" size="1"/>')), 
            $('')
            //,$('<ul id="ul_files"></ul>')
            ), 
            $(''));
        //init();
    };

    $.uploadSetUp.defaults = {
        // image types allowed
        file_types: "jpg,gif,png",
        // php script
        ajaxFile: "uploads.php",
        // maximum number of files allowed to upload
        maxNumFiles: 1,
        // if set to "demo", files are automatically deleted from server
        mode: "",
        // absolute path for upload pictures folder (don't forget to chmod)
        uploadFolder: "/uploads",
        // absolute path for thumbnail folder (don't forget to chmod)
        thumbFolder: "/uploads/thumbnails"
    };

    function init() {

        // delete uploaded file
        $(".delete").livequery('click', function() {
            // avoid duplicate function call
            $(this).unbind('click');
            // determine how to delete based on demo mode
            (opt.mode == "demo") ? _demoDelete($(this)) : _delete($(this));
        });
        
        $(".edit_in_place").livequery('click', function(e) {

            editInPlace(e);
        });
        
        // delete during demo mode
        function _demoDelete(toDelete) {
            toDelete
            	.parents('LI')
            	.fadeOut(1000, function() {
                	$(this).remove();
               		$('UL#response').append('<LI>Arquivo <SPAN>' + toDelete[0]._name + '</SPAN> removido. </LI>');
                	updateCount();
            	});
        };
        // normal delete
        function _delete(toDelete) {
            $.post(opt.ajaxFile, { deleteFile: true, image_id: toDelete[0].id, origName: toDelete[0]._name, upload: opt.uploadFolder, thumb: opt.thumbFolder, mode: opt.mode },  
            	function(returned) {
            		$('UL#response').append('<li>' + returned.replace(/^\s+|\s+$/g, '') + '</li>');
               	 	toDelete
                		.parents('LI')
                		.fadeOut(1000, function(){ $(this).remove(); updateCount() });
            	});
        };
        // update the file counter
        function updateCount() {
            var numUploads = $("UL#ul_files").children('LI').size(),
            limit = (numUploads == opt.maxNumFiles) ? " alcançado.": " permitido.";
            $("H2.numFiles").text(numUploads + " arquivo(s) enviado(s) . . . Limite de " + opt.maxNumFiles + limit);
            $('.select').css({ opacity: (numUploads == opt.maxNumFiles) ? 0 : 1 });
        };

        // check type of iframe
        function frametype(fid) {
            return (fid.contentDocument) ? fid.contentDocument: (fid.contentWindow) ? fid.contentWindow.document: window.frames[fid].document;
        };

        updateCount();
    }

})(jQuery);