<?php ob_start();?>
<ul class="dropdown-menu">
  <li class="divider"></li>
  <li><a href="http://www.york.ac.uk/inst/crd/pdf/Systematic_Reviews.pdf" target="_blank"><i class="icon-external-link"></i> CRD’s guidance for undertaking reviews in health care<br />- Khan <em>et al.</em>, 2001'</a></li>
  <li class="divider"></li>
  <li><a href="http://handbook.cochrane.org/" target="_blank"><i class="icon-external-link"></i> Cochrane Reviewers’ Handbook<br /> - Green, Higgins, 2011</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('review_id' => $review_id));
?>

<div class="row-fluid">
  <div class="span12">
	<?php if ($sf_user->hasCredential('systematic')) : ?>
    <h2><?php echo __('Novo Questionário de Avaliação dos Estudos') ?></h2>
    
    <p><?php echo __('Permite a utilização de uma lista com critérios de avaliação que devem ser respondidos, preferencialmente por valores booleanos. Desta forma, o estudo que obtiver uma quantidade maior de respostas verdadeiras, é mais significante frente a questão de pesquisa') ?>:</p>
    
    <?php include '_form.php' ?>
  <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
  <?php endif; ?>
  </div>
</div>