<?php
use_helper('Tag','JavascriptBase', 'enMessageBox');

/**
 * Extra form helpers
 *
 * @package credideal
 * @subpackage helper
 * @author Pedro Paulo de Mello F. <pedro@enova.com.br>
 */

/*function save_edit_controls($object = null, $newText = '', $request = false, $options = array())
{
  $module = sfContext::getInstance()->getModuleName();
  $route = sfRouting::getInstance()->getCurrentRouteName();
  $newText = empty($newText) ? '' : ' '.$newText; 
  
  try {
    if ($object->isNew())
    {
      $txt = sprintf(__('Criar%s'), $newText);

      if ($request instanceof sfRequest && $request->isXmlHttpRequest())
      {
        $output = ' '.__('ou').' ' . link_to_function(__('Cancelar'), "loadAction(a.getLast('{$module}'),'{$module}')",'class=negate');
      }
      else
      {
        $output = ' '.__('ou').' ' . link_to(__('Cancelar'), "$module/list", 'class=negate');
      }
    }
    else
    {
      $txt = 'Salvar';
      if ($request instanceof sfRequest && $request->isXmlHttpRequest())
      {
        $output = ' '.__('ou').' ' . link_to_function(__('Cancelar'), "loadAction('/{$module}/show?id={$object->getId()}','forms')",'class=negate');
      }
      else
      {
        $output = ' '.__('ou').' ' . link_to(__('Cancelar'), ($route == 'default' ? "$module/list" : str_replace('_edit', '_list', "@$route")), 'class=negate');
      }
    }
    $options = _parse_attributes($options);

    return button_tag($txt.image_tag('ico16/btnext'), array_merge(array('type'=>'submit'), $options ) ) . $output;
  }
  catch (Exception $e)
  {
    return msbox_error($e->getMessage());
  }
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
  return button_tag($txt.image_tag('ico16/btnext'), array_merge(array('type'=>'submit'), $options ) ) . $output;
}

/**
 * Returns an XHTML compliant <button> tag.
 *
 * By default, this helper creates a tag with a name of <em>commit</em> to avoid
 * conflicts with other parts of the framework.  It is recommended that you do not use the name
 * "submit" for submit tags unless absolutely necessary. Also, the default <i>$value</i> parameter
 * (title of the button) is set to "Salvar", which can be easily overwritten by passing a
 * <i>$value</i> parameter.
 *
 * <b>Examples:</b>
 * <code>
 *  echo button_tag();
 * </code>
 *
 * <code>
 *  echo button_tag('Update Record');
 * </code>
 *
 * @param  string field value (title of button)
 * @param  array  additional HTML compliant <button> tag parameters
 * @return string XHTML compliant <button> tag
 */
function button_tag($value = 'Save changes', $options = array())
{
  return content_tag('button', $value, array_merge(array('name' => 'commit'), _convert_options_to_javascript(_convert_options($options))));
}

function button_tag_to($value = 'Go', $internal_uri, $options = array())
{
  $html_options = _convert_options($options);

  if (isset($html_options['post']) && $html_options['post'])
  {
    if (isset($html_options['popup']))
    {
      throw new sfConfigurationException('You can\'t use "popup" and "post" together');
    }
    $html_options['type'] = 'submit';
    unset($html_options['post']);
    $html_options = _convert_options_to_javascript($html_options);

    return form_tag($internal_uri, array('method' => 'post', 'class' => 'button_to')).tag('input', $html_options).'</form>';
  }
  else if (isset($html_options['popup']))
  {
    $html_options['type'] = 'button';
    $html_options = _convert_options_to_javascript($html_options, $internal_uri);

    return button_tag($value, $html_options);
  }
  else
  {
    $html_options['type']    = 'button';
    $html_options['onclick'] = "document.location.href='".url_for($internal_uri)."';";
    $html_options = _convert_options_to_javascript($html_options);

    return button_tag($value, $html_options);
  }
}

