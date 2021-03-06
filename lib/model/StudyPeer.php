<?php


/**
 * Skeleton subclass for performing query and update operations on the 'studies' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Oct 20 13:59:37 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class StudyPeer extends BaseStudyPeer 
{
	
  public static function doSelectList(Criteria $c)
  {
  	$c = clone $c;
  	$c->clearSelectColumns()
  	->addSelectColumn(self::ID)//0
  	->addSelectColumn(self::TITLE)//1
  	->addSelectColumn(self::URL)//2
  	->addSelectColumn(self::CREATED_AT)//3
  	->addSelectColumn(self::CREATED_BY)//4
  	->addSelectColumn(sfGuardUserProfilePeer::NAME)//5
  	->addSelectColumn(StudyUserCriteriaPeer::CRITERIA_ID);//6
  
  	$c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
  	
  	return self::doSelectRS($c);
  }
  
  public static function doSelectListSelection(Criteria $c)
  {
  	$c = clone $c;
  	$c->clearSelectColumns()
  	->addSelectColumn(self::ID)//0
  	->addSelectColumn(self::TITLE)//1
  	->addSelectColumn(self::URL)//2
  	->addSelectColumn(self::CREATED_AT)//3
  	->addSelectColumn(StudyPeer::CREATED_BY)//4
  	->addSelectColumn(sfGuardUserProfilePeer::NAME)//5
  	->addSelectColumn(StudyUserCriteriaPeer::CRITERIA_ID)//6
  	->addAsColumn('qualidade','(SELECT sum(answer::NUMERIC)' .
  			 ' FROM ' . AnswerPeer::TABLE_NAME .
  			 ' INNER JOIN ' . QuestionPeer::TABLE_NAME . ' ON ' . QuestionPeer::ID . ' = ' . AnswerPeer::QUESTION_ID .
  			 ' WHERE ' . StudyPeer::ID . ' = ' . AnswerPeer::STUDY_ID .
  			 ' AND UPPER(answer) = LOWER(answer)' .
  			 ' AND ' . QuestionPeer::DELETED_AT  . ' IS NULL' .
  			 ' AND ' . AnswerPeer::DELETED_AT  . ' IS NULL)')//7
  	//Se possuir voto de minerva 
  	//  considera voto de minerva
  	//Se não
  	//  <0 excluso, 0: divergente, >0 incluso, nullo: não avaliado
  	->addAsColumn('situacao',' CASE WHEN ' . StudyPeer::CASTING_VOTE . ' IS NOT NULL ' .
  			' THEN (SELECT CASE WHEN '.  RslCriteriaPeer::TYPE . ' THEN 1 ELSE -1 END '.
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . 
  			'   AND ' . StudyUserCriteriaPeer::USER_ID . ' = ' . StudyPeer::CASTING_VOTE . ')' .
  			' ELSE (SELECT ' . 
  			'     CASE WHEN COUNT(DISTINCT ' . StudyUserCriteriaPeer::CRITERIA_ID . ') > 1'.
  			'     THEN 0 '.
  			'     ELSE SUM(CASE WHEN ' . RslCriteriaPeer::TYPE . ' THEN 1 ELSE -1 END)'.
  			'     END ' .
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . ')' .
  			' END')//8
  	->addAsColumn('casting_vote_criteria', '(SELECT '.  RslCriteriaPeer::NAME . 
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . 
  			'   AND ' . StudyUserCriteriaPeer::USER_ID . ' = ' . StudyPeer::CASTING_VOTE . ')')//9
  	->addAsColumn('casting_vote', StudyPeer::CASTING_VOTE);//10
  	
  	return self::doSelectListSelectionCount($c, false);
  }
  
  public static function doSelectListSelectionCount(Criteria $c, $isCount = true)
  {
  	$c = clone $c;
  	$c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
  	$c->add(StudyPeer::DELETED_AT, null);
  	return $isCount ? self::doCount($c) : self::doSelectRS($c);
  }
  
  public static function doSelectListAssessment(Criteria $c)
  {
  	$c = clone $c;
  	$c->setDistinct(self::ID)
  	->clearSelectColumns()
  	->addSelectColumn(self::ID)//0
  	->addSelectColumn(self::TITLE)//1
  	->addSelectColumn(self::URL)//2
  	->addSelectColumn(self::CREATED_AT)//3
  	->addSelectColumn(self::CREATED_BY)//4
  	->addAsColumn('null1', 'NULL')//5
  	->addAsColumn('null2', 'NULL')//6
  	->addAsColumn('qualidade','(SELECT sum(answer::NUMERIC)' .
  			 ' FROM ' . AnswerPeer::TABLE_NAME .
  			 ' INNER JOIN ' . QuestionPeer::TABLE_NAME . ' ON ' . QuestionPeer::ID . ' = ' . AnswerPeer::QUESTION_ID .
  			 ' WHERE ' . self::ID . ' = ' . AnswerPeer::STUDY_ID .
  			 ' AND UPPER(answer) = LOWER(answer)' .
  			 ' AND ' . QuestionPeer::DELETED_AT  . ' IS NULL' .
  			 ' AND ' . AnswerPeer::DELETED_AT  . ' IS NULL)')//7
  	->addAsColumn('avaliado','EXISTS(SELECT ' . AnswerPeer::STUDY_ID . ' FROM ' .AnswerPeer::TABLE_NAME . ' WHERE ' . StudyPeer::ID . ' = ' . AnswerPeer::STUDY_ID . ')');//8

	return self::doSelectListAssessmentCount($c, false);
  }
  
  public static function doSelectListAssessmentCount(Criteria $c, $isCount = true)
  {
  	$c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
  	$c->addJoin(StudyPeer::ID, AnswerPeer::STUDY_ID, Criteria::LEFT_JOIN);

  	$c->add(StudyPeer::DELETED_AT, null);
  	
  	//TODO:Filtra os estudos inclusos sem divergencia 
	$c->add(StudyPeer::ID,' CASE WHEN ' . self::CASTING_VOTE . ' IS NOT NULL ' .
  		' THEN (SELECT '.  RslCriteriaPeer::TYPE . 
  		'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  		'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  		'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . 
  		'   AND ' . self::CASTING_VOTE . ' = ' . StudyUserCriteriaPeer::USER_ID . ')' .
  		' ELSE (SELECT ' . 
  		'     CASE WHEN COUNT(DISTINCT ' . StudyUserCriteriaPeer::CRITERIA_ID . ') > 1'.
  		'     THEN false'.
  		'     ELSE bool_and(' . RslCriteriaPeer::TYPE . ')'.
  		'     END ' .
  		'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  		'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  		'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . ')' .
  		' END', Criteria::CUSTOM);
  	
  	return $isCount ? self::doCount($c) : self::doSelectRS($c);
  }

  public static function doSelectListDataextraction(Criteria $c)
  {
  	$c = clone $c;
  	$c->clearSelectColumns()
  	->addSelectColumn(self::ID)//0
  	->addSelectColumn(self::TITLE)//1
  	->addSelectColumn(self::URL)//2
  	->addSelectColumn(self::CREATED_AT)//3
  	->addSelectColumn(self::CREATED_BY)//4
  	->addAsColumn('null1', 'NULL')//5
  	->addAsColumn('null2', 'NULL')//6
  	->addAsColumn('concluida', 'EXISTS(SELECT ' . DataExtractionPeer::STUDY_ID .' FROM ' . DataExtractionPeer::TABLE_NAME . ' WHERE ' . StudyPeer::ID . ' = ' . DataExtractionPeer::STUDY_ID .')')//7
  	->addAsColumn('total', 'EXISTS(SELECT ' . DataExtractionPeer::STUDY_ID .
  			' FROM ' . MetadataPeer::TABLE_NAME .
  			' LEFT JOIN ' . DataExtractionPeer::TABLE_NAME . ' ON ' . DataExtractionPeer::METADATA_ID . ' = ' . MetadataPeer::ID . ' AND ' . DataExtractionPeer::STUDY_ID . ' = ' . StudyPeer::ID.
  			' WHERE ' . MetadataPeer::SYSTEMATIC_REVIEW_ID . ' = ' . StudyPeer::SYSTEMATIC_REVIEW_ID .
  			' AND ' . DataExtractionPeer::METADATA_ID . ' IS NULL )');
  	
  	return self::doSelectListDataextractionCount($c, false);
  }
  
  public static function doSelectListDataextractionCount(Criteria $c, $isCount = true)
  {
  	$c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
  	
  	$c->add(StudyPeer::DELETED_AT, null);
  	
  	//TODO:Filtra os estudos inclusos sem divergencia
  	$c->add(StudyPeer::ID,' CASE WHEN ' . self::CASTING_VOTE . ' IS NOT NULL ' .
  			' THEN (SELECT '.  RslCriteriaPeer::TYPE .
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID .
  			'   AND ' . self::CASTING_VOTE . ' = ' . StudyUserCriteriaPeer::USER_ID . ')' .
  			' ELSE (SELECT ' .
  			'     CASE WHEN COUNT(DISTINCT ' . StudyUserCriteriaPeer::CRITERIA_ID . ') > 1'.
  			'     THEN false'.
  			'     ELSE bool_and(' . RslCriteriaPeer::TYPE . ')'.
  			'     END ' .
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . ')' .
  			' END', Criteria::CUSTOM);
  	return $isCount ? self::doCount($c) : self::doSelectRS($c);
  }    
  
  public static function doSelectListDataSynthesis(Criteria $c)
  {
  	$c = clone $c;
  	$c->clearSelectColumns()
  	->addSelectColumn(self::ID)//0
  	->addSelectColumn(self::TITLE)//1
  	->addSelectColumn(self::URL)//2
  	->addSelectColumn(self::CREATED_AT)//3
  	->addSelectColumn(self::CREATED_BY)//4
  	->addAsColumn('null1', 'NULL')//5
  	->addAsColumn('null2', 'NULL')//6
  	->addSelectColumn('(SELECT 
  				string_agg((SELECT metadata_id || \':\' || value FROM ' . DataExtractionPeer::TABLE_NAME . ' de
  				 WHERE true in(studies.id = study_id)
  				 AND  ' . MetadataPeer::ID . ' = metadata_id
  				 ORDER BY id DESC LIMIT 1), \', \')
  			FROM ' . MetadataPeer::TABLE_NAME . ' WHERE true in(studies.systematic_review_id = systematic_review_id))');//7

  	return self::doSelectListDataSynthesisCount($c, false);
  }  
  
  public static function doSelectListDataSynthesisCount(Criteria $c, $isCount = true)
  {
  	$c->addJoin(self::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
  	
  	$c->add(StudyPeer::DELETED_AT, null);
  	
  	//TODO:Filtra os estudos inclusos sem divergencia
  	$c->add(StudyPeer::ID,' CASE WHEN ' . self::CASTING_VOTE . ' IS NOT NULL ' .
  			' THEN (SELECT '.  RslCriteriaPeer::TYPE .
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID .
  			'   AND ' . self::CASTING_VOTE . ' = ' . StudyUserCriteriaPeer::USER_ID . ')' .
  			' ELSE (SELECT ' .
  			'     CASE WHEN COUNT(DISTINCT ' . StudyUserCriteriaPeer::CRITERIA_ID . ') > 1'.
  			'     THEN false'.
  			'     ELSE bool_and(' . RslCriteriaPeer::TYPE . ')'.
  			'     END ' .
  			'   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
  			'   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
  			'   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . ')' .
  			' END', Criteria::CUSTOM);

  	return $isCount ? self::doCount($c) : self::doSelectRS($c);
  }
  
  
  
  public static function doSelectJoinDataExtraction(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
  {
    $criteria = clone $criteria;
  
    // Set the correct dbName if it has not been overridden
    if ($criteria->getDbName() == Propel::getDefaultDB()) {
      $criteria->setDbName(self::DATABASE_NAME);
    }
  
    StudyPeer::addSelectColumns($criteria);
    $startcol = (StudyPeer::NUM_COLUMNS - StudyPeer::NUM_LAZY_LOAD_COLUMNS);
    DataExtractionPeer::addSelectColumns($criteria);
  
    $criteria->addJoin(StudyPeer::ID, DataExtractionPeer::STUDY_ID, $join_behavior);
  
    // symfony_behaviors behavior
    /*foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
    {
      call_user_func($sf_hook, 'StudyPeer', $criteria, $con);
    }*/
  
    //$stmt = MetadataPeer::doSelect($criteria, $con);
    $results = array();
     
    //$stmt->closeCursor();
    return $results;
  }
  
  public static function doSelectRS(Criteria $criteria, $con = null)
  {
  
    foreach (sfMixer::getCallables('BaseStudyPeer:doSelectRS:doSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseStudyPeer', $criteria, $con);
    }
  
  
  
    foreach (sfMixer::getCallables('BaseStudyPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseStudyPeer', $criteria, $con);
    }
  
  
    if ($con === null) {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }
  
    if (!$criteria->getSelectColumns()) {
      $criteria = clone $criteria;
      StudyPeer::addSelectColumns($criteria);
    }
  
    $criteria->setDbName(self::DATABASE_NAME);
  
    return BasePeer::doSelect($criteria, $con);
  }
} // StudyPeer
