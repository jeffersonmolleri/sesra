<?php

/**
 * RslResult form base class.
 *
 * @method RslResult getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseRslResultForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'data_sintesys'         => new sfWidgetFormTextarea(),
      'class_description'     => new sfWidgetFormTextarea(),
      'meta_sintesys'         => new sfWidgetFormTextarea(),
      'results'               => new sfWidgetFormTextarea(),
      'discussions'           => new sfWidgetFormTextarea(),
      'conclusions'           => new sfWidgetFormTextarea(),
      'practice_implications' => new sfWidgetFormTextarea(),
      'search_implications'   => new sfWidgetFormTextarea(),
      'appointments'          => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'deleted_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'            => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'rsl_id'                => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'data_sintesys'         => new sfValidatorString(array('required' => false)),
      'class_description'     => new sfValidatorString(array('required' => false)),
      'meta_sintesys'         => new sfValidatorString(array('required' => false)),
      'results'               => new sfValidatorString(array('required' => false)),
      'discussions'           => new sfValidatorString(array('required' => false)),
      'conclusions'           => new sfValidatorString(array('required' => false)),
      'practice_implications' => new sfValidatorString(array('required' => false)),
      'search_implications'   => new sfValidatorString(array('required' => false)),
      'appointments'          => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'            => new sfValidatorDateTime(array('required' => false)),
      'created_by'            => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'            => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'            => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'rsl_id'                => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rsl_result[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RslResult';
  }


}
