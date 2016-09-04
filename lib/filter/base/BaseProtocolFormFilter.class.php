<?php

/**
 * Protocol filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseProtocolFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'objective'       => new sfWidgetFormFilterInput(),
      'population'      => new sfWidgetFormFilterInput(),
      'intervention'    => new sfWidgetFormFilterInput(),
      'comparative'     => new sfWidgetFormFilterInput(),
      'outcome'         => new sfWidgetFormFilterInput(),
      'context'         => new sfWidgetFormFilterInput(),
      'search_string'   => new sfWidgetFormFilterInput(),
      'metodology'      => new sfWidgetFormFilterInput(),
      'assessment'      => new sfWidgetFormFilterInput(),
      'data_extraction' => new sfWidgetFormFilterInput(),
      'data_analisys'   => new sfWidgetFormFilterInput(),
      'dissemination'   => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'rsl_id'          => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
      'framework_id'    => new sfWidgetFormPropelChoice(array('model' => 'Framework', 'add_empty' => true)),
      'strategy_id'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'objective'       => new sfValidatorPass(array('required' => false)),
      'population'      => new sfValidatorPass(array('required' => false)),
      'intervention'    => new sfValidatorPass(array('required' => false)),
      'comparative'     => new sfValidatorPass(array('required' => false)),
      'outcome'         => new sfValidatorPass(array('required' => false)),
      'context'         => new sfValidatorPass(array('required' => false)),
      'search_string'   => new sfValidatorPass(array('required' => false)),
      'metodology'      => new sfValidatorPass(array('required' => false)),
      'assessment'      => new sfValidatorPass(array('required' => false)),
      'data_extraction' => new sfValidatorPass(array('required' => false)),
      'data_analisys'   => new sfValidatorPass(array('required' => false)),
      'dissemination'   => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'rsl_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
      'framework_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Framework', 'column' => 'id')),
      'strategy_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('protocol_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Protocol';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'objective'       => 'Text',
      'population'      => 'Text',
      'intervention'    => 'Text',
      'comparative'     => 'Text',
      'outcome'         => 'Text',
      'context'         => 'Text',
      'search_string'   => 'Text',
      'metodology'      => 'Text',
      'assessment'      => 'Text',
      'data_extraction' => 'Text',
      'data_analisys'   => 'Text',
      'dissemination'   => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'deleted_at'      => 'Date',
      'rsl_id'          => 'ForeignKey',
      'framework_id'    => 'ForeignKey',
      'strategy_id'     => 'Number',
    );
  }
}
