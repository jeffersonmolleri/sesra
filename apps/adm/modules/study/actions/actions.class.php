<?php

/**
 * studies actions.
 *
 * @package    mestrado
 * @subpackage studies
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class studyActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('review_id', null);
    $this->review = null;

    if($this->review_id) {
      $this->review = SystematicReviewPeer::retrieveByPk($this->review_id);
    }

    $this->title = $this->getRequestParameter('title', false);

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }

    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $c->add(StudyPeer::DELETED_AT, null);
    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->criterios = array();
    if($this->review_id)
    {
      $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);

      $cr = new Criteria();
      $cr->add(BaseRslCriteriaPeer::RSL_ID, $this->review_id);
      $criterios = RslCriteriaPeer::doSelectForSelection($cr);

      if (!empty($criterios))
      {
        foreach ($criterios as $criterio)
        {
          $this->criterios[$criterio[0]] = new stdclass();
          $this->criterios[$criterio[0]]->name = $criterio[1];
          $this->criterios[$criterio[0]]->type = $criterio[2];
        }
      }
    }
    //TODO:Encontrar forma para buscar sessão dentro da classe
    $c->addMultipleJoin(
      array(
         array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
         array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
       ),
       Criteria::LEFT_JOIN);
    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectList');
    $this->studies->setPage($page);
    $this->studies->init();

  }

  public function executeIdentification(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('id', null);
    $this->review = null;

    $this->title = $this->getRequestParameter('title', false);

    $request_info = $request->getRequestParameters();

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }

    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $c->add(StudyPeer::DELETED_AT, null);
    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->criterios = array();
    if($this->review_id)
    {
      $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);

      $cr = new Criteria();
      $cr->add(BaseRslCriteriaPeer::RSL_ID, $this->review_id);
      $criterios = RslCriteriaPeer::doSelectForSelection($cr);

      if (!empty($criterios))
      {
        foreach ($criterios as $criterio)
        {
          $this->criterios[$criterio[0]] = new stdclass();
          $this->criterios[$criterio[0]]->name = $criterio[1];
          $this->criterios[$criterio[0]]->type = $criterio[2];
        }
      }
    }

    //TODO:Encontrar forma para buscar sessão dentro da classe
    $c->addMultipleJoin(
      array(
         array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
         array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
       ),
       Criteria::LEFT_JOIN);
    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectList');
    $this->studies->setPage($page);
    $this->studies->init();

    $study = new Study();
    $study->setSystematicReviewId($this->review_id);
    $study->setCreatedBy($this->getContext()->getUser()->getId());

    $this->form = new StudyForm($study);
    $this->screen = "identification";

    $c = new Criteria();
    $c->add(ProtocolPeer::RSL_ID, $this->review_id);
    $protocolo = ProtocolPeer::doSelectOne($c);
    $this->queryBusca = $protocolo->getSearchString();

    $this->bib_success = @implode(', ', $this->getUser()->getFlash("bib_success"));
    $this->success_qty = count($this->getUser()->getFlash("bib_success"));
    $this->bib_error = @implode(', ', $this->getUser()->getFlash("bib_error"));


    $c = new Criteria();
    $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
//     $c->addJoin(SearchBasePeer::ID, SystematicReviewSearchBasePeer::SEARCH_BASE_ID, Criteria::INNER_JOIN);
    $c->add(SearchBasePeer::TXTID, null, Criteria::ISNOTNULL);
    $this->autobases = SystematicReviewSearchBasePeer::doSelectJoinSearchBase($c);
  }

  public function executeStudyselection(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('id', null);
    $this->filter = $request->getParameter('filter', null);

    $this->title = $this->getRequestParameter('title', false);

    $request_info = $request->getRequestParameters();

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }
  switch($this->filter)
  {
    case 'divergente_resolvida':
      $c->addMultipleJoin(
          array(
              array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
              array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
          ),
          Criteria::LEFT_JOIN);
      $c->add(StudyPeer::CASTING_VOTE, null, Criteria::ISNOTNULL);
      break;
    case 'divergente':
      $c->addMultipleJoin(
          array(
              array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
              array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
          ),
          Criteria::LEFT_JOIN);
      $c->add(StudyPeer::ID,' CASE WHEN ' . StudyPeer::CASTING_VOTE . ' IS NOT NULL ' .
        ' THEN false ' .
        ' ELSE (SELECT COUNT(DISTINCT ' . StudyUserCriteriaPeer::CRITERIA_ID . ') > 1'.
        '   FROM ' . StudyUserCriteriaPeer::TABLE_NAME .
        '   INNER JOIN ' . RslCriteriaPeer::TABLE_NAME . ' ON ' . RslCriteriaPeer::ID . ' = ' . StudyUserCriteriaPeer::CRITERIA_ID .
        '   WHERE ' . StudyUserCriteriaPeer::STUDY_ID . ' = ' . StudyPeer::ID . ')' .
        ' END', Criteria::CUSTOM);
      break;
    case 'included':
    case 'excluded':
      $c->addMultipleJoin(
        array(
          array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
          array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
        ),
        Criteria::INNER_JOIN);
      $c->addJoin(StudyUserCriteriaPeer::CRITERIA_ID, RslCriteriaPeer::ID, Criteria::INNER_JOIN);
      if($this->filter == 'included')
        $c->add(RslCriteriaPeer::TYPE, true);
      else
        $c->add(RslCriteriaPeer::TYPE, false);
      break;
    case 'empty':
    default:
      $c->addMultipleJoin(
        array(
          array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
          array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
        ),
        Criteria::LEFT_JOIN);
      if($this->filter == 'empty')
        $c->add(StudyUserCriteriaPeer::USER_ID, null);
      break;
  }

    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->criterios = array();

  $cr = new Criteria();
  $cr->add(BaseRslCriteriaPeer::RSL_ID, $this->review_id);
    $criterios = RslCriteriaPeer::doSelectForSelection($cr);
    if (!empty($criterios))
    {
      foreach ($criterios as $criterio)
      {
        $this->criterios[$criterio[0]] = new stdclass();
        $this->criterios[$criterio[0]]->name = $criterio[1];
        $this->criterios[$criterio[0]]->type = $criterio[2];
      }
    }

    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectListSelection');
    $this->studies->setPeerCountMethod('doSelectListSelectionCount');
    $this->studies->setPage($page);
    $this->studies->init();
  }

  public function executeClassify(sfWebRequest $request)
  {
    $study_id = $request->getParameter('study_id');
    $this->review_id = $request->getParameter('review_id');

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');

    $this->study = StudyPeer::retrieveByPk($study_id);

    //------------------
    $bib = new Structures_BibTex();
    $bib->loadString($this->study->getBibtex());
    $bib->parse();
    $this->data = isset($bib->data[0]) ? $bib->data[0] : null;

    //------------------
    $this->criterios = array();
    $cr = new Criteria();
    $cr->add(BaseRslCriteriaPeer::RSL_ID, $this->review_id);
    $criterios = RslCriteriaPeer::doSelectForSelection($cr);
    if (!empty($criterios))
    {
      foreach ($criterios as $criterio)
      {
        $this->criterios[$criterio[0]] = new stdclass();
        $this->criterios[$criterio[0]]->name = $criterio[1];
        $this->criterios[$criterio[0]]->type = $criterio[2];
      }
    }

    //------------------
    $c = new Criteria();
    $c->add(StudyUserCriteriaPeer::STUDY_ID, $study_id);
    $c->add(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId());
    $this->criterio = StudyUserCriteriaPeer::doSelectOne($c);

    //------------------
    $c = new Criteria();
  $c->addMultipleJoin(
    array(
      array(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID),
      array(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId())
    ),
    Criteria::LEFT_JOIN);
  $c->add(StudyPeer::ID, $this->study->getId(), Criteria::NOT_EQUAL);
  $c->add(StudyUserCriteriaPeer::USER_ID, null);
    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $c->addJoin(StudyPeer::CREATED_BY,sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
    $c->add(StudyPeer::DELETED_AT, null);
    $title = strip_tags(str_replace(array("'",'.'), '_', $this->study->getTitle()));
    $c->addDescendingOrderByColumn(StudyPeer::TITLE . " > '{$title}'");
    $c->addAscendingOrderByColumn(StudyPeer::TITLE);
    $c->clearSelectColumns()->addSelectColumn(StudyPeer::ID);
    $c->setLimit(1);
    $this->nextId = StudyPeer::doSelectRS($c)->fetch();

    //------------------
    $c = new Criteria();
    $c->addJoin(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID, Criteria::INNER_JOIN);
    $c->addJoin(StudyUserCriteriaPeer::CRITERIA_ID, RslCriteriaPeer::ID, Criteria::INNER_JOIN);
    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $this->selectedCount = StudyPeer::doSelectListSelectionCount($c);

    //------------------
    $c = new Criteria();
    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $c->addJoin(StudyPeer::ID, StudyUserCriteriaPeer::STUDY_ID, Criteria::INNER_JOIN);

    $this->weight = 0;
    $studiesIds = array();
    $studiesCriterios = array();
    $this->criteriosScore = array();
    $studiesCriteriosAmount = array();
    foreach(StudyPeer::doSelectListSelection($c) as $st)
    {
      $this->criteriosScore[$st['criteria_id']] = 0;
      $studiesIds[$st['id']] = $st['id'];
      $studiesCriterios[$st['id']] = $st['criteria_id'];
      @$studiesCriteriosAmount[$st['criteria_id']] += 1;
    }
    $this->isDistinct = false;
    if(!empty($studiesIds))
    {
      $this->bagofword = $this->getBagOfWord(array('abstract', 'title'), $study_id);
      $scores = array();

    foreach($this->compareStudy(array('abstract', 'title'), array_keys($this->bagofword), $studiesIds) as $sId => $score)
      {
        @$scores[$sId] += $score;
      }
      foreach ($scores as $sId => $score)
      {
        $this->criteriosScore[ $studiesCriterios[$sId] ] += $score;
      }
      foreach ($studiesCriteriosAmount as $cId => $amount) {
        @$this->criteriosScore[ $cId ] = $this->criteriosScore[ $cId ] / $amount;
        $this->weight += $this->criteriosScore[ $cId ];
        $this->cristeriosDistinct++;
      }
      $dists = 0;
      foreach($this->criteriosScore as $val) {
        if($val > 0) {
          $dists++;
          if($dists > 0) {
            $this->isDistinct = true;
            break;
          }
        }
      }
    }
  }

  public function executeSelectQuestionary(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $review_id = $request->getParameter('review_id', null);
    $questionnaire_id = $request->getParameter('questionnaire_id', null);

    $review = SystematicReviewPeer::retrieveByPk($review_id);
    $review->setQuestionnaire(empty($questionnaire_id) ? null : QuestionnairePeer::retrieveByPk($questionnaire_id));
    $review->save();

    $this->redirect("study/studyassessment?id={$review_id}&page={$page}");
  }

  public function executeStudyassessment(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('id', null);
    $this->review = SystematicReviewPeer::retrieveByPk($this->review_id);

    $this->filter = $request->getParameter('filter', null);
    $this->title = $this->getRequestParameter('title', false);

    $request_info = $request->getRequestParameters();

    $c = new Criteria();
    $c->add(QuestionnairePeer::DELETED_AT, QuestionnairePeer::DELETED_AT . ' IS NULL', Criteria::CUSTOM);
    $cr = $c->getNewCriterion(QuestionnairePeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $cr->addOr($c->getNewCriterion(QuestionnairePeer::SYSTEMATIC_REVIEW_ID, QuestionnairePeer::SYSTEMATIC_REVIEW_ID . ' IS NULL', Criteria::CUSTOM));
    $c->addAnd($cr);
    $this->Questionnaires = QuestionnairePeer::doSelect($c);

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }
    switch($this->filter)
    {
      case 'assessed';
        $c->addJoin(StudyPeer::ID, AnswerPeer::STUDY_ID, Criteria::LEFT_JOIN);
        $c->add(AnswerPeer::STUDY_ID, null, '<>');
        break;
      case 'unassessed';
        $c->addJoin(StudyPeer::ID, AnswerPeer::STUDY_ID, Criteria::LEFT_JOIN);
        $c->add(AnswerPeer::STUDY_ID, null);
        break;
    }
    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);

    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectListAssessment');
    $this->studies->setPeerCountMethod('doSelectListAssessmentCount');
    $this->studies->setPage($page);
    $this->studies->init();
  }

  public function executeDataextraction(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('id', null);
    $this->filter = $this->getRequestParameter('filter', false);
    $this->title = $this->getRequestParameter('title', false);

    $request_info = $request->getRequestParameters();

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }
  switch($this->filter) {
    case 'not_extracted':
      $c->addJoin(StudyPeer::ID, DataExtractionPeer::STUDY_ID, Criteria::LEFT_JOIN);
      $c->add(DataExtractionPeer::STUDY_ID, null);
      break;
    case 'initialized':
      $c->add('0', 'EXISTS(SELECT ' . DataExtractionPeer::STUDY_ID .' FROM ' . DataExtractionPeer::TABLE_NAME . ' WHERE ' . StudyPeer::ID . ' = ' . DataExtractionPeer::STUDY_ID .')', Criteria::CUSTOM);
      $c->add('1', 'EXISTS(SELECT ' . DataExtractionPeer::STUDY_ID .
          ' FROM ' . MetadataPeer::TABLE_NAME .
          ' LEFT JOIN ' . DataExtractionPeer::TABLE_NAME . ' ON ' . DataExtractionPeer::METADATA_ID . ' = ' . MetadataPeer::ID . ' AND ' . DataExtractionPeer::STUDY_ID . ' = ' . StudyPeer::ID.
          ' WHERE ' . MetadataPeer::SYSTEMATIC_REVIEW_ID . ' = ' . $this->review_id .
          ' AND ' . DataExtractionPeer::METADATA_ID . ' IS NULL )', Criteria::CUSTOM);
      break;
    case 'extract':
      $c->add(StudyPeer::ID, 'NOT EXISTS(SELECT ' . DataExtractionPeer::STUDY_ID .
        ' FROM ' . MetadataPeer::TABLE_NAME .
        ' LEFT JOIN ' . DataExtractionPeer::TABLE_NAME . ' ON ' . DataExtractionPeer::METADATA_ID . ' = ' . MetadataPeer::ID . ' AND ' . DataExtractionPeer::STUDY_ID . ' = ' . StudyPeer::ID.
        ' WHERE ' . MetadataPeer::SYSTEMATIC_REVIEW_ID . ' = ' . $this->review_id .
        ' AND ' . DataExtractionPeer::METADATA_ID . ' IS NULL )', Criteria::CUSTOM);
      break;
  }
    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);

    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectListDataextraction');
    $this->studies->setPeerCountMethod('doSelectListDataextractionCount');
    $this->studies->setPage($page);
    $this->studies->init();
  }

  public function executeDatasynthesis(sfWebRequest $request)
  {
    $page = $this->getRequestParameter('page', false);
    $this->review_id = $request->getParameter('id', null);
    $this->filter = $this->getRequestParameter('filter', false);
    $this->title = $this->getRequestParameter('title', false);

    $request_info = $request->getRequestParameters();

    $c = new Criteria();
    $this->order = $this->getRequestParameter('order', StudyPeer::TITLE);
    $this->dir = $this->getRequestParameter('dir', 'asc');
    if ($this->dir == 'asc') {
      $c->addAscendingOrderByColumn($this->order);
    } else {
      $c->addDescendingOrderByColumn($this->order);
    }

    $c->add(StudyPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    if (!empty($this->title))
    {
      $c->add(StudyPeer::TITLE, '%'.$this->title.'%', Criteria::LIKE);
    }

    $this->studies = new sfPropelPager('Study', $request->getParameter('sf_pager', 20));
    $this->studies->setCriteria($c);
    $this->studies->setPeerMethod('doSelectListDataSynthesis');
    $this->studies->setPeerCountMethod('doSelectListDataSynthesisCount');
    $this->studies->setPage($page);
    $this->studies->init();

    $md = new Criteria();
    $md->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    /* TODO: ORDERBY */
    //$md->addJoin(MetadataPeer::ID, DataExtractionPeer::METADATA_ID, Criteria::LEFT_JOIN);
    $this->metadata = MetadataPeer::doSelect($md);

  }

  public function executeDesempatarAvaliacao(sfWebRequest $request)
  {
    $this->review_id = $request->getParameter('review_id');
    $this->study_id = $request->getParameter('study_id');

    $this->study = $user = StudyPeer::retrieveByPk($this->study_id);

    $c = new Criteria();
    $c->add(StudyUserCriteriaPeer::STUDY_ID, $this->study_id);
    $c->addJoin(StudyUserCriteriaPeer::CRITERIA_ID, RslCriteriaPeer::ID);
    $this->avaliacoes = StudyUserCriteriaPeer::doSelect($c);


    $userIds = array();
    foreach($this->avaliacoes as $a)
    {
      $userIds[] = $a->getUserId();
    }
    $c = new Criteria();
    $c->add(sfGuardUserPeer::ID, $userIds, Criteria::IN);
    $this->users = array();
    $users = sfGuardUserPeer::doSelect($c);
    foreach($users as $u)
    {
      $this->users[$u->getId()] = $u;
    }

    $cr = new Criteria();
    $cr->add(BaseRslCriteriaPeer::RSL_ID, $this->review_id);
    $criterios = RslCriteriaPeer::doSelectForSelection($cr);
    $this->criterios = array();
    if (!empty($criterios))
    {
      foreach ($criterios as $criterio)
      {
        $this->criterios[$criterio[0]] = new stdclass();
        $this->criterios[$criterio[0]]->name = $criterio[1];
        $this->criterios[$criterio[0]]->type = $criterio[2];
      }
    }
  }

  public function executeSolicitarAvaliador(sfWebRequest $request)
  {
    $this->review_id = $request->getParameter('review_id');
    $this->study_id = $request->getParameter('study_id');

    $this->study = $user = StudyPeer::retrieveByPk($this->study_id);

    $c = new Criteria();
    $c->add(StudyUserCriteriaPeer::STUDY_ID, $this->study_id);
    $c->addJoin(StudyUserCriteriaPeer::CRITERIA_ID, RslCriteriaPeer::ID);
    $this->avaliacoes = StudyUserCriteriaPeer::doSelect($c);

    $userIds = array();
    foreach($this->avaliacoes as $a)
    {
      $userIds[] = $a->getUserId();
    }
    $c = new Criteria();
    $c->add(sfGuardUserPeer::ID, $userIds, Criteria::IN);

    $this->users = array();
    $users = sfGuardUserPeer::doSelect($c);
    foreach($users as $u)
    {
      $this->users[$u->getId()] = $u;
    }
    $levels = sfConfig::get('app_levels_ids');

    $c = new Criteria();
    $c->add(SystematicReviewUserPeer::SYSTEMATIC_REVIEW_ID, $this->review_id);
    $levels = array($levels['mediador'], $levels['coordenador']);
    $c->add(SystematicReviewUserPeer::LEVEL, $levels, Criteria::IN);

    $c->addAscendingOrderByColumn(sfGuardUserProfilePeer::NAME);
    $this->avaliadores = SystematicReviewUserPeer::doSelectJoinsfGuardUserPlusProfile($c);

    if($request->hasParameter('avaliador')) {
      $systematic_review = SystematicReviewPeer::retrieveByPk($this->review_id);

      $c = new Criteria();
      $c->add(SystematicReviewUserPeer::USER_ID, $request->getParameter('avaliador'));
      $this->avaliador = SystematicReviewUserPeer::doSelectOne($c);


      $this->study->setCastingVote($request->getParameter('avaliador'));
      try {
        $this->study->save();

        $levelsN = sfConfig::get('app_levels_names');

        $msg = Swift_Message::newInstance();
        $msg->setFrom(sfConfig::get('app_invitations_sender'));// TODO: definir padrao
        $msg->setTo($this->avaliador->getSfGuardUser()->getProfile()->getEmail());
        $msg->setSubject($this->study->getTitle());
        $msg->setBody($this->getPartial('mail/sendAssess', array (
            'profile' => $this->avaliador->getSfGuardUser()->getProfile(),
            'inviter' => $this->getUser(),
            'review' => $systematic_review,
            'study' => $this->study,
            'level' => $levelsN[$this->avaliador->getLevel()],
        )));
        $msg->setContentType('text/html');
        $this->send = $this->getMailer()->send($msg);
      } catch (PropelException $e) {

      }
    }
    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
  }

  public function executeAvaliar(sfWebRequest $request)
  {
    $study_id = $request->getParameter('study_id');
    $criteria_id = $request->getParameter('criteria_id');

    $c = new Criteria();
    $c->add(StudyUserCriteriaPeer::STUDY_ID, $study_id);
    $c->add(StudyUserCriteriaPeer::USER_ID, $this->getUser()->getId());

    $criteria = StudyUserCriteriaPeer::doSelectOne($c);
    if($criteria_id === '0')
    {
      if (!empty($criteria))
      {
        $criteria->delete();
      }
    } else {
      if (empty($criteria))
      {
        $criteria = new StudyUserCriteria();
        $criteria->setStudyId($study_id);
        $criteria->setUserId($this->getUser()->getId());
      }
      $criteria->setCriteriaId($criteria_id);
      $criteria->save();
    }

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxAvaliar');

    $this->study = StudyPeer::retrieveByPk($study_id);
    $this->criteria = RslCriteriaPeer::retrieveByPk($criteria_id);
  }

  public function executeNew(sfWebRequest $request)
  {
    var_dump("teste");
    die;
    $this->review_id = $request->getParameter('review_id');
    $this->forward404If(!$this->review_id);

    $study = new Study();
    $study->setSystematicReviewId($this->review_id);
    $study->setCreatedBy($this->getContext()->getUser()->getId());

    $this->form = new StudyForm($study);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->review_id = $request->getParameter('review_id');
    $this->review = null;
    if($this->review_id) {
      $this->review = SystematicReviewPeer::retrieveByPk($this->review_id);
    }
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StudyForm();

    $this->processForm($request, $this->form);
    /*if($request->getParameter('screen'))
    {
    $this->redirect("study/identification?id=" . $this->review_id);
    }*/
    $this->redirect("study/identification?id=" . $this->review_id);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404If(!$request->getParameter('id'));
    $study = StudyPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404If(!($study instanceof Study), 'Estudo não encontrado.');

    $this->review_id = $study->getSystematicReviewId();
    $this->title = $study->getTitle();
    $this->form = new StudyForm($study);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($study = StudyPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Questionnaire does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudyForm($study);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $study = StudyPeer::retrieveByPK($request->getParameter('id', null));
    $review_id = $study->getSystematicReviewId();
    $this->forward404If(!($study instanceof Study));
    $study->delete();
    $this->redirect('@studies_identification?id=' . $review_id);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->save();

      $review_id = $request->getParameter('review_id');

      if($this->exportToSolr($form->getObject()->asBibtexArray(), $form->getObject()->getId()))
        $this->getUser()->setFlash("bib_success", array($form->getObject()->getTitle()));
      else
        $this->getUser()->setFlash("bib_error", array($form->getObject()->getTitle()));

      if($request->getParameter('screen'))
      {
        $this->redirect("study/identification?id=" . $review_id);
      }
      $this->redirect("@studies_selection?id=" . $review_id);
    }
  }

  public function executeSearchMetaData(sfWebRequest $request)
  {
    $study_id = $request->getParameter('study_id');
    $rsl_id = $request->getParameter('rsl_id');

    $c = new Criteria();
    $c->add(MetadataPeer::SYSTEMATIC_REVIEW_ID, $rsl_id);
    $this->metadatas = MetadataPeer::doSelect($c);

    $this->metadatas_info = array();

    $option_input = null;
    foreach($this->metadatas as $i => $metadata)
    {
      $input = null;
      $c = new Criteria();
      $c->add(DataExtractionPeer::STUDY_ID, $study_id);
      $c->add(DataExtractionPeer::METADATA_ID, $metadata->getId());
      $c->addDescendingOrderByColumn(DataExtractionPeer::ID);
      $dataExtraction = DataExtractionPeer::doSelectOne($c);
      if ($metadata->getType() == Metadata::NUMERO || $metadata->getType() == Metadata::CATEGORIAS) {
        $value = empty($dataExtraction) ? null : intval($dataExtraction->getValue());
      } else {
        $value = empty($dataExtraction) ? null : $dataExtraction->getValue();
      }

      if(strlen(trim($metadata->getDescription())) > 0)
      {
        if ($metadata->getType() == Metadata::BIBTEX) {
          try {
            $study = StudyPeer::retrieveByPK($study_id);
            $bibtex = trim($study->getBibtex());
            if (!empty($bibtex)) {
              $_bibtex = new BibTex();
              $_bibtex->loadString($bibtex);
              $_bibtex->parse();
              $_data = isset($_bibtex->data[0][$metadata->getDescription()]) ? $_bibtex->data[0][$metadata->getDescription()] : null;
              
              //$value = is_array($_data) ? implode(', ', $_data) : $_data;
              $value = empty($dataExtraction) ? null : $dataExtraction->getValue();
							if($value == null) {
								//$value = '';
								if(is_array($_data)) {
									foreach($_data as $d) {
										$value .= is_array($d) ? implode(' ', $d) : $d;
									}
								} else {
									$value = $_data;
								}
							}
              //$input = sprintf('<input type="text" readonly title="%s" class="input-xlarge" name="metadata[%d][valor]" value="%s" />', $metadata->getDescription(), $metadata->getId(), $value);
							$input = sprintf('<input type="text" title="%s" class="input-xlarge" name="metadata[%d][valor]" value="%s" />', $metadata->getDescription(), $metadata->getId(), $value);
            }
          }
          catch (Exception $e) {
            $input = '<div class="alert alert-error"><i class="icon-warning-sign"></i> Erro ao obter dado do BibTex</div>';
          }
        }

        if (!isset($input) || empty($input)) {
          $options = explode(',', $metadata->getDescription());
          $input = '<select id="metadata_'.$i.'" name="metadata[' . $metadata->getId() . '][valor]">';
          $option_input = '<option value="">- select -</option>';
          foreach($options as $i => $option)
          {
            if($value === $i)
                $option_input .= '<option value="' . $i . '" selected="selected">' . $option . '</option>';
            else
              $option_input .= '<option value="' . $i . '">' . $option . '</option>';
          }
          $input .= $option_input . '</select>';
        }
      }
      else
      {
        $input = '<input type="text" class="input-xlarge" name="metadata[' . $metadata->getId() . '][valor]" value="' . $value . '" />';
      }
      $input_hiddem = '<input type="hidden" name="metadata[' . $metadata->getId() . '][study_id]" value="' . $study_id .'" /><input type="hidden" name="metadata[' . $metadata->getId() . '][id]" value="' . $metadata->getId() .'" />';
      $input .= $input_hiddem;

      $this->metadatas_info[$metadata->getId()]['input'] = $input;
      $this->metadatas_info[$metadata->getId()]['name'] = $metadata->getName();
      $this->metadatas_info[$metadata->getId()]['id'] = $metadata->getId();
    }

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxDataExtration');
  }

  public function executeExtratMetaData()
  {

    $metadatas = $this->getRequestParameter('metadata');

    foreach($metadatas as $metadata)
    {

      if(strlen(trim($metadata['valor'])) > 0)
      {
        try {
          $c = new Criteria();
          $c->add(DataExtractionPeer::STUDY_ID, $metadata['study_id']);
          $c->add(DataExtractionPeer::METADATA_ID, $metadata['id']);
          $extract = DataExtractionPeer::doSelectOne($c);
          if ($extract === null) {
            $extract = new DataExtraction();
            $extract->setStudyId($metadata['study_id']);
            $extract->setMetadataId($metadata['id']);
          }
          $extract->setValue($metadata['valor']);
          $extract->save();
          $this->save = true;
        }
        catch (PropelException $e) {
          $this->save = false;
          $this->debug = $e->getMessage();
        }
      }
    }

    $this->getResponse()->setContentType('text/xml');
    $this->setLayout('taconite');
    $this->setTemplate('ajaxDataExtration');
  }

  public function executeCrawler(sfWebRequest $request)
  {
    switch ($request->getParameter('txtid')) {
      case 'ieee' :
        $this->forward('study', 'crawlerIEEE');
        break;

      case 'iet' :
        $this->forward('study', 'crawlerIET');
        break;

      case 'springer' :
        $this->forward('study', 'crawlerSpringer');
        break;

      default :
        $this->forward404();
        break;
    }
    /*
    ob_start();
    echo '<?xml version="1.0" encoding="UTF-8"?><taconite><html select="#waitingModal .modal-body"><![CDATA[';
      $request->getParameterHolder()->getAll();
    echo ']]></html></taconite>';
    $content = ob_get_clean();

    $this->getResponse()->setContentType('text/xml');
    $this->getResponse()->setContent($content);
    return sfView::NONE;
    */
  }

  public function executeUpdateQueryString(sfWebRequest $request)
  {
    try {
      $c = new Criteria();
      $c->add(SearchBasePeer::TXTID, $request->getParameter('txtid'));
      $sb = SearchBasePeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(SystematicReviewSearchBasePeer::SYSTEMATIC_REVIEW_ID, $request->getParameter('review_id'));
      $c->add(SystematicReviewSearchBasePeer::SEARCH_BASE_ID, $sb->getId());
      $query = SystematicReviewSearchBasePeer::doSelectOne($c);
      $query->setQueryString($request->getParameter('search_string'));
      $query->save();
    }
    catch (Exception $e) {
      // swallow
    }
    $this->getResponse()->setContentType('text/xml');
    $this->getResponse()->setContent('<?xml version="1.0" encoding="UTF-8"?><taconite></taconite>');
    return sfView::NONE;
  }

  public function executeCrawlerIEEE(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('text/xml');
    $this->getResponse()->setContent($content);
    return sfView::NONE;

    $search_string = str_replace(array("\r", "\n"), '',$request->getParameter("search_string"));
    //http://ieeexplore.ieee.org/search/searchresult.jsp?action=search&sortType=&rowsPerPage=10000000&matchBoolean=true&searchField=Search_All&queryText=
    $ch = curl_init("http://ieeexplore.ieee.org/search/searchresult.jsp?newsearch=true&rowsPerPage=10000000&queryText=".urlencode($search_string));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content = curl_exec($ch);
    $error = curl_error($ch);
    $baseContent = "";
    curl_close($ch);
    $ids = explode("value='' id='", $content);
    $idList="0";
    foreach ($ids as $id)
    {
      if(!strpos($id,"'/>"))continue;
        $id = explode("'/>",$id);
        $idList = $idList . ',' . $id[0] ;
    }

    //echo "http://ieeexplore.ieee.org/xpl/downloadCitations?recordIds=". $idList ."&citations-format=citation-abstract&download-format=download-bibtex";
    $ch = curl_init("http://ieeexplore.ieee.org/xpl/downloadCitations?recordIds=". $idList ."&citations-format=citation-abstract&download-format=download-bibtex");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $request->getParameterHolder()->add(array('bibtex' => $content));

    $this->executeSaveBibtex($request);
  }

  public function executeCrawlerSpringer(sfWebRequest $request)
  {
    set_time_limit(0);
    $search_string = str_replace(array("\r", "\n"), '', $request->getParameter("search_string"));
    //$search_string = null;
    $ch = curl_init('http://link.springer.com/search/csv?query=' . urlencode($search_string));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content = curl_exec($ch);
    $error = curl_error($ch);

    $lines = explode("\n", $content);
    if(count($lines) > 0)
    {
      unset($lines[0]);
      $datalist = array();
      foreach($lines as $line)
      {
        $values = str_getcsv($line, ',');
        $authors = array();
        foreach(explode(',', $values[SpringerParameters::AUTHORS]) as $ar) {
          $authors[] = array('name' => $ar);
        }
        $data['author'] = $authors;
        $data['title'] = $values[SpringerParameters::PUBLICATION_TITLE];
        $data['booktitle'] = $values[SpringerParameters::AUTHORS];
        $data['series'] = $values[SpringerParameters::SERIES];
        $data['year'] = $values[SpringerParameters::YEAR];
        $data['url'] = $values[SpringerParameters::URL];
        $data['doi'] = $values[SpringerParameters::DOI];
        $data['publisher'] = SpringerParameters::PUBLISHER;
        //$data['abstract'] = $values[SpringerParameters::ABSTRACT];
        $data['type'] = $values[SpringerParameters::TYPE];
        $datalist[] = $data;
      }
      $request->getParameterHolder()->add(array('datalist' => $datalist));
      $this->executeSaveBibtex($request);
    }
  }

  public function executeCrawlerIET(sfWebRequest $request)
  {
    set_time_limit(0);
    $search_string = str_replace(array("\r", "\n"), '',$request->getParameter("search_string"));

    $file_path = sfConfig::get('sf_app_cache_dir') . DIRECTORY_SEPARATOR . 'cookies.txt';
  //var_dump('http://digital-library.theiet.org/search?value1=' . urlencode($search_string) . '&option1=all&option2=contentType&pageSize=20&value2=&x=-1106&y=-77');die;

    $ch = curl_init('http://digital-library.theiet.org/search?value1=' . urlencode($search_string) . '&option1=all&option2=contentType&pageSize=20&value2=&x=-1106&y=-77');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.3',
      'Accept-Encoding:txt',
      'Accept-Language:en-US,en;q=0.8'
    ));

    curl_setopt($ch, CURLOPT_COOKIEJAR, $file_path);
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $ch = curl_init("http://digital-library.theiet.org/export?fmt=bib");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.3',
      'Accept-Encoding:gzip',
      'Accept-Language:en-US,en;q=0.8'
    ));

    curl_setopt($ch, CURLOPT_COOKIEFILE, $file_path);
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $request->getParameterHolder()->add(array('bibtex' => $content));

    $this->executeSaveBibtex($request);
  }

  public function executeSaveBibtex(sfWebRequest $request)
  {
    $this->review_id = $request->getParameter('review_id');
    $file = $request->getFiles('file');

    if ($request->hasParameter('datalist')) {
      $datalist = $request->getParameter('datalist');
    } else if ($request->hasParameter('bibtex')) {
      $cnts = $request->getParameter('bibtex');
    }
    else if (!empty($file)) {
      $cnts = strip_tags(file_get_contents($file['tmp_name']));
    }
    else if ($request->isXmlHttpRequest()) {
      $this->error = true;
      $this->getResponse()->setContentType('text/xml');
      $this->setLayout('taconite');
      return sfView::SUCCESS;
    }
    else {
      $this->getUser()->setFlash('bibtex_error', 'Erro ao salvar conteúdo do BibTex');
      $this->redirect($request->getReferer()); // retorna para onde veio
    }

    $cnts = @explode('@',$cnts);
    $this->success = array();
    $this->error = array();

    if(!empty($datalist))
      foreach($datalist as $data)
        if($this->saveBibtex(null, $data, "", $this->review_id)) {
          $this->success[] = $data["title"];
        } else {
          $this->error[] = $data["title"];
        }
    if(!empty($cnts))
      foreach($cnts as $cnt) {
        $cnt = '@' . $cnt;
        $bib = new Structures_BibTex();
        $bib->loadString(strip_tags($cnt));
        $bib->parse();
        foreach ($bib->data as $data) {
          if($this->saveBibtex($cnt, $data, "", $this->review_id)) {
            $this->success[] = $data["title"];
          } else {
            $this->error[] = $data["title"];
          }
        }
      };

    if ($request->isXmlHttpRequest()) {
      $this->getResponse()->setContentType('text/xml');
      $this->setLayout('taconite');
      $this->setTemplate('saveBibtex');
    }
    else {
      $this->getUser()->setFlash("bib_success", $this->success);
      $this->getUser()->setFlash("bib_error", $this->error);
      $this->redirect("@studies_identification?id=" . $this->review_id);
    }
  }

  public function saveBibtex($bib, $data, $studyUrl,$sys_id)
  {
    set_time_limit(0);

    $study = new Study();
    $sb = SearchBasePeer::retrieveByPK(2);
    $study->setSearchBase($sb);
    //$study->setPublicationDate($data["year"]);
    $study->setTitle(strip_tags($data["title"]));
    $study->setSystematicReviewId($sys_id);
    $study->setUrl($studyUrl);

    if (!empty($data['url'])) {
      $study->setUrl($data['url']);
    }
    else if (!empty($data['doi'])) {
      $study->setUrl(sprintf('http://dx.doi.org/%s', $data['doi']));
    }
    if(!empty($data["abstract"])) {
      $study->setStudyAbstract(strip_tags($data['abstract']));
    }

    $study->setBibtex($bib);
    $study->setCreatedBy($this->getUser()->getId());

    $db = Propel::getConnection();
    try {
      $db->beginTransaction();
      $study->save($db);
      $this->exportToSolr($data, $study->getId());
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      return false;
    }
    return true;


  }

  public function getBagOfWord($field, $studyId)
  {
    $url = sfConfig::get('app_solr_url_get_bagofword');
    $query = array(
      'q'    =>"id:{$studyId}",
      'wt'  =>'json',
      'facet'     => 'true',
      'facet.field'  => $field,
      'facet.mincount'  => 1
  );
    $queryEnd = '';
    if(!is_array($field)) $field = array($field);
    foreach($field as $f) $queryEnd .= '&facet.field=' . $f;

    $ch = curl_init($url . http_build_query($query) . $queryEnd);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content = json_decode(curl_exec($ch));
    $error = curl_error($ch);
    curl_close($ch);

    $bagofword = array();
    if(isset($content->facet_counts))
    {
      foreach($field as $f)
      {
        $rs = $content->facet_counts->facet_fields->$f;
        for($j = 0; $j < count($rs); $j +=2)
        {
          @$bagofword[$rs[$j]] += $rs[$j+1];
        }
      }
    }
    return $bagofword;
  }

  public function compareStudy($field, $word, $studiesIds)
  {
    $ids = array();
    foreach($studiesIds as $id)
    {
      $ids[] = "id:{$id}";
    }
    if(!is_array($field)) $field = array($field);
    if(!is_array($word)) $word = array($word);

    $values = array();
  foreach($field as $f) {
      $values[] = "{$f}:" . implode($word, '~ ') . '~';
    }
    $fieldsQuery = '(' . implode($values, ' OR ') . ')';

    $url = sfConfig::get('app_solr_url_get_bagofword');
    $query = array(
        'q'    =>"{$fieldsQuery}",
        'wt'  =>'json',
        'fl'  =>'id,score',
        'fq'  =>implode($ids , ' OR '),
        'rows'  =>count($studiesIds)
        );

    $ch = curl_init($url . http_build_query($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $content = json_decode(curl_exec($ch));
    $error = curl_error($ch);
    curl_close($ch);

    $score = array();
    if(isset($content->response->docs))
    foreach($content->response->docs as $doc)
    {
      $score[$doc->id] = $doc->score;
    }
    return $score;
  }
  public function exportToSolr($data, $studyId)
  {
    $fields = array();
    $fields['id'] = $studyId;

    foreach($data as $key => $value) {
      if(in_array($key, array('author', 'cited-by', 'cites'))) {
        $vs = array();
        foreach($value as $v) {
          $names = implode(',', $v);
          $vs[] = str_replace(",,", ",", $names);
        }
        $fields[$key] = $vs;
      }
      else
        $fields[$key] = $value;
    }
    $fields = array_intersect_key($fields, array_flip(sfConfig::get('app_solr_fields')));

    $json = json_encode(array('add' => array('doc' => $fields)));

    $ch = curl_init(sfConfig::get('app_solr_url_add'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type:application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    $content = json_decode(curl_exec($ch));
    $error = curl_error($ch);
    curl_close($ch);

    //var_dump(sfConfig::get('app_solr_fields'), $fields, $content);die;
    return true; //$content->responseHeader->status == 200 || $content->responseHeader->status == 0;
  }
}

/*****
*  Converte os CSVs gerados pela Springer e IEEEXplore para
*  formato bib.
*
*  Arivan Bastos 2013
*  arivanbastos@gmail.com
*
******/
class SpringerParameters
{
  const PUBLISHER = "Springer";

  // 0-indexed
  const FIRST_DATA_LINE = 1;

  const TITLE = 0;
  const PUBLICATION_TITLE = 1;
  const SERIES = 2;
  const DOI = 5;
  const AUTHORS = 6;
  const YEAR = 7;
  const URL = 8;
  const TYPE = 9;

  // Springer não inclui o abstract no CSV.
  const ABSTRACT_ = -1;
}