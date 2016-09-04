<?php

/**
 * SystematicReviewSearchBase form base class.
 *
 * @method SystematicReviewSearchBase getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewSearchBaseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => false)),
      'search_base_id'       => new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'add_empty' => false)),
      'protocol_id'          => new sfWidgetFormPropelChoice(array('model' => 'Protocol', 'add_empty' => false)),
      'query_string'         => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'systematic_review_id' => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id')),
      'search_base_id'       => new sfValidatorPropelChoice(array('model' => 'SearchBase', 'column' => 'id')),
      'protocol_id'          => new sfValidatorPropelChoice(array('model' => 'Protocol', 'column' => 'id')),
      'query_string'         => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('systematic_review_search_base[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReviewSearchBase';
  }


}
