<?php

/**
 * sfGuardGroup form.
 *
 * @package    form
 * @subpackage sf_guard_group
 * @version    SVN: $Id: sfGuardGroupForm.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardGroupForm extends BasesfGuardGroupForm
{
  public function configure()
  {
    unset($this['sf_guard_user_group_list']);

    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'name'                           => new sfWidgetFormInputText(),
      'description'                    => new sfWidgetFormTextarea(),
      'sf_guard_user_group_list'       => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'sf_guard_group_permission_list' => new sfWidgetFormPropelChoice(array('expanded'=>true, 'multiple' => true, 'model' => 'sfGuardPermission')),
    ));
    
    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                           => new sfValidatorString(array('max_length' => 255),array('required'=>'O campo <strong>NOME</strong> é obrigatório.')),
      'description'                    => new sfValidatorString(array('required' => false)),
      'sf_guard_user_group_list'       => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'sf_guard_group_permission_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
    ));
    
    $this->widgetSchema['sf_guard_group_permission_list']->setLabel('Permissions');
    $this->widgetSchema['sf_guard_group_permission_list']->setOption('method', 'getDescription');
    
    $this->widgetSchema->setNameFormat('sf_guard_group[%s]');
  }
}
