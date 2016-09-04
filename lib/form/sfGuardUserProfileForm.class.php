<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(),
      'birthdate' => new sfWidgetFormInputText(),
      'email'     => new sfWidgetFormInputText(),
      'user_id'   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
  	  'institute'   => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255), array('required'=>'O campo <strong>NOME</strong> é obrigatório.')),
      'birthdate' => new sfValidatorDate(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~', 'date_format_error' => 'd/m/Y', 'required' => false), array('required'=>'O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório.')),
      'email'     => new sfValidatorEmail(array('max_length' => 128), array('required'=>'O campo <strong>E-MAIL</strong> é obrigatório.', 'invalid'=>'Por favor, digite um <strong>E-MAIL</string> válido.')),
      'user_id'   => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'institute'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');
  }
}
