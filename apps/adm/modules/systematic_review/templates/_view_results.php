<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

  <h1><?php echo $review->getTitle() ?></h1>

  <p class="author">
  <?php end($systematic_users); $last = key($systematic_users); ?>
  <?php foreach($systematic_users as $i => $user) : ?>
    <?php echo ($i != $last)?$user->getsfGuardUser()->getProfile()->getName().', ':$user->getsfGuardUser()->getProfile()->getName(); ?>
  <?php endforeach;?>
  </p>
  
  <h2><?php echo __('Resumo') ?> <a href="#" role="button" class="btn btn-mini" data-target="abstract" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><strong><?php echo __('Contexto') ?>:</strong> <?php echo __('The importance of the research questions addressed by the review') ?>.<br />
    <strong><?php echo __('Objetivos') ?>:</strong> <?php echo __('The questions addressed by the systematic review') ?>.<br />
    <strong><?php echo __('Métodos') ?>:</strong> <?php echo __('Data Sources, Study selection, Quality Assessment and Data extraction') ?>.<br />
    <strong><?php echo __('Resultados') ?>:</strong> <?php echo __('Main finding including any meta-analysis results and sensitivity analyses') ?>.<br />
    <strong><?php echo __('Conclusões') ?>:</strong> <?php echo __('Implications for practice and future research') ?>.
  </p>

  <h2><?php echo __('Objeto do Estudo') ?> <a href="#" role="button" class="btn btn-mini" data-target="objective" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $protocol->getObjective(); ?></p>
  <p><?php echo __('Este relatório foi desenvolvido de acordo com as orientações para a realização ou comissionamento de revisões sistemática da literatura sobre eficácia de Khan <em>et al.</em> (2001)') ?>.</p>

  <h2><?php echo __('Questões de Pesquisa') ?> <a href="#" role="button" class="btn btn-mini" data-target="researchquestion" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo __('As questões de pesquisa a serem abordadas por este estudo são') ?>:</p>
  <ul>
    <li><strong><?php echo __('População') ?>:</strong> <?php echo $protocol->getPopulation(); ?></li>
    <li><strong><?php echo __('Intervenção') ?>:</strong> <?php echo $protocol->getIntervention(); ?></li>
    <li><strong><?php echo __('Comparação') ?>:</strong> <?php echo $protocol->getComparative(); ?></li>
    <li><strong><?php echo __('Resultados') ?>:</strong> <?php echo $protocol->getOutcome(); ?></li>
    <li><strong><?php echo __('Contexto') ?>:</strong> <?php echo $protocol->getContext(); ?></li>
  </ul>

  <h2><?php echo __('Metodologia') ?> <a href="#" role="button" class="btn btn-mini" data-target="metodology" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $protocol->getMetodology(); ?></p>

  <h3><?php echo __('Processo de Busca') ?> <a href="#" role="button" class="btn btn-mini" data-target="researchprocess" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo __('O processo de busca inclui pesquisas manual e automatizada em fontes de pesquisa mostradas na tabela a seguir') ?>:</p>

  <h4><?php echo __('Fontes de Pesquisa') ?></h4>
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

  <h3><?php echo __('Processo de Seleção de Estudos Primários') ?> <a href="#" role="button" class="btn btn-mini" data-target="selectionprocess" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo __('Os resultados foram tabulados como se segue') ?>:</p>
  <ul>
    <?php foreach($metadata as $m) { echo '<li>'.$m->getName().'</li>'; } ?>
  </ul>
  
  <h3><?php echo __('Avaliação Qualitativa') ?> <a href="#" role="button" class="btn btn-mini" data-target="assessment" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $protocol->getAssessment(); ?></p>

  <h3><?php echo __('Extração dos Dados') ?> <a href="#" role="button" class="btn btn-mini" data-target="data_extraction" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $protocol->getDataExtraction(); ?></p>

  <h3><?php echo __('Síntese dos Dados') ?> <a href="#" role="button" class="btn btn-mini" data-target="data_analisys" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $protocol->getDataAnalisys(); ?></p>
  
  <!-- -->
  
  <h2><?php echo __('Estudos Incluídos e Excluídos') ?> <a href="#" role="button" class="btn btn-mini" data-target="include_exclude_criteria" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  
  <h3><?php echo __('Critérios de Inclusão') ?></h3>
  <p><?php echo __('Artigos nos seguintes tópicos de pesquisa foram incluídos') ?>:</p>
  <ul>
    <?php foreach($criteria as $c) { if($c->getType()) { echo '<li>'.$c->getName().'</li>'; } } ?>
  </ul>

  <h3><?php echo __('Critérios de Exclusão') ?></h3>
  <p><?php echo __('Artigos nos seguintes tópicos de pesquisa foram excluídos') ?>:</p>
  <ul>
    <?php foreach($criteria as $c) { if($c->getType() == false) { echo '<li>'.$c->getName().'</li>'; } } ?>
  </ul>
  
  <?php if($result): ?>
  
  <h3><?php echo __('Síntese dos Dados') ?> <a href="#" role="button" class="btn btn-mini" data-target="data_sintesys" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $result->getDataSintesys(); ?></p>
  
  <h3><?php echo __('Descrição dos Estudos') ?> <a href="#" role="button" class="btn btn-mini" data-target="class_description" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $result->getClassDescription(); ?></p>
  
  <h3><?php echo __('Meta-síntese') ?> <a href="#" role="button" class="btn btn-mini" data-target="meta_sintesys" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $result->getMetaSintesys(); ?></p>
  
  
  <h2><?php echo __('Resultados Obtidos') ?> <a href="#" role="button" class="btn btn-mini" data-target="results" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $result->getResults(); ?></p>
  
  <h2><?php echo __('Discussões') ?> <a href="#" role="button" class="btn btn-mini" data-target="discussions" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $result->getDiscussions(); ?></p>
  
  <h2><?php echo __('Conclusões') ?> <a href="#" role="button" class="btn btn-mini" data-target="conclusions" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $result->getConclusions(); ?></p>
  
  <?php if($result->getPracticeImplications()): ?>
  <h3><?php echo __('Implicações para a prática') ?> <a href="#" role="button" class="btn btn-mini" data-target="practice_implications" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $result->getPracticeImplications(); ?></p>
  <?php endif; ?>
  
  <?php if($result->getSearchImplications()): ?>
  <h3><?php echo __('Implicações para a pesquisa') ?> <a href="#" role="button" class="btn btn-mini" data-target="search_implications" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h3>
  <p><?php echo $result->getSearchImplications(); ?></p>
  <?php endif; ?>
  
  <?php if($result->getAppointments()): ?>
  <h2><?php echo __('Reconhecimentos') ?> <a href="#" role="button" class="btn btn-mini" data-target="appointments" data-context="addanotacao"><i class="icon-comment"></i> <?php echo __('comentar') ?></a></h2>
  <p><?php echo $result->getAppointments(); ?></p>
  <?php endif; ?>
  
  <?php endif; ?>

  <h2><?php echo __('Referências') ?></h2>
  <p>Khan, Khalid, S., ter Riet, Gerben., Glanville, Julia., Sowden, Amanda, J. and Kleijnen, Jo. (eds) Undertaking Systematic Review of Research on Effectiveness. CRD’s Guidance for those Carrying Out or Commissioning Reviews. CRD Report Number 4 (2nd Edition), NHS Centre for Reviews and Dissemination, University of York, IBSN 1 900640 20 1, March 2001.</p>