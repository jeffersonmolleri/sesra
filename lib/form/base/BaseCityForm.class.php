<?php

/**
 * City form base class.
 *
 * @method City getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseCityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'name'     => new sfWidgetFormInputText(),
      'state_id' => new sfWidgetFormPropelChoice(array('model' => 'State', 'add_empty' => false)),
      'slug'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'     => new sfValidatorString(array('max_length' => 255)),
      'state_id' => new sfValidatorPropelChoice(array('model' => 'State', 'column' => 'id')),
      'slug'     => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('city[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'City';
  }


}
