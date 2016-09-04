<?php

/**
 * SystematicRevision form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class SystematicRevisionForm extends BaseSystematicRevisionForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormInputText(),
      'question'   => new sfWidgetFormTextarea(),
      'restrict'   => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormDateTime(),
      'created_by' => new sfWidgetFormInputText(),
      'updated_by' => new sfWidgetFormInputText(),
      'deleted_by' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'      => new sfValidatorString(array('max_length' => 255), array('required'=>'O campo <strong>TÍTULO</strong> é obrigatório.')),
      'question'   => new sfValidatorString(array('required' => false)),
      'restrict'   => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
      'created_by' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'updated_by' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'deleted_by' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('systematic_review[%s]');
  }
}
