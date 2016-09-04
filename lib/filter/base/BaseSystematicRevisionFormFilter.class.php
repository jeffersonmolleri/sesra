<?php

/**
 * SystematicRevision filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSystematicRevisionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'question'   => new sfWidgetFormFilterInput(),
      'restrict'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by' => new sfWidgetFormFilterInput(),
      'updated_by' => new sfWidgetFormFilterInput(),
      'deleted_by' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'      => new sfValidatorPass(array('required' => false)),
      'question'   => new sfValidatorPass(array('required' => false)),
      'restrict'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_by' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_by' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('systematic_revision_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicRevision';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'title'      => 'Text',
      'question'   => 'Text',
      'restrict'   => 'Boolean',
      'created_at' => 'Date',
      'updated_at' => 'Date',
      'deleted_at' => 'Date',
      'created_by' => 'Number',
      'updated_by' => 'Number',
      'deleted_by' => 'Number',
    );
  }
}
