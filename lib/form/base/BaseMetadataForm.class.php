<?php

/**
 * Metadata form base class.
 *
 * @method Metadata getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseMetadataForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'description'          => new sfWidgetFormTextarea(),
      'type'                 => new sfWidgetFormInputText(),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'description'          => new sfValidatorString(array('required' => false)),
      'type'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'systematic_review_id' => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('metadata[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Metadata';
  }


}
