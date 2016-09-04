<?php

/**
 * Study filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseStudyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'study_abstract'       => new sfWidgetFormFilterInput(),
      'url'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'publication_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'bibtex'               => new sfWidgetFormFilterInput(),
      'base_id'              => new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'add_empty' => true)),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
      'casting_vote'         => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'answer_list'          => new sfWidgetFormPropelChoice(array('model' => 'Question', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'                => new sfValidatorPass(array('required' => false)),
      'study_abstract'       => new sfValidatorPass(array('required' => false)),
      'url'                  => new sfValidatorPass(array('required' => false)),
      'publication_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'bibtex'               => new sfValidatorPass(array('required' => false)),
      'base_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SearchBase', 'column' => 'id')),
      'systematic_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
      'casting_vote'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'answer_list'          => new sfValidatorPropelChoice(array('model' => 'Question', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('study_filters[%s]');

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

    $criteria->addJoin(AnswerPeer::STUDY_ID, StudyPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AnswerPeer::QUESTION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AnswerPeer::QUESTION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Study';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'title'                => 'Text',
      'study_abstract'       => 'Text',
      'url'                  => 'Text',
      'publication_date'     => 'Date',
      'bibtex'               => 'Text',
      'base_id'              => 'ForeignKey',
      'systematic_review_id' => 'ForeignKey',
      'casting_vote'         => 'ForeignKey',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'deleted_at'           => 'Date',
      'created_by'           => 'ForeignKey',
      'updated_by'           => 'ForeignKey',
      'deleted_by'           => 'ForeignKey',
      'answer_list'          => 'ManyKey',
    );
  }
}
