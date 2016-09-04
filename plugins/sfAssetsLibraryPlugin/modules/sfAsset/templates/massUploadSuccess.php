<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N', 'Form') ?>
<div class="content">
	<div id="sf_asset_container">
	
	  <h1><?php echo __('Mass upload files', null, 'sfAsset') ?></h1>
	
	  <?php include_partial('sfAsset/create_folder_header') ?>
	
	
	  <form action="<?php echo url_for('@sf_asset_library_mass_upload') ?>" method="post" enctype="multipart/form-data">
	
	    <?php echo $form->renderGlobalErrors() ?>
		
		<div class="rowElem">
		    <fieldset>    
		    <?php echo $form ?>
		    <div id="more_files"></div>
		    <?php echo '<span id="add_files">'.image_tag('ico16/add').' Adicionar mais arquivos</span>' ?>
		    </fieldset>
	    </div>
	    <?php include_partial('edit_actions', array('button' => 'Upload')) ?>
	
	  </form>
	
	  <?php include_partial('sfAsset/create_folder_footer') ?>
	
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	 $(".rowElem").jqTransform();
	 $(".form-row").addClass('clear');

	 var new_file = 6;
	 $("#add_files").click(function (){
		var html = $("#more_files").html();
		var new_field = '<div class="form-row clear"><label for="sf_asset_file_'+new_file+'">File '+new_file+'</label><input type="file" id="sf_asset_file_'+new_file+'" name="sf_asset[file_'+new_file+']"></div>';
		$("#more_files").html(html+new_field);
		new_file++;
	 });
});
</script>
