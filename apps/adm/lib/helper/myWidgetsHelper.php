<?php
/**
 * port to 1.2
 * 
 * @param $form sfForm
 * @param $msgBox boolean
 * @param $isAlertField boolean
 * @return string Html
 */
/*function form_errors_display(sfForm $form, $msgBox = true, $isAlertField = true)
{
  $out     = '';
  $fields  = '';
  $js      = '';
  
  if ($form->hasErrors()) {
    $out  = '<div class="msg error"><p>'.'Os dados que você forneceu <strong>parecem estar incorretos</strong>. Por favor, corrija os seguintes problemas e tente novamente:'.'</p>'."\n";
    $out .= '<ul id="items">';
    foreach ($form->getErrorSchema()->getErrors() as $name => $error) {
      $fields .= "label:has(#{$form[$name]->renderId()}), ";
      //$out .= '<li>'. $name . ":" . $error .'</li>'."\n";
      $out .= '<li>'. $error .'</li>'."\n";
    }
    $out .= '</ul>'."\n";
    $out .= '</div>';
    $content = '$(document).ready(function(){
      $("'.substr($fields, 0, -2).'").addClass("errorCell");
    });';
    if ($isAlertField)
    {
      $js = content_tag('script', "\n//".cdata_section("\n$content\n//")."\n", array('type' => 'text/javascript'));
      sfContext::getInstance()->getResponse()->setSlot('form_errors', $js);
    }
  }
  else
  {
    if ($msgBox)
    $out = msbox_alert('<strong>Alerta:</strong> Os campos marcados com asterisco (*) são obrigatórios.');
    $js = '';
  }
  
  return content_tag('div', $out, array ('id' => 'messages_holder'));
}*/


function save_edit_controls($object = null, $newText = '', $options = array())
{
	$module = sfContext::getInstance()->getModuleName();
	$newText = empty($newText) ? '' : ' '.$newText;

	if (isset($options['sf_asset_dir']))
	{
		$target = $options['sf_asset_dir'];
	}
	else
	{
		$target = $module . '/index';
	}

	if (is_object($object) && $object->getId()) {
		$txt = 'Salvar'.$newText;
		$output = ' '.__('ou').' ' . link_to(__('Cancelar'), $target, array ('class' => 'negate'));
	}
	else
	{
		$txt = __('Criar').$newText;
		$output = ' '.__('ou').' ' . link_to(__('Cancelar'), $target, array ('class' => 'negate'));
	}
	$options = _parse_attributes($options);
	return button_tag('<i class="icon-ok"></i> '.$txt, array_merge(array('type'=>'submit', 'class'=>'btn btn-success'), $options ) ) . $output;
}

function save_edit_conclude_controls($object = null, $newText = '', $options = array())
{
  $module = sfContext::getInstance()->getModuleName();
  $newText = empty($newText) ? '' : ' '.$newText;

  if (isset($options['sf_asset_dir']))
  {
    $target = $options['sf_asset_dir'];
  }
  else
  {
    $target = $module . '/index';
  }

  if (is_object($object) && $object->getId()) {
    $txt = 'Salvar'.$newText;
    $output = ' '.__('ou').' ' . link_to(__('Cancelar'), $target, array ('class' => 'negate'));
  }
  else
  {
    $txt = __('Criar').$newText;
    $output = ' '.__('ou').' ' . link_to(__('Cancelar'), $target, array ('class' => 'negate'));
  }
  $options = _parse_attributes($options);
  return '<div class="btn-group pull-left">'
    . button_tag('<i class="icon-ok"></i> Salvar', array_merge(array('type'=>'submit', 'class'=>'btn btn-success'), $options ) ) //.$txt
    . button_tag('<i class="icon-check"></i> Salvar e concluir', array_merge(array('type'=>'submit', 'class'=>'btn finaliza'), $options ) )
    . '</div><div class="btn-group-item pull-left">'
    . $output
    . '</div>';
}

function button_tag($value = 'Salvar alterações', $options = array())
{
  return content_tag('button', $value, array_merge(array('name' => 'commit'), _convert_options_to_javascript(_convert_options($options))));
}

function button_tag_to($value = 'Go', $internal_uri, $options = array())
{
  $html_options = _convert_options($options);
  if (isset($html_options['post']) && $html_options['post']) {
    if (isset($html_options['popup'])) {
      throw new sfConfigurationException('You can\'t use "popup" and "post" together');
    }
    $html_options['type'] = 'submit';
    unset($html_options['post']);
    $html_options = _convert_options_to_javascript($html_options);
    return form_tag($internal_uri, array('method' => 'post', 'class' => 'button_to')).tag('input', $html_options).'</form>';
  } else if (isset($html_options['popup'])) {
    $html_options['type'] = 'button';
    $html_options = _convert_options_to_javascript($html_options, $internal_uri);
    return button_tag($value, $html_options);
  } else {
    $html_options['type']    = 'button';
    $html_options['onclick'] = "document.location.href='".url_for($internal_uri)."';";
    $html_options = _convert_options_to_javascript($html_options);
    return button_tag($value, $html_options);
  }
}

