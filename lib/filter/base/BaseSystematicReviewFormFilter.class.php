<?php

/**
 * SystematicReview filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'question'         => new sfWidgetFormFilterInput(),
      'restrict'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'questionnaire_id' => new sfWidgetFormPropelChoice(array('model' => 'Questionnaire', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorPass(array('required' => false)),
      'question'         => new sfValidatorPass(array('required' => false)),
      'restrict'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'questionnaire_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Questionnaire', 'column' => 'id')),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('systematic_review_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReview';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'title'            => 'Text',
      'question'         => 'Text',
      'restrict'         => 'Boolean',
      'questionnaire_id' => 'ForeignKey',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'deleted_at'       => 'Date',
      'created_by'       => 'ForeignKey',
      'updated_by'       => 'ForeignKey',
      'deleted_by'       => 'ForeignKey',
    );
  }
}
