<?php

class TokenAccessFilter extends sfBasicSecurityFilter {
  public function execute($filterChain)
  {
    $request = $this->getContext()->getRequest();
    if ($request->hasParameter('token') && !$this->getContext()->getUser()->isAuthenticated()) {
      $token = $request->getParameter('token');
      if (strlen($token) == 13) {
        $c = new Criteria();
        $c->add(AccessTokenPeer::ID, $token);
        $c->add(AccessTokenPeer::EXPIRE_AT, date('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
        $c->add(sfGuardUserPeer::IS_ACTIVE, true);
        $c->setLimit(1);
        $token = AccessTokenPeer::doSelectJoinsfGuardUser($c);
        if (isset($token[0]) && $token[0] instanceof AccessToken) {
          $this->getContext()->getUser()->signIn($token[0]->getsfGuardUser());
        }
        else {
          $this->getContext()->getUser()->setFlash('invalid_token', true);
        }
      }
      else {
        $this->getContext()->getUser()->setFlash('invalid_token', true);
      }
    }

    parent::execute($filterChain);
  }
}
