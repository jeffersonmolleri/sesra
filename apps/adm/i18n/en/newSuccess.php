<?php if ($sf_user->hasCredential('systematic')) : ?>
  <h2><?php echo __('Nova Revisão Sistemática') ?></h2>
  <?php $requester='new' ?>
  <?php include '_form.php' ?>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>