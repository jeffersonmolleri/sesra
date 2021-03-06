<?php


/**
 * Skeleton subclass for performing query and update operations on the 'search_bases' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Feb 22 19:41:46 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class SearchBasePeer extends BaseSearchBasePeer {
	
	static public function getOwnSearchBases($protocol_id)
	{
		$criteria = new Criteria();
		$criteria->addAscendingOrderByColumn(SearchBasePeer::NAME);
		$criteria->add(SearchBasePeer::IS_DEFAULT, false);
		$criteria->addJoin(self::ID, SystematicReviewSearchBasePeer::SEARCH_BASE_ID);
		$criteria->add(SystematicReviewSearchBasePeer::PROTOCOL_ID, $protocol_id);
		$criteria->setDistinct();
	
		return self::doSelect($criteria);
	}	

} // SearchBasePeer
