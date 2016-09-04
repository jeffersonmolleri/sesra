<?php

/**
 * Question filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseQuestionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'questionnaire_id' => new sfWidgetFormPropelChoice(array('model' => 'Questionnaire', 'add_empty' => true)),
      'description'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'answer_type'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'answer_list'      => new sfWidgetFormPropelChoice(array('model' => 'Study', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'questionnaire_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Questionnaire', 'column' => 'id')),
      'description'      => new sfValidatorPass(array('required' => false)),
      'answer_type'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'answer_list'      => new sfValidatorPropelChoice(array('model' => 'Study', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('question_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAnswerListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AnswerPeer::QUESTION_ID, QuestionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AnswerPeer::STUDY_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AnswerPeer::STUDY_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Question';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'questionnaire_id' => 'ForeignKey',
      'description'      => 'Text',
      'answer_type'      => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'deleted_at'       => 'Date',
      'created_by'       => 'ForeignKey',
      'updated_by'       => 'ForeignKey',
      'deleted_by'       => 'ForeignKey',
      'answer_list'      => 'ManyKey',
    );
  }
}
