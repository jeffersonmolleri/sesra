<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('Os dados do metadado foram atualizados com sucesso'), __('A atualização nos dados da metadado falharam')) ?>

<?php echo form_errors_display($form) ?>

<form action="<?php echo url_for('systematic_review/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  
  <?php echo $form->renderHiddenFields() ?>
  
  <fieldset>
    <legend><?php echo __('Sobre este metadado') ?>: </legend>
	
	<div class="rowElem">
    <label for="name" class="name">
      <span><?php echo __('Nome') ?>*:</span>
      <?php echo $form['name'] ?>
    </label>
    </div>
    <br class="clear" />

    <label for="type">
      <span><?php echo __('Tipo') ?>:</span>
      <?php echo $form['type']; ?>
    </label>
    
    <div class="rowElem">
    <label for="description" class="description">
      <span><?php echo __('Descrição') ?>:</span>
      <?php echo $form['description']; ?>
    </label>
	</div>
  </fieldset>
  <hr /><br/>
  <?php echo save_edit_controls($form->getObject(), __('este metadado')) ?>
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
  <?php echo rich_editor_script('#systematic_review_question'); ?>
</script>