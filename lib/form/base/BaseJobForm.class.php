<?php

/**
 * Job form base class.
 *
 * @method Job getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseJobForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'date'        => new sfWidgetFormDateTime(),
      'description' => new sfWidgetFormTextarea(),
      'activity_id' => new sfWidgetFormPropelChoice(array('model' => 'Activity', 'add_empty' => true)),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'protocol_id' => new sfWidgetFormPropelChoice(array('model' => 'Protocol', 'add_empty' => false)),
      'finished_at' => new sfWidgetFormDateTime(),
      'finished_by' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'date'        => new sfValidatorDateTime(array('required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
      'activity_id' => new sfValidatorPropelChoice(array('model' => 'Activity', 'column' => 'id', 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'protocol_id' => new sfValidatorPropelChoice(array('model' => 'Protocol', 'column' => 'id')),
      'finished_at' => new sfValidatorDateTime(array('required' => false)),
      'finished_by' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('job[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Job';
  }


}
