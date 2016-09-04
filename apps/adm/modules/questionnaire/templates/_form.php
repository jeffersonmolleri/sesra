<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('Os dados do questionário foram atualizados com sucesso'), __('A atualização do questionário falhou')) ?>

<?php echo form_errors_display($form) ?>

<form class="form-horizontal" action="<?php echo url_for('questionnaire/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <?php echo $form->renderHiddenFields() ?>
  <input type="hidden" name="review_id" value="<?php echo $review_id ?>" >
  <fieldset>
    <legend><?php echo __('Questionário de Avaliação dos Estudos') ?>:</legend>
    
    <div class="alert alert-info alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4><i class="icon-exclamation-sign"></i> <?php echo __('Por onde começar?') ?></h4>
      <p><?php echo __('Consulte o material de apoio acima para procedimentos de apoio a criação de sua própria lista de avaliação') ?>.</p>
    </div>
  
    <div class="control-group">
      <label for="name" class="control-label"><?php echo __('Título do Questionário') ?>*:</label>
      <div class="controls"><?php echo $form['name']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>
  
    <div class="control-group">
      <label for="description" class="control-label"><?php echo __('Descrição') ?>*:</label>
      <div class="controls"><?php echo $form['description']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>
  </fieldset>
  
  <fieldset>
    <legend id="criterios"><?php echo __('Critérios de Avaliação') ?>:</legend>
    <?php if ($form->getObject()->isNew()): ?>
      <p class="alert"><i class="icon-warning-sign"></i> <?php echo __('É preciso salvar o questionário para adicionar critérios de avaliação') ?>.</p>
    <?php else: ?>
      <!-- <div class="msg alert"><?php //echo __('Atenção: As questões são salvas e removidas sem precisar salvar') ?>.</div> -->
      <div id="questions">
		<?php include "_questions.php" ?>
	  </div> 
	<?php endif; ?>
	<div class="form-actions">
      <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar este questionário') ?></button>
      <?php echo __('ou') . ' ' . link_to(__('Cancelar'), '@studies_assessment?id='.$review_id, array('class' => 'negate')) ?> 
    </div>
	  <?php //echo save_edit_controls($form->getObject(), __('este questionário')) ?>
    
  </fieldset>
  
</form>
<?php if (!$form->getObject()->isNew()): ?>
<script type="text/javascript">
function changeType() {
	if( $('#tipo').val() == 'logico')
	{
		$('#question_answer_type').val('logico');
		$('#question_answer_type').hide();
	} else {
		$('#question_answer_type').val('');
		$('#question_answer_type').show();
	}
}
function bindQuestionClick() {
  changeType();
  //TODO: revisar caso inicial
  $('#tipo').on('change',changeType);
	$('#question_add').bind('click', function(e){
		e.preventDefault();
		if($("#question_description").val() == '' || $("#question_description").val() == null) {
			alert(__('O campo descrição é obrigatório'));
		}
		else if($("#question_answer_type").val() == '' || $("#question_answer_type").val() == null) {
			alert(__('O campo tipo é obrigatório'));
		}
		else
		{
			$.ajax({ 
				type:'post', 
				dataType:'xml', 
				data:{ 
					description:$("#question_description").val(), 
					answer_type:$("#question_answer_type").val(), 
					questionare_id: '<?php echo $form->getObject()->getId() ?>' 
				}, 
				url:'<?php echo url_for('@add_question') ?>' 
			});			
		}
	});
	$('.question_delete').bind('click', function(e)
	{
		e.preventDefault();
	
		$.ajax({ 
			type:'post', 
			dataType:'xml', 
			data:{ 
				id:$(this).attr('data-id'), 
			}, 
			url:'<?php echo url_for('@remove_question') ?>' });	
	});
}
$(document).ready(function(){
	bindQuestionClick();
});
</script>
<?php endif; ?>