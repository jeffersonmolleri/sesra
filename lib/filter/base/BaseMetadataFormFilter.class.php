<?php

/**
 * Metadata filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseMetadataFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(),
      'description'          => new sfWidgetFormFilterInput(),
      'type'                 => new sfWidgetFormFilterInput(),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
      'type'                 => new sfValidatorPass(array('required' => false)),
      'systematic_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystematicReview', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('metadata_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Metadata';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'description'          => 'Text',
      'type'                 => 'Text',
      'systematic_review_id' => 'ForeignKey',
    );
  }
}
