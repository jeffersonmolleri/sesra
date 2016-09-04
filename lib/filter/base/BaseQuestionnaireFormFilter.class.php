<?php

/**
 * Questionnaire filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseQuestionnaireFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'systematic_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('questionnaire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Questionnaire';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'systematic_review_id' => 'ForeignKey',
      'name'                 => 'Text',
      'description'          => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'deleted_at'           => 'Date',
      'created_by'           => 'ForeignKey',
      'updated_by'           => 'ForeignKey',
      'deleted_by'           => 'ForeignKey',
    );
  }
}
