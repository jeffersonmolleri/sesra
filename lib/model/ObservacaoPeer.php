<?php


/**
 * Skeleton subclass for performing query and update operations on the 'observacoes' table.
 *
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sun Apr 21 15:51:09 2013
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ObservacaoPeer extends BaseObservacaoPeer {

  public static function doList(Criteria $criteria) {
    $c = clone $criteria;

    $c->addAlias("creators", sfGuardUserProfilePeer::TABLE_NAME);
    $c->addAlias("updaters", sfGuardUserProfilePeer::TABLE_NAME);

    $c->clearSelectColumns()
      ->addSelectColumn(ObservacaoPeer::OWNER_COLUMN)
      ->addSelectColumn(ObservacaoPeer::ID)
      ->addSelectColumn(ObservacaoPeer::OBSERVACAO)
      ->addAsColumn("creator", sfGuardUserProfilePeer::alias("creators", sfGuardUserProfilePeer::NAME))
      ->addSelectColumn(ObservacaoPeer::SITUACAO)
      ->addSelectColumn(ObservacaoPeer::UPDATED_AT)
      ->addAsColumn("updater", sfGuardUserProfilePeer::alias("updaters", sfGuardUserProfilePeer::NAME))
      ->addJoin(ObservacaoPeer::CREATED_BY, sfGuardUserProfilePeer::alias("creators", sfGuardUserProfilePeer::USER_ID), Criteria::INNER_JOIN)
      ->addJoin(ObservacaoPeer::UPDATED_BY, sfGuardUserProfilePeer::alias("updaters", sfGuardUserProfilePeer::USER_ID), Criteria::INNER_JOIN);

    $c->addAscendingOrderByColumn(ObservacaoPeer::OWNER_COLUMN);

    return self::doSelectStmt($c);
  }
} // ObservacaoPeer
