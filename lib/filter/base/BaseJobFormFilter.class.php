<?php

/**
 * Job filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseJobFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'description' => new sfWidgetFormFilterInput(),
      'activity_id' => new sfWidgetFormPropelChoice(array('model' => 'Activity', 'add_empty' => true)),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'protocol_id' => new sfWidgetFormPropelChoice(array('model' => 'Protocol', 'add_empty' => true)),
      'finished_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'finished_by' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'description' => new sfValidatorPass(array('required' => false)),
      'activity_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Activity', 'column' => 'id')),
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'protocol_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Protocol', 'column' => 'id')),
      'finished_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'finished_by' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('job_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Job';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'date'        => 'Date',
      'description' => 'Text',
      'activity_id' => 'ForeignKey',
      'user_id'     => 'ForeignKey',
      'protocol_id' => 'ForeignKey',
      'finished_at' => 'Date',
      'finished_by' => 'ForeignKey',
    );
  }
}
