<?php

/**
 * RslCriteria form base class.
 *
 * @method RslCriteria getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseRslCriteriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'rsl_id'      => new sfWidgetFormInputText(),
      'protocol_id' => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormInputText(),
      'type'        => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted_at'  => new sfWidgetFormDateTime(),
      'created_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'rsl_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'protocol_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'type'        => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'  => new sfValidatorDateTime(array('required' => false)),
      'created_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rsl_criteria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RslCriteria';
  }


}
