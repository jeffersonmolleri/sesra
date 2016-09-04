<?php use_helper('Object', 'Date', 'sfAsset', 'myWidgets') ?>
<form action="<?php echo url_for('@sf_asset_library_update') ?>" method="post">

<fieldset id="sf_fieldset_none" class="">

  <div class="form-row">
    <label for="sf_asset_filepath"><?php echo __('Path:', null, 'sfAsset') ?></label>
    <div class="content">
    <?php if (!$sf_asset->isNew()): ?>
      <?php echo assets_library_breadcrumb($sf_asset->getRelativePath(), 0) ?>
    <?php endif ?>
    </div>
  </div>

</fieldset>

<fieldset id="sf_fieldset_meta" class="">
  <h2><?php echo __('Metadata', null, 'sfAsset') ?></h2>
  <?php echo $form ?>
</fieldset>

<?php include_partial('edit_actions', array('sf_asset' => $sf_asset)) ?>

</form>


<?php /*echo form_tag('sfAsset/save', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
)) ?>

<?php echo object_input_hidden_tag($sf_asset, 'getId') ?>

<?php echo label_for('sf_asset[filepath]', __('Path:', null, 'sfAsset'), '') ?>
<div class="<?php if ($sf_request->hasError('sf_asset{filepath}')): ?>form-error<?php endif; ?>">
<?php if (!$sf_asset->isNew()): ?>
  <?php echo assets_library_breadcrumb($sf_asset->getRelativePath(), 0);?>
<?php endif; ?>
</div>

<fieldset id="sf_fieldset_meta" class="">

  <legend><?php echo __('Metadata', null, 'sfAsset') ?></legend>

  <label>
    <span class="<?php if ($sf_request->hasError('sf_asset{description}')): ?>form-error<?php endif; ?>">
    <?php echo __('Description:', null, 'sfAsset') ?><br/>
    <?php if ($sf_request->hasError('sf_asset{description}')): ?>
      <?php echo form_error('sf_asset{description}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    </span>
    <?php echo object_textarea_tag($sf_asset, 'getDescription', array(
      'size' => '40x3',
      'control_name' => 'sf_asset[description]',
    )) ?>
  </label>
  <br/>
  <label>
    <span class="<?php if ($sf_request->hasError('sf_asset{author}')): ?>form-error<?php endif; ?>">
      <?php echo __('Author:', null, 'sfAsset') ?>
      <?php if ($sf_request->hasError('sf_asset{author}')): ?>
        <br/>
        <?php echo form_error('sf_asset{author}', array('class' => 'form-error-msg')) ?>
      <?php endif; ?>
    </span>
    <?php echo object_input_tag($sf_asset, 'getAuthor', array(
      'size' => 40,
      'control_name' => 'sf_asset[author]',
    )) ?>
  </label>

  <label>
    <span class="<?php if ($sf_request->hasError('sf_asset{copyright}')): ?>form-error<?php endif; ?>">
      <?php echo __('Copyright:', null, 'sfAsset') ?>
      <?php if ($sf_request->hasError('sf_asset{copyright}')): ?>
        <?php echo form_error('sf_asset{copyright}', array('class' => 'form-error-msg')) ?>
      <?php endif; ?>
    </span>

    <?php echo object_input_tag($sf_asset, 'getCopyright', array(
    'size' => 40,
    'control_name' => 'sf_asset[copyright]',
    )) ?>
  </label>

  <label>
    <span class="<?php if ($sf_request->hasError('sf_asset{type}')): ?>form-error<?php endif; ?>">
      <?php echo __('Type:', null, 'sfAsset') ?>
      <?php if ($sf_request->hasError('sf_asset{type}')): ?>
        <br/>
        <?php echo form_error('sf_asset{type}', array('class' => 'form-error-msg')) ?>
      <?php endif; ?>
    </span>
    <?php foreach (sfConfig::get('app_sfAssetsLibrary_types', array('image', 'txt', 'archive', 'pdf', 'xls', 'doc', 'ppt')) as $type): ?>
      <?php $options[$type] = $type; ?>
    <?php endforeach; ?>
    <?php echo select_tag('sf_asset[type]', options_for_select($options, $sf_asset->getType())) ?>
  </label>

  <?php include_partial('sfAsset/edit_form_custom', array('sf_asset' => $sf_asset)) ?>

</fieldset>

<?php //include_partial('edit_actions', array('sf_asset' => $sf_asset)) ?>
<hr/><br/>

<?php echo save_edit_controls($sf_asset, '', array ('sf_asset_dir' => url_for('@sf_asset_library_dir?dir=media') . $sf_asset->getPath()))*/ ?>

<!-- </form> -->