function form_pager_display(sfPager $pager = null, $link = false, $autoReload = true) {
  use_helper('I18N');

  $out = '';
  $user = sfContext::getInstance()->getUser();
  $max = $pager->getMaxPerPage();
  $out .= '<div class="pagination">';
  $out .= '<span class="right">';
  $out .= format_number_choice('[0]nenhum resultado|[1]um resultado|(1,+Inf]%1% resultados', array ('%1%' => $pager->getNbResults()), $pager->getNbResults());
  $out .= link_to('<i class="icon-th"></i>', $link . $pager->getFirstPage() . '&sf_pager=10', array('title' => '10 por página', 'class' => ($max == 10 ? 'selected':'')));
  $out .= link_to('<i class="icon-th-list"></i>', $link . $pager->getFirstPage() . '&sf_pager=25', array('title' => '25 por página', 'class' => ($max == 25 ? 'selected':'')));
  $out .= link_to('<i class="icon-list"></i>', $link . $pager->getFirstPage() . '&sf_pager=50', array('title' => '50 por página', 'class' => ($max == 50 ? 'selected':'')));
  $out .= '</span>';

  if ($pager->haveToPaginate())
  {
    $rq = sfContext::getInstance()->getRequest()->getParameterHolder()->getAll();
    
    if (isset($rq['order']) && isset($rq['dir']))
    {
      $rq = '&order=' . $rq['order'] . '&dir=' . $rq['dir'];
    }
    else
    {
      $rq = '';
    }

    if ($pager->getFirstPage() < $pager->getPage()) {
      $out .= link_to(image_tag('ico16/tab_first'), $link . $pager->getFirstPage() . '&sf_pager=' . $max . $rq);
      $out .= link_to(image_tag('ico16/tab_left'), $link . $pager->getPreviousPage() . '&sf_pager=' . $max . $rq);
    }
    foreach ($pager->getLinks() as $page) {
      if ($page == $pager->getPage()) {
        $out .= '<span class="current"><span>' . $page . "</span></span>";
      } else {
        $out .= link_to('<span>' . $page . '</span>', $link . $page . '&sf_pager=' . $max . $rq);
      }
    }
    if ($pager->getLastPage() > $pager->getPage()) {
      $out .= link_to(image_tag('ico16/tab_right'), $link . $pager->getNextPage() . '&sf_pager=' . $max . $rq);
      $out .= link_to(image_tag('ico16/tab_last'), $link . $pager->getLastPage() . '&sf_pager=' . $max . $rq);
    }
  }
  $out .= "</div>";
  return $out;
}

function update_message($success = 'Dados atualizados com sucesso',$failure = 'Informações não atualizadas.')
{
  $user = sfContext::getInstance()->getUser();
  if ($user->hasFlash('update'))
  {
    $upd = $user->getFlash('update');
    $closebtn = '<button type="button" class="close" data-dismiss="alert">&times;</button>';

    if ($upd == 'success')
    {
      return msbox_success($closebtn . $success, array ('class' => 'alert-success'));
    }
    else
    {
      return msbox_error($closebtn . $failure . (sfConfig::get('sf_environment') == 'dev' ? ':<br />' . $user->getFlash('update') : '.'));
    }
  }
}

function add_slot($name){
  $old = '';
  if (has_slot($name)){ $old = get_slot($name); }
  slot($name);
  echo $old;
}

function rich_editor_script($selector, $folder='/media', $options = array ())
{
  if (isset($options['ajax_image_lib']))
    $ajax_image_lib = "$.get('{$options['ajax_image_lib']}', { popup : 1 });";
  else
    $ajax_image_lib = "$.get('" . url_for('sfAsset/list') . "', { popup : 1 });";

  $out = "

  function insertImage(src, options)
  {
    if ($.browser.msie)
    {
      $('{$selector}').focus();
    }
    $('{$selector}').wysiwyg('insertImage', src, options);
  }
  function insertVideo(src)
  {
    var instance = $.data($('{$selector}')[0], 'wysiwyg'); instance.insertVideo(src, 'video');
  }
  $(document).ready(function() {
  $('{$selector}').wysiwyg({
  autoSave: true,
  css : '/adm/css/jwysiwyg/editor.css',
  controls : {
  insertImage : {
          visible : false,
          exec : function () {
            {$ajax_image_lib}
            $('#medialib').dialog({ modal: true, width: 560, height: 480}).dialog('open');
          }
        },
  insertVideo:   { visible: false, exec: function (self) { $('#medialib').dialog({ modal: true, width: 560, height: 480}).dialog('open'); } },
  insertYoutube: { visible: false, exec: function (self) { $('#youtubeDialog').dialog({ modal: true, width: 400, height: 150, buttons: { Inserir: function () { var instance = $.data($('{$selector}')[0], 'wysiwyg'); content = $('#youtube_url').val().replace('?', '/').replace('=', '/'); instance.insertVideo(content, 'youtube'); }, Fechar: function () { $(this).dialog('close') }  } }).dialog('open'); } }

      }
    });
  });";
  return $out;
}
/*
function rich_editor_script($selector,$folder)
{
  $out = "
  function submitImage() {
    src = $('#lib_address').val();
    options = { align : $('[@name=lib_align]:checked').val(), title : $('#lib_title').val() }
    switch($('[@name=lib_thumbnails]').val()) {
      case '2': options['width'] = '128px'; break;
      case '1': options['width'] = '256px'; break;
    }
    $('{$selector}').wysiwyg('insertImage', src, options);
    tb_remove();
  }
  $(document).ready(function() {
  $('{$selector}').wysiwyg({
  css : '/adm/css/jwysiwyg/editor.css',
  controls : {
  insertImage : { visible : true, exec : function () { tb_show('Biblioteca de arquivos','" . url_for('files/index?folder='.$folder) . "'); } }
      }
    });
  });";
  return $out;
}*/

