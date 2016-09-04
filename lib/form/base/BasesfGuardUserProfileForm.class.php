<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'birthdate'   => new sfWidgetFormDate(),
      'email'       => new sfWidgetFormInputText(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'institute'   => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'birthdate'   => new sfValidatorDate(array('required' => false)),
      'email'       => new sfValidatorString(array('max_length' => 128)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'institute'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


}
