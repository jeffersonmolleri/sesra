<!-- <div class="form-row">
  <?php //echo image_tag('/sfAssetsLibraryPlugin/images/magnifier.png', 'alt=search align=top') ?>
  <?php //echo link_to(__('Search', null, 'sfAsset'), '@sf_asset_library_search', array('class' => 'toggle', 'rel' => '{ div: \'sf_asset_search_form\'}')) ?>
</div>

<div id="sf_asset_search_form" style="display:none">
  <form action="<?php //echo url_for('@sf_asset_library_search') ?>" method="get" id="sf_asset_search">

    <?php //echo $form ?>

    <ul class="sf_admin_actions">
      <li>
        <input type="submit" value="<?php //echo __('Search', null, 'sfAsset') ?>" name="search" class="sf_admin_action_filter" />
      </li>
    </ul>

  </form>
</div> 

<?php //use_helper('myWidgets') ?>
<div class="form-row">
  <a href="#" id="dosearch"><?php //echo image_tag('/sfAssetsLibraryPlugin/images/magnifier.png', 'align=top') . __('search', null, 'sfAsset') ?></a> 
</div>

<form method="get" id="sf_asset_search" style="display: none;" action="<?php //echo url_for('sfAsset/search') ?>">
  <label for="search_params_rel_path">
    <span><?php //echo __('Folder:', null, 'sfAsset') ?></span>
    <?php //echo select_tag('search_params[path]', '<option></option>'.options_for_select(sfAssetFolderPeer::getAllPaths(), isset($search_params['path']) ? $search_params['path'] : null)) ?>
  </label>
  <br/>
  <label for="search_params_name">
    <span><?php //echo __('Filename:', null, 'sfAsset') ?></span>
    <?php //echo input_tag('search_params[name]', isset($search_params['name']) ? $search_params['name'] : null, 'size=20') ?>
  </label>
  <br/>
  <label for="search_params_author">
    <span><?php //echo __('Author:', null, 'sfAsset') ?></span>
    <?php //echo input_tag('search_params[author]', isset($search_params['author']) ? $search_params['author'] : null, 'size=20') ?>
  </label>
  <br/>
  <label for="search_params_copyright">
    <span><?php //echo __('Copyright:', null, 'sfAsset') ?></span>
    <?php //echo input_tag('search_params[copyright]', isset($search_params['copyright']) ? $search_params['copyright'] : null, 'size=20') ?>
  </label>
  <br/>
  <label for="search_params_created_at">
    <span><?php //echo __('Created on:', null, 'sfAsset') ?></span>
    <?php //echo input_tag('search_params[created_at]', isset($search_params['created_at']) ? $search_params['created_at'] : null, array ('size' => 20, 'class' => 'date')) ?>
  </label>
  <?php /*
  <br/>
  <label for="search_params_description">
    <span><?php echo __('Description:', null, 'sfAsset') ?></span>
    <?php echo input_tag('search_params[description]', isset($search_params['description']) ? $search_params['description'] : null, 'size=20') ?>
  </label>
  */ ?>
  <br/>
  <?php //include_partial('sfAsset/search_custom', array('search_params' => isset($search_params) ? $search_params : array())) ?>

  <?php //echo button_tag(__('Search', null, 'sfAsset') . image_tag('ico16/btnext'), 'name=search class=sf_admin_action_filter type=submit') ?>

</form> -->
<script type="text/javascript">
//$("#dosearch").click(function (e) {
    e.preventDefault();
    //$('#sf_asset_search').toggle();
  //});
</script>