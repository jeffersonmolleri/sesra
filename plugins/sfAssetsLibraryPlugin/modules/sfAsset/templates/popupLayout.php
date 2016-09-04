<?php echo '<?xml version="1.0" encoding="UTF-8"?>', "\n" ?>
<taconite>
<html select="#medialib">
<![CDATA[
<?php echo $sf_data->getRaw('sf_content') ?>
]]>
</html>
<eval>
  $('#medialib').find('a').click(doAjax);
  $('#medialib').find('form').not('#addquick').ajaxForm();
  $('#addquick').ajaxForm({
    dataType: 'script'
  });
  $('#medialib').find('.date').datepicker({
    buttonText: 'Escolha uma data',
    buttonImage: '/adm/images/ico16/date.png',
    buttonImageOnly: true,
    showOn: 'both',
    rangeSelect: true
  }).mask('99/99/9999 - 99/99/9999');
  $("#dosearch").click(function (e) {
    e.preventDefault();
    $('#sf_asset_search').toggle();
  });
</eval>
</taconite>