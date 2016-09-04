<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N', 'Date')?>
<div class="content">
	<h1><?php echo __('Asset edition', null, 'sfAsset') ?></h1>
	
	<?php include_partial('sfAsset/edit_header', array('sf_asset' => $sfAsset)) ?>
	
	<div id="sf_asset_container">
	  <?php include_partial('sfAsset/messages', array('sf_asset' => $sfAsset)) ?>
	  <?php include_partial('sfAsset/edit_form', array('sf_asset' => $sfAsset, 'form' => $form)) ?>
	</div>
	
	<?php include_partial('sfAsset/edit_footer', array('sf_asset' => $sfAsset)) ?>
</div>

<div id="side">
  <div id="sf_asset_bar" class="block details">
    <h2>Detalhes</h2>
    <?php include_partial('sfAsset/sidebar_edit', array('sf_asset' => $sfAsset, 'renameform' => $renameform, 'moveform' => $moveform, 'replaceform' => $replaceform)) ?>
 </div>
</div>
<?php /*use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N', 'Date')?>
<div class="content">
  <h1><?php echo __('Asset edition', null, 'sfAsset') ?></h1>
  
  <?php include_partial('sfAsset/edit_header', array('sf_asset' => $sf_asset)) ?>
  
  <div id="sf_asset_container">
    <?php include_partial('sfAsset/messages', array('sf_asset' => $sf_asset)) ?>
    <?php include_partial('sfAsset/edit_form', array('sf_asset' => $sf_asset)) ?>
  </div>
  
  <?php include_partial('sfAsset/edit_footer', array('sf_asset' => $sf_asset)) ?>
</div>

<div id="side">
  <div id="sf_asset_bar" class="block details">
    <h2>Detalhes</h2>
    <?php include_partial('sfAsset/sidebar_edit', array('sf_asset' => $sf_asset))*/ ?>
 </div>
</div>
