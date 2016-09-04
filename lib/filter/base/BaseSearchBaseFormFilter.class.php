<?php

/**
 * SearchBase filter form base class.
 *
 * @package    mestrado
 * @subpackage filter
 * @author     Jefferson Seide Molléri
 */
abstract class BaseSearchBaseFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(),
      'url'         => new sfWidgetFormFilterInput(),
      'api'         => new sfWidgetFormFilterInput(),
      'is_default'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'txtid'       => new sfWidgetFormFilterInput(),
      'preview_url' => new sfWidgetFormFilterInput(),
      'guidelines'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'url'         => new sfValidatorPass(array('required' => false)),
      'api'         => new sfValidatorPass(array('required' => false)),
      'is_default'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'txtid'       => new sfValidatorPass(array('required' => false)),
      'preview_url' => new sfValidatorPass(array('required' => false)),
      'guidelines'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('search_base_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SearchBase';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'url'         => 'Text',
      'api'         => 'Text',
      'is_default'  => 'Boolean',
      'txtid'       => 'Text',
      'preview_url' => 'Text',
      'guidelines'  => 'Text',
    );
  }
}
