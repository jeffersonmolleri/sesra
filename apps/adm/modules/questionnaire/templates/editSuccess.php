<?php ob_start();?>
<ul class="dropdown-menu">  
  <li><a href="http://en.wikipedia.org/wiki/Cohen's_kappa" target="_blank"><i class="icon-external-link"></i> <?php echo __('Coeficientes estatísticos de Cohen Kappa para auxiliar na resolução <br />dos conflitos na seleção de estudos') ?></a></li>
  <li class="divider"></li>
  <li><a href="http://www.sciencedirect.com/science/article/pii/S0950584910001527" target="_blank"><i class="icon-external-link"></i> Barriers in the selection of offshore software development outsourcing <br />vendors: An exploratory study using a systematic literature review<br /> - Khan, Niazi e Ahmadd (2011)</a></li>  
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('review_id' => $review_id));
?>

<div class="row-fluid">
  <div class="span12">
  <?php if ($sf_user->hasCredential('systematic')) : ?>
    <h2><?php echo __('Editando Questionário de Avaliação dos Estudos') ?></h2>
  
  	<?php include '_form.php' ?>
  <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
  <?php endif; ?>
	</div>
</div>