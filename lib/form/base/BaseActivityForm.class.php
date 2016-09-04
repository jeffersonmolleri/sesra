<?php

/**
 * Activity form base class.
 *
 * @method Activity getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseActivityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name_pt'         => new sfWidgetFormTextarea(),
      'name_us'         => new sfWidgetFormTextarea(),
      'framework_name'  => new sfWidgetFormTextarea(),
      'activity_parent' => new sfWidgetFormPropelChoice(array('model' => 'Activity', 'add_empty' => true)),
      'description'     => new sfWidgetFormTextarea(),
      'framework_id'    => new sfWidgetFormPropelChoice(array('model' => 'Framework', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name_pt'         => new sfValidatorString(array('required' => false)),
      'name_us'         => new sfValidatorString(array('required' => false)),
      'framework_name'  => new sfValidatorString(array('required' => false)),
      'activity_parent' => new sfValidatorPropelChoice(array('model' => 'Activity', 'column' => 'id', 'required' => false)),
      'description'     => new sfValidatorString(array('required' => false)),
      'framework_id'    => new sfValidatorPropelChoice(array('model' => 'Framework', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activity';
  }


}
