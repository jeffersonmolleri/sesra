<?php

/**
 * StudyUserCriteria form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class StudyUserCriteriaForm extends BaseStudyUserCriteriaForm
{
  public function configure()
  {
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['study_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['criteria_id'] = new sfWidgetFormInputHidden();
  }
}
