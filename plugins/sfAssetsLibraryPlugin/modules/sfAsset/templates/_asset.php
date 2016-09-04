<?php use_helper('sfAsset') ?>
<div class="assetImage">
  <div class="thumbnails">
    <?php echo link_to_asset_action(asset_image_tag($sf_asset, 'small', array('style'=>'width: 100%; height: 100%;'), isset($folder) ? $folder->getRelativePath() : null), $sf_asset) ?>
  </div>

  <?php if (!isset($is_search)) : ?>
  <div class="assetComment">
    <?php echo auto_wrap_text($sf_asset->getFilename()) ?>
    <div class="details">
      <?php echo $sf_asset->getFilesize() ?> Kb
      <?php if (!$sf_user->hasAttribute('popup', 'sf_admin/sf_asset/navigation')): ?>
        	<?php echo link_to(image_tag('/sfAssetsLibraryPlugin/images/delete.png', 'class=deleteImage align=top'), 'sfAsset/deleteAsset?id='.$sf_asset->getId(), array('title' => __('Delete', null, 'sfAsset'), 'confirm' => __('Are you sure?', null, 'sfAsset'))); ?>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
</div>
