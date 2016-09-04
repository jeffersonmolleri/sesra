<?php

/**
 * SystematicReviewUser filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSystematicReviewUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'systematic_review_id'      => new sfWidgetFormFilterInput(),
      'user_id'                   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'level'                     => new sfWidgetFormFilterInput(),
      'validation_invite'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'results_validation_invite' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'systematic_review_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'                   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'level'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'validation_invite'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'results_validation_invite' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('systematic_review_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystematicReviewUser';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'systematic_review_id'      => 'Number',
      'user_id'                   => 'ForeignKey',
      'level'                     => 'Number',
      'validation_invite'         => 'Date',
      'results_validation_invite' => 'Date',
    );
  }
}
