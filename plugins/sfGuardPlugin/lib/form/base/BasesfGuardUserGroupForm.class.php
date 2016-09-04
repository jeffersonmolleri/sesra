<?php

/**
 * sfGuardUserGroup form base class.
 *
 * @method sfGuardUserGroup getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasesfGuardUserGroupForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'group_id' => new sfWidgetFormInputHidden(),
      'user_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'group_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardGroup', 'column' => 'id', 'required' => false)),
      'user_id'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserGroup';
  }


}