function objects_to_array($options, $value_method, $text_method = null)
{
  $select_options = array();
  foreach ($options as $option) {
    if ($text_method && !is_callable(array($option, $text_method))) {
      throw new sfViewException(sprintf('Method "%s" doesn\'t exist for object of class "%s".', $text_method, _get_class_decorated($option)));
    }
    if (!is_callable(array($option, $value_method))) {
      throw new sfViewException(sprintf('Method "%s" doesn\'t exist for object of class "%s".', $value_method, _get_class_decorated($option)));
    }
    $value = $option->$value_method();
    $key = $option->$text_method();
    $select_options[$value] = $key;
  }
  return $select_options;
}

function bitABit($k,$j){ return ($k&$j)==$j; }

function array_bibABit($array,$val) {
  $rs = array();
  foreach ($array as $id => $str) {
    if(bitABit($val,$id)) $rs[$id] = $str;
  }
  return $rs;
}

function en_distance_of_time_in_words($from_time, $to_time = null, $include_seconds = false)
{
  if (empty($from_time))
  {
    return 'nunca';
  }
  if (!is_numeric($from_time))
  {
    $from_time = strtotime($from_time);
  }
  $to_time = $to_time? $to_time: time();

  $distance_in_minutes = floor(abs($to_time - $from_time) / 60);
  $distance_in_seconds = floor(abs($to_time - $from_time));

  $string = '';
  $parameters = array();

  if ($distance_in_minutes <= 1)
  {
    if (!$include_seconds)
    {
      $string = $distance_in_minutes == 0 ? 'menos de um minuto' : '1 minuto';
    }
    else
    {
      if ($distance_in_seconds <= 5)
      {
        $string = 'menos de 5 segundos';
      }
      else if ($distance_in_seconds >= 6 && $distance_in_seconds <= 10)
      {
        $string = 'menos de 10 segundos';
      }
      else if ($distance_in_seconds >= 11 && $distance_in_seconds <= 20)
      {
        $string = 'menos de 20 segundos';
      }
      else if ($distance_in_seconds >= 21 && $distance_in_seconds <= 40)
      {
        $string = 'meio minuto';
      }
      else if ($distance_in_seconds >= 41 && $distance_in_seconds <= 59)
      {
        $string = 'menos de um minuto';
      }
      else
      {
        $string = '1 minuto';
      }
    }
  }
  else if ($distance_in_minutes >= 2 && $distance_in_minutes <= 44)
  {
    $string = '%minutes% minutos';
    $parameters['%minutes%'] = $distance_in_minutes;
  }
  else if ($distance_in_minutes >= 45 && $distance_in_minutes <= 89)
  {
    $string = 'cerca de 1 hora';
  }
  else if ($distance_in_minutes >= 90 && $distance_in_minutes <= 1439)
  {
    $string = 'cerca de %hours% horas';
    $parameters['%hours%'] = round($distance_in_minutes / 60);
  }
  else if ($distance_in_minutes >= 1440 && $distance_in_minutes <= 2879)
  {
    $string = '1 dia';
  }
  else if ($distance_in_minutes >= 2880 && $distance_in_minutes <= 43199)
  {
    $string = '%days% dias';
    $parameters['%days%'] = round($distance_in_minutes / 1440);
  }
  else if ($distance_in_minutes >= 43200 && $distance_in_minutes <= 86399)
  {
    $string = 'cerca de 1 mês';
  }
  else if ($distance_in_minutes >= 86400 && $distance_in_minutes <= 525959)
  {
    $string = '%months% meses';
    $parameters['%months%'] = round($distance_in_minutes / 43200);
  }
  else if ($distance_in_minutes >= 525960 && $distance_in_minutes <= 1051919)
  {
    $string = 'cerca de 1 ano';
  }
  else
  {
    $string = 'mais de %years% anos';
    $parameters['%years%'] = floor($distance_in_minutes / 525960);
  }

  return strtr($string, $parameters);
}
