<?php

/**
 * index actions.
 *
 * @package    aline
 * @subpackage index
 * @author     Enova Interactive
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class indexActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
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
	
  public function executeIndex(sfWebRequest $request)
  {
  	//var_dump($this->getUser()->getCulture());
    //$this->forward('default', 'module');
  }
	
  public function executeAbout(sfWebRequest $request)
  {
  }
	
  public function executeContacts(sfWebRequest $request)
  {
  }
}
