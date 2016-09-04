<?php

/**
 * users actions.
 *
 * @package    aline
 * @subpackage users
 * @author     Enova Interactive
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class usersActions extends sfActions
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

  public function executeIndex(sfWebRequest $request)
  {
    $page = $request->getParameter('page', false);
    $this->name = $this->getRequestParameter('name', false);

    $c = new Criteria();
    $this->order = $request->getParameter('order', sfGuardUserPeer::USERNAME);
    $this->dir = $request->getParameter('dir', 'asc');
    if ($this->dir == 'asc')
    {
      $c->addAscendingOrderByColumn($this->order);
    }
    else
    {
      $c->addDescendingOrderByColumn($this->order);
    }

    if (!empty($this->name))
    {
    	//$c->add(sfGuardUserProfilePeer::NAME, '%'.$this->name.'%', Criteria::LIKE);
    	$c->add(sfGuardUserPeer::USERNAME, '%'.$this->name.'%', Criteria::LIKE);
    }

    $this->users = new sfPropelPager('sfGuardUser', $request->getParameter('sf_pager', 10));
    $this->users->setPeerMethod('doSelectList');
    $this->users->setCriteria($c);
    $this->users->setPage($page);
    $this->users->init();

    $c = new Criteria();
    $usuarios = sfGuardUserProfilePeer::doSelect($c);

    $this->usuarios = array();
    foreach ($usuarios as $usuario)
    {
    	$user = sfGuardUserPeer::retrieveByPk($usuario->getUserId());
    	if ($user->getIsActive() == true)
    	{
    		$this->usuarios[] = $user->getUsername();
    	}
    }
    $this->count_users = count($this->usuarios);

    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setContentType('text/xml');
      $this->setLayout('taconite');
      $this->setTemplate('ajaxList');
    }

  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sfGuardUserForm();

    $c = new Criteria();
    $c->addAscendingOrderByColumn(sfGuardGroupPeer::ID);
    $this->groups = sfGuardGroupPeer::doSelect($c);
    $this->his_groups = array();

    $c = new Criteria();
    $c->addAscendingOrderByColumn(sfGuardPermissionPeer::ID);
    $this->permissions = sfGuardPermissionPeer::doSelect($c);
    $this->his_permissions = array();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new sfGuardUserForm();

    $this->processForm($request, $this->form);

    $c = new Criteria();
    $c->addAscendingOrderByColumn(sfGuardGroupPeer::ID);
    $this->groups = sfGuardGroupPeer::doSelect($c);
    $this->his_groups = array();

    $c = new Criteria();
    $c->addAscendingOrderByColumn(sfGuardPermissionPeer::ID);
    $this->permissions = sfGuardPermissionPeer::doSelect($c);
    $this->his_permissions = array();

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = sfGuardUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));

    $this->recover = false;

    if ($request->hasParameter('token')) {
      if (preg_match('/^convidado\d+$/', $this->user->getUsername())) {
        $this->user->setUsername('');
        $this->user->getProfile()->setName('');
      }
      $this->recover = true;
    }

    $this->form = new sfGuardUserForm($this->user);

    $this->id = $request->getParameter('id');

    if ($this->user->getIsSuperAdmin() || $this->user->getId() == $this->getUser()->getId())
    {
      $this->groups = $this->user->getGroups();
    }
    else
    {
      $c = new Criteria();
      $c->addAscendingOrderByColumn(sfGuardGroupPeer::ID);
      $this->groups = sfGuardGroupPeer::doSelect($c);
      $this->his_groups = $this->user->hasGroup('admin') ? $this->groups : $this->user->getGroupNames();

      $c = new Criteria();
      $c->addAscendingOrderByColumn(sfGuardPermissionPeer::ID);
      $this->permissions = sfGuardPermissionPeer::doSelect($c);
      $this->his_permissions = $this->user->getAllPermissions();
    }
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($this->user = sfGuardUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfGuardUserForm($this->user);

    $this->id = $request->getParameter('id');

    $this->processForm($request, $this->form);

    if ($this->user->getIsSuperAdmin() || $this->user->getId() == $this->getUser()->getId())
    {
      $this->groups = $this->user->getGroups();
    }
    else
    {
      $c = new Criteria();
      $c->addAscendingOrderByColumn(sfGuardGroupPeer::ID);
      $this->groups = sfGuardGroupPeer::doSelect($c);
      $this->his_groups = $this->user->hasGroup('admin') ? $this->groups : $this->user->getGroupNames();

      $c = new Criteria();
      $c->addAscendingOrderByColumn(sfGuardPermissionPeer::ID);
      $this->permissions = sfGuardPermissionPeer::doSelect($c);
      $this->his_permissions = $this->user->getAllPermissions();
    }

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_user = sfGuardUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $sf_guard_user->delete();

    $this->redirect('users/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	$user = $request->getParameter($form->getName());
  	/*$birthdate = explode('/',$user['birthdate']);
  	if (!empty($birthdate[0]))
  	{
  		$date = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
  		$user['birthdate'] = $date;
  	}*/
    $form->bind($user, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      try
      {
        $sf_guard_user = $form->save();

        $this->getUser()->setFlash('update', 'success');
      }
      catch (Exception $e)
      {
   		  echo $e->getMessage();
          $this->getUser()->setFlash('update', $e->getMessage());
      }

      $this->redirect('users/edit?id='.$sf_guard_user->getId());
    }
  }

  public function executeGroups(sfWebRequest $request)
  {
    $page = $request->getParameter('page', false);
	$this->name = $this->getRequestParameter('name', false);

    $c = new Criteria();
    $this->order = $request->getParameter('order', sfGuardGroupPeer::NAME);
    $this->dir = $request->getParameter('dir', 'asc');
    if ($this->dir == 'asc')
    {
      $c->addAscendingOrderByColumn($this->order);
    }
    else
    {
      $c->addDescendingOrderByColumn($this->order);
    }

    if (!empty($this->name))
    {
    	$c->add(sfGuardGroupPeer::NAME, '%'.$this->name.'%', Criteria::LIKE);
    }

    $this->groups = new sfPropelPager('sfGuardGroup', $request->getParameter('sf_pager', 10));
    $this->groups->setPeerMethod('doSelectList');
    $this->groups->setCriteria($c);
    $this->groups->setPage($page);
    $this->groups->init();

    $c = new Criteria();
    $grupos = sfGuardGroupPeer::doSelect($c);

    $this->grupos = array();
    foreach ($grupos as $grupo)
    {
    	$this->grupos[] = $grupo->getName();
    }

    $this->count_groups = count($this->grupos);

    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setContentType('text/xml');
      $this->setLayout('taconite');
      $this->setTemplate('ajaxGroupList');
    }
  }

  public function executeNewGroup(sfWebRequest $request)
  {
    $this->form = new sfGuardGroupForm();
  }

  public function executeCreateGroup(sfWebRequest $request)
  {
    $this->form = new sfGuardGroupForm();
    $this->processGroupForm($request, $this->form);
    $this->setTemplate('newGroup');
  }

  public function executeEditGroup(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	$group = sfGuardGroupPeer::retrieveByPk($id);
    $this->form = new sfGuardGroupForm($group);
  }

  protected function processGroupForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      try
      {
      	$c = new Criteria();
    	$c->add(sfGuardUserGroupPeer::GROUP_ID, $request->getParameter('id'));
    	$group_users = sfGuardUserGroupPeer::doSelect($c);

        $sf_guard_group = $form->save();

        if (!empty($group_users))
        {
	        foreach ($group_users as $group_user)
	        {
	        	$user_group = new sfGuardUserGroup();
	        	$user_group->setGroupId($group_user->getGroupId());
	        	$user_group->setUserId($group_user->getUserId());
	        	$user_group->save();
	        }
        }

        $this->getUser()->setFlash('update', 'success');
      }
      catch (Exception $e)
      {
   		  echo $e->getMessage(); die;
          $this->getUser()->setFlash('update', $e->getMessage());
      }
      $this->redirect('@edit_group?id='.$sf_guard_group->getId());
    }
  }

  public function executeUpdateGroup(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
  	$group = sfGuardGroupPeer::retrieveByPk($id);
    $this->form = new sfGuardGroupForm($group);
    $this->processGroupForm($request, $this->form);
    $this->setTemplate('editGroup');
  }

  public function executeDeleteGroup(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	$group = sfGuardGroupPeer::retrieveByPk($id);

    $c = new Criteria();
    $c->add(sfGuardUserGroupPeer::GROUP_ID, $id);
    $group_users = sfGuardUserGroupPeer::doSelect($c);

    if (!empty($group_users))
    {
    	foreach ($group_users as $group_user)
    	{
    		$user = sfGuardUserPeer::retrieveByPk($group_user->getUserId());
    		$user->delete();
    	}
    }

    $group->delete();
    $this->redirect('users/groups');
  }

  public function executeViewGroup(sfWebRequest $request)
  {
    $this->form = new sfGuardGroupForm();
  }
}
