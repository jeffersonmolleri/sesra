<?php

/**
 * systematic_review actions.
 *
 * @package    mestrado
 * @subpackage systematic_review
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systematic_reviewActions extends sfActions
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
    $this->filter = $request->getParameter('filter', null);

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', SystematicReviewPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }
    switch($this->filter)
    {
    	case 'waiting':
    		$c->addJoin(SystematicReviewPeer::ID, ProtocolPeer::RSL_ID, Criteria::INNER_JOIN);
    		$c->add(SystematicReviewPeer::ID, 'NOT EXISTS(SELECT ' . JobPeer::ID .
    				' FROM ' . JobPeer::TABLE_NAME .
    				' WHERE ' . JobPeer::PROTOCOL_ID . ' = ' . ProtocolPeer::ID .
    				' AND ' . JobPeer::ACTIVITY_ID . ' = 18)', Criteria::CUSTOM);
    		break;
    	case 'concluded':
    		$c->addJoin(SystematicReviewPeer::ID, ProtocolPeer::RSL_ID, Criteria::INNER_JOIN);
    		$c->add(SystematicReviewPeer::ID, 'EXISTS(SELECT ' . JobPeer::ID .
    				' FROM ' . JobPeer::TABLE_NAME .
    				' WHERE ' . JobPeer::PROTOCOL_ID . ' = ' . ProtocolPeer::ID .
    				' AND ' . JobPeer::ACTIVITY_ID . ' = 18)', Criteria::CUSTOM);
    		break;

    }
    if (!empty($this->name))
    {
    	$c->add(SystematicReviewPeer::TITLE, '%'.$this->name.'%', Criteria::LIKE);

    	$this->googleScholar = "";

    	$page = str_replace(' ', '+', $this->name);
    	$page = str_replace('&', '%26', $page);

    	$ch = curl_init('http://scholar.google.com/scholar?q=' . $page);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    	$content = curl_exec($ch);
    	curl_close($ch);

    	$content = explode(" results (", $content);
    	$this->googleScholar = substr($content[0],strrpos($content[0], ' '));
    }

    $c->add(SystematicReviewPeer::DELETED_AT, null);
    if(!$this->getUser()->isSuperAdmin())
    	$c->add(SystematicReviewUserPeer::USER_ID, $this->getUser()->getId());

    $c->setDistinct(SystematicReviewPeer::ID);

    $this->reviews = new sfPropelPager('SystematicReview', $request->getParameter('sf_pager', 10));
    $this->reviews->setCriteria($c);
    $this->reviews->setPeerCountMethod('doCountList');
    $this->reviews->setPeerMethod('doSelectList');
    $this->reviews->setPage($page);
    $this->reviews->init();

    $this->levels = sfConfig::get('app_levels_names');

    $this->revisoes = array();
    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::USER_ID, $this->getUser()->getId());
    $reviews_users = SystematicReviewUserPeer::doSelect($c);

    if (!empty($reviews_users))
    {
    	foreach ($reviews_users as $review_user)
    	{
    		$review = SystematicReviewPeer::retrieveByPk($review_user->getSystematicReviewId());
    		if (!empty($review))
    		{
    			$this->revisoes[] = $review->getTitle();
    		}
    	}
    }

    $this->count_reviews = count($this->revisoes);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SystematicReviewForm();
//     $this->protocolForm = new ProtocolForm();
    $this->protocolForm = $this->form['protocol'];
    $this->request = 'new';
  }

  public function executeCreate(sfWebRequest $request)
  {
    //var_dump($request);die;
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new SystematicReviewForm();
    $this->protocolForm = $this->form['protocol'];
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
    $this->old_search_string = '';
  }

  public function executeQuestion(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->form = new SystematicReviewForm($systematic_review);
    $c = new Criteria();
    $c->add(ProtocolPeer::RSL_ID, $systematic_review->getId());
    $protocol = ProtocolPeer::doSelectOne($c);
   	$this->protocolForm = $this->form['protocol'];
    $this->id = $systematic_review->getId();

    $this->review = $systematic_review;
    $this->old_search_string = $protocol->getSearchString();
    //$this->setTemplate('questionAdd');
  }

  public function executeEdit(sfWebRequest $request)
  {
  	$c = new Criteria();
  	$c->add(ProtocolPeer::RSL_ID, $request->getParameter('id'));
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
  	$urls = sfConfig::get('app_etapa_url');
  	foreach($urls as $id => $url)
  	{
  		if(!in_array($id, $arrayJobs))
  		{
  			$this->redirect($url . $request->getParameter('id'));
  		}
  	}
  	$this->redirect(array_pop($urls) . $request->getParameter('id'));

    /*$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->form = new SystematicReviewForm($systematic_review);
    $this->protocolForm = $this->form['protocol'];
    $this->id = $systematic_review->getId();

    $this->review = $systematic_review;
    $this->old_search_string = $this->form->getEmbeddedForm('protocol')->getObject()->getSearchString();*/
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));

    $this->form = new SystematicReviewForm($systematic_review);
    $this->protocolForm = $this->form['protocol'];

    $this->id = $systematic_review->getId();

    $this->processForm($request, $this->form);
    $this->setTemplate($request->getParameter('requester'));

    $this->review = $systematic_review;
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

        if ($is_new == true && $systematic_review instanceof SystematicReview)
        {
          $systematic_review_user = new SystematicReviewUser();
          $systematic_review_user->setUserId($systematic_review->getCreatedBy());
          $systematic_review_user->setSystematicReviewId($systematic_review->getId());
          $systematic_review_user->setLevel(SystematicReview::COORDENADOR);
          $systematic_review_user->save();
        }

        $this->getUser()->setFlash('update', 'success');
      }
      catch (Exception $e)
      {
        $this->getUser()->setFlash('error', $e->getMessage());
      }


      if($request->hasParameter('finaliza')) {
        $request->setParameter('activity', 5);
        $request->setParameter('id', $systematic_review->getId());
        $this->executeFinalizaTarefa($request);
        $this->redirect($request->getParameter('finaliza'));
      } else if ($request->getParameter('requester') == 'question') {
        $this->redirect('systematic_review/protocols?id=' . $systematic_review->getId());
      } else {
        $this->redirect('systematic_review/needs?id=' . $systematic_review->getId());
      }
    }

    $this->review = $form->getObject();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $users = SystematicReviewUserPeer::doSelect($c);

    if (!empty($users))
    {
    	foreach ($users as $user)
    	{
    		$user->delete();
    	}
    }

    $systematic_review->delete();

    $this->redirect('systematic_review/index');

    $this->review = $systematic_review;
  }

  public function executeView(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));

  	$c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $this->systematic_users = SystematicReviewUserPeer::doSelect($c);

    $this->review = $systematic_review;
  }

  //TEAM FUNCTIONS
  public function executeTeam(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();

  	$this->levels = sfConfig::get('app_levels_names');
  	unset($this->levels[0]);
  	$this->all_levels = sfConfig::get('app_levels_names');

  	$c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    //TODO: ordernar por nome de usuário
    $c->addAscendingOrderByColumn(sfGuardUserProfilePeer::NAME);
    $this->users = SystematicReviewUserPeer::doSelectJoinsfGuardUserPlusProfile($c);

    if ($this->getUser()->hasFlash('has_email')) {
      $this->has_email = true;
    }
    if ($this->getUser()->hasFlash('email')) {
    	$this->email = $this->getUser()->getFlash('email');
    }

    if ($this->getUser()->hasFlash('newuser')) {
    }

    $this->form = $this->getUser()->hasFlash('form') ? $this->getUser()->getFlash('form') : new sfGuardUserForm();

    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setContentType('text/xml');
      $this->setLayout('taconite');
      $this->setTemplate('ajaxTeam');
    }
    $this->review = $systematic_review;
  }

  public function executeUpdateTeam(sfWebRequest $request)
  {
    $email = trim($request->getParameter('email'));
    $this->getUser()->setFlash('email', $email);

    $c = new Criteria();
    $c->add(sfGuardUserProfilePeer::EMAIL, $email);
    $usuario = sfGuardUserProfilePeer::doSelectOne($c);

    $id = $request->getParameter('id');
    $level = $request->getParameter('level');

    $form = null;

    if (empty($usuario)) { // email não cadastrado, convidar
      $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=~!@#$%^&*()_+,./<>?;:[]{}\|';
      $password = substr(str_shuffle($chars), 0, 8);

      $user = array();
      $user['name'] = 'Convidado';
      $user['username'] = '##generated##';
      $user['email'] = $email;
      $user['password'] = $password;
      $user['password_again'] = $password;
      $user['is_active'] = true;
      $user['sf_guard_user_group_list'] = sfGuardUserProfile::USERS;

      $form = new sfGuardUserForm();
      $form->bind($user, $request->getFiles($form->getName()));
      if ($form->isValid())
      {
        try {
          $user = $form->save();

          $sys_user = new SystematicReviewUser();
          $sys_user->setSystematicReviewId($id);
          $sys_user->setUserId($user->getId());
          $sys_user->setLevel($level);
          $sys_user->save();

          $levels = sfConfig::get('app_levels_names');

          try {
              $at = AccessToken::newTokenForUser($user->getId());
	          $mailer = $this->getMailer();
	          $msg = Swift_Message::newInstance();
	          $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
	          $msg->setTo($email);
	          $msg->setSubject(sfConfig::get('app_invitations_subject'));
	          $msg->setBody($this->getPartial('mail/sendNewInvitation', array ('profile' => $user->getProfile(), 'inviter' => $this->getUser(), 'review' => SystematicReviewPeer::retrieveByPK($id), 'level' => $levels[$level], 'token' => $at->getId())));
	          $msg->setContentType('text/html');
	          $mailer->send($msg);
	          $this->getUser()->setFlash('update', 'success');
          }
          catch (Exception $e)
          {
          	$this->getUser()->setFlash('update', 'not_send_email');
          }
        }
        catch (Exception $e)
        {
        	$this->getUser()->setFlash('update', 'error');
          	$this->getUser()->setFlash('error', $e->getMessage());
        }
      }
    }
    else
    {
      $this->getUser()->setFlash('form', null);
      $form = null;

      if ($request->getParameter('do', 'add') == 'add') {
        $c = new Criteria();
        $c->add(SystematicReviewUserPeer::USER_ID, $usuario->getUserId());
        $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $id);
        $sys_rev_user = SystematicReviewUserPeer::doSelectOne($c);

        if (empty($sys_rev_user))
        {
          $sys_user = new SystematicReviewUser();
          $sys_user->setSystematicReviewId($id);
          $sys_user->setUserId($usuario->getUserId());
          $sys_user->setLevel($level);
          $sys_user->save();

          $levels = sfConfig::get('app_levels_names');
          try {
              $at = AccessToken::newTokenForUser($usuario->getUserId());
	          $mailer = $this->getMailer();
	          $msg = Swift_Message::newInstance();
	          $msg->setTo($usuario->getEmail());
	          $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
	          $msg->setSubject(sfConfig::get('app_invitations_subject'));
	          $msg->setBody($this->getPartial('mail/sendInvitation', array ('profile' => $usuario, 'inviter' => $this->getUser(), 'review' => SystematicReviewPeer::retrieveByPK($id), 'level' => $levels[$level], 'token' => $at->getId())));
	          $msg->setContentType('text/html');
	          $mailer->send($msg);
	          $this->getUser()->setFlash('update', 'success');
          }
          catch (Exception $e)
          {
          	$this->getUser()->setFlash('update', 'not_send_email');
          }

        }
        else
        {
          $this->getUser()->setFlash('has_email', true);
        }
      }
      else {
        try {
          $c = new Criteria();
          $c->add(SystematicReviewUserPeer::USER_ID, $usuario->getUserId());
          $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $id);
          SystematicReviewUserPeer::doDelete($c);
        }
        catch (Exception $e) {
          $this->getResponse()->setStatusCode(500);
          return sfView::HEADER_ONLY;
        }
      }
    }

    if ($request->getParameter('do', 'add') == 'add') {
      $this->getUser()->setFlash('form', $form);
      $this->forward('systematic_review', 'team');

      $this->review = $systematic_review;
    }
    else {
      $this->getResponse()->setStatusCode(200);
      return sfView::HEADER_ONLY;
    }
  }
