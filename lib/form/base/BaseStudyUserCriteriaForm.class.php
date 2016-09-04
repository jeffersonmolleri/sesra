<?php

/**
 * StudyUserCriteria form base class.
 *
 * @method StudyUserCriteria getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseStudyUserCriteriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'study_id'    => new sfWidgetFormPropelChoice(array('model' => 'Study', 'add_empty' => false)),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'criteria_id' => new sfWidgetFormPropelChoice(array('model' => 'RslCriteria', 'add_empty' => false)),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'study_id'    => new sfValidatorPropelChoice(array('model' => 'Study', 'column' => 'id')),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'criteria_id' => new sfValidatorPropelChoice(array('model' => 'RslCriteria', 'column' => 'id')),
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('study_user_criteria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudyUserCriteria';
  }


}
