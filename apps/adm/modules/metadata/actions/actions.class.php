<?php

/**
 * metadata actions.
 *
 * @package    mestrado
 * @subpackage metadata
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class metadataActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->name = $this->getRequestParameter('name', false);

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', MetadataPeer::NAME);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }
    
    if (!empty($this->name))
    {
    	$c->add(MetadataPeer::NAME, '%'.$this->name.'%', Criteria::LIKE);
    }
    $c->add(SystematicRevisionPeer::DELETED_AT, null);
    $c->add(SystematicRevisionUserPeer::USER_ID, $this->getUser()->getId());
    $c->setDistinct(SystematicRevisionPeer::ID);
    
    $this->metadata = new sfPropelPager('Metadata', $request->getParameter('sf_pager', 10));
    $this->metadata->setCriteria($c);
    $this->metadata->setPeerMethod('doSelectList');
    $this->metadata->setPage($page);
    $this->metadata->init();
    
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MetadataForm();
  }
  
  public function executeCreate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isMethod('post'));
    $this->form = new MetadataForm();
   	$this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($metadata = MetadataPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicRevision does not exist (%s).', $request->getParameter('id')));
    $this->form = new MetadataForm($systematic_review);
    $this->id = $metadata->getId();
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($metadata = MetadataPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicRevision does not exist (%s).', $request->getParameter('id')));
    $this->form = new MetadataForm($metadata);
    $this->id = $metadata->getId();
  	$this->processForm($request, $this->form);    
    $this->setTemplate('edit');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $is_new = false;
    
    if ($form->isValid())
    {
      try
      {
      	if ($form->getObject()->isNew())
        {
        	$is_new = true;
        }
        
        $systematic_review = $form->save();
        
        if ($is_new == true)
        {
	      $systematic_review_user = new SystematicRevisionUser();
	      $systematic_review_user->setUserId($systematic_review->getCreatedBy());
	      $systematic_review_user->setSystematicRevisionId($systematic_review->getId());
	      $systematic_review_user->setLevel(SystematicRevision::COORDENADOR);
	      $systematic_review_user->save();
        }
        
        $this->getUser()->setFlash('update', 'success');
      }
      catch (Exception $e)
      {
        $this->getUser()->setFlash('error', $e->getMessage());
      }
      
      $this->redirect('systematic_review/edit?id='.$systematic_review->getId());
    }
  }
  
  public function executeDelete(sfWebRequest $request)
  { 
    $this->forward404Unless($systematic_review = SystematicRevisionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicRevision does not exist (%s).', $request->getParameter('id')));
    
    $c = new Criteria();
    $c->add(SystematicRevisionUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $users = SystematicRevisionUserPeer::doSelect($c);
    
    if (!empty($users))
    {
    	foreach ($users as $user)
    	{
    		$user->delete();
    	}
    }
    
    $systematic_review->delete();
    
    $this->redirect('systematic_review/index');
  }
  
  public function executeView(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicRevisionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicRevision does not exist (%s).', $request->getParameter('id')));
  	
  	$c = new Criteria();
    $c->add(SystematicRevisionUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $this->systematic_users = SystematicRevisionUserPeer::doSelect($c);
  }  
}
