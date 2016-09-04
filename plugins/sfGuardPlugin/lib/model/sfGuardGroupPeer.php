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
 * @version    SVN: $Id: sfGuardGroupPeer.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardGroupPeer extends PluginsfGuardGroupPeer
{
  public static function doSelectList(Criteria $c)
  {
    $c = clone $c;
    $c->clearSelectColumns()
      ->addSelectColumn(self::ID)
      ->addSelectColumn(self::NAME)
      ->addSelectColumn(self::DESCRIPTION);      
    return self::doSelectStmt($c);
  }
}
