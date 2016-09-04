<?php

/**
 * Framework filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseFrameworkFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name_pt' => new sfWidgetFormFilterInput(),
      'name_us' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name_pt' => new sfValidatorPass(array('required' => false)),
      'name_us' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('framework_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Framework';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'name_pt' => 'Text',
      'name_us' => 'Text',
    );
  }
}
