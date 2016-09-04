<?php

/**
 * StudyUserCriteria filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseStudyUserCriteriaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'study_id'    => new sfWidgetFormPropelChoice(array('model' => 'Study', 'add_empty' => true)),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'criteria_id' => new sfWidgetFormPropelChoice(array('model' => 'RslCriteria', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'study_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Study', 'column' => 'id')),
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'criteria_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RslCriteria', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('study_user_criteria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudyUserCriteria';
  }

  public function getFields()
  {
    return array(
      'study_id'    => 'ForeignKey',
      'user_id'     => 'ForeignKey',
      'criteria_id' => 'ForeignKey',
      'id'          => 'Number',
    );
  }
}
