<?php use_helper('Javascript', 'I18N', 'sfAsset', 'Form') ?>
<div class="content">
  <form action="" method="post" id="tinyMCE_insert_form">
    <fieldset>
      <legend><?php echo __('Metadata', null, 'sfAsset') ?></legend>
      <?php echo asset_image_tag($sf_asset, 'large', array('class' => 'thumb')) ?>
  
      <label>
        <span><?php echo __('Filename:', null, 'sfAsset'); ?></span>
        <?php echo $sf_asset->getUrl() ?>
      </label>
      <br />  
      <label>
        <span><?php echo __('Copyright:'); ?></span>
        <?php echo input_tag('alt', $sf_asset->getCopyright(), 'size=40') ?>
      </label>
      <br/>
      <?php
      list($widthoriginal, $heightoriginal, $type, $attr) = getimagesize(sfConfig::get('sf_web_dir').$sf_asset->getUrl());
      list($widthsmall, $heightsmall, $type, $attr)       = getimagesize(sfConfig::get('sf_web_dir').$sf_asset->getUrl('small'));
      list($widthlarge, $heightlarge, $type, $attr)       = getimagesize(sfConfig::get('sf_web_dir').$sf_asset->getUrl('large'));
      ?>
      <?php echo input_hidden_tag('url', $sf_asset->getUrl()) ?>
      <?php echo input_hidden_tag('height', $heightoriginal) ?>
      <?php echo input_hidden_tag('width', $widthoriginal) ?>

      <?php echo input_hidden_tag('url0', $sf_asset->getUrl('full')) ?>
      <?php echo input_hidden_tag('height0', $heightoriginal) ?>
      <?php echo input_hidden_tag('width0', $widthoriginal) ?>
      
      <?php echo input_hidden_tag('url1', $sf_asset->getUrl('large')) ?>
      <?php echo input_hidden_tag('height1', $heightlarge) ?>
      <?php echo input_hidden_tag('width1', $widthlarge) ?>
      
      <?php echo input_hidden_tag('url2', $sf_asset->getUrl('small')) ?>
      <?php echo input_hidden_tag('height2', $heightsmall) ?>
      <?php echo input_hidden_tag('width2', $widthsmall) ?>
      <label>
        <span><?php echo __('Image size:', null, 'sfAsset'); ?></span>
        <?php echo select_tag('thumbnails',
          array(__('Original', null, 'sfAsset'), __('Large thumbnail', null, 'sfAsset'), __('Small thumbnail', null, 'sfAsset'))) ?>
      </label>
      <br/>
      <label class="radio">
        <?php echo __('Frame image', null, 'sfAsset') ?>
        <?php echo checkbox_tag('border', 1, true) ?>
      </label>
    </fieldset>
    <fieldset id="frame_fieldset">
      <label class="radio">
        <?php echo __('Display description', null, 'sfAsset') ?>
        <?php echo checkbox_tag('legend', 1, true) ?>
      </label>
      <br/>
      <div id="legend_form_row">
      <label>
        <span><?php echo __('Description:', null, 'sfAsset') ?></span>
        <?php echo input_tag('asset_description', $sf_asset->getDescription(), 'size=40') ?>
      </label>
      <br/>
      </div>
      <label>
        <span><?php echo __('Image align:', null, 'sfAsset') ?></span>
        <?php echo select_tag('align', array(
          ''   => __('none', null, 'sfAsset'),
          'left'   => __('left', null, 'sfAsset'),
          'center' => __('center', null, 'sfAsset'),
          'right'  => __('right', null, 'sfAsset')
        )) ?>
      </label>
      
      <label>
        <span><?php echo __('Width (%):', null, 'sfAsset') ?></span>
        <?php echo input_tag('width', 50, 'size=5') ?>
      </label>

    </fieldset>
      
    <hr/>
    <br/>
    <button type="button" id="insertImageBtn"><?php echo __('Insert', null, 'sfAsset') . image_tag('ico16/btnext') ?></button>
    <?php echo __('ou'); ?> <?php echo link_to(__('Back to the list', null, 'sfAsset'), 'sfAsset/list', 'class=negate') ?>
  </form>
</div>
]]>
</html>
<eval>
$("#insertImageBtn").click(function(e) {
  e.preventDefault();
  insertImage($('#url').val(), { 
    alt: $('#alt').val(),
    'class': 'inlineAsset',
    title: $('#legend').attr('checked') ? $('#asset_description').val() : '',
    align: $('#align').val()
  });
  jAlert('Imagem incluida com sucesso','sfAsset');
  $('#medialib').dialog('close');
});
$("#border").click(function() {
  $('#frame_fieldset').css({ display : this.checked ? "block" : "none" });
});
$("#legend").click(function() {
  $('#legend_form_row').css({ display : this.checked ? "block" : "none" });
});
$("#thumbnails").change(function() {
  var id = $(this).val();
  $('#url').val($('#url' + id).val());
  $('#height').val($('#width'  + id).val());
  $('#width').val($('#height' + id).val());
});
</eval>
<html select="#empty">
<![CDATA[
