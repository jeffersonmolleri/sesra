<div class="row-fluid">
  <div class="span9">
  <?php if ($sf_user->hasCredential('users')) : ?>
    <?php include '_list.php'; ?>
  <?php else : ?>
  	<h1><?php echo __('Acesso Restrito') ?></h1>
  	<?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.
  	<br />
  	<?php echo __('Entre em contato com o administrador do sistema') ?>.
  <?php endif; ?>
  </div>
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0; margin-top: 80px;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li><?php echo link_to('<i class="icon-user"></i> '.__('novo usuário'), 'users/new', 'class=') ?></li>
        <!--<li class="nav-header">Filtros</li>
        <li class=""><a name=""><strong><i class="icon-ok-sign"></i> <?php //echo __('Ativos') ?></strong></a></li>
        <li class=""><a name=""><strong><i class="icon-remove-sign"></i> <?php //echo __('Inativos') ?></strong></a></li>-->
        <?php if ($sf_user->hasCredential('users')) : ?>
        <li class="divider"></li>
        <li>
          <form action="<?php echo url_for('users/index') ?>" class="element input-append" method="post">
            <input type="text" name="name" id="name" placeholder="<?php echo __('Pesquisar') ?>" class="span8" />
            <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
          </form>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(".rowElem").jqTransform();

	var availableTags = [
		                 	<?php foreach ($usuarios as $x => $usuario) : ?>
		                 		<?php if ($x+1 == $count_users) : ?>
		                 			<?php echo "'{$usuario}'"; ?>
		                 		<?php else : ?>
		                 			<?php echo "'{$usuario}',"; ?>
		                 		<?php endif; ?>
		                 	<?php endforeach; ?>
		         		];

		$( "#name" ).autocomplete({
			source: availableTags
		});
</script>