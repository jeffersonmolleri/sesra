<?php

/**
 * Questionnaire form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class QuestionnaireForm extends BaseQuestionnaireForm
{
  public function configure()
  {
  	$this->widgetSchema['systematic_review_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['name'] = new sfWidgetFormInputText();
    
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
