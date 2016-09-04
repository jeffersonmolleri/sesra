<?php

/**
 * RslResult form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class RslResultForm extends BaseRslResultForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'data_sintesys'         => new sfWidgetFormTextarea(),
      'class_description'     => new sfWidgetFormTextarea(),
      'meta_sintesys'         => new sfWidgetFormTextarea(),
      'results'               => new sfWidgetFormTextarea(),
      'discussions'           => new sfWidgetFormTextarea(),
      'conclusions'           => new sfWidgetFormTextarea(),
      'practice_implications' => new sfWidgetFormTextarea(),
      'search_implications'   => new sfWidgetFormTextarea(),
      'appointments'          => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'deleted_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormInputText(),
      'updated_by'            => new sfWidgetFormInputText(),
      'deleted_by'            => new sfWidgetFormInputText(),
      'rsl_id'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'data_sintesys'         => new sfValidatorString(array('required' => false)),
      'class_description'     => new sfValidatorString(array('required' => false)),
      'meta_sintesys'         => new sfValidatorString(array('required' => false)),
      'results'               => new sfValidatorString(array('required' => false)),
      'discussions'           => new sfValidatorString(array('required' => false)),
      'conclusions'           => new sfValidatorString(array('required' => false)),
      'practice_implications' => new sfValidatorString(array('required' => false)),
      'search_implications'   => new sfValidatorString(array('required' => false)),
      'appointments'          => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'            => new sfValidatorDateTime(array('required' => false)),
      'created_by'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'updated_by'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'deleted_by'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'rsl_id'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rsl_result[%s]');

    unset(
        $this['created_by'],
        $this['updated_by'],
        $this['deleted_by'],
        $this['created_at'],
        $this['updated_at'],
        $this['deleted_at']
    );
  }
}
