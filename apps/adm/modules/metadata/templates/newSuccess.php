<div class="content">
  <?php if ($sf_user->hasCredential('systematic')) : ?>
  	<h1><?php echo __('Novo Metadado') ?></h1>
  
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
    <h2><?php echo __('Ações') ?></h2>
      <?php echo link_to(image_tag('ico16/btprev') . 'retornar à lista', 'metadata/index') ?>
  </div>
</div>
