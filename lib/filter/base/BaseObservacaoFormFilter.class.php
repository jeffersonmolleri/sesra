<?php

/**
 * Observacao filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseObservacaoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'owner_id'     => new sfWidgetFormFilterInput(),
      'owner_model'  => new sfWidgetFormFilterInput(),
      'owner_column' => new sfWidgetFormFilterInput(),
      'observacao'   => new sfWidgetFormFilterInput(),
      'situacao'     => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'   => new sfWidgetFormFilterInput(),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_by'   => new sfWidgetFormFilterInput(),
      'deleted_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_by'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'owner_id'     => new sfValidatorPass(array('required' => false)),
      'owner_model'  => new sfValidatorPass(array('required' => false)),
      'owner_column' => new sfValidatorPass(array('required' => false)),
      'observacao'   => new sfValidatorPass(array('required' => false)),
      'situacao'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_by'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_by'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('observacao_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Observacao';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'owner_id'     => 'Text',
      'owner_model'  => 'Text',
      'owner_column' => 'Text',
      'observacao'   => 'Text',
      'situacao'     => 'Number',
      'created_at'   => 'Date',
      'created_by'   => 'Number',
      'updated_at'   => 'Date',
      'updated_by'   => 'Number',
      'deleted_at'   => 'Date',
      'deleted_by'   => 'Number',
    );
  }
}
