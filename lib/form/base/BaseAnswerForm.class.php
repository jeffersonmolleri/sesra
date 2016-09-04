<?php

/**
 * Answer form base class.
 *
 * @method Answer getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseAnswerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'question_id' => new sfWidgetFormInputHidden(),
      'study_id'    => new sfWidgetFormInputHidden(),
      'answer'      => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted_at'  => new sfWidgetFormDateTime(),
      'created_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'question_id' => new sfValidatorPropelChoice(array('model' => 'Question', 'column' => 'id', 'required' => false)),
      'study_id'    => new sfValidatorPropelChoice(array('model' => 'Study', 'column' => 'id', 'required' => false)),
      'answer'      => new sfValidatorString(),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'  => new sfValidatorDateTime(array('required' => false)),
      'created_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('answer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }


}
