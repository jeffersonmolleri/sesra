<?php use_helper('Text'); ?>

<html select="#msg_<?php echo $questionnaire_id ?>">
<![CDATA[
  <?php if($success) :?>
  <div class='alert alert-success'>
  	<a href="#" class="close" data-dismiss="alert">&times;</a><i class="icon-ok"></i> <?php echo __('Avaliação salva com successo'); ?>.
  </div>
  <?php else :?>
  <div class='alert alert-warning'>
  	<a href="#" class="close" data-dismiss="alert">&times;</a><i class="icon-ok"></i> <?php echo __('Ocorreu um problema ao salvar sua avaliação'); ?>.
  </div>
  <?php endif;?>
]]>
</html>