<?php use_helper('JavascriptBase', 'sfAsset', 'myWidgets', 'Form') ?>
<?php use_javascript('/sfAssetsLibraryPlugin/js/util') ?>

<?php if ($folder->isRoot()): ?>
	<div class="form-row">
	  <?php echo link_to(image_tag('/sfAssetsLibraryPlugin/images/images.png', 'align=top') . __('Mass upload', null, 'sfAsset'), 'sfAsset/massUpload') ?>
	</div>
<?php endif ?>

<form id="addquick" action="<?php echo url_for('@sf_asset_library_add_quick') ?>" enctype="multipart/form-data" method="post">
  <div class="form-row">
    <label for="new_file">
      <?php echo link_to_function(image_tag('/sfAssetsLibraryPlugin/images/image_add.png', 'align=top') . __('Upload a file here', null, 'sfAsset'), 'document.getElementById("input_new_file").style.display="block"') ?>
    </label>
    <span class="sideContent" id="input_new_file" style="display:none">
      <input type="hidden" name="is_popup" value="<?php echo $sf_request->getParameter('popup'); ?>" />
      <?php echo $fileform->renderHiddenFields() ?>
      <?php echo $fileform['file'] ?>
      <input type="submit" value="<?php echo __('Add', null, 'sfAsset') ?>" />
    </span>
  </div>
</form>

<form method="post" action="<?php echo url_for('@sf_asset_library_create_folder') ?>">
<div class="form-row">
  <label for="new_directory">
    <?php echo link_to_function(image_tag('/sfAssetsLibraryPlugin/images/folder_add.png', 'align=top') . __('Add a subfolder', null, 'sfAsset'), 'document.getElementById("input_new_directory").style.display="block"') ?>
  </label>
  <div class="sideContent" id="input_new_directory" style="display:none">
    <?php echo $folderform->renderHiddenFields() ?>
    <?php echo $folderform['name'] ?>
      <input type="submit" value="<?php echo __('Create', null, 'sfAsset') ?>" />
  </div>
</div>
</form>

<?php if (!$folder->isRoot()): ?>
<form method="post" action="<?php echo url_for('@sf_asset_library_rename_folder') ?>">
    <div class="form-row">
      <label for="new_folder">
        <?php echo link_to_function(image_tag('/sfAssetsLibraryPlugin/images/folder_edit.png', 'align=top') . __('Rename folder', null, 'sfAsset'), 'document.getElementById("input_new_name").style.display="block";document.getElementById("new_name").focus()') ?>
      </label>
      <div class="sideContent" id="input_new_name" style="display:none">
        <?php echo $renameform->renderHiddenFields() ?>
        <?php echo $renameform['name'] ?>
        <input type="submit" value="<?php echo __('Rename', null, 'sfAsset') ?>" />
      </div>
    </div>
</form>

<form method="post" action="<?php echo url_for('@sf_asset_library_move_folder') ?>">
    <div class="form-row">
      <label for="new_folder">
        <?php echo link_to_function(image_tag('/sfAssetsLibraryPlugin/images/folder_go.png', 'align=top') . __('Move folder', null, 'sfAsset'), 'document.getElementById("input_move_folder").style.display="block"') ?>
      </label>
      <div class="sideContent" id="input_move_folder" style="display:none">
        <?php echo $moveform->renderHiddenFields() ?>
        <?php echo $moveform['parent_folder'] ?>
        <input type="submit" value="<?php echo __('Move', null, 'sfAsset') ?>" />
      </div>
    </div>
</form>

<div class="form-row">
    <?php echo link_to(image_tag('/sfAssetsLibraryPlugin/images/folder_delete.png', 'align=top') . __('Delete folder', null, 'sfAsset'), '@sf_asset_library_delete_folder?id='.$folder->getId(), array(
      'method'  => 'delete',
      'confirm' => __('Are you sure?', null, 'sfAsset'),
      'post' => true,
    )) ?>
  </div>
<?php endif ?>