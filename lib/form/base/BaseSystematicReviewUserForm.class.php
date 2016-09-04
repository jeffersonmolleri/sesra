<?php

/**
 * SystematicReviewUser form base class.
 *
 * @method SystematicReviewUser getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'systematic_review_id'      => new sfWidgetFormInputText(),
      'user_id'                   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'level'                     => new sfWidgetFormInputText(),
      'validation_invite'         => new sfWidgetFormDateTime(),
      'results_validation_invite' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'systematic_review_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'user_id'                   => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'level'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'validation_invite'         => new sfValidatorDateTime(array('required' => false)),
      'results_validation_invite' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('systematic_review_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReviewUser';
  }


}
