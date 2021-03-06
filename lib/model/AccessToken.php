<?php


/**
 * Skeleton subclass for representing a row from the 'access_tokens' table.
 *
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Tue Jun  4 23:20:24 2013
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class AccessToken extends BaseAccessToken {

  public static function newTokenForUser($user_id) {
    // invalida tokens ativos para usuário
    $db = Propel::getConnection();
    try {
      $db->beginTransaction();
      $db->exec("UPDATE " . AccessTokenPeer::TABLE_NAME . " SET " . substr(AccessTokenPeer::EXPIRE_AT, strpos(AccessTokenPeer::EXPIRE_AT, '.') + 1) . " = now() - interval '1 day' WHERE "
          . AccessTokenPeer::USER_ID . " = " . $user_id . " AND " . AccessTokenPeer::EXPIRE_AT . " <= CURRENT_TIMESTAMP");

      $at = new AccessToken();
      $at->setUserId($user_id);
      $at->setId(uniqid());
      $at->setExpireAt(new DateTime('NOW + 30 day'));

      $at->save($db);
      $db->commit();

      return $at;
    }
    catch (Exception $e) {
      if ($db->inTransaction()) $db->rollBack();
      return null;
    }
  }

} // AccessToken
