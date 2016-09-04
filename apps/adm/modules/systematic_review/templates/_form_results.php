<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('O relatório da revisão sistemática foi atualizado com sucesso'), __('A atualização do relatório da revisão sistemática falhou')) ?>

<?php echo form_errors_display($form) ?>

<form class="form-horizontal" action="<?php echo url_for('systematic_review/'.($form->getObject()->isNew() ? 'resultCreate' : 'resultUpdate').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  
  <?php echo $form->renderHiddenFields() ?>
  
  <input type="hidden" name="rsl_id" value="<?php echo $id ?>" />
  
  <fieldset>
    <legend id="dosestudos"><?php echo __('A respeito dos estudos') ?>:</legend>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_data_sintesys"><?php echo __('Síntese dos dados') ?>:</label>
      <div class="controls"><?php echo $form['data_sintesys']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_class_description"><?php echo __('Descrição dos estudos') ?>:</label>
      <div class="controls"><?php echo $form['class_description']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_data_sintesys"><?php echo __('Meta-síntese') ?>:</label>
      <div class="controls"><?php echo $form['meta_sintesys']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  </fieldset>
  
  <fieldset>
    <legend id="resultados"><?php echo __('Resultados obtidos') ?>:</legend>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_data_sintesys"><?php echo __('Resultados Obtidos') ?>:</label>
      <div class="controls"><?php echo $form['results']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_discussions"><?php echo __('Discussão') ?>:</label>
      <div class="controls"><?php echo $form['discussions']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_conclusions"><?php echo __('Conclusões') ?>:</label>
      <div class="controls"><?php echo $form['conclusions']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  </fieldset>
  
  <fieldset>
    <legend id="info"><?php echo __('Informações adicionais') ?>:</legend>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_practice_implications"><?php echo __('Implicações para prática') ?>:</label>
      <div class="controls"><?php echo $form['practice_implications']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_search_implications"><?php echo __('Implicações para a pesquisa') ?>:</label>
      <div class="controls"><?php echo $form['search_implications']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label class="control-label" for="rsl_result_appointments"><?php echo __('Reconhecimentos') ?>:</label>
      <div class="controls"><?php echo $form['appointments']->render(array('class' => 'textarea input-xxlarge')) ?></div>
    </div>
  
    <hr />
    <div class="control-group">
      <label class="control-label">&nbsp;</label>
      <div class="controls">
        <?php //echo save_edit_conclude_controls($form->getObject(), __('este relatório')) ?>
        <div class="btn-group pull-left">
          <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
          <button class="btn" value="@results_validation?id=<?php echo $id ?>" type="submit" name="finaliza"><i class="icon-check"></i> <?php echo __('ou') ?><?php echo __('Salvar e concluir') ?></button>
        </div>
        <div class="btn-group-item pull-left">
           <?php echo __('ou') ?> <a href="/adm_dev.php/systematic_review" class="negate"><?php echo __('Cancelar') ?></a>
        </div>
      </div>
    </div>
  </fieldset>
</form>
<?php
  use_javascript('users');
  use_javascript('wysihtml5/wysihtml5-0.3.0.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.js');
?>