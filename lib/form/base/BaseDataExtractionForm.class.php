<?php

/**
 * DataExtraction form base class.
 *
 * @method DataExtraction getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseDataExtractionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'       => new sfWidgetFormInputText(),
      'metadata_id' => new sfWidgetFormPropelChoice(array('model' => 'Metadata', 'add_empty' => false)),
      'study_id'    => new sfWidgetFormPropelChoice(array('model' => 'Study', 'add_empty' => false)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted_at'  => new sfWidgetFormDateTime(),
      'created_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'value'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'metadata_id' => new sfValidatorPropelChoice(array('model' => 'Metadata', 'column' => 'id')),
      'study_id'    => new sfValidatorPropelChoice(array('model' => 'Study', 'column' => 'id')),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'  => new sfValidatorDateTime(array('required' => false)),
      'created_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('data_extraction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DataExtraction';
  }


}
