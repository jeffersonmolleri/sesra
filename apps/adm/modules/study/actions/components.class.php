<?php

/**
 * studies components.
 *
 * @package    mestrado
 * @subpackage studies
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class studyComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeStudylist(sfWebRequest $request)
  {
  	$this->requester = $request->getParameter('requester', null);
  	$this->dir = $request->getParameter('dir', null);
  	$this->order = $request->getParameter('order', null);
  }
  
}
