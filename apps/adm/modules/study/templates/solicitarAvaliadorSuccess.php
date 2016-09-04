<?php if(isset($send)) :?>
<prepend select="#myModal .modal-body">
<?php echo '<![CDATA['?>
<div>
	<div class="alert alert-success">
		<?php $name = $avaliador->getSfGuardUser()->getProfile()->getName(); $email = $avaliador->getSfGuardUser()->getProfile()->getEmail();	echo __('<strong>Solicitação para resolução de divergência</strong> encaminhada para <a href="mailto:%c2%">%c1%</a> com sucesso', array('%c1%' => empty($name) ? __('pesquisador') : $name, '%c2%' => empty($email) ? '' : $email) ?>.
	
	   
	</div>
</div>
]]>
</prepend>

<?php else: ?>
<html select="#myModal .modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><![CDATA[&times;]]></button>
    <h3><?php echo __('Divergências Encontradas na Seleção do Estudo') ?></h3>
</html>
<html select="#myModal .modal-footer">
    <button id="solicitarAvaliacao" class="btn btn-success"><i class="icon-ok"></i> <?php echo __('Solicitar') ?></button>
    <?php echo __('ou') ?> <a href="#" aria-hidden="true" data-dismiss="modal"><?php echo __('Cancelar') ?></a>
</html>
<html select="#myModal .modal-body">
<?php echo '<![CDATA['?>
<p><?php echo __('Este estudo apresentou divergências em sua seleção, conforme listado abaixo') ?>:</p>
<ul class="icons-ul">
	<?php foreach($avaliacoes as $a) :?>
		<li class="<?php echo $a->getRslCriteria()->getType() ? 'text-success' : 'text-error'?>">
		  <?php echo $a->getRslCriteria()->getType() ? '<i class="icon-plus-sign"></i>' : '<i class="icon-minus-sign"></i>' ?>
		  <strong><?php echo $users[$a->getUserId()]->getProfile()->getName() ?></strong> 
		  <?php echo $a->getRslCriteria()->getType() ? __('incluiu') : __('excluiu') ?> <?php echo __('o estudo segundo o critério ') ?>
          <strong><?php echo $a->getRslCriteria()->getName()?></strong>
		</li>
	<?php endforeach; ?>
</ul>
<form action="<?php echo url_for('study/solicitarAvaliador') ?>" method="post" id="solicitarAvaliacaoForm"> 
  <fieldset>
    <legend><?php echo __('Solicitar Mediação') ?></legend>
    <p><?php echo __('Para solucionar este impasse, você deve solicitar a intervenção de um mediador ou revisor independente. Selecione um a partir da listagem abaixo') ?>:</p>
    <input type="hidden" name="study_id" value="<?php echo $study_id ?>" >
    <input type="hidden" name="review_id" value="<?php echo $review_id ?>" >
    
    <select name="avaliador" class="input-xxlarge">
    <?php foreach ($avaliadores as $avaliador) : ?>
    	<option value="<?php echo $avaliador->getUserId() ?>" <?php echo SystematicReview::COORDENADOR == $avaliador->getLevel() ? 'selected="selected"' : '' ?>>
    		<?php echo $avaliador->getsfGuardUser()->getProfile()->getName(); ?> (<?php echo $avaliador->getsfGuardUser()->getProfile()->getEmail(); ?>) 
    	</option>
    <?php endforeach; ?>
    </select>
  </fieldset>
</form>


]]>
</html>
<eval>
	$('#myModal').modal('show');
	$('#solicitarAvaliacaoForm').ajaxForm();
	$('#solicitarAvaliacao').on('click',function(e){
	  e.preventDefault();
	  $('#solicitarAvaliacaoForm').submit();
	});
</eval>
<?php endif; ?>