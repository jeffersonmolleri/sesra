<?php

/**
 * systematic_review components.
 *
 * @package    mestrado
 * @subpackage systematic_review
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systematic_reviewComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSubmenu(sfWebRequest $request)
  {
  	if (empty($this->review_id)) {
  		$this->review_id = $this->id;
  	}
  	
    $c = new Criteria();
    $c->add(ProtocolPeer::RSL_ID, $this->review_id);
    $protocol = ProtocolPeer::doSelectOne($c);
    
    $c = new Criteria();
    $c->clearSelectColumns()->addSelectColumn(JobPeer::ACTIVITY_ID);
    $c->add(JobPeer::PROTOCOL_ID, $protocol->getId());
    $c->addAnd(JobPeer::FINISHED_AT, null, Criteria::ISNOTNULL);
    $c->setDistinct();
    $jobs = JobPeer::doSelectStmt($c);
    
    $arrayJobs = array();
    foreach ($jobs as $i) {
      $arrayJobs[] = $i[0];
    }
    
    $this->jobs = $arrayJobs;
    
    $c = new Criteria();
    $c->add(SystematicReviewPeer::ID, $this->review_id);
    $review = SystematicReviewPeer::doSelectOne($c);
    
    $this->urls = sfConfig::get('app_etapa_url');
    $this->review = $review;
  }
}
