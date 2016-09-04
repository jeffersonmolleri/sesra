<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeSignin(sfWebRequest $request)
  {
    $this->setLayout('signin');
    parent::executeSignin($request);
  }

  public function executeSigninSite(sfWebRequest $request)
  {
    $this->setLayout('signin');
    parent::executeSigninSite($request);
  }

  public function executeJoin(sfWebRequest $request)
  {
  	$this->setLayout('join');
    if ($request->hasParameter('id')) {
      $id = $request->getParameter('id');
      if (!empty($id) && is_numeric($id)) {
        $user = sfGuardUserPeer::retrieveByPK($id);
        if (empty($user)) {
          parent::executeJoin($request);
        }
        else {
          if ($user->getLastLogin() == null) {
            $user->setUsername(''); // clean username
            $user->getProfile()->setName('');
            $user->getProfile()->setBirthdate(null);
          }
          $user->setIsActive(true);
          $this->form = new sfGuardUserForm($user);
        }
      }
    }
    else {
      parent::executeJoin($request);
    }
  }

  public function executeCreateUser(sfWebRequest $request)
  {
  	$this->setLayout('join');
  	$this->setTemplate('join');
//   	$params = $request->getParameter('sf_guard_user');
//   	if(!empty($params)) {
//   		if(array_key_exists('birthdate', $params)) {
//   			$params['birthdate'] = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/', '$3-$2-$1', $params['birthdate']);
//   			$request->setParameter('sf_guard_user', $params);
//   		}
//   	}
  	parent::executeCreateUser($request);
  }

  public function executeConfirm(sfWebRequest $request)
  {
  	$this->setLayout('join');
  	$this->setTemplate('join');
  	parent::executeCreateUser($request);
  }

  public function executeNegate(sfWebRequest $request)
  {
  	/* TODO: remover da revisão */
  }

  public function executeRetrieveNewToken(sfWebRequest $request)
  {
    $this->email = $request->getParameter('email');
    $c = new Criteria();
    $c->add(sfGuardUserProfilePeer::EMAIL, $request->getParameter('email'));

    try {
      $user = sfGuardUserProfilePeer::doSelectOne($c);

      $at = AccessToken::newTokenForUser($user->getUserId());

      $mailer = $this->getMailer();
      $msg = Swift_Message::newInstance();
      $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
      $msg->setTo($this->email);
      $msg->setSubject(sfConfig::get('app_invitations_tokenSubject'));
      $msg->setBody($this->getPartial('mail/sendNewToken', array ('user_id' => $at->getUserId(), 'token' => $at->getId())));
      $msg->setContentType('text/html');
      $mailer->send($msg);

      if ($request->isXmlHttpRequest()) {
        $this->getResponse()->setContentType('application/xml');
        $this->getResponse()->setContent('<?xml version="1.0" encoding="UTF-8"?><taconite><html select="#passrec-response">Uma nova chave de acesso foi enviada para o endereço <b>' . $this->email . '</b></html><hide select="#passrec-send,div.modal-body h4"/><show select="#passrec-close"/></taconite>');
        return sfView::NONE;
      }
    }
    catch (PropelException $e) {
      $this->forward404();
    }
  }
}
