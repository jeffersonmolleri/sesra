var active_edit = false;
var old_title = '';

function editInPlace (e) {
	  e.preventDefault();

	  if (active_edit != e.target.parentNode.rel)
	  {
		  $('#title_' + active_edit).html(old_title);
		  old_title   = '';
		  active_edit = e.target.parentNode.rel;
	  }
	  else if (active_edit == e.target.parentNode.rel)
	  {
		  return false;
	  }

	  old_title = $('#title_' + e.target.parentNode.rel).html();
	  
	  $('#title_' + active_edit).html('');

	  $('#title_' + active_edit).append($('<input id="edit_in_place" type="text" size="15" value="' + old_title + '" />')).append($('<img src="/adm/images/ico16/btnext.png"/>').bind('click', function (e) {
		  $.ajax({
			  type: 'POST',
			  url: env.concat('/novelties/updateImageTitle'),
			  data: { title: $('#edit_in_place').val(), id: active_edit },
		  	  success: function (data) {
			    $('#title_' + active_edit).html(data);
			    active_edit = 0;
		      }
		  });
	  }));
	  
}

$(document).ready(function () {
  //$('.birthdate').datepicker().mask('99/99/9999');

  /*if ($("#gallery").get(0))
  {
	  $("#gallery").ajaxMultiFileUpload({
		  ajaxFile: env.concat('/novelties/handleImageGallery?id=', $('#novelty_id').val(), '&role=', $('#novelty_role').val()),
		  maxNumFiles: 100,
		  uploadFolder: host.concat('/uploads/'),
		  thumbFolder:	host.concat('/uploads/thumbnails'),
		  inputLegend: true,
		  mode: false
	  });
  }*/

  $('#change_main').bind('click', function (e) {
	  e.preventDefault();
      $('#main_image_holder').html('').append('<label for="novelty_main_image"><span>Arquivo: </span><input type="file" name="novelty[main_image]" id="novelty_main_image" /></label><br class="clear" />');
  });
  $('#supplier_main_image').bind('click', function (e) {
	  e.preventDefault();
      $('#supplier_main_image').html('').append('<label for="supplier_main_image"><span>Arquivo: </span><input type="file" name="person[main_image]" id="person_main_image" /></label><br class="clear" />');
  });
  
  $('input[id^=highlight]').bind('click', function () {
	  $.get(env.concat('/novelties/updateGalleryHighlight?id=', $(this).val()));
  });

  $('.edit_in_place').bind('click', function (e) { editInPlace(e) });

});