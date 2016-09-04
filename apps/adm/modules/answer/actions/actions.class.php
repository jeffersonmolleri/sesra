<?php

/**
 * studies actions.
 *
 * @package    mestrado
 * @subpackage studies
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class answerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeForm(sfWebRequest $request)
  {
  	$this->study_id = $request->getParameter('study_id', null);
  	$this->review_id = $request->getParameter('review_id', null);
  	
  	$review = SystematicReviewPeer::retrieveByPk($this->review_id);
  	if($review->getQuestionnaire() != null)
  		$questionnaire_id = $review->getQuestionnaire()->getId();
  	
  	if(empty($questionnaire_id)) {
  		throw new Exception("Nenhum questionário foi selecionado");
  	}
  	$c = new Criteria();
  	$c->add(QuestionnairePeer::DELETED_AT, null);
  	$c->add(QuestionnairePeer::ID, $questionnaire_id);
  	$c->addAscendingOrderByColumn(QuestionnairePeer::NAME);
  	
  	$this->questionnaires = array();
  	foreach (QuestionnairePeer::doSelect($c) as $quest)
  	{
  		$std = new stdclass();
  		$std->id = $quest->getId();
  		$std->name = $quest->getName();
  		$std->description = $quest->getDescription();

  		$c = new Criteria();
  		$c->add(QuestionPeer::QUESTIONNAIRE_ID, $quest->getId());
  		$c->addMultipleJoin(
  			array(
  					array(QuestionPeer::ID,  AnswerPeer::QUESTION_ID),
  					array(AnswerPeer::STUDY_ID, $this->study_id)
  			), Criteria::LEFT_JOIN);
  		$std->questions = QuestionPeer::doSelectForForm($c);
  		$this->questionnaires[] = $std;
  	}

  	$this->getResponse()->setContentType('text/xml');
  	$this->setLayout('taconite');
  }

  public function executeAvaliar(sfWebRequest $request)
  {
  	$this->questionnaire_id = $request->getParameter('questionnaire_id');
  	$study_id = $request->getParameter('study_id');
  	$questions = $request->getParameter('questions');
  	
  	try {
	  	foreach ($questions as $id => $ans) 
	  	{
		  	$c = new Criteria();
		  	$c->add(AnswerPeer::STUDY_ID, $study_id);
		  	$c->add(AnswerPeer::QUESTION_ID, $id);
		
		  	$answer = AnswerPeer::doSelectOne($c);
		  	if (empty($answer))
		  	{
		  		$answer = new Answer();
		  		$answer->setQuestionId($id);
		  		$answer->setStudyId($study_id);
		  		$answer->setCreatedBy($this->getUser()->getId());
		  	}
		  	$answer->setAnswer($ans);
		  	$answer->save();
	  	}
	  	$this->success = true;
  	} catch(Exception $ex) {}
  	
  	$this->getResponse()->setContentType('text/xml');
  	$this->setLayout('taconite');
  	$this->setTemplate('ajaxAvaliar');
  }
}
