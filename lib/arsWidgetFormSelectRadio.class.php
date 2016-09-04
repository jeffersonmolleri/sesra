<?php

/*
 * Based on sfWidgetFormSelectRadio.class.php
 */

/**
 * sfWidgetFormSelectRadio represents radio HTML tags.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSelectRadio.class.php 30762 2010-08-25 12:33:33Z fabien $
 */
class arsWidgetFormSelectRadio extends sfWidgetFormChoiceBase
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:         An array of possible choices (required)
   *  * label_separator: The separator to use between the input radio and the label
   *  * separator:       The separator to use between each input radio
   *  * class:           The class to use for the main <ul> tag
   *  * formatter:       A callable to call to format the radio choices
   *                     The formatter callable receives the widget and the array of inputs as arguments
   *  * template:        The template to use when grouping option in groups (%group% %options%)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormChoiceBase
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('tooltips', $options['tooltips']);
    $this->addOption('class', 'controls');
    $this->addOption('label_separator', "\n");
    $this->addOption('separator', "\n");
    $this->addOption('formatter', array($this, 'formatter'));
    $this->addOption('template', '%group% %options%');
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ('[]' != substr($name, -2))
    {
      $name .= '[]';
    }

    $choices = $this->getChoices();

    // with groups?
    if (count($choices) && is_array(next($choices)))
    {
      $parts = array();
      foreach ($choices as $key => $option)
      {
        $parts[] = strtr($this->getOption('template'), array('%group%' => $key, '%options%' => $this->formatChoices($name, $value, $option, $attributes)));
      }

      return implode("\n", $parts);
    }
    else
    {
      return $this->formatChoices($name, $value, $choices, $attributes);
    }
  }

  protected function formatChoices($name, $value, $choices, $attributes)
  {
    $inputs = array();
    $tooltips = $this->getOption('tooltips');

    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => substr($name, 0, -2),
        'type'  => 'radio',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );

      if (strval($key) == strval($value === false ? 0 : $value))
      {
        $baseAttributes['checked'] = 'checked';
      }

      $inputs[$id] = array(
        'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
        'label' => self::escapeOnce($option),
        'tooltip' => isset($tooltips[$key]) ? $tooltips[$key] : ''
      );
    }

    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }

  public function formatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $attrs = array('class' => 'radio', 'data-original-title' => $input['tooltip'], 'data-placement' => 'left', 'rel' => 'tooltip');
      if (empty($input['tooltip'])) {
        unset($attr['rel'], $attr['data-original-title'], $data['data-placement']);
      }
      $rows[] = $this->renderContentTag('label', $input['input'] . $input['label'], $attrs);
    }

    return !$rows ? '' : $this->renderContentTag('div', implode($this->getOption('separator'), $rows), array('class' => $this->getOption('class')));
  }
}
