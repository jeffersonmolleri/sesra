<?php

/**
 * SystematicRevisionSearchBase filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSystematicRevisionSearchBaseFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicRevision', 'add_empty' => true)),
      'search_base_id'       => new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'add_empty' => true)),
      'protocol_id'          => new sfWidgetFormPropelChoice(array('model' => 'Protocol', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'systematic_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicRevision', 'column' => 'id')),
      'search_base_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SearchBase', 'column' => 'id')),
      'protocol_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Protocol', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('systematic_revision_search_base_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicRevisionSearchBase';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'systematic_review_id' => 'ForeignKey',
      'search_base_id'       => 'ForeignKey',
      'protocol_id'          => 'ForeignKey',
    );
  }
}
