<?php

/**
 * Tag form base class.
 *
 * @method Tag getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseTagForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'is_triple'        => new sfWidgetFormInputCheckbox(),
      'triple_namespace' => new sfWidgetFormInputText(),
      'triple_key'       => new sfWidgetFormInputText(),
      'triple_value'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getID()), 'empty_value' => $this->getObject()->getID(), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'is_triple'        => new sfValidatorBoolean(array('required' => false)),
      'triple_namespace' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'triple_key'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'triple_value'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tag';
  }


}
