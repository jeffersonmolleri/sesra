<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserPeer.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardUserPeer extends PluginsfGuardUserPeer
{
  const NAME = 'sf_guard_user_profile.NAME';

  public static function doSelectList(Criteria $c)
  {
    $c = clone $c;
    $c->clearSelectColumns()
      ->addSelectColumn(self::ID)
      ->addSelectColumn(self::USERNAME)
      ->addSelectColumn(sfGuardUserGroupPeer::GROUP_ID)
      ->addSelectColumn(sfGuardUserProfilePeer::NAME)
      ->addSelectColumn(self::LAST_LOGIN)
      ->addSelectColumn(self::IS_ACTIVE)
      ->addSelectColumn(self::IS_SUPER_ADMIN);

    $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID, Criteria::LEFT_JOIN);
    $c->addJoin(sfGuardUserPeer::ID, sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);

    return self::doSelectStmt($c);
  }

  public static function getAdmin()
  {
    $c = new Criteria();
    $c->add(sfGuardUserPeer::IS_SUPER_ADMIN, true);
    $c->add(sfGuardUserPeer::IS_ACTIVE, true);

    return parent::doSelectOne($c);
  }
}
