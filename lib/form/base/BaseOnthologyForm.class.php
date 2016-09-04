<?php

/**
 * Onthology form base class.
 *
 * @method Onthology getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseOnthologyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'name' => new sfWidgetFormInputText(),
      'root' => new sfWidgetFormPropelChoice(array('model' => 'Onthology', 'add_empty' => false)),
      'path' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name' => new sfValidatorString(array('max_length' => 255)),
      'root' => new sfValidatorPropelChoice(array('model' => 'Onthology', 'column' => 'id')),
      'path' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('onthology[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Onthology';
  }


}
