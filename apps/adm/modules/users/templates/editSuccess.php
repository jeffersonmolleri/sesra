<?php $user = $form->getObject() ?>
<!-- <ul class="breadcrumb">
  <li><?php //echo link_to('ARS','/index'); ?> <span class="divider">/</span></li>
  <li><?php //echo link_to(__('Usuários'),'users/index'); ?> <span class="divider">/</span></li>
  <li class="active"><?php echo $user->getProfile()->getFirstName() ?></li>
</ul> -->

<h1><?php echo __('Editando Usuário') ?>: <?php echo $user->getProfile()->getFirstName() ?></h1>
<?php if ($sf_user->hasCredential('users') || $id == $sf_user->getId()) : ?>

<div class="rows">
  <div class="span9">
    <?php include '_form.php' ?>
    <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
    <?php endif; ?>
  </div>

  <!--<div id="span4">
    <h2>Ações</h2>
    <?php //echo link_to('<i class="icon-circle-arrow-left"></i> <?php echo __('retornar à lista') ?>', 'users/index', 'class=btn') ?>
  </div>-->
</div>