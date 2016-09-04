<?php

/**
 * Activity filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseActivityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name_pt'         => new sfWidgetFormFilterInput(),
      'name_us'         => new sfWidgetFormFilterInput(),
      'framework_name'  => new sfWidgetFormFilterInput(),
      'activity_parent' => new sfWidgetFormPropelChoice(array('model' => 'Activity', 'add_empty' => true)),
      'description'     => new sfWidgetFormFilterInput(),
      'framework_id'    => new sfWidgetFormPropelChoice(array('model' => 'Framework', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name_pt'         => new sfValidatorPass(array('required' => false)),
      'name_us'         => new sfValidatorPass(array('required' => false)),
      'framework_name'  => new sfValidatorPass(array('required' => false)),
      'activity_parent' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Activity', 'column' => 'id')),
      'description'     => new sfValidatorPass(array('required' => false)),
      'framework_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Framework', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('activity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activity';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name_pt'         => 'Text',
      'name_us'         => 'Text',
      'framework_name'  => 'Text',
      'activity_parent' => 'ForeignKey',
      'description'     => 'Text',
      'framework_id'    => 'ForeignKey',
    );
  }
}