/*function form_errors_display($request = null,$msgBox = true, $isAlertField = true)
{
  $request = is_null($request) ? sfContext::getInstance()->getRequest() : $request;
  $out     = '';
  $fields  = '';
  $js      = '';

  if ($request->hasErrors()) {
    $out  = '<div class="msg error"><p>Os dados que você forneceu <strong>parecem estar incorretos</strong>. Por favor, corrija os seguintes problemas e tente novamente:</p>'."\n";
    $out .= '<ul>';
    foreach ($request->getErrors() as $name => $error) {
      $fields .= "dd:has(#$name), ";
      //$out .= '<li>'. $name .': '. $error .'</li>'."\n";
      $out .= '<li>'. $error .'</li>'."\n";
    }
    $out .= '</ul>'."\n";
    $out .= '</div><br />';
    $content = '$(document).ready(function(){
      $("'.substr($fields, 0, -2).'").addClass("errorCell");
    });';

    $js = content_tag('script', "\n//".cdata_section("\n$content\n//")."\n", array('type' => 'text/javascript'));
  } else {
    if ($msgBox)
    $out = msbox_info("<strong>Atenção:</strong> os campos marcados com um asterisco (*) são obrigatórios.");
    $js = '';
  }
  return content_tag('div', $out.($isAlertField ? $js : ''), array ('id' => 'messages_holder'));
}*/
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

function form_errors_taconite($request = null, $prepend)
{
  $request = is_null($request) ? sfContext::getInstance()->getRequest() : $request;
  $out     = '';
  $fields  = '';
  $js      = '';

  if ($request->hasErrors()) {
    $out  = '<div id="err" class="msg error"><p>Os seguintes erros ocorreram:</p>';
    $out .= '<ul>';
    foreach ($request->getErrors() as $name => $error) {
      $fields .= "dd:has(#$name), ";
      //$out .= '<li>'. $name .': '. $error .'</li>'."\n";
      $out .= '<li>'. $error .'</li>';
    }
    $out .= '</ul>';
    $out .= '</div>';
    
    $js = tag('addClass', array ('select' => substr($fields, 0, -2), 'value' => 'errorCell'));
  }

  return tag('removeClass', array('select' => $prepend . ' dd', 'value' => 'errorCell')) . "\n" 
         . ( $out ? (content_tag('prepend', $out, array ('select' => $prepend)) . "\n" . $js) : '' );
}
/*
 * Retorna um xhtml contendo os filtros usado na tela.
 *
 * por default este helper cria um span com o parametro $span_text
 * seguido do(s) filtros passado pelo parametro $filters.
 *
 * O filtro é um array de um array com 2 valores
 * No array de 2 valores é passado o texto destaco,
 * seguido do texto não destacado.
 *
 * Caso o filtro venha vazio é retornado,
 * uma string vazia
 */
function form_alert_display($filters = null,$count = 0)
{
  $out = '';
  if(!empty($filters))
  {
    $field = "A busca pelo termo <strong>'".$filters."'</strong> ";
    $field .=  ($count > 0) ? "retornou ".$count." resultado(s);" :  "não retornou resultados.";
    $out .= "<p class='msg alert'>".$field."</p>";
  }
  return $out;
}
function form_filter_input($title = '',$form = '', $hiddenName='', $object = null, $getId = null, $getDisplay = null,$idSelected, $id = '')
{
  $out = '';
  $docval = 'document.'.$form.'.'.$hiddenName.'.value';
  $docSub = 'document.'.$form.'.submit()';
  if(!empty($object)){
    $out .= "<div class='block' id='".$id."'>";
    $out .= "<h2>".$title."</h2>";
    $out .= "<input type='hidden' name='{$hiddenName}' value='{$idSelected}'>";
    $out .= "<ul>";
    $out .= "<li><a href='#' onclick='document.{$form}.{$hiddenName}.value = \"\";document.{$form}.submit();' class='".(empty($idSelected) ? 'selected' : '')."'>Todas</a></li>";
    if(is_object( reset($object) )){
      foreach($object as $id => $pk)
      {
        $out .= "<li><a href='#' onclick='{$docval} = {$pk->$getId()};{$docSub};' class='".($idSelected == $pk->$getId() ? 'selected' : '')."'>{$pk->$getDisplay()}</a></li>";
      }
    }else{
      foreach($object as $id => $pk)
      {
        $out .= "<li><a href='#' onclick='{$docval} = {$id};{$docSub};' class='".($idSelected == $id ? 'selected' : '')."'>{$pk}</a></li>";
      }
    }
    $out .= "</ul>";
    $out .= "</div>";
  }
  return $out;
}

