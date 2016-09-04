<?php


/**
 * Skeleton subclass for performing query and update operations on the 'systematic_reviews' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Dec 17 13:42:31 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class SystematicRevisionPeer extends BaseSystematicRevisionPeer {
  public static function doSelectList(Criteria $c)
  {
    $c = clone $c;
    $c->clearSelectColumns()
      ->addSelectColumn(self::ID)
      ->addSelectColumn(self::TITLE)
      ->addSelectColumn(self::QUESTION)
      ->addSelectColumn(self::RESTRICT)
      ->addSelectColumn(self::CREATED_AT)
      ->addSelectColumn(self::CREATED_BY)
      ->addSelectColumn(sfGuardUserProfilePeer::NAME)
      ->addSelectColumn(SystematicRevisionUserPeer::LEVEL);
      
    $c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::INNER_JOIN);
	$c->addJoin(self::CREATED_BY,SystematicRevisionUserPeer::USER_ID, Criteria::INNER_JOIN);
    
    return self::doSelectRS($c);
  }
  
  public static function doSelectRS(Criteria $criteria, $con = null)
  {

    foreach (sfMixer::getCallables('BaseSystematicRevisionPeer:doSelectRS:doSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSystematicRevisionPeer', $criteria, $con);
    }



    foreach (sfMixer::getCallables('BaseSystematicRevisionPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSystematicRevisionPeer', $criteria, $con);
    }


    if ($con === null) {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }

    if (!$criteria->getSelectColumns()) {
      $criteria = clone $criteria;
      SystematicRevisionPeer::addSelectColumns($criteria);
    }

        $criteria->setDbName(self::DATABASE_NAME);

            return BasePeer::doSelect($criteria, $con);
  }
} // SystematicRevisionPeer
