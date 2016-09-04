<?php include_component('systematic_review', 'submenu', array ('review_id' => $review_id)); ?>

<div class="rows-fuild">
  <div class="span9">
    <?php if ($sf_user->hasCredential('systematic')) : ?>
      <!--  <h1><?php echo __('Editando Estudo Primário') ?></h1>  -->
      <?php include '_form.php' ?>
    <?php else : ?>
      <h1><?php echo __('Acesso Restrito') ?></h1>
      <?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
      <br />
      <?php echo __('Entre em contato com o administrador do sistema') ?>.
    <?php endif; ?>
  </div>
  
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li><a href="<?php echo url_for('@studies_identification?id=' . $review_id)?>"><i class="icon-chevron-left"></i> <?php echo __('voltar a listagem') ?></a></li>
      </ul>
    </div>
  </div>
</div>