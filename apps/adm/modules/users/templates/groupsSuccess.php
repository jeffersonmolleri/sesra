<?php include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id)); ?>
<div class="content">
<?php if ($sf_user->hasCredential('users')) : ?>
	<?php include '_group_list.php'; ?>
<?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
<?php endif; ?>
</div>

<div id="side">
  <?php if ($sf_user->hasCredential('users')) : ?>
	  <div class="block" id="actions">
	    <h2><?php echo __('Ações') ?></h2>
	    <?php echo link_to(image_tag('ico16/add') . __('criar um grupo'), '@new_group') ?>
	  </div>
  <?php endif; ?>
  <?php if ($sf_user->hasCredential('users')) : ?>
  <div id="search" class="block">
    <form action="<?php echo url_for('users/groups') ?>" method="post">
      <h2><?php echo __('Localizar') ?></h2>
      <div class="rowElem">
      <label for="name">
        <span><?php echo __('Nome') ?></span>
        <input type="text" name="name" id="name" size="16" />
      </label>
      </div>
      <br class="clear" />
      <?php echo button_tag(__('Localizar '). image_tag('ico16/btnext')) ?>
    </form>
  </div>
  <div class="block" id="filters">
    <h2><?php echo __('Legenda') ?></h2>
    <?php echo image_tag('ico16/tick') ?> <?php echo __('Ativos') ?>
    <br /><br />
    <?php echo image_tag('ico16/cross') ?> <?php echo __('Inativos') ?>
  </div>
  <?php endif; ?>
</div>
<script type="text/javascript">
	$(".rowElem").jqTransform();

	var availableTags = [
		                 	<?php foreach ($grupos as $x => $grupo) : ?>
		                 		<?php if ($x+1 == $count_groups) : ?>
		                 			<?php echo "'{$grupo}'"; ?>
		                 		<?php else : ?>
		                 			<?php echo "'{$grupo}',"; ?>
		                 		<?php endif; ?>
		                 	<?php endforeach; ?>
		         		];
		
		$( "#name" ).autocomplete({
			source: availableTags
		});
</script>