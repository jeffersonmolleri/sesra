<?php if(!empty($questionnaires)): ?>
<html select="#myModal .modal-body">
<?php echo '<![CDATA['?>
  <form action="<?php echo url_for('answer/avaliar') ?>" method="post" id="answerForm"> 
	<?php foreach ($questionnaires as $questionnaire) : ?>
	  <div id="msg_<?php echo $questionnaire->id?>"></div>
    <div class="">
      <h4><?php echo $questionnaire->name ?></h4>
      <p><?php echo $questionnaire->description ?></p>
      <hr />
    </div> 
    	
    <input type="hidden" name="study_id" value="<?php echo $study_id ?>" >
    <input type="hidden" name="questionnaire_id" value="<?php echo $questionnaire->id ?>" >

      <?php foreach ($questionnaire->questions as $questions) : ?>
      <div class="control-group">
        <label class="control-label" for="inputEmail"><?php echo $questions[1]?></label>
        <div class="controls">
          <select name="questions[<?php echo $questions['id']?>]">
            <?php if($questions[2] == 'logico') : ?>
              <option value="1" <?php echo $questions[4] == '1' ? 'selected="selected"' : '' ?>><?php echo __('Sim'); ?></option>
              <option value="0" <?php echo $questions[4] == '0' ? 'selected="selected"' : '' ?>><?php echo __('Não'); ?></option>
            <?php else: ?>
              <?php foreach (explode(',',$questions[2]) as $q) : ?>
                <option value="<?php echo $q?>" <?php echo $questions[4] == $q ? 'selected="selected"' : '' ?>><?php echo $q?></option>
            <?php endforeach; ?>
            <?php endif ?>
          </select>
        </div>
      </div>
      <?php endforeach; ?>
  <?php endforeach; ?>
  </form>
]]>
</html>
<eval>
	$('#myModal').modal('show');
	$('#answerForm').ajaxForm();
</eval>
<?php else: ?>
  <div class="alert"><?php echo __('Para aplicar os critérios de qualidade de estudos, você deve primeiro selecionar um modelo de listas de avaliação de estudos ou criar seu próprio questionário de avaliação'); ?>.</div>
<?php endif; ?>