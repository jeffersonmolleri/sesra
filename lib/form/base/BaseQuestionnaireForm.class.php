<?php

/**
 * Questionnaire form base class.
 *
 * @method Questionnaire getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseQuestionnaireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
      'name'                 => new sfWidgetFormTextarea(),
      'description'          => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted_at'           => new sfWidgetFormDateTime(),
      'created_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'systematic_review_id' => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id', 'required' => false)),
      'name'                 => new sfValidatorString(),
      'description'          => new sfValidatorString(),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'           => new sfValidatorDateTime(array('required' => false)),
      'created_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('questionnaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Questionnaire';
  }


}
