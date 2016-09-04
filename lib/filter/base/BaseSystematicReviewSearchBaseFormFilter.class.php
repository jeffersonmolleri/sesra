<?php

/**
 * SystematicReviewSearchBase filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewSearchBaseFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
      'search_base_id'       => new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'add_empty' => true)),
      'protocol_id'          => new sfWidgetFormPropelChoice(array('model' => 'Protocol', 'add_empty' => true)),
      'query_string'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'systematic_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
      'search_base_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SearchBase', 'column' => 'id')),
      'protocol_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Protocol', 'column' => 'id')),
      'query_string'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('systematic_review_search_base_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReviewSearchBase';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'systematic_review_id' => 'ForeignKey',
      'search_base_id'       => 'ForeignKey',
      'protocol_id'          => 'ForeignKey',
      'query_string'         => 'Text',
    );
  }
}
