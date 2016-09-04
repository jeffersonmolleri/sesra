<?php

/**
 * Onthology filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseOnthologyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'root' => new sfWidgetFormPropelChoice(array('model' => 'Onthology', 'add_empty' => true)),
      'path' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name' => new sfValidatorPass(array('required' => false)),
      'root' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Onthology', 'column' => 'id')),
      'path' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('onthology_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Onthology';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'name' => 'Text',
      'root' => 'ForeignKey',
      'path' => 'Text',
    );
  }
}
