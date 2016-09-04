<?php

/**
 * DataExtraction filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseDataExtractionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'       => new sfWidgetFormFilterInput(),
      'metadata_id' => new sfWidgetFormPropelChoice(array('model' => 'Metadata', 'add_empty' => true)),
      'study_id'    => new sfWidgetFormPropelChoice(array('model' => 'Study', 'add_empty' => true)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'value'       => new sfValidatorPass(array('required' => false)),
      'metadata_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Metadata', 'column' => 'id')),
      'study_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Study', 'column' => 'id')),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('data_extraction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DataExtraction';
  }

  public function getFields()
  {
    return array(
      'value'       => 'Text',
      'metadata_id' => 'ForeignKey',
      'study_id'    => 'ForeignKey',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'deleted_at'  => 'Date',
      'created_by'  => 'ForeignKey',
      'updated_by'  => 'ForeignKey',
      'deleted_by'  => 'ForeignKey',
      'id'          => 'Number',
    );
  }
}
