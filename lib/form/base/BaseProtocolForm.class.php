<?php

/**
 * Protocol form base class.
 *
 * @method Protocol getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseProtocolForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'objective'       => new sfWidgetFormTextarea(),
      'population'      => new sfWidgetFormTextarea(),
      'intervention'    => new sfWidgetFormTextarea(),
      'comparative'     => new sfWidgetFormTextarea(),
      'outcome'         => new sfWidgetFormTextarea(),
      'context'         => new sfWidgetFormTextarea(),
      'search_string'   => new sfWidgetFormTextarea(),
      'metodology'      => new sfWidgetFormTextarea(),
      'assessment'      => new sfWidgetFormTextarea(),
      'data_extraction' => new sfWidgetFormTextarea(),
      'data_analisys'   => new sfWidgetFormTextarea(),
      'dissemination'   => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'deleted_at'      => new sfWidgetFormDateTime(),
      'rsl_id'          => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => false)),
      'framework_id'    => new sfWidgetFormPropelChoice(array('model' => 'Framework', 'add_empty' => false)),
      'strategy_id'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'objective'       => new sfValidatorString(array('required' => false)),
      'population'      => new sfValidatorString(array('required' => false)),
      'intervention'    => new sfValidatorString(array('required' => false)),
      'comparative'     => new sfValidatorString(array('required' => false)),
      'outcome'         => new sfValidatorString(array('required' => false)),
      'context'         => new sfValidatorString(array('required' => false)),
      'search_string'   => new sfValidatorString(array('required' => false)),
      'metodology'      => new sfValidatorString(array('required' => false)),
      'assessment'      => new sfValidatorString(array('required' => false)),
      'data_extraction' => new sfValidatorString(array('required' => false)),
      'data_analisys'   => new sfValidatorString(array('required' => false)),
      'dissemination'   => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'      => new sfValidatorDateTime(array('required' => false)),
      'rsl_id'          => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id')),
      'framework_id'    => new sfValidatorPropelChoice(array('model' => 'Framework', 'column' => 'id')),
      'strategy_id'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('protocol[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Protocol';
  }


}
