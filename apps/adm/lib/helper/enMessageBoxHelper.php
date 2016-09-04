<?php
use_helper('Tag');

/**
 * MESSAGE BOXES
 */

/**
 * Sets default tag for boxes
 */
define('MSBOX_TAG', 'div');

function msbox_close_tag()
{
  return '</' . MSBOX_TAG . '>';
}

function msbox_blank($id = false)
{
	$options = array();
	if ($id) {
		$options['id'] = $id;
	}
	return msbox('', array (), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function msbox_info($msg, $options = '')
{
  return msbox($msg, array('class'=>'alert alert-info'), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function msbox_alert($msg, $options = '')
{
  return msbox($msg, array('class'=>'alert'), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function msbox_error($msg, $options = '')
{
  return msbox($msg, array('class'=>'alert alert-error'), $options);
}

/**
 * Returns html formated message
 *
 * @param string $msg Text to display in box
 * @return string
 */
function msbox_success($msg, $options = '')
{
  return msbox($msg, array('class'=>'alert alert-success'), $options);
}

function _msbox_generate_id()
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
function msbox($msg, $html_options, $options)
{
  $options = _parse_attributes($options);

  if (isset($options['id'])) {
    $html_options['id'] =  $options['id'];
    unset($options['id']);
  } else {
     $html_options['id'] = _msbox_generate_id();
  }

  if (isset($options['class'])) {
    $html_options['class'] .= ' '.$options['class'];
    unset($options['class']);
  }
  $html_options['class'] = 'msg' . ( empty($html_options['class']) ? '' : ' ' . $html_options['class'] );
  if (isset($options['removable']))
  {
    $html_options['onclick'] = '$(this).remove()';
    unset($options['removable']);
  }

  $options = array_merge($options, $html_options);

  $open = !empty($options['open']);

  if (!empty($options['focus'])) {
    $content = "Element.scrollTo('{$options['id']}');new Effect.Highlight('{$options['id']}');";
    $roll = content_tag('script', "\n//" . cdata_section("\n$content\n//") . "\n", array('type' => 'text/javascript'));
  } else {
    $roll = '';
  }

  unset($options['focus'], $options['open']);

  if ($open) {
    return tag(MSBOX_TAG, $options, true) . $msg;
  } else {
    return content_tag(MSBOX_TAG, $msg , $options) . $roll;
  }
}
