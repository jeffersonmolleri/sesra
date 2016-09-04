<?php

/**
 * Observacao form base class.
 *
 * @method Observacao getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseObservacaoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'owner_id'     => new sfWidgetFormInputText(),
      'owner_model'  => new sfWidgetFormInputText(),
      'owner_column' => new sfWidgetFormInputText(),
      'observacao'   => new sfWidgetFormTextarea(),
      'situacao'     => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'created_by'   => new sfWidgetFormInputText(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'updated_by'   => new sfWidgetFormInputText(),
      'deleted_at'   => new sfWidgetFormDateTime(),
      'deleted_by'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'owner_id'     => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'owner_model'  => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'owner_column' => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'observacao'   => new sfValidatorString(array('required' => false)),
      'situacao'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'created_by'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_by'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'deleted_at'   => new sfValidatorDateTime(array('required' => false)),
      'deleted_by'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('observacao[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Observacao';
  }


}
