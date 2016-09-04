<?php use_helper('enWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('Os dados do questionario foram atualizados com sucesso'), __('A atualização nos dados do questionario falharam')) ?>

<?php echo form_errors_display($form) ?>

<form action="<?php echo url_for(''.($form->getObject()->isNew() ? '@studies_create' : '@studies_update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="form-horizontal">

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form->renderHiddenFields() ?>

  <fieldset>
    <legend><?php echo (($form->getObject()->isNew())?__('Novo Estudo Primário').':':$title); ?></legend>
    <div class="control-group">
      <label class="control-label" for="study_name"><?php echo __('Título do Estudo') ?>:</label>
      <div class="controls"><?php echo $form['title']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>

    <div class="control-group">
      <label class="control-label" for="study_url"><?php echo __('URL') ?>:</label>
      <div class="controls"><?php echo $form['url']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>

    <div class="control-group">
      <label class="control-label" for="study_base_id"><?php echo __('Base de Dados') ?>:</label>
      <div class="controls">
      <?php echo $form['base_id']->render(array('class' => 'input-xxlarge'))//, 'required' => 'required')) ?>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="study_study_abstract"><?php echo __('Abstract') ?>:</label>
      <div class="controls"><?php echo $form['study_abstract']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>
    <input type="hidden" name="screen" value="<?php echo @$screen;?>"></input>
    <input type="hidden" name="review_id" value="<?php echo $review_id;?>"></input>

    <div class="">
      <div class="form-actions">
        <div class="btn-group pull-left">
          <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('este estudo') ?> </div>
      </div>
    </div>
  </fieldset>

</form>
