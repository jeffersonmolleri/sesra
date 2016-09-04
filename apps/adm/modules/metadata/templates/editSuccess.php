<?php include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id)); ?>
<div class="content">
  <?php if ($sf_user->hasCredential('systematic')) : ?>
  	<h1><?php echo __('Editando Revisão Sistemática') ?>: <?php echo $form->getObject()->getTitle(); ?></h1>
  
  	<?php include '_form.php' ?>
  <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
  <?php endif; ?>
</div>

<div id="side">
  <div class="block" id="actions">
    <h2>Ações</h2>
      <?php echo link_to(image_tag('ico16/add') . __('incluir nova revisão sistemática'), 'systematic_review/new') ?>
      <?php echo link_to(image_tag('ico16/btprev') . __('retornar à lista'), 'systematic_review/index') ?>
  </div>
</div>

