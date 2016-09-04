<?php

/**
 * mail actions.
 *
 * @package    mestrado
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if ($request->hasParameter('tpl')) {
      $this->tpl = $request->getParameter('tpl');
//       $this->profile = $this->getUser()->getGuardUser()->getProfile();
      $this->review = SystematicReviewPeer::retrieveByPK($request->getParameter('review'));

      $protocols = $this->review->getProtocols();
      $this->protocol_id = $protocols[0]->getId();

      switch ($this->tpl) {
        case "_sendTimetable.php" :
          $this->activities = ActivityPeer::doSelectWithChildrenForProtocol($protocols[0], true);
          break;
      }

    } else {
      $this->forward('default', 'module');
    }
  }
}
