
<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://en.wikipedia.org/wiki/Cohen's_kappa" target="_blank"><i class="icon-external-link"></i> <?php echo __('Coeficientes estatísticos de Cohen Kappa para auxiliar na resolução <br />dos conflitos na seleção de estudos') ?></a></li>
  <li class="divider"></li>
  <li><a href="http://www.sciencedirect.com/science/article/pii/S0950584910001527" target="_blank"><i class="icon-external-link"></i> Barriers in the selection of offshore software development outsourcing <br />vendors: An exploratory study using a systematic literature review<br /> - Khan, Niazi e Ahmadd (2011)</a></li>  
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support'=>$support, 'review_id' => $review_id)); 
?>

<div class="rows">
  <div class="span9">
  <?php if ($sf_user->hasCredential('systematic')) : ?>
	<h2><?php echo __('Novo Estudo Primário') ?></h2>
  	<?php include '_form.php' ?>
  <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
  <?php endif; ?>
  </div>
  
  <div class="span3">
    <ul class="nav nav-list bs-docs-sidenav affix span3">
      <li class="active"><a name=""><strong><?php echo __('Ações') ?>:</strong></a></li>
      <li><a href="<?php echo url_for('@studies_identification?review_id=' . $id)?>"><i class="icon-file"></i> <?php echo __('voltar a listagem') ?></a></li>
    </ul>
  </div>
</div>