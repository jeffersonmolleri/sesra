<?php

/**
 * Framework form base class.
 *
 * @method Framework getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseFrameworkForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name_pt' => new sfWidgetFormInputText(),
      'name_us' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name_pt' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'name_us' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('framework[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Framework';
  }


}
