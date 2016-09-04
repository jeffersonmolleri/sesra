<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('Os dados do grupo foram atualizados com sucesso.'), __('A atualização nos dados do grupo falhou')) ?>

<?php echo form_errors_display($form) ?>

<form action="<?php echo url_for(($form->getObject()->isNew() ? '@create_group' : '@update_group').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  
  <?php echo $form->renderHiddenFields() ?>
  
  <fieldset>
    <legend><?php echo __('Sobre este grupo') ?></legend>
	
	<div class="rowElem">
    <label for="profile_name" class="name">
      <span><?php echo __('Nome') ?>*:</span>
      <?php echo $form['name'] ?>
    </label>
    </div>
    <br class="clear" />

    <label for="profile_description">
      <span><?php echo __('Descrição') ?>:</span>
      <?php echo $form['description']->render(array ('style' => 'width: 650px;')) ?>
    </label>
  </fieldset>

  <fieldset>
    <legend><?php echo __('Permissões') ?></legend>

	<div class="rowElema">
    <label for="username">
    	<?php echo $form['sf_guard_group_permission_list']->render(array('class'=>'perms')); ?>
    </label>
    </div>
  </fieldset>
  
  <?php echo save_edit_controls($form->getObject(), __('este grupo')) ?>
</form>
<?php 
  use_javascript('jquery/jquery.ui.js');
  use_javascript('jquery/ui/i18n/ui.datepicker-pt-BR.js');
  use_javascript('jquery/jquery.maskedinput.js');
  use_javascript('users');
  use_stylesheet('jquery-ui-themeroller');
?>
<script type="text/javascript">
  $(".rowElem").jqTransform();

  function turnOffAdmin()
  {
	$(".groups").removeAttr('checked');
  }
  
  $('.groups').click(function () {
	  if($(".groups").attr('checked') == true)
	  { 
      		$('.perms').attr('checked', 'checked');
	  }
	  else
	  {
		    $('.perms').removeAttr('checked');
	  }
  });
  <?php echo rich_editor_script('#sf_guard_group_description'); ?>
</script>