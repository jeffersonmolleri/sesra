<?php

/**
 * City filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseCityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'state_id' => new sfWidgetFormPropelChoice(array('model' => 'State', 'add_empty' => true)),
      'slug'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'     => new sfValidatorPass(array('required' => false)),
      'state_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'State', 'column' => 'id')),
      'slug'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'City';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'name'     => 'Text',
      'state_id' => 'ForeignKey',
      'slug'     => 'Text',
    );
  }
}
