<?php

/**
 * sfGuardUser form.
 *
 * @package    form
 * @subpackage sf_guard_user
 * @version    SVN: $Id: sfGuardUserForm.class.php 24560 2009-11-30 11:05:31Z fabien $
 */
class sfGuardUserForm extends sfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $this->widgetSchema['sf_guard_user_group_list']->setOption('expanded', false);
    $this->widgetSchema['sf_guard_user_group_list']->setOption('multiple', false);
    $this->widgetSchema['sf_guard_user_group_list']->setOption('method', 'getDescription');
    $this->widgetSchema['sf_guard_user_permission_list']->setOption('expanded', true);
    $this->widgetSchema['sf_guard_user_permission_list']->setOption('method', 'getDescription');

    $this->widgetSchema['is_active'] = new sfWidgetFormInputHidden();
    
    $this->validatorSchema['name']->setMessage('required', 'O campo <strong>NOME</strong> é obrigatório.');
    $this->validatorSchema['email']->setMessage('required', 'O campo <strong>E-MAIL</strong> é obrigatório.');
    $this->validatorSchema['email']->setMessage('invalid', 'Por favor, digite um <strong>EMAIL</strong> válido.');
    $this->validatorSchema['username']->setMessage('required', 'O campo <strong>LOGIN</strong> é obrigatório.');
    $this->validatorSchema['password']->setMessage('required', 'O campo <strong>SENHA</strong> é obrigatório.');
    $this->validatorSchema['password_again']->setMessage('required', 'Por favor, digite a <strong>CONFIRMAÇÃO DE SENHA</strong>.');

	//referencia http://stackoverflow.com/questions/9552473/symfony-multiple-post-validators
	$this->mergePostValidator(
			new sfValidatorPropelUnique(
				array('model' => 'sfGuardUser', 'column' => array('username')),
	 			array(
	 				"invalid" => "O <strong>Login</strong> já está sendo utilizado."
	 			)

			)
	);


    //$post = $this->validatorSchema->getPostValidator();
    //$post[1]->setMessage('invalid', 'As senhas informadas devem ser iguais');

    unset(
      //$this['is_active'],
      $this['is_super_admin']
//       $this['sf_guard_user_group_list'],
//       $this['sf_guard_user_permission_list']
    );
  }
}
