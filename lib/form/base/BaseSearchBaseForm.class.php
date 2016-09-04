<?php

/**
 * SearchBase form base class.
 *
 * @method SearchBase getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSearchBaseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormTextarea(),
      'url'         => new sfWidgetFormTextarea(),
      'api'         => new sfWidgetFormTextarea(),
      'is_default'  => new sfWidgetFormInputCheckbox(),
      'txtid'       => new sfWidgetFormInputText(),
      'preview_url' => new sfWidgetFormInputText(),
      'guidelines'  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'        => new sfValidatorString(array('required' => false)),
      'url'         => new sfValidatorString(array('required' => false)),
      'api'         => new sfValidatorString(array('required' => false)),
      'is_default'  => new sfValidatorBoolean(array('required' => false)),
      'txtid'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'preview_url' => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'guidelines'  => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('search_base[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SearchBase';
  }


}
