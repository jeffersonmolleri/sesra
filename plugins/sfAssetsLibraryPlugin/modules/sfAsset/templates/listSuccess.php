<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N')?>

<div class="content">
<?php if ($sf_user->hasCredential('assets')) : ?>
	<h1><?php echo __('Asset Library', null, 'sfAsset') ?></h1>

	<?php if (!$sf_user->hasAttribute('popup','sf_admin/sf_asset/navigation')) : ?>
	  <?php include_partial('list_header', array('folder' => $folder)) ?>
	<?php endif ?>
	
	<div id="sf_asset_container">
	  <?php include_partial('sfAsset/messages') ?>
	  <?php include_partial('sfAsset/list', array(
	    'folder' => $folder,
	    'dirs'   => $dirs,
	    'files'  => $files
	  )) ?>
	</div>
	
	<?php if (!$sf_user->hasAttribute('popup','sf_admin/sf_asset/navigation')) : ?>
	  <?php include_partial('sfAsset/list_footer', array('folder' => $folder)) ?>
	<?php endif ?>
<?php else : ?>
	<h1>Acesso Restrito</h1>
  	Você não tem as permissões necessárias para acessar este local.
  	<br />
  	Entre em contato com o administrador do sistema.
<?php endif; ?>
</div>
<?php if ($sf_user->hasCredential('assets')) : ?>
	<div id="side">
		  <div id="actions" class="block">
			<h2>Ações</h2>
				<?php include_partial('sfAsset/sidebar_list', array('folder' => $folder, 'fileform' => $fileform, 'folderform' => $folderform, 'renameform' => $renameform, 'moveform' => $moveform)) ?>
				<?php include_partial('sfAsset/sidebar_search', array('form' => $filterform)) ?>
		  </div>
	  <?php include_partial('sfAsset/sidebar_sort') ?>
	  <p><?php echo $folder->getName() ?></p>
	  <?php if ($nbDirs || $nbFiles): ?>
	    <?php if ($nbDirs): ?>
	        <p><?php echo format_number_choice('[1]Uma subpasta|(1,+Inf]%nb% pastas', array('%nb%' => $nbDirs), $nbDirs, 'sfAsset') ?></p>
	    <?php endif ?>
	    <?php if ($nbFiles): ?>
	        <p><?php echo format_number_choice('[1]Um arquivo, %weight% Kb|(1,+Inf]%nb% arquivos, %weight% Kb', array('%nb%' => $nbFiles, '%weight%' => $totalSize), $nbFiles, 'sfAsset') ?></p>
	    <?php endif ?>
	  <?php endif ?>
	</div>
<?php endif; ?>