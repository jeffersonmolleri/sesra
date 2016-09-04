<?php


/**
 * Skeleton subclass for representing a row from the 'search_bases' table.
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
class SearchBase extends BaseSearchBase {

  public function __toString(){
    echo $this->getName();
  }
  
  public function doSelectForChoice()
  {
    return $this->getName();
  }
  
	public function hasChecked($protocol_id, $rsl_id)
	{
				
		$c = new Criteria();
		$c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $rsl_id);
		$c->add(SystematicReviewSearchBasePeer::SEARCH_BASE_ID, $this->getId());
		$c->add(SystematicReviewSearchBasePeer::PROTOCOL_ID, $protocol_id);
		$rsl_base_search = SystematicReviewSearchBasePeer::doSelectOne($c);
		
		if($rsl_base_search)
		{
			return true;
		}
		else
		{
			return false;
		}
		
		
	}
	
	
} // SearchBase