function form_pager_display($pager = null, $link = false, $linkFunc = false) {
  $out = '';
  if ($pager->haveToPaginate()) {
    $rq = sfContext::getInstance()->getRequest()->getParameterHolder()->getAll();
    if (isset($rq['order']) && isset($rq['dir'])) {
      $rq = '&order=' . $rq['order'] . '&dir=' . $rq['dir'];
    } else {
      $rq = '';
    }
    $out .= '<div class="pagination"><ul>';
    if ($pager->getFirstPage() < $pager->getPage()) {
      if (empty($linkFunc)) {
        $out .= '<li>'.link_to('<i class="icon-double-angle-left"></i>', $link.$pager->getFirstPage().$rq).'</li>';
        $out .= '<li>'.link_to('<i class="icon-angle-left"></i>', $link.$pager->getPreviousPage().$rq).'</li>';
      } else {
        $out .= '<li>'.link_to_function('<i class="icon-double-angle-left"></i>',"loadAction('{$link}{$pager->getFirstPage()}','{$linkFunc}')").'</li>';
        $out .= '<li>'.link_to_function('<i class="icon-angle-left"></i>',"loadAction('{$link}{$pager->getPreviousPage()}','{$linkFunc}')").'</li>';
      }
    }

    foreach ($pager->getLinks() as $page) {
      if ($page == $pager->getPage()) {
        $out .= '<li class="disabled"><a name="actual">'.$page.'</a></li>';
      } else {
        if (empty($linkFunc)) {
          $out .= '<li>'.link_to($page, $link.$page.$rq).'</li>';
        } else {
          $out .= '<li>'.link_to_function($page,"loadAction('{$link}{$page}','{$linkFunc}')").'</li>';
        }
      }
      //$out .= ($page != $pager->getCurrentMaxLink()) ? ' | ':'';
    }

    if ($pager->getLastPage() > $pager->getPage()) {
      if (empty($linkFunc)) {
        $out .= '<li>'.link_to('<i class="icon-angle-right"></i>', $link.$pager->getNextPage().$rq).'</li>';
        $out .= '<li>'.link_to('<i class="icon-double-angle-right"></i>', $link.$pager->getLastPage().$rq).'</li>';
      } else {
        $out .= '<li>'.link_to_function('<i class="icon-angle-right"></i>',"loadAction('{$link}{$pager->getNextPage()}','{$linkFunc}')").'</li>';
        $out .= '<li>'.link_to_function('<i class="icon-double-angle-right"></i>',"loadAction('{$link}{$pager->getLastPage()}','{$linkFunc}')").'</li>';
      }
    }
    $out .= "</ul></div>";
  }
  return $out;
}

function boolean_select_tag($name, $option_tags = null, $options = array(), $default_value = null)
{
  $option_tags = empty($option_tags) ? array('Não','Sim') : $option_tags;
  return select_tag($name, options_for_select($option_tags, $default_value), $options);
}

function currency_number($value)
{
  return number_format($value, 2, ',', '.');
}

function format_boolean($value)
{
  return $value ? 'Sim' : 'Não';
}

function update_attr_message($sf_user, $success = 'Data was updated successfully.', $failure = 'Data update has failed.')
{
  if ($sf_user->hasAttribute('update'))
  {
    if ($sf_user->getAttribute('update') == 'success')
    {
      return msbox_success($success, array ('class' => 'alert-success'));
    }
    else
    {
      return msbox_error($failure.'.');
    }
  }
}

