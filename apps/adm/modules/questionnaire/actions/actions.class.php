<?php

/**
 * questionnaire actions.
 *
 * @package    mestrado
 * @subpackage questionnaire
 * @author     Your name here
 */
class questionnaireActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$this->review_id = $request->getParameter('id');
  	$this->review = null;
  	if($this->review_id) {
  		$this->review = SystematicReviewPeer::retrieveByPk($this->review_id);
  	}
	$c = new Criteria();
	$c->add(QuestionnairePeer::DELETED_AT,QuestionnairePeer::DELETED_AT . ' IS NULL',Criteria::CUSTOM);
    $this->Questionnaires = QuestionnairePeer::doSelect($c);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->review_id = $request->getParameter('review_id');
  	$this->review = null;
  	if($this->review_id) {
  		$this->review = SystematicReviewPeer::retrieveByPk($this->review_id);
  	}
    $quest = new Questionnaire();
    $quest->setSystematicReviewId($this->review_id);
  	$this->form = new QuestionnaireForm($quest);
  }

  public function executeCreate(sfWebRequest $request)
  {
  	$quest = $request->getParameter('questionnaire');
  	$this->review_id = $quest['systematic_review_id'];
  	$this->review = null;
  	if($this->review_id) {
  		$this->review = SystematicReviewPeer::retrieveByPk($this->review_id);
  	}
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new QuestionnaireForm();
    
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
  	$this->review_id = $request->getParameter('review_id');
  	
  	$Questionnaire = QuestionnairePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($Questionnaire, sprintf('Object Questionnaire does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuestionnaireForm($Questionnaire);
    
    $c = new Criteria();
	$c->add(QuestionPeer::DELETED_AT,QuestionPeer::DELETED_AT . ' IS NULL',Criteria::CUSTOM);
    $c->add(QuestionPeer::QUESTIONNAIRE_ID, $this->getRequestParameter('id'));
    $this->questions = QuestionPeer::doSelect($c);
  }

  public function executeUpdate(sfWebRequest $request)
  {
  	$this->review_id = $request->getParameter('review_id');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Questionnaire = QuestionnairePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Questionnaire does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuestionnaireForm($Questionnaire);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Questionnaire = QuestionnairePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Questionnaire does not exist (%s).', $request->getParameter('id')));
    $Questionnaire->delete();
    $this->redirect("@studies_assessment?id={$this->review_id}");
    
    //$this->redirect('questionnaire/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
	  $ancora = $form->getObject()->isNew() ? '#criterios' : '';
      $Questionnaire = $form->save();
      
      //if($form->getObject()->isNew())
      $this->redirect("questionnaire/edit?review_id={$this->review_id}&id={$Questionnaire->getId()}{$ancora}");
      //else $this->redirect("@studies_assessment?id={$this->review_id}");
    }
  }
  
  public function executeQuestionAdd(sfWebRequest $request)
  {
  	$question = new Question();
  	$question->setQuestionnaireId($this->getRequestParameter('questionare_id'));
  	$question->setDescription($this->getRequestParameter('description'));
  	$question->setAnswerType($this->getRequestParameter('answer_type'));
  	
  	try
  	{
  		$question->save();
  	}
  	catch (Exception $e)
  	{
  		$this->error = $e->getMessage();
  	}
  
  	$c = new Criteria();
	$c->add(QuestionPeer::DELETED_AT,QuestionPeer::DELETED_AT . ' IS NULL',Criteria::CUSTOM);
  	$c->add(QuestionPeer::QUESTIONNAIRE_ID, $this->getRequestParameter('questionare_id'));
  	$this->questions = QuestionPeer::doSelect($c);
  
  	$this->getResponse()->setContentType('text/xml');
  	$this->setLayout('taconite');
  }
  
  public function executeQuestionRemove(sfWebRequest $request)
  {
	$c = new Criteria();
	$c->add(QuestionPeer::ID, $this->getRequestParameter('id'));
	$cq = new Criteria();
	$cq->add(QuestionPeer::DELETED_AT,QuestionPeer::DELETED_AT . ' IS NULL',Criteria::CUSTOM);
	
	$question = QuestionPeer::doSelectOne($c);
	$cq->add(QuestionPeer::QUESTIONNAIRE_ID, $question->getQuestionnaireId());
	$question->delete();

	$this->questions = QuestionPeer::doSelect($cq);
		
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('questionAdd');
    
  }
}