//SEARCH BASE FUNCTIONS


  public function executeUpdateSearchBase(sfWebRequest $request)
  {
    $base = new SearchBase();

    $base->setName($this->getRequestParameter('name'));
    $base->setUrl($this->getRequestParameter('base_url'));
    // $base->setApi($this->getRequestParameter('api'));
    $base->setIsDefault(false);

    $con = Propel::getConnection(SearchBasePeer::DATABASE_NAME);
    try
    {
      $con->beginTransaction();
      $base->save($con);

      $new_base_search = new SystematicReviewSearchBase();

      $new_base_search->setSearchBaseId($base->getId());
      $new_base_search->setSystematicReviewId($this->getRequestParameter('rsl_id'));
      $new_base_search->setProtocolId($this->getRequestParameter('protocol_id'));

      $new_base_search->save($con);
      $this->getUser()->setFlash('update', 'success');
      $con->commit();
    }
    catch (Exception $e)
    {
      $con->rollBack();
      $this->getUser()->setFlash('error', $e->getMessage());
    }

    $this->rsl_id = $this->getRequestParameter('rsl_id');
    $this->protocol_id = $this->getRequestParameter('protocol_id');

    if($this->getRequestParameter('protocol_id'))
    {

      $c = new Criteria();
      $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $this->getRequestParameter('rsl_id'));
      $c->add(SystematicReviewSearchBasePeer::PROTOCOL_ID, $this->getRequestParameter('protocol_id'));
      $search_bases_protocol = SystematicReviewSearchBasePeer::doSelect($c);

      $this->search_bases_protocol = array();

      foreach($search_bases_protocol as $base)
      {
        $object_base = SearchBasePeer::retrieveByPK($base->getSearchBaseId());

        if($object_base->getIsDefault() == false)
        {
          $this->search_bases_protocol[$object_base->getId()] = $object_base;
        }
      }
    }
    else
    {
      $this->search_bases_protocol = null;
    }
    //var_dump(count($this->search_bases_protocol));die;
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxSearchBase');
  }

  public function executeDeleteSearchBase(sfWebRequest $request)
  {

  	$base_search = BaseSearchBasePeer::retrieveByPK($this->getRequestParameter('id'));
    $this->forward404If(empty($base_search));

	  $c = new Criteria();
	  $c->add(SystematicReviewSearchBasePeer::SEARCH_BASE_ID, $base_search->getId());
	  $base_search_protocol = SystematicReviewSearchBasePeer::doDelete($c);
    BaseSearchBasePeer::doDelete($base_search->getId());

	  $c = new Criteria();
	  $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $this->getRequestParameter('rsl_id'));
	  $c->add(SystematicReviewSearchBasePeer::PROTOCOL_ID, $this->getRequestParameter('protocol_id'));
	  $search_bases_protocol = SystematicReviewSearchBasePeer::doSelect($c);

	  $this->search_bases_protocol = array();

	  $this->rsl_id = $this->getRequestParameter('rsl_id');
	  $this->protocol_id = $this->getRequestParameter('protocol_id');

	  foreach($search_bases_protocol as $base)
	  {
	  	$object_base = SearchBasePeer::retrieveByPK($base->getSearchBaseId());

	  	if($object_base->getIsDefault() == false)
	  	{
	  		$this->search_bases_protocol[$object_base->getId()] = $object_base;
	  	}
	  }

	  $this->getResponse()->setContentType('text/xml');
	  $this->setLayout('taconite');
	  $this->setTemplate('ajaxSearchBase');
  }



 //METADATA FUNCTIONS

  public function executeUpdateMetadata(sfWebRequest $request)
  {

  	$metadata = new Metadata();
  	$metadata->setSystematicReviewId($this->getRequestParameter('rsl_id'));
  	$metadata->setName($this->getRequestParameter('name'));
  	$metadata->setType($this->getRequestParameter('type'));
  	switch ($metadata->getType()) {
  	  case Metadata::CATEGORIAS :
        $metadata->setDescription($this->getRequestParameter('categories'));
        break;
      case Metadata::BIBTEX :
        $metadata->setDescription($this->getRequestParameter('bibtex'));
        break;
  	}

    try
	  {
	  	$metadata->save();
	  }
	  catch (Exception $e)
	  {
	  	$this->getUser()->setFlash('error', $e->getMessage());
		}

		$c = new Criteria();
		$c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->getRequestParameter('rsl_id'));
		$this->metadata_list = MetadataPeer::doSelect($c);

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxMetadata');
  }

  public function executeDeleteMetadata(sfWebRequest $request)
  {
		$c = new Criteria();
		$c->add(MetadataPeer::ID, $this->getRequestParameter('id'));
		$metadata = MetadataPeer::doDelete($c);

		$c = new Criteria();
		$c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->getRequestParameter('rsl_id'));
		$this->metadata_list = MetadataPeer::doSelect($c);

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxMetadata');

  }
  //PROTOCOL FUNCTIONS

  public function executeProtocols(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();

		$c = new Criteria();
		$c->add(ProtocolPeer::RSL_ID, $this->id);
		$protocol = ProtocolPeer::doSelectOne($c);

		if($protocol)
		{
			$c = new Criteria();
		 	$c->add(RslCriteriaPeer::PROTOCOL_ID,$protocol->getId());
		 	$c->add(RslCriteriaPeer::DELETED_AT,null);
		 	$this->criterias = RslCriteriaPeer::doSelect($c);
		}
		else
		{
			$this->criterias = null;
		}
		$this->old_search_string = '';

		if (empty($protocol)) {
	  		$this->form = new ProtocolForm();
		} else {
			$this->form = new ProtocolForm($protocol);
			$arr_strings = array($protocol->getPopulation(),$protocol->getIntervention(),$protocol->getComparative(),$protocol->getOutcome(),$protocol->getContext());
			foreach ($arr_strings as $arr_string) {
				if (!empty($arr_string)) {
					$this->old_search_string .= "'".$arr_string."' AND ";
				}
			}

			$this->old_search_string = substr($this->old_search_string,0,strlen($this->old_search_string)-4);
		}

		$c = new Criteria();
		$c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->id);
		$this->metadata_list = MetadataPeer::doSelect($c);

		//BUSCANDO OS BANCOS DE BUSCA PARA LISTAGEM EM CHECKBOX

		$c = new Criteria();
		$c->add(SearchBasePeer::IS_DEFAULT, true);
		$c->addAscendingOrderByColumn(SearchBasePeer::NAME);
		$this->search_bases = SearchBasePeer::doSelect($c);

		if($protocol) {
			$this->search_bases_protocol = SearchBasePeer::getOwnSearchBases($protocol->getId());
		}
		else {
			$this->search_bases_protocol = null;
		}

		//BUSCANDO FRAMEWORKS

		$c = new Criteria();
		$c->addAscendingOrderByColumn(FrameworkPeer::NAME_PT);
		$this->frameworks = FrameworkPeer::doSelect($c);

		//BUSCANDO LISTA DE USUÁRIOS RELACIONADOS AO SYSTEMATIC REVIEW
		//(select count(' . SystematicReviewUserPeer::ID . ') from ' . SystematicReviewUserPeer::TABLE_NAME . ' where ' . SystematicReviewUserPeer::USER_ID . '=' . sfGuardUserPeer::ID . ')

		$c = new Criteria();
		$c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $this->id);
		$this->systematic_users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);
		//select * from sf_guard_user where (select count(id) from systematic_reviews_users where user_id = sf_guard_user.id) != 0;

    $this->review = $systematic_review;
    $this->pid = $protocol->getId();
  }

  public function executeProtocolsView(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();
    $this->review = $systematic_review;
    $this->partial = $request->getParameter('partial', false);
    if ($this->partial) {
      $this->setLayout(false);
    }

	$c = new Criteria();
	$c->add(ProtocolPeer::RSL_ID, $this->id);
	$this->protocol = ProtocolPeer::doSelectOne($c);
	$this->pid = $this->protocol->getId();

    $c = new Criteria();
    $c->add(RslCriteriaPeer::PROTOCOL_ID,$this->protocol->getId());
    $c->add(RslCriteriaPeer::DELETED_AT,null);
    $this->criteria = RslCriteriaPeer::doSelect($c);

    $c = new Criteria();
	$c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->id);
	$this->metadata = MetadataPeer::doSelect($c);

	$c = new Criteria();
	$c->add(SearchBasePeer::IS_DEFAULT, true);
	$c->addAscendingOrderByColumn(SearchBasePeer::NAME);
	$this->search_bases = SearchBasePeer::doSelect($c);
    //adicionar filtro pela revisão

    /*$c = new Criteria();
  	$c->addAscendingOrderByColumn(ActivityPeer::ID);
  	$c->add(ActivityPeer::FRAMEWORK_ID, '1');
    $c->add(ActivityPeer::ACTIVITY_PARENT, null);*/
    $this->activities = ActivityPeer::doSelectWithChildrenForProtocol($this->pid);
    //adicionar filtro dos usuários
		
		//$this->protocol_id = $request->getParameter('protocol_id');
    //$this->activities = ActivityPeer::doSelectWithChildrenForProtocol($this->protocol_id);

    $c = new Criteria();
	$c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $this->id);
	$c->addAscendingOrderByColumn(SystematicReviewUserPeer::LEVEL);
	$systematic_users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);
    $this->systematic_users = array();

    foreach($systematic_users as $su) {
      $this->systematic_users[$su->getUserId()] = $su;
    }
		
		
    //adicionar nome do usuário
  }

  public function executeProtocolDownload(sfWebRequest $request)
  {

    $this->forward404Unless($request->hasParameter('id'));
    $request->setParameter('partial', 1);
    $content = $this->getController()->getPresentationFor('systematic_review', 'protocolsView');
    $content = preg_replace('/ data-target=\"\w+\"/', '', $content);
    $content = str_replace('<a href="#" role="button" class="btn btn-mini" data-context="addanotacao"><i class="icon-comment"></i> comentar</a>', '', $content);
    $content = str_replace('<i class="icon-check"></i> Salvar e concluir', '', $content);

    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/phpword/PHPWord.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/simplehtmldom/simple_html_dom.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/htmltodocx_converter/h2d_htmlconverter.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/example_files/styles.inc';

    $phpword = new PHPWord();
    $section = $phpword->createSection();

    $html_dom = new simple_html_dom();
    $html_dom->load('<html><body>' . $content . '</body></html>');

    $html_dom_array = $html_dom->find('html',0)->children();

    $initial_state = array(
        // Required parameters:
        'phpword_object' => &$phpword, // Must be passed by reference.
        'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
        'base_path' => '/htmltodocx/', // Path from base_root to whatever url your links are relative to.

        // Optional parameters - showing the defaults if you don't set anything:
        'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
        'parents' => array(0 => 'body'), // Our parent is body.
        'list_depth' => 0, // This is the current depth of any current list.
        'context' => 'section', // Possible values - section, footer or header.
        'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
        'pseudo_list_indicator_font_name' => 'Webdings', // Bullet indicator font.
        'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
        'pseudo_list_indicator_character' => '= ', // Gives a circle bullet point with wingdings.
        'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
        'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.

        // Optional - no default:
        'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
    );

    // Convert the HTML and put it into the PHPWord object
    htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

    // Clear the HTML dom object:
    $html_dom->clear();
    unset($html_dom);

    // Save File
    $h2d_file_uri = tempnam(sfConfig::get('sf_cache_dir'), 'proto');
    $objWriter = PHPWord_IOFactory::createWriter($phpword, 'Word2007');
    $objWriter->save($h2d_file_uri);

    // Download the file:
    $this->getResponse()->setHttpHeader('Content-Description', 'File Transfer');
    $this->getResponse()->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=protocolo-' . $request->getParameter('id') . '.docx');
    $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');
    $this->getResponse()->setHttpHeader('Expires', '0');
    $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
    $this->getResponse()->setHttpHeader('Pragma', 'public');
    $this->getResponse()->setHttpHeader('Content-Length', filesize($h2d_file_uri));

    ob_start();
    readfile($h2d_file_uri);
    $content = ob_get_clean();
    $this->getResponse()->setContent($content);
    unlink($h2d_file_uri);

    return sfView::NONE;
  }

  public function executeProtocolCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new ProtocolForm();

    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('rsl_id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('rsl_id')));
  	$this->id = $systematic_review->getId();

    $proto = $request->getParameter($this->form->getName());
  	$proto['rsl_id'] = $this->id;
  	$this->form->bind($proto, $request->getFiles($this->form->getName()));

   	$this->processProtocolForm($request, $this->form);

    $this->setTemplate('protocols');

    $this->review = $systematic_review;

    if($request->hasParameter('finaliza')) {
      $request->setParameter('activity', 6);
      $this->executeFinalizaTarefa($request);
      $this->redirect($request->getParameter('finaliza'));
    }
  }

  public function executeProtocolUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('rsl_id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('rsl_id')));
  	$this->id = $systematic_review->getId();

    $c = new Criteria();
    $c->add(ProtocolPeer::RSL_ID, $this->id);
    $protocol = ProtocolPeer::doSelectOne($c);
    $this->form = new ProtocolForm($protocol);

    $c = new Criteria();
    $c->add(RslCriteriaPeer::PROTOCOL_ID,$protocol->getId());
    $c->add(RslCriteriaPeer::DELETED_AT,null);
    $this->criterias = RslCriteriaPeer::doSelect($c);

    $proto = $request->getParameter($this->form->getName());
    $proto['rsl_id'] = $this->id;
    $this->form->bind($proto, $request->getFiles($this->form->getName()));

    $this->processProtocolForm($request, $this->form);
    $this->setTemplate('protocols');

    $this->review = $systematic_review;

  }

  protected function processProtocolForm(sfWebRequest $request, sfForm $form, $is_new_sr = false)
  {
  	//var_dump($this->getRequestParameter('framework_users'));die;
  	//var_dump($_POST);die;
  	//var_dump($form->isValid());die;
    if ($form->isValid()) {
      try {
        $protocol = $form->save();
        $this->getUser()->setFlash('update', 'success');

        $activity_date = $this->getRequestParameter('activity_date');
        $framework_users = $this->getRequestParameter('framework_users');
        if($activity_date) {
	        foreach($activity_date as $value => $date) {
	        	if($date && $framework_users[$value]) {
              if (!empty($date)) {
	        		  $date = explode('/',$date);
	        		  $date = $date[2].'-'.$date[1].'-'.$date[0];
	        		}

	        		$c = new Criteria();
	        		$c->add(JobPeer::ACTIVITY_ID, $value);
	        		$job = JobPeer::doSelectOne($c);

	        		if(!$job) {
		        		$job = new Job();
	        		}
		        	$job->setActivityId($value);
		        	$job->setUserId($framework_users[$value]);
		        	$job->setProtocolId($protocol->getId());
		        	$job->setDate($date);

              try {
		        		$job->save();
                //var_dump($job);die;
		        	}
							catch (Exception $e) {
		        		var_dump($e->getMessage());
		        		die;
		        		$this->getUser()->setFlash('error', $e->getMessage());
		        	}
	        	}
	        }
        }
        $c = new Criteria();
        $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $protocol->getRslId());
        $c->add(SystematicReviewSearchBasePeer::PROTOCOL_ID, $protocol->getId());
        $new_base_search = SystematicReviewSearchBasePeer::doSelect($c);

        foreach($new_base_search as $b) {
        	$b->delete();
        }
        if($this->getRequestParameter('base')) {
          $bases = $this->getRequestParameter('base');
          foreach($bases as $base) {
            $new_base_search = new SystematicReviewSearchBase();
            $new_base_search->setSearchBaseId($base);
            $new_base_search->setSystematicReviewId($protocol->getRslId());
            $new_base_search->setProtocolId($protocol->getId());

            try {
              $new_base_search->save();
              $this->getUser()->setFlash('update', 'success');
            }
            catch (Exception $e) {
              $this->getUser()->setFlash('error', $e->getMessage());
            }
          }
        }
      }
      catch (Exception $e) {
        $this->getUser()->setFlash('error', $e->getMessage());
      }

      if($request->hasParameter('finaliza')) {
        $request->setParameter('activity', 6);
        $request->setParameter('id', $protocol->getRslId());

        // email timetable

        $mailer = $this->getMailer();
        $msg = Swift_Message::newInstance();
        $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
        $msg->setTo($this->getUser()->getProfile()->getEmail());

        $c = new Criteria();
        $c->add(JobPeer::PROTOCOL_ID, $protocol->getId());
        $rs = JobPeer::doSelectUsersEmails($c);
        foreach ($rs as $r) {
          $msg->addTo($r[0]);
        }

        $msg->setSubject(sfConfig::get('app_invitations_timetableSubject'));
        $msg->setBody($this->getPartial('mail/sendTimetable', array (
            'review' => SystematicReviewPeer::retrieveByPK($protocol->getRslId()),
            'activities' => ActivityPeer::doSelectWithChildrenForProtocol($protocol, true)
        )));
        $msg->setContentType('text/html');
        $mailer->send($msg);

        $this->executeFinalizaTarefa($request);

        $this->redirect($request->getParameter('finaliza'));
      } else if(!$is_new_sr) {
        $this->redirect('systematic_review/protocols?id='.$protocol->getRslId());
      }
    }
  }

  public function executeFrameworkDetails(sfWebRequest $request)
  {
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(ActivityPeer::ID);

//   	$c->add(ActivityPeer::FRAMEWORK_ID, $request->getParameter('id'));
//     $c->add(ActivityPeer::ACTIVITY_PARENT, null);
//     $this->activities = ActivityPeer::doSelect($c);

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $request->getParameter('rsl_id'));
    $this->systematic_users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);

    $this->protocol_id = $request->getParameter('protocol_id');

    $this->activities = ActivityPeer::doSelectWithChildrenForProtocol($this->protocol_id);

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxFrameworkDetails');
  }

  public function executeNewCriteria(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('rsl_id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('rsl_id')));
  	$this->id = $systematic_review->getId();

  	$name = $request->getParameter('name');
  	$proto_id = $request->getParameter('protocol_id');
  	$type = $request->getParameter('type');

  	$criteria = new RslCriteria();
  	$criteria->setName($name);
  	$criteria->setProtocolId($proto_id);
  	$criteria->setRslId($this->id);
  	if ($type == 'true') {
  		$criteria->setType(true);
  	} else {
  		$criteria->setType(false);
  	}

  	try {
  		$criteria->save();
  	}
  	catch(Exception $e) {
  		$this->getUser()->setFlash('error', $e->getMessage());
  	}

  	$c = new Criteria();
  	$c->add(RslCriteriaPeer::PROTOCOL_ID,$proto_id);
  	$c->add(RslCriteriaPeer::DELETED_AT,null);
  	$this->criterias = RslCriteriaPeer::doSelect($c);

  	$this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxCriteria');

    $this->review = $systematic_review;
  }

  public function executeDeleteCriteria(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	$criteria = RslCriteriaPeer::retrieveByPk($id);
  	$proto_id = $criteria->getProtocolId();
  	$rsl_id = $criteria->getRslId();

  	try {
  		$criteria->delete();
  	}
  	catch(Exception $e) {
  		$this->getUser()->setFlash('error', $e->getMessage());
  	}

  	$c = new Criteria();
  	$c->add(RslCriteriaPeer::PROTOCOL_ID,$proto_id);
  	$c->add(RslCriteriaPeer::DELETED_AT,null);
  	$this->criterias = RslCriteriaPeer::doSelect($c);

  	$this->redirect('systematic_review/protocols?id='.$rsl_id);

    $this->review = $systematic_review;
  }

  //RESULTS FUNCTIONS

  public function executeResults(sfWebRequest $request)
  {
  	$this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();

    $c = new Criteria();
    $c->add(RslResultPeer::RSL_ID, $this->id);
    $result = RslResultPeer::doSelectOne($c);

    if (empty($result))
    {
      $this->form = new RslResultForm();
    }
    else
    {
      $this->form = new RslResultForm($result);
    }

    $this->review = $systematic_review;
  }

  public function executeResultCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new RslResultForm();

    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('rsl_id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('rsl_id')));
  	$this->id = $systematic_review->getId();

    $res = $request->getParameter($this->form->getName());
  	$res['rsl_id'] = $this->id;
  	$this->form->bind($res, $request->getFiles($this->form->getName()));

   	$this->processResultForm($request, $this->form);

    $this->setTemplate('results');

    $this->review = $systematic_review;
  }

  public function executeResultUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('rsl_id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('rsl_id')));
  	$this->id = $systematic_review->getId();

    $c = new Criteria();
		$c->add(RslResultPeer::RSL_ID, $this->id);
		$result = RslResultPeer::doSelectOne($c);
		$this->form = new RslResultForm($result);

		$res = $request->getParameter($this->form->getName());
  	$res['rsl_id'] = $this->id;
  	$this->form->bind($res, $request->getFiles($this->form->getName()));

  	$this->processResultForm($request, $this->form);
    $this->setTemplate('results');

    $this->review = $systematic_review;
  }

  protected function processResultForm(sfWebRequest $request, sfForm $form)
  {
    if ($form->isValid())
    {
      try
      {
        $result = $form->save();
        $this->getUser()->setFlash('update', 'success');
      }
      catch (Exception $e)
      {
        $this->getUser()->setFlash('error', $e->getMessage());
      }

      //var_dump($request);die;

      if($request->hasParameter('finaliza')) {
        $request->setParameter('activity', 17);
        $request->setParameter('id', $result->getRslId());
        $this->executeFinalizaTarefa($request);
        $this->redirect($request->getParameter('finaliza'));
      } else {
        $this->redirect('systematic_review/results?id='.$result->getRslId());
      }

    }

    $this->review = $systematic_review;
  }

  public function executeNeeds(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->order = SystematicReviewPeer::TITLE;
    $this->dir =  'asc';
  	$this->id = $systematic_review->getId();
  	$this->review = $systematic_review;
  	$this->reviews = new sfPropelPager('SystematicReview', $request->getParameter('sf_pager', 10));
  	$this->reviews->setPeerMethod('doSelectList');
  	$this->reviews->init();

  	$c = new Criteria();
  	$c->add(ProtocolPeer::RSL_ID, $this->id);
  	$protocol = ProtocolPeer::doSelectOne($c);
  	$this->string = $protocol->getSearchString();
  	$this->string = str_replace('"', '\'', $this->string);
  	//var_dump($this->string); die;
  }

  public function executeValidation(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->id = $systematic_review->getId();
    $this->review = $systematic_review;

    $c = new Criteria();
    $c->add(ProtocolPeer::RSL_ID, $systematic_review->getId());
    $c->clearSelectColumns()->addSelectColumn(ProtocolPeer::ID);
    $protocolId = ProtocolPeer::doSelectStmt($c)->fetchColumn(0);

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $c->add(SystematicReviewUserPeer::LEVEL, 2);
    $this->users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);

    $this->invitationButton = false;
    foreach ($this->users as $user) {
      if($user->getValidationInvite() == null){
        $this->invitationButton = true;
      }
    }

    $c = new Criteria();
    $c->add(ObservacaoPeer::OWNER_MODEL, 'protocol');
    $c->add(ObservacaoPeer::OWNER_ID, $protocolId);
    $c->addAscendingOrderByColumn(ObservacaoPeer::OWNER_COLUMN);
    $this->observations = ObservacaoPeer::doList($c);
    //var_dump($this->id);
  }

  public function executeValidationInvite(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($message = $request->getParameter('message'));

  	$c = new Criteria();
  	$c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
  	$c->add(SystematicReviewUserPeer::LEVEL, 2);

  	if ($message == 'ResultsValidationInvite') {
  	  $c->add(SystematicReviewUserPeer::RESULTS_VALIDATION_INVITE, null, Criteria::ISNULL);
  	} else {
  	  $c->add(SystematicReviewUserPeer::VALIDATION_INVITE, null, Criteria::ISNULL);
  	}

  	$users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);

  	$mailer = $this->getMailer();
    foreach ($users as $user) {
	  	$msg = Swift_Message::newInstance();
	    $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
	    $msg->setTo($user->getsfGuardUser()->getProfile()->getEmail());
	    $msg->setSubject(sfConfig::get('app_invitations_validationSubject'));
	    $msg->setBody($this->getPartial('mail/send' . $message, array ('profile' => $user->getsfGuardUser()->getProfile(), 'inviter' => $this->getUser(), 'review' => $systematic_review)));
	    $msg->setContentType('text/html');
	    $mailer->send($msg);

        if ($message == 'ResultsValidationInvite') {
          $user->setResultsValidationInvite(time());
        } else {
          $user->setValidationInvite(time());
        }
	    $user->save();
    }

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $c->add(SystematicReviewUserPeer::LEVEL, 2);
    $this->users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
  }

  public function executeResultsValidation(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
    $this->id = $systematic_review->getId();
    $this->review = $systematic_review;

    $c = new Criteria();
    $c->add(RslResultPeer::RSL_ID, $systematic_review->getId());
    $c->clearSelectColumns()->addSelectColumn(RslResultPeer::ID);
    $resultsId = RslResultPeer::doSelectStmt($c)->fetchColumn(0);

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $systematic_review->getId());
    $c->add(SystematicReviewUserPeer::LEVEL, 2);
    $this->users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);

    $this->invitationButton = false;
    foreach ($this->users as $user) {
      if($user->getResultsValidationInvite() == null){
        $this->invitationButton = true;
      }
    }

    $c = new Criteria();
    $c->add(ObservacaoPeer::OWNER_MODEL, 'rsl_results');
    $c->add(ObservacaoPeer::OWNER_ID, $resultsId);
    $this->observations = ObservacaoPeer::doList($c);
    //var_dump($this->observations);die;
  }

  public function executeResultsView(sfWebRequest $request)
  {
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();
    $this->review = $systematic_review;
    $this->partial = $request->getParameter('partial', false);
    if ($this->partial) {
      $this->setLayout(false);
    }

	$c = new Criteria();
	$c->add(ProtocolPeer::RSL_ID, $this->id);
	$this->protocol = ProtocolPeer::doSelectOne($c);
	$this->pid = $this->protocol->getId();

	$c = new Criteria();
	$c->add(RslResultPeer::RSL_ID, $this->id);
	$this->result = RslResultPeer::doSelectOne($c, null);
	if($this->result) {
		$this->rid = $this->result->getId();
	}
	else {
	  try {
        $result = new RslResult();
        $result->setRslId($this->id);
        $result->save();

        $this->result = $result;
        $this->rid = $result->getId();
	  }
	  catch (PropelException $e) {
	    $this->forward404("Não foi possível definir um resultado para esta revisão.");
	  }
	}

    $c = new Criteria();
    $c->add(RslCriteriaPeer::PROTOCOL_ID,$this->protocol->getId());
    $c->add(RslCriteriaPeer::DELETED_AT,null);
    $this->criteria = RslCriteriaPeer::doSelect($c);

    $c = new Criteria();
	$c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->id);
	$this->metadata = MetadataPeer::doSelect($c);

	$c = new Criteria();
	$c->add(SearchBasePeer::IS_DEFAULT, true);
	$c->addAscendingOrderByColumn(SearchBasePeer::NAME);
	$this->search_bases = SearchBasePeer::doSelect($c);
    //adicionar filtro pela revisão

    $c = new Criteria();
  	$c->addAscendingOrderByColumn(ActivityPeer::ID);
  	$c->add(ActivityPeer::FRAMEWORK_ID, '1');
    $c->add(ActivityPeer::ACTIVITY_PARENT, null);
    $this->activities = ActivityPeer::doSelect($c);
    //adicionar filtro dos usuários

    $c = new Criteria();
	$c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $this->id);
	$c->addAscendingOrderByColumn(SystematicReviewUserPeer::LEVEL);
	$systematic_users = SystematicReviewUserPeer::doSelectJoinsfGuardUser($c);
    $this->systematic_users = array();

    foreach($systematic_users as $su) {
      $this->systematic_users[$su->getUserId()] = $su;
    }
    //adicionar nome do usuário


  }

  public function executeResultsDownload(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('id'));
    $request->setParameter('partial', 1);
    $content = $this->getController()->getPresentationFor('systematic_review', 'resultsView');
    $content = preg_replace('/ data-target=\"\w+\"/', '', $content);
    $content = str_replace('<a href="#" role="button" class="btn btn-mini" data-context="addanotacao"><i class="icon-comment"></i> comentar</a>', '', $content);
    $content = str_replace('<i class="icon-check"></i> Salvar e concluir', '', $content);

    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/phpword/PHPWord.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/simplehtmldom/simple_html_dom.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/htmltodocx_converter/h2d_htmlconverter.php';
    require_once sfConfig::get('sf_lib_dir') . '/vendor/htmltodocx/example_files/styles.inc';

    $phpword = new PHPWord();
    $section = $phpword->createSection();

    $html_dom = new simple_html_dom();
    $html_dom->load('<html><body>' . $content . '</body></html>');

    $html_dom_array = $html_dom->find('html',0)->children();

    $initial_state = array(
        // Required parameters:
        'phpword_object' => &$phpword, // Must be passed by reference.
        'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
        'base_path' => '/htmltodocx/', // Path from base_root to whatever url your links are relative to.

        // Optional parameters - showing the defaults if you don't set anything:
        'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
        'parents' => array(0 => 'body'), // Our parent is body.
        'list_depth' => 0, // This is the current depth of any current list.
        'context' => 'section', // Possible values - section, footer or header.
        'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
        'pseudo_list_indicator_font_name' => 'Webdings', // Bullet indicator font.
        'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
        'pseudo_list_indicator_character' => '= ', // Gives a circle bullet point with wingdings.
        'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
        'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.

        // Optional - no default:
        'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
    );

    // Convert the HTML and put it into the PHPWord object
    htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

    // Clear the HTML dom object:
    $html_dom->clear();
    unset($html_dom);

    // Save File
    $h2d_file_uri = tempnam(sfConfig::get('sf_cache_dir'), 'proto');
    $objWriter = PHPWord_IOFactory::createWriter($phpword, 'Word2007');
    $objWriter->save($h2d_file_uri);

    // Download the file:
    $this->getResponse()->setHttpHeader('Content-Description', 'File Transfer');
    $this->getResponse()->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=protocolo-' . $request->getParameter('id') . '.docx');
    $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');
    $this->getResponse()->setHttpHeader('Expires', '0');
    $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
    $this->getResponse()->setHttpHeader('Pragma', 'public');
    $this->getResponse()->setHttpHeader('Content-Length', filesize($h2d_file_uri));

    ob_start();
    readfile($h2d_file_uri);
    $content = ob_get_clean();
    $this->getResponse()->setContent($content);
    unlink($h2d_file_uri);

    return sfView::NONE;
  }

  public function executeDissemination(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('id'));
    $this->forward404Unless($systematic_review = SystematicReviewPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SystematicReview does not exist (%s).', $request->getParameter('id')));
  	$this->id = $systematic_review->getId();
    $this->review = $systematic_review;
    $protocols = $systematic_review->getProtocols();
    $this->protocol = $protocols[0];
  }

  public function executeSearchNeeds (sfWebRequest $request)
  {
    //if ($request->isXmlHttpRequest())
    {
			
      $c = new Criteria();
      $this->order = SystematicReviewPeer::ID;
      $this->dir =  'asc';
      if ($this->dir == 'asc') {
        $c->addAscendingOrderByColumn($this->order);
      } else {
        $c->addDescendingOrderByColumn($this->order);
      }
      $this->name = trim($request->getParameter("name"));

      if (empty($this->name)) {
        $this->noquery = true;
        $this->googleScholar = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Digite ao menos um termo no <strong>Foco da Pesquisa</strong> para que possam ser apresentados resultados.</div>';
      }
      else {

      $searchs = explode(',', $this->name);
      if (!empty($searchs)) {
        $cr = $c->getNewCriterion(SystematicReviewPeer::TITLE, '%' . trim(array_shift($searchs)) . '%', Criteria::ILIKE);
        foreach ($searchs as $n)
        {
          $cr->addOr($c->getNewCriterion(SystematicReviewPeer::TITLE, '%' . trim($n) . '%', Criteria::ILIKE));
        }
        $c->addAnd($cr);
      }

      $c->add(SystematicReviewPeer::DELETED_AT, null, Criteria::ISNULL);
      $c->add(SystematicReviewPeer::RESTRICT, false, Criteria::EQUAL);
      if(!$this->getUser()->isSuperAdmin())
        $c->add(SystematicReviewUserPeer::USER_ID, $this->getUser()->getId());
      $c->setDistinct(SystematicReviewPeer::ID);

      $this->reviews = new sfPropelPager('SystematicReview', $request->getParameter('sf_pager', 1000));
      $this->reviews->setCriteria($c);
      $this->reviews->setPeerMethod('doSelectList');
      $this->reviews->init();

      $this->levels = sfConfig::get('app_levels_names');

      $this->revisoes = array();
      $c = new Criteria();
      $c->add(SystematicReviewUserPeer::USER_ID, $this->getUser()->getId());
      $reviews_users = SystematicReviewUserPeer::doSelect($c);

  		if (!empty($reviews_users))
  		{
  			foreach ($reviews_users as $review_user)
  			{
  				$review = SystematicReviewPeer::retrieveByPk($review_user->getSystematicReviewId());
  				if (!empty($review))
  				{
  					$this->revisoes[] = $review->getTitle();
  				}
  			}
  		}

  		$this->revisoes;
  		$this->googleScholar = "";
  		$this->name = $this->getRequestParameter('name', false);
  		$this->tipo = $this->getRequestParameter('tipo', false);
  		if (!empty($this->name))
  		{
  			$page = str_replace(' ', '+', $this->name) . '+and+' . str_replace(' ', '+', $this->tipo);
        	$page = str_replace('&', '%26', $page);
  			$page = 'http://scholar.google.com/scholar?q=' . $page;
  			$ch = curl_init($page);
  			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  			$content = curl_exec($ch);
  			curl_close($ch);
			$content = explode('<div id="gs_ab_md">',$content);
  			$content = explode(" result", $content[1]);
  			$this->googleScholar = substr($content[0],strrpos($content[0], ' '));
  			$this->googleScholar = str_replace(",","",$this->googleScholar);
        	$this->googleScholar = '<div class="alert alert-info"><a href =' .$page. ' target="_blank"><i class="icon-book"></i> '._('A busca retornou '). '<strong>' . $this->googleScholar .'</strong> '.__('resultados no Google Acadêmico. Clique aqui para visualizar.').'</a></div>';
  		} else {
        $this->googleScholar = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>'.__('Digite ao menos um termo no <strong>Foco da Pesquisa</strong> para que possam ser apresentados resultados a partir do Google Acadêmico.').'</div>';
      }
      }
  		//$this->renderText($this->googleScholar);
  		//return sfView::NONE;
  	}
    $this->dir = 'asc';
    $this->order = SystematicReviewPeer::TITLE;
  	$this->getResponse()->setContentType('text/xml');
  	$this->setLayout('taconite');
  	$this->setTemplate('ajaxList');
  	//$this->review = $systematic_review;
  }

  public function executeFinalizaTarefa (sfWebRequest $request)
  {
  	//var_dump($_POST);die;
  	$this->id = $this->getRequestParameter('id', false);
  	//var_dump($this->id);die;
  	$this->activity = $this->getRequestParameter('activity', false);

  	$c = new Criteria();
  	$c->add(ProtocolPeer::RSL_ID, $this->id);
  	$protocol = ProtocolPeer::doSelectOne($c);

  	$c = new Criteria();
  	$c->add(JobPeer::ACTIVITY_ID, $this->activity);
  	$c->add(JobPeer::PROTOCOL_ID, $protocol->getId());
  	$job = JobPeer::doSelectOne($c);

  	if($job)
  	{
  		$job->setFinishedBy($this->getUser()->getId());
  		$job->setFinishedAt(time());
  		$job->save();
  		return $this->renderText("Estágio Concluído");
  	}
  	else
  	{
  		//$this->renderText($this->activity. ' - ' .$protocol->getId(). ' - ' .$this->getUser()->getId());
  		$job = new Job();
  		$job->setActivityId($this->activity);
  		$job->setProtocolId($protocol->getId());
  		$job->setUserId($this->getUser()->getId());
  		$job->setDate(time());
  		$job->setFinishedBy($this->getUser()->getId());
  		$job->setFinishedAt(time());
  		JobPeer::doInsert($job);
  		return $this->renderText("Estágio Concluído");
  	}
  }


  public function executeGetObservacao (sfWebRequest $request)
  {

  	if ($request->isXmlHttpRequest())
  	{
  		$this->protocolId = $this->getRequestParameter('protocol_id', false);

  		$this->target = $this->getRequestParameter('target', false);
  		$this->owner = $this->getRequestParameter('owner', false);

  		$c = new Criteria();
  		$c->add(ObservacaoPeer::OWNER_ID, $this->protocolId);
  		$c->add(ObservacaoPeer::OWNER_MODEL, $this->owner);
  		$c->add(ObservacaoPeer::OWNER_COLUMN, $this->target);
  		$res = new stdClass();
  		$observacao = ObservacaoPeer::doSelectOne($c);
		if($observacao)
		{
  			$res->observacao = $observacao->getObservacao();
  			$res->id = $observacao->getId();
		}
		else
		{
			$res->observacao = "";
		}
		$this->renderText(json_encode($res));

  	}

  	return sfView::NONE;
  	/*}*/
  }

  public function executeAddObservacao (sfWebRequest $request)
  {
  	if ($request->isXmlHttpRequest())
  	{
  		$observacao = new Observacao();
  		if($request->getParameter("observation_id"))
  		{

  			$c = new Criteria();
  			$c->add(ObservacaoPeer::ID, $request->getParameter("observation_id"));
  			$observacao = ObservacaoPeer::doSelectOne($c);
  		}
  		else
  		{
  			$observacao->setOwnerColumn($request->getParameter("owner_column"));
  			$observacao->setOwnerId($request->getParameter("owner_id"));
  			$observacao->setOwnerModel($request->getParameter("owner_model"));
  			$observacao->setCreatedBy($this->getUser()->getId());
  			$observacao->setCreatedAt(new DateTime());
  		}
  		$observacao->setObservacao($request->getParameter("observation"));
  		$observacao->setUpdatedBy($this->getUser()->getId());
  		$observacao->setUpdatedAt(new DateTime());
  		$observacao->save();
  	}
  	return sfView::NONE;
  }

  public function executeFinalizeObservation(sfWebRequest $request)
  {
    $id = $request->getParameter('id', 0);
    if (is_numeric($id) && $id > 0) {
      try {
        $obs = ObservacaoPeer::retrieveByPK($id);
        $obs->setSituacao(Observacao::STATUS_FINISHED);
        $obs->save();
        $this->getResponse()->setHttpHeader('Success', $obs->getId());
      }
      catch (Exception $e) {
        // do nothing
      }
    }

    return sfView::HEADER_ONLY;
  }

  public function executeProtocolsViewOk (sfWebRequest $request)
  {
	$this->id = $request->getParameter("id");
	$c = new Criteria();
	$c->add(SystematicReviewPeer::ID, $this->id);
	$sr = SystematicReviewPeer::doSelectOne($c);

	$c = new Criteria();

	$c->add(sfGuardUserProfilePeer::USER_ID, $sr->getCreatedBy());
	$user = sfGuardUserProfilePeer::doSelectOne($c);
	$this->coordenadorNome = $user->getName();
	$this->coordenadorEmail = $user->getEmail();
  }

  public function executeOnthologySuggestion(sfWebRequest $request)
  {
  	$this->getResponse()->setContentType('text/xml');
  	$this->setLayout('taconite');
  	
  	$this->display_in = $request->getParameter("display_in");
  	$this->target = $request->getParameter("target");
  	$orders = array();
  	$c = new Criteria();
  	foreach(explode(",", $request->getParameter("search")) as $s) {
  		$text = trim(str_replace("'", '', $s));
  		$orders[] = "similarity(name, '" . $text ."')";
  		$c->add($text, OnthologyPeer::NAME . Criteria::NOT_EQUAL . "'" . $text ."'",Criteria::CUSTOM);
  	}
  	$c->add(OnthologyPeer::NAME, 'mostof(' . implode(", ", $orders) . ') > 0.1',Criteria::CUSTOM);
  	$c->addDescendingOrderByColumn('mostof(' . implode(", ", $orders) . ')');
  	$c->setLimit(5);
  	$onthologies = OnthologyPeer::doSelect($c);

  	$this->onthologies = array();
  	foreach($onthologies as $ont){
  		$this->onthologies[$ont->getName()] = $ont->getName();
  		$root = $ont->getOnthologyRelatedByRoot();
  		if(!empty($root))
  			$this->onthologies[$ont->getName()] = $ont->getName();
  	}
  }

  public function executeImportontology(sfWebRequest $request)
  {
  	$owl = simplexml_load_file('/var/www/vhosts/mestradovexo/web/uploads/SWEBOKOntology.owl');

  	$leafs = array();
  	$tree = array();
  	foreach($owl->Declaration as $declaration)
  	{
  		$leaf = $declaration->Class[0]['IRI']->__toString();
  		$obj = new stdclass();
  		$obj->twig = $leaf;
  		$obj->leaf = array();
  		$leafs[$leaf] = $obj;
  		$tree[$leaf] = $obj;
  	}
  	foreach($owl->SubClassOf as $subclass)
  	{
  		$leaf = $subclass->Class[0]['IRI']->__toString();
  		$twig = $subclass->Class[1]['IRI']->__toString();
  		$leafs[$twig]->leaf[] = $leafs[$leaf];
  		if(isset($tree[$leaf])) unset($tree[$leaf]);
  	}
  	foreach($tree as $t)
  	{
  		echo "begin;\n";
  		$this->persisteOntology($t, false);
  		echo "commit;\n";
  	}
  	die;
  }

  public function persisteOntology($tree, $twig)
  {
  	$id = "nextval('onthologies_id_seq')";
  	$name = str_replace(array('_','#'),array(' ',''),$tree->twig);
  	$root = 'null';
  	$path = 'null';
  	if($twig) {
  		$root = "(SELECT id FROM onthologies WHERE name = '$twig')";
  		$path = "COALESCE((SELECT path FROM onthologies WHERE name = '$twig') || ':', '') || {$root}";
  	}
  	echo "INSERT INTO onthologies (id, name, root, path) VALUES ({$id}, '{$name}', {$root}, {$path});";
  	echo "\n";
  	foreach($tree->leaf as $t)
  	{
  		$this->persisteOntology($t, $name);
  	}
  }
}
