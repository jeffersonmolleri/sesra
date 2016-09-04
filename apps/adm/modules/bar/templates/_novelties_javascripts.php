<?php $sf_response->addJavascript('jquery/jquery.wysiwyg.js') ?>
<?php $sf_response->addJavascript('jquery/jquery-ui-1.7.2.custom.min.js') ?>
<?php $sf_response->addJavascript('jquery/ui/i18n/ui.datepicker-pt-BR.js') ?>
<?php $sf_response->addJavascript('jquery/jquery.thickbox.js') ?>
<?php $sf_response->addJavascript('jquery/jquery.example.min.js') ?>
<?php $sf_response->addStyleSheet('thickbox.css') ?>
<?php $sf_response->addStyleSheet('smoothness/jquery-ui-1.7.2.custom.css') ?>
<?php $sf_response->addStyleSheet('jwysiwyg/editor.css') ?>
<?php $sf_response->addStyleSheet('jwysiwyg/jquery.wysiwyg.css') ?>

<script type="text/javascript">
//<![CDATA[
function categoriesHandler()
{
  $('#category_name').example('Nome', { class_name: 'txtoff' });
  $('#categories').find('input:checkbox').attr('checked', function() {
    return $('#novelty_categories_'+$(this).val()).get(0) ? true : false;
  }).click(function(e) {
    var o = $(this);

    if (this.checked)
    {
      if (!$('#novelty_categories_'+o.val()).get(0))
      {
        $('#novelty_form').append(['<input type="hidden" name="novelty_categories['+ o.val() +']" id="novelty_categories_',o.val(),'" value="category:name=',o.val(),'" />'].join(''));
      }
    }
    else
    {
      $('#novelty_categories_'+o.val()).remove();
    }
  });
}

function dropTag(e)
{
  e.preventDefault();
  $('#novelty_tags_'+ $(this).attr('title')).remove();
  $(this).parent().remove();
}

function addTag(e)
{
  e.preventDefault();
  var v = $(this).attr('title');

  if (v == "")
    return;

  $("#tags_list").append('<li><input type="image" title="' + v + '" src="/adm/images/888888_11x11_icon_close.gif" /> ' + v + '</li>');
  $("#novelty_form").append('<input type="hidden" id="novelty_tags_' + v + '" name="novelty_tags[]" value="' + v + '" />');

  $(this).parent().remove();
}

<?php //echo rich_editor_script('#novelty_body', 'media', array ('ajax_image_lib' => url_for('@sf_asset_library_dir?dir=media') . '/' . strtolower(NoveltyForm::getModels($form->getObject()->getRole())) . '/' . $form->getObject()->getId())); ?>
		
$(document).ready(function() {
	<?php if ($form->getObject()->isNew()) : ?>
	 $('#novelty_display_in_site').attr('checked', false);
	<?php endif ?>

	categoriesHandler();

	$('#novelty_date_start').datepicker().mask('99/99/9999');
	$('#novelty_date_end').datepicker().mask('99/99/9999');

  $("#tags_list input[type=image]").livequery('click', dropTag);
  $("#tags_mostpopular a").livequery('click', addTag);
  $("#tag_add").click(function (e) {
    e.preventDefault();
    var $t = $("#tag"), tags, ctrls = [], hiddens = [];

    tags = $.map($t.val().split(','), function (i) {
      var v = i.replace(/^\s+/g,'').replace(/\s+$/g, '');
      ctrls.push('<li><input type="image" title="' + v.replace(/\W/g, '_') + '" src="/adm/images/888888_11x11_icon_close.gif" /> ' + v + '</li>');
      hiddens.push('<input type="hidden" id="novelty_tags_' + v.replace(/\W/g, '_') + '" name="novelty_tags[]" value="' + v + '" />');
    });

    $("#tags_list").append(ctrls.join("\n"));
    $("#novelty_form").append(hiddens.join("\n"));

    $t.val('');
  });

  $("#tags_choose").click(function (e) {
    e.preventDefault();
    $.get('<?php echo url_for('bar/mostPopular') ?>', { rel: 'Novelty', id: <?php echo $form->getObject()->isNew() ? 0 : $form->getObject()->getId() ?> });
  });

  var instance = $.data($('#novelty_body')[0], 'wysiwyg');
  var focused  = false;
  var count    = 0;

  $('body', instance.editor[0].contentDocument).bind('click', function () {
      count++;

      if (!focused)
      {
        focused = true;

        $('span.video', instance.editor.get(0).contentDocument).each(function () {
          var a_span = $(this);

          var div = '<div style="z-index: 0; left: 0px; top: 339px; -moz-user-select: none; visibility: visible;" class="bubble_content"><span id="embed_' + count + '" class="removeVideoTag bubble_link" style="border: solid 1px blue; width: 15px; height: 15px;">' + __('Remover imagem') + '</span></div>';

					//<div class="removeVideoTag" id="embed_' + count + '" style="border: solid 1px blue; width: 15px; height: 15px;"><a>x</a></div>

          $(this).append(div);
          $('#embed_' + count + ' > a', instance.editor.get(0).contentDocument).click(function (e) { $(a_span).remove() });
        });
      }
  });

  $('#novelty_form').bind('submit', function () {
    var instance = $.data($('#novelty_body')[0], 'wysiwyg');

    $('.removeVideoTag', instance.editor[0].contentDocument).remove();
    instance.saveContent();
    focused = false;

    //return false;
  });

});

//]]>
</script>
