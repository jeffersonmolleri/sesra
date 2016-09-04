<?php

/**
 * Study form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class StudyForm extends BaseStudyForm
{
  public function configure()
  {
    $this->widgetSchema['systematic_review_id'] = new sfWidgetFormInputHidden();

    $c = new Criteria();
    $c->addJoin(SearchBasePeer::ID, SystematicReviewSearchBasePeer::SEARCH_BASE_ID);
    $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $this->getObject()->getSystematicReviewId());
    $this->widgetSchema['base_id'] = new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'criteria' => $c, 'add_empty' => true, 'method' => 'doSelectForChoice', 'order_by' => array ('Name', 'asc')));
    
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
