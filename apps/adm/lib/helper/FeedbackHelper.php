<?php
use_helper('Tag');

/**
 * MESSAGE BOXES
 */

/**
 * Sets default tag for boxes
 */
define('FEEDBACK_TAG', 'div');

function feedback_close_tag()
{
  return '</' . FEEDBACK_TAG . '>';
}

function feedback_blank($id = false)
{
  $options = array();
  if ($id) {
    $options['id'] = $id;
  }
  return feedback('', '', array (), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function feedback_info($msg, $options = '')
{
  return feedback('<i class="icon-info-sign"></i> Dica', $msg, array('class'=>'alert-info'), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function feedback_important($msg, $options = '')
{
  return feedback('<i class="icon-question-sign"></i> Importante', $msg, array('class'=>''), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function feedback_warning($msg, $options = '')
{
  return feedback('<i class="icon-remove-sign"></i> Atenção', $msg, array('class'=>'alert-error'), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function feedback_note($msg, $options = '')
{
  return feedback('<i class="icon-info-sign"></i> ', $msg, array('class'=>'alert-info'), $options);
}

function feedback_error($msg, $options = '')
{
  return feedback('<i class="icon-question-sign"></i> ', $msg, array('class'=>''), $options);
}


function _feedback_generate_id()
{
  return 'msg' . md5(microtime());
}

/**
 * Outputs formated html message box
 *
 * @todo Rewrite focus js in jQuery API
 * @param string $msg
 * @param array $html_options
 * @param array $options
 * @return string
 */
function feedback($title, $msg, $html_options, $options)
{
  $options = _parse_attributes($options);

  if (isset($options['id'])) {
    $html_options['id'] =  $options['id'];
    unset($options['id']);
  } else {
     $html_options['id'] = _feedback_generate_id();
  }

  if (isset($options['class'])) {
    $html_options['class'] .= ' '.$options['class'];
    unset($options['class']);
  }
  $html_options['class'] = 'alert' . ( empty($html_options['class']) ? '' : ' ' . $html_options['class'] );
  if (isset($options['removable']))
  {
    $html_options['onclick'] = '$(this).remove()';
    unset($options['removable']);
  }

  if (!empty($title))
  {
    $msg = content_tag('strong', $title . ':') . ' ' . $msg;
  }

  $options = array_merge($options, $html_options);

  $open = !empty($options['open']);

  unset($options['focus'], $options['open']);

  if ($open) {
    return tag(FEEDBACK_TAG, $options, true) . $msg;
  } else {
    return content_tag(FEEDBACK_TAG, $msg , $options);
  }
}


function form_errors_display(sfForm $form, $msgBox = true, $isAlertField = true, $has_email = false)
{
  $out     = '';
  $fields  = '';
  $js      = '';

  if ($form->hasErrors()) {
    $out  = '<p>'.'Os dados que você forneceu parecem estar incorretos. Por favor, corrija os seguintes problemas e tente novamente:'.'</p>'."\n";
    $out .= '<ul>';
    $errors = $form->getErrorSchema()->getErrors();

    foreach ($errors as $name => $error) {
	      $fields .= "label:has(#{$form[$name]->renderId()}), ";
	      $out .= '<li>'. $error .'</li>'."\n";
    }
    if ($has_email == true || array_key_exists('', $errors))
    {
    	  $out .= '<li><strong>E-MAIL</strong> já cadastrado no sistema.</li>'."\n";
    }
    $out .= '</ul>'."\n";
    $out = feedback_warning($out);
    $content = '$(document).ready(function(){
      $("'.substr($fields, 0, -2).'").addClass("errorCell");
    });';
    if ($isAlertField)
    {
      $js = content_tag('script', "\n//".cdata_section("\n$content\n//")."\n", array('type' => 'text/javascript'));
      sfContext::getInstance()->getResponse()->setSlot('form_errors', $js);
    }
  }
  /*else
  {
    if ($msgBox)
    $out = feedback_info('Os campos marcados com asterisco (*) são obrigatórios.');
    $js = '';
  }*/
//var_dump($recover); die;
  return content_tag('div', $out, array ('id' => 'messages_holder'));
}


function breadcrumb()
{
  $args = func_get_args();
  $title = array_shift($args);
  $trail = array ();
  foreach ($args as $arg)
  {
    $t = explode(':',$arg);
    $c = new stdClass();
    $c->title = $t[0];
    $c->link = isset($t[1]) ? trim($t[1]) : null ;
    $trail[] = $c;
  }

  include_component('home', 'breadcrumb', array ('title' => $title, 'trail' => $trail));
}
