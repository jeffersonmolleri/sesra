<?php

/**
 * Protocol form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class ProtocolForm extends BaseProtocolForm
{
  public function configure()
  {

		$c = new Criteria();
		$c->addAscendingOrderByColumn(FrameworkPeer::NAME_PT);
		$frameworks = FrameworkPeer::doSelect($c);
		$framework_list = array();
		$framework_list[''] = ' - selecionar - ';

		$strategy_list = array();
		$strategy_list[0] = 'Seleção através de múltiplos pesquisadores';
		$strategy_list[1] = 'Testes de confiabilidade entre avaliadores (inter-rater reliability test)';
		$strategy_list[2] = 'Critérios de avaliação de qualidade dos estudos';
		foreach($frameworks as $f)
		{
			$framework_list[$f->getId()] = $f->getNamePt();
		}

		$strategy_tooltips = array();
		$strategy_tooltips[0] = 'Realizada individualmente por cada membro do grupo. As divergências que surgirem devem ser resolvidas através de consenso ou da intervenção de um mediador.';
		$strategy_tooltips[1] = 'Um pesquisador primário realiza a seleção dos estudos de forma completa, e uma amostra dos estudos identificados é disponibilizada a um revisor secundário.';
		$strategy_tooltips[2] = 'Realizar a classificação automática a partir da avaliação de qualidade dos estudos.';

  	$this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'objective'       => new sfWidgetFormTextarea(),
      'population'      => new sfWidgetFormInputText(),
      'intervention'    => new sfWidgetFormInputText(),
      'comparative'     => new sfWidgetFormInputText(),
      'outcome'         => new sfWidgetFormInputText(),
      'context'         => new sfWidgetFormInputText(),
      'search_string'   => new sfWidgetFormTextarea(),
      'metodology'      => new sfWidgetFormTextarea(),
      'assessment'      => new sfWidgetFormTextarea(),
      'data_extraction' => new sfWidgetFormTextarea(),
      'data_analisys'   => new sfWidgetFormTextarea(),
      'dissemination'   => new sfWidgetFormTextarea(),
  	  'rsl_id'          => new sfWidgetFormInputHidden(),
  	  'framework_id'    => new sfWidgetFormInputHidden(),
      'strategy_id'     => new arsWidgetFormSelectRadio(array('choices' => $strategy_list, 'tooltips' => $strategy_tooltips)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'objective'       => new sfValidatorString(array('required' => false)),
      'population'      => new sfValidatorString(array('required' => false)),
      'intervention'    => new sfValidatorString(array('required' => false)),
      'comparative'     => new sfValidatorString(array('required' => false)),
      'outcome'         => new sfValidatorString(array('required' => false)),
      'context'         => new sfValidatorString(array('required' => false)),
      'search_string'   => new sfValidatorString(array('required' => false)),
      'metodology'      => new sfValidatorString(array('required' => false)),
      'assessment'      => new sfValidatorString(array('required' => false)),
      'data_extraction' => new sfValidatorString(array('required' => false)),
      'data_analisys'   => new sfValidatorString(array('required' => false)),
      'dissemination'   => new sfValidatorString(array('required' => false)),
      'framework_id'    => new sfValidatorInteger(array('required' => false)),
      'rsl_id'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'strategy_id'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->setDefault('framework_id', '1');

    $this->widgetSchema->setNameFormat('protocol[%s]');

    unset(
      $this['created_by'],
      $this['updated_by'],
      $this['deleted_by'],
      $this['created_at'],
      $this['updated_at'],
      $this['deleted_at']
    );
  }
}
