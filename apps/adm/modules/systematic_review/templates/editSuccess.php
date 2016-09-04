<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://www.cebma.org/frequently-asked-questions/what-is-a-picoc/" target="_blank"><i class="icon-external-link"></i> What is a PICOC?<br />- CEBMa, Center for Evidence Based Management</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id));
?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="row-fluid">
    <div class="span12">
      <h2><?php echo __('Editando Revisão Sistemática') ?><?php //echo $form->getObject()->getTitle(); ?></h2>
      <?php $requester='edit' ?>
      <?php include '_form.php' ?>
    </div>
  </div>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>

<?php //include '_sidebar.php' ?>
