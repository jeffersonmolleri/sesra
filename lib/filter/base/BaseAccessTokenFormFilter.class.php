<?php

/**
 * AccessToken filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseAccessTokenFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'expire_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'forward_to' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'expire_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'forward_to' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('access_token_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccessToken';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Text',
      'user_id'    => 'ForeignKey',
      'expire_at'  => 'Date',
      'forward_to' => 'Text',
    );
  }
}