function update_message($success = 'Dados atualizados com sucesso',$failure = 'Informações não atualizadas.')
{
  $user = sfContext::getInstance()->getUser();
  if ($user->hasFlash('update'))
  {
    $upd = $user->getFlash('update');
	
    if ($upd == 'success')
    {
      return msbox_success($success, array ('class' => 'alert-success'));
    }
    else
    {
      return msbox_error($failure . (sfConfig::get('sf_environment') == 'dev' ? ':<br />' . $user->getFlash('update') : '.'));
    }
  }
}

/**
 * Testa se a ordem expirou
 * 
 * @see Order::hasExpired
 * @param $deadline integer data final unix timestamp
 * @param $model
 * @param $tr_status
 * @return boolean
 */
function is_expired($deadline, $model, $tr_status, $is_active)
{
  $rs = false;
  if (!defined('EXP_CURR_TIME'))
  {
    define ('EXP_CURR_TIME' , time()); // avoids multiple calls
  }
  if (!is_bool($is_active))
  {
    $is_active = $is_active == 't' ? true : false;
  }
  if (in_array($tr_status, array(ETransaction::STATUS_FAILURE, ETransaction::STATUS_WAITING, ETransaction::STATUS_UNSET)) && $is_active)
  {
    if (!is_int($deadline))
    {
      $deadline = strtotime($deadline);
    }
    $rs = (EXP_CURR_TIME - $deadline) >= ($model == ETransaction::MODEL_BANKINGBILLET ? 345600 : 86400);
  }

  return $rs; 
}

function image_order_status_tag($v)
{
  return $v ? image_tag('ico16/success', array ('title' => 'aprovada', 'alt' => 'aprovada')) : '';
}

/**
 * Helper to include wysiwyg editor with sfAsset enabled
 * 
 * @uses jquery, jquery.form, jquery.wysiwyg, jquery.ui (dialog and datepicker)
 * @uses sfAssetsLibraryPlugin
 * @param $selector string jQuery selector
 * @return string javascript
 */
function rich_editor_script($selector)
{
  $js = array ('jquery/jquery.form.js', 'jquery/jquery.maskedinput.js', 'jwysiwyg/jquery.wysiwyg.pack.js', 'jquery/jquery.ui.js', 'jquery/ui/i18n/ui.datepicker-pt-BR.js');
  $css = array ('jwysiwyg/jquery.wysiwyg.css', 'jquery-ui-themeroller', '/sfAssetsLibraryPlugin/css/media');
  
  $rs = sfContext::getInstance()->getResponse();
  foreach ($js as $j)
  {
    $rs->addJavascript($j);
  }
  foreach ($css as $c)
  {
    $rs->addStylesheet($c);
  }
  
  $out = "
  function insertImage(src, options)
  {
    if ($.browser.msie)
    {
      $('{$selector}').focus();
    }
    $('{$selector}').wysiwyg('insertImage', src, options);
  }
  $(document).ready(function() {
    $('{$selector}').wysiwyg({
      css : '/adm/css/jwysiwyg/editor.css',
      controls : {
        html: { visible : true },
        separator04 : { visible : true, separator : true },
        paste:  { visible: true },
        insertOrderedList    : { visible : true, tags : ['ol'] },
        insertUnorderedList  : { visible : true, tags : ['ul'] },
        insertImage : {
          visible : true,
          exec : function () {
            if ($('#medialib').get(0)) {
              $('#medialib').html('" . image_tag('ico16/loading.gif') . " carregando...').dialog('open');
            } else {
              $('#empty').after('<div id=\"medialib\" title=\"Escolha uma imagem\" style=\"display: none;\">" . image_tag('ico16/loading.gif') . " carregando...</div>');
              $('#medialib').dialog({
                width : 660,
                height: 480
              }).show();
            }
            $.get('" . url_for('sfAsset/list') . "', { popup : 1 });
          }
        }
      }
    });
  });";

  return $out;
}
/*
 * CONTENT HELPER
 */

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
