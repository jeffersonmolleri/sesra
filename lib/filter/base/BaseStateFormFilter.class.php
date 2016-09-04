<?php

/**
 * State filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseStateFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'    => new sfValidatorPass(array('required' => false)),
      'code'    => new sfValidatorPass(array('required' => false)),
      'country' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('state_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'State';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'name'    => 'Text',
      'code'    => 'Text',
      'country' => 'Text',
    );
  }
}
