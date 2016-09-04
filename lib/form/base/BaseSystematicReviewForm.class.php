<?php

/**
 * SystematicReview form base class.
 *
 * @method SystematicReview getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInputText(),
      'question'         => new sfWidgetFormTextarea(),
      'restrict'         => new sfWidgetFormInputCheckbox(),
      'questionnaire_id' => new sfWidgetFormPropelChoice(array('model' => 'Questionnaire', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'question'         => new sfValidatorString(array('required' => false)),
      'restrict'         => new sfValidatorBoolean(array('required' => false)),
      'questionnaire_id' => new sfValidatorPropelChoice(array('model' => 'Questionnaire', 'column' => 'id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'       => new sfValidatorDateTime(array('required' => false)),
      'created_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('systematic_review[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReview';
  }


}
