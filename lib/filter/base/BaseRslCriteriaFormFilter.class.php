<?php

/**
 * RslCriteria filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseRslCriteriaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'rsl_id'      => new sfWidgetFormFilterInput(),
      'protocol_id' => new sfWidgetFormFilterInput(),
      'name'        => new sfWidgetFormFilterInput(),
      'type'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'rsl_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'protocol_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'        => new sfValidatorPass(array('required' => false)),
      'type'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('rsl_criteria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RslCriteria';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'rsl_id'      => 'Number',
      'protocol_id' => 'Number',
      'name'        => 'Text',
      'type'        => 'Boolean',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'deleted_at'  => 'Date',
      'created_by'  => 'ForeignKey',
      'updated_by'  => 'ForeignKey',
      'deleted_by'  => 'ForeignKey',
    );
  }
}
