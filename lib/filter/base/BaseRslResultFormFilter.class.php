<?php

/**
 * RslResult filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseRslResultFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'data_sintesys'         => new sfWidgetFormFilterInput(),
      'class_description'     => new sfWidgetFormFilterInput(),
      'meta_sintesys'         => new sfWidgetFormFilterInput(),
      'results'               => new sfWidgetFormFilterInput(),
      'discussions'           => new sfWidgetFormFilterInput(),
      'conclusions'           => new sfWidgetFormFilterInput(),
      'practice_implications' => new sfWidgetFormFilterInput(),
      'search_implications'   => new sfWidgetFormFilterInput(),
      'appointments'          => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'deleted_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'rsl_id'                => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'data_sintesys'         => new sfValidatorPass(array('required' => false)),
      'class_description'     => new sfValidatorPass(array('required' => false)),
      'meta_sintesys'         => new sfValidatorPass(array('required' => false)),
      'results'               => new sfValidatorPass(array('required' => false)),
      'discussions'           => new sfValidatorPass(array('required' => false)),
      'conclusions'           => new sfValidatorPass(array('required' => false)),
      'practice_implications' => new sfValidatorPass(array('required' => false)),
      'search_implications'   => new sfValidatorPass(array('required' => false)),
      'appointments'          => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'rsl_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('rsl_result_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RslResult';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'data_sintesys'         => 'Text',
      'class_description'     => 'Text',
      'meta_sintesys'         => 'Text',
      'results'               => 'Text',
      'discussions'           => 'Text',
      'conclusions'           => 'Text',
      'practice_implications' => 'Text',
      'search_implications'   => 'Text',
      'appointments'          => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'deleted_at'            => 'Date',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
      'deleted_by'            => 'ForeignKey',
      'rsl_id'                => 'ForeignKey',
    );
  }
}
