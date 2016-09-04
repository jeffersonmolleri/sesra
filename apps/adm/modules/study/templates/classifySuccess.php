<html select="#myModal .modal-header">
<?php echo '<![CDATA[' ?>
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3><?php echo __('Seleção do Estudo Primário') ?>:<br/> <small><?php echo $study->getTitle() ?></small></h3>
]]>
</html>
<html select="#myModal .modal-footer">
	<div class="btn-group">
    <?php if(!empty($nextId)): ?>
    <button id="avaliarProximo" class="btn btn-info"><i class="icon-arrow-right"></i> <?php echo __('Avaliar próximo') ?></button>
    <?php endif ?>
	<button id="solicitarAvaliacao" class="btn" aria-hidden="true" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __('Fechar') ?></button>
	</div>
</html>
<html select="#myModal .modal-body">
<?php echo '<![CDATA[' ?>
  <div class="row-fluid">
  	<div class="span6">    
  	  <?php if($study->getUrl()): ?>
  			<h4><?php echo __('URL') ?></h4>
  			<a href="<?php echo $study->getUrl() ?>" class="overflow-hidden"><?php echo $study->getUrl() ?></a>
  		<?php endif; ?>
  		<h4><?php echo __('Abstract') ?></h4>
  		<?php if(empty($data['abstract'])): ?>
  			<?php echo __('Abstract não informado/ou importado na base de dados') ?>. 
  		<?php else: ?>
  			<?php echo $data['abstract'] ?>
  		<?php endif;?>
  	</div>
  	<div class="span6">
  		<h4><?php echo __('Critérios de avaliação') ?></h4>
  		<?php if($isDistinct): ?>
  		<div class="alert alert-block alert-info clickable" id="criterio_msg_bt">
			<i class="icon-info-sign"></i>
  			<?php echo __('O número entre parênteses representa a similaridade do estudo a outros relacionados àquele critério de seleção') ?>.<span id="criterio_msg_rm">..</span>
  			<div class="hide" id="criterio_msg">
  				<?php echo __('Para tal, o ARS utiliza-se da frequência de termos contidos no título e resumo do artigo, extraindo os estatisticamente mais significantes e comparando-os aos termos de estudos já selecionados') ?>.
  			</div>
  		</div>
  		<?php endif; ?>
  		<div id="msgSave"></div>
  		<ul class="unstyled">
        	<?php foreach($criterios as $id => $c): ?>
            <li>
              <label class="radio <?php echo ($c->type ? 'text-success' : 'text-error') ?>" title="<?php echo $criteriosScore[$id],' de ', $weight?>">
            	 <input type="radio" name="criterio" value="<?php echo $id?>" <?php echo isset($criterio) && $criterio->getCriteriaId() == $id ? 'checked="checked"' : ''?>>
                 <?php echo ($c->type ? '<i class="icon-plus-sign"></i> ' : '<i class="icon-minus-sign"></i> ') . $c->name ?> 
                 <?php //if($sf_context->getConfiguration()->getEnvironment() == 'dev'): ?>
                 <?php if($isDistinct) echo '(' . (empty($criteriosScore[$id]) ? 0 : round($criteriosScore[$id] / $weight * 100,2)) . '%)' ?>
                 <?php //endif; ?>
               </label>
            </li>
            <?php endforeach;?>
         </ul>
  	</div>
  </div>
]]>
</html>
<eval>
	$('#myModal').modal('show');
	$('#solicitarAvaliacaoForm').ajaxForm();
	
	$('input[name="criterio"]').each(function(idx, item){
		$(this).bind('change', function() {
			link = '<?php echo url_for("study/avaliar?study_id={$study->getId()}&criteria_id=c_id") ?>';
			$.get(link.replace('c_id', $(this).val()));
		});
	});
	$('#criterio_msg_bt').on('click', function() {
		$('#criterio_msg_rm').hide();
		$('#criterio_msg').show();
	});
<?php if(!empty($nextId)): ?>
	$('#avaliarProximo').on('click', function(e) {
		e.preventDefault();
		$.ajax({ 
			type:'get', 
			dataType:'xml', 
			data:{ 
				study_id: <?php echo $nextId['id'] ?>, 
				review_id: <?php echo $review_id ?>, 
			}, 
			url:'<?php echo url_for('study/classify') ?>' 
		 });			
	});
<?php endif ?>
</eval>
