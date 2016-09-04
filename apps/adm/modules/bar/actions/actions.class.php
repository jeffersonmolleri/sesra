<?php

/**
 * bar actions.
 *
 * @package    aline
 * @subpackage bar
 * @author     Enova Interactive
 * @version    SVN: $Id: actions.class.php 118 2009-01-29 20:36:50Z pedro $
 */
class barActions extends sfActions
{
	
  public function preExecute()
  {
  	if ($this->getUser()->isAuthenticated())
    {
   		$perms = $this->getUser()->getAllPermissions();
    	$has_permission = false;
    	foreach ($perms as $perm)
    	{
    		if (!empty($perm) && $perm->getId() <= 8)
    		{
    			$has_permission = true;
    		}
    	}
    	
    	if ($has_permission == false)
    	{
    		$this->redirect('@sf_guard_signout');
    	}
    }
  }
	
  public function executeRetrieveStatesByCountry(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('retrieveDataForSelect');
    //teste
    $this->target = $request->getParameter('target');
    $this->selected = $request->getParameter('selected',null);
    $this->country = 'BR';
    if ($this->country) {
      $this->data = StatePeer::doSelectByCountry($this->country);
    } else {
      $this->noresult = 'nenhum estado encontrado';
    }
  }

  public function executeRetrieveCitiesByState(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('retrieveDataForSelect');

    $this->target = $request->getParameter('target');
    $this->selected = $request->getParameter('selected',null);
    $state_id = $request->getParameter('state_id');
    if (!empty($state_id)) {
      $state = StatePeer::retrieveByPK($state_id);
      $this->data = $state->getCitys();
    } else {
      $this->noresult = 'nenhuma cidade encontrada';
    }
  }

  public function executeRetrieveCitiesByStateCode()
  {
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('retrieveDataForSelect');

    $this->target = $this->getRequestParameter('target');
    $state = $this->getRequestParameter('state_id');

    if ($state) {
      $this->data = CityPeer::doSelectByStateCode($state);
    } else {
      $this->noresult = 'no city found';
    }
  }

  public function executeDefaultJavascript()
  {
    $url = substr($this->getController()->genUrl('@homepage', true), 0, -1);
    $this->getResponse()->setContentType('text/javascript');
    list($Y, $m, $d) = explode('-', date('Y-m-d'));
    
    /*return $this->renderText("
      /**
       * GLOBAL SCOPE VARS
       */ /*
      var env = '$url';
      var host = 'http://{$this->getRequest()->getHost()}';
      var curr_date = [$Y, $m, $d];
    ");*/
  }
}
