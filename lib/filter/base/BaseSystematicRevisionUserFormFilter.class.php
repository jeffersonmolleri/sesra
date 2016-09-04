<?php

/**
 * SystematicRevisionUser filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSystematicRevisionUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'systematic_review_id' => new sfWidgetFormFilterInput(),
      'user_id'              => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'level'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'systematic_review_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'level'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('systematic_revision_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicRevisionUser';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'systematic_review_id' => 'Number',
      'user_id'              => 'ForeignKey',
      'level'                => 'Number',
    );
  }
}
