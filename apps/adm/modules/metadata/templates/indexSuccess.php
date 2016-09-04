<div class="content">
<?php if ($sf_user->hasCredential('systematic')) : ?>
	<?php include '_list.php'; ?>
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
	    <?php echo link_to(image_tag('ico16/add') . 'criar um novo metadado', 'metadata/new') ?>
	  </div>
  <div id="search" class="block">
    <form action="<?php echo url_for('metadata/index') ?>" method="post">
      <h2><?php echo __('Localizar') ?></h2>
      <div class="rowElem">
      <label for="name">
        <span><?php echo __('Título') ?></span>
        <input type="text" name="name" id="name" size="16" />
      </label>
      </div>
      <br class="clear" />
      <?php echo button_tag(__('Localizar '). image_tag('ico16/btnext')) ?>
    </form>
  </div>
</div>
<script type="text/javascript">
	$(".rowElem").jqTransform();

		$( "#name" ).autocomplete({
			source: availableTags
		});
</script>