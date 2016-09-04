<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>


<?php $culture = sfContext::getInstance()->getUser()->getCulture(); ?>
<?php $data_format = ($culture == 'en') ? 'yyyy-MM-dd' : 'dd/MM/yyyy' ; ?>

  <h1><?php echo $review->getTitle() ?></h1>

  <p class="author">
  <?php end($systematic_users); $last = key($systematic_users); ?>
  <?php foreach($systematic_users as $i => $user) : ?>
    <?php echo ($i != $last)?$user->getsfGuardUser()->getProfile()->getName().', ':$user->getsfGuardUser()->getProfile()->getName(); ?>
  <?php endforeach;?>
  </p>

  <h2><?php echo __('Objeto do Estudo') ?> <a href="#" role="button" class="btn btn-mini" data-target="objective" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getObjective()); ?></p>
  <p><?php echo __('Este protocolo foi desenvolvido de acordo com as orientações para a realização de revisões sistemáticas da literatura em Engenharia de Software de Kitchenham (2007)') ?>.</p>

  <h2><?php echo __('Questões de Pesquisa') ?> <a href="#" role="button" class="btn btn-mini" data-target="researchquestion" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('A(s) questão(ões) de pesquisa a ser(em) abordadas por este estudo são') ?>:</p>
	<p><?php echo nl2br($review->getQuestion()); ?></p>
	<p><?php echo __('A especificação das questões de pesquisa através do acrônimo PICOC permite a fundamentação da string de busca') ?>:</p>
  <ul>
    <li><strong><?php echo __('População') ?>:</strong> <?php echo $protocol->getPopulation(); ?></li>
    <li><strong><?php echo __('Intervenção') ?>:</strong> <?php echo $protocol->getIntervention(); ?></li>
    <li><strong><?php echo __('Comparação') ?>:</strong> <?php echo $protocol->getComparative(); ?></li>
    <li><strong><?php echo __('Resultados') ?>:</strong> <?php echo $protocol->getOutcome(); ?></li>
    <li><strong><?php echo __('Contexto') ?>:</strong> <?php echo $protocol->getContext(); ?></li>
  </ul>

  <h2><?php echo __('Processo de Busca') ?> <a href="#" role="button" class="btn btn-mini" data-target="researchprocess" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('O processo de busca inclui pesquisas manual e automatizada em fontes de pesquisa mostradas na tabela a seguir') ?>:</p>

  <h3><?php echo __('Fontes de Pesquisa') ?></h3>
  <table border="1" class="Table1">
    <tr>
      <th width="50%"><?php echo __('Fonte') ?></th>
      <th width="50%"><?php echo __('Responsável') ?></th>
    </tr>
    <?php foreach($search_bases as $sb): ?>
    <?php if($sb->hasChecked($protocol->getId(), $review->getId())): ?>
    <tr>
      <td width="50%"><?php echo $sb->getName(); ?></td>
      <td width="50%"></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
  </table>

  <h2><?php echo __('Critérios de Inclusão') ?> <a href="#" role="button" class="btn btn-mini" data-target="includecriteria" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('Artigos nos seguintes tópicos de pesquisa serão incluídos') ?>:</p>
  <ul>
    <?php foreach($criteria as $c) { if($c->getType()) { echo '<li>'.$c->getName().'</li>'; } } ?>
  </ul>

  <h2><?php echo __('Critérios de Exclusão') ?> <a href="#" role="button" class="btn btn-mini" data-target="excludecriteria" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('Artigos nos seguintes tópicos de pesquisa serão excluídos') ?>:</p>
  <ul>
    <?php foreach($criteria as $c) { if($c->getType() == false) { echo '<li>'.$c->getName().'</li>'; } } ?>
  </ul>

  <h2><?php echo __('Processo de Seleção de Estudos Primários') ?> <a href="#" role="button" class="btn btn-mini" data-target="selectionprocess" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('Os resultados serão tabulados como se segue') ?>:</p>
  <ul>
    <?php foreach($metadata as $m) { echo '<li>'.$m->getName().'</li>'; } ?>
  </ul>

  <h2><?php echo __('Metodologia') ?> <a href="#" role="button" class="btn btn-mini" data-target="metodology" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getMetodology()); ?></p>
  <p><?php echo __('O cronograma do estudo inclui fases e estágios específicos realizadas de acordo com a tabela a seguir') ?>:</p>

  <h3><?php echo __('Cronograma do Estudo') ?> <a href="#" role="button" class="btn btn-mini" data-target="timetable" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
	
	<table border="1" cellspacing="0" cellpadding="2" class="Table1">
    <thead>
      <tr>
  	    <th><?php echo __('Fase / Etapa') ?></th>
  	    <th><?php echo __('Data') ?></th>
  	    <th><?php echo __('Responsável') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $root = 0; $child = 0; foreach($activities as $ac) : if ($ac->getActivityParent() == null) { $root++; $child = 0; } else { $child++; } $job = $ac->getCachedJobs(); ?>
      <tr>
        <td width="50%"><?php echo ($root + $child / 10), '. ', __($ac->getNamePt()); ?></td>
        <td width="25%"><?php !empty($job[0]) and print format_date($job[0]->getDate(), $data_format) ?></td>
        <td width="25%"><?php !empty($job[0]) and print $job[0]->getUserIdProfile()->getName(); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2><?php echo __('Avaliação Qualitativa') ?> <a href="#" role="button" class="btn btn-mini" data-target="assessment" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getAssessment()); ?></p>

  <h2><?php echo __('Extração dos Dados') ?> <a href="#" role="button" class="btn btn-mini" data-target="data_extraction" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getDataExtraction()); ?></p>

  <h2><?php echo __('Análise dos Dados') ?> <a href="#" role="button" class="btn btn-mini" data-target="data_analisys" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getDataAnalisys()); ?></p>

  <h2><?php echo __('Disseminação') ?> <a href="#" role="button" class="btn btn-mini" data-target="dissemination" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo nl2br($protocol->getDissemination()); ?></p>

  <h2><?php echo __('Referências') ?></h2>
  <p>Kitchenham, B. Guidelines for performing Systematic Literature Reviews in Software Engineering. v. 2.3, EBSE Technical Report, Keele University EBSE-2007-01, July 2007.</